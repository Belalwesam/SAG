<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin.pages.clients.index');
    }

    public function store(ClientStoreRequest $request)
    {
        $data = $request->validated();
        unset($data['image']);
        unset($data['password']);

        $data['password'] = bcrypt($request->password);
        $client = User::create($data);

        if ($request->hasFile('image')) {
            $path = Storage::put('/public/clients', $request->image);
            $client->update(["image" => $path]);
        }

        return http_response_code(200);
    }


    public function update(ClientUpdateRequest $request)
    {
        $client = User::findOrFail($request->id);
        $client->update([
            "name" => $request->name,
            "email" => $request->email,
            "username" => $request->username,
            "hours" => $request->hours
        ]);

        if ($request->hasFile('image')) {
            if ($client->image) {
                Storage::delete('/' . $client->image);
            }
            $path = Storage::put('/public/clients', $request->image);
            $client->update(["image" => $path]);
        }

        if ($request->has('password') && $request->filled('password')) {
            $client->update([
                "password" => bcrypt($request->password)
            ]);
        }

        return http_response_code(200);
    }

    public function destroy(Request $request)
    {
        $client = User::findOrFail($request->id);
        // if ($client->image) {
        //     Storage::delete('/' . $client->image);
        // }

        $client->delete();

        return http_response_code(200);
    }

    public function getClientsList(Request $request)
{
    $query = User::query();

    if ($request->has('created_at') && !empty($request->created_at)) {
        $query->whereDate('created_at', $request->created_at);
    }

    $data = $query->latest()->get();

    return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('created_at', function ($row) {
            return $row->created_at->format('d-m-Y');
        })
        ->editColumn('image', function ($row) {
            if ($row->image) {
                $path = Storage::url($row->image);
            } else {
                $path = asset('/dashboard/assets/img/avatars/1.png');
            }
            return <<<HTML
                <div class="avatar avatar-lg me-2">
                      <img src="{$path}" alt="Avatar" class="rounded-circle">
                    </div>
            HTML;
        })
        ->addColumn('actions', function ($row) {
            $edit_text = trans('general.edit');
            $delete_text = trans('general.delete');
            $projects_text = trans('projects');
            $projects_route = route('admin.clients.projects', $row->id);
            $tickets_text = __("tickets list");
            $tickets_route = route('admin.tickets.client-tickets', $row->id);
            $btns = <<<HTML
                <div class="dropdown d-flex justify-content-center">
                    <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item edit-btn"
                         data-id="{$row->id}"
                         data-name="{$row->name}"
                         data-username="{$row->username}"
                         data-email="{$row->email}"
                         data-hours="{$row->hours}"
                          data-bs-toggle="modal"
                          data-bs-target="#editClientModal"
                          href="javascript:void(0);"><i class="bx bx-edit me-0 me-2 text-primary"></i>{$edit_text}</a></li>
                         <li>
                          <a class="dropdown-item delete-btn"
                            data-id="{$row->id}"
                          href="javascript:void(0);"><i class="bx bx-trash me-0 me-2 text-danger"></i>{$delete_text}</a></li>
                          <li>
                          <a class="dropdown-item"
                          href="{$projects_route}"><i class="bx bx-cog me-0 me-2 text-success"></i>{$projects_text}</a></li>
                          <li>
                          <a class="dropdown-item"
                          href="{$tickets_route}"><i class="bx bx-support me-0 me-2 text-info"></i>{$tickets_text}</a></li>
                      </ul>
                </div>
            HTML;

            if (auth('admin')->user()->hasAbilityTo('edit clients')) {
                return $btns;
            }
            return;
        })
        ->rawColumns(['actions', 'image'])
        ->make(true);
}


    public function projects($id)
    {
        $project_client = User::findOrFail($id);
        $clients = User::whereNotIn('id', [$project_client->id]);
        return view('admin.pages.clients.projects', compact('project_client', 'clients'));
    }
}

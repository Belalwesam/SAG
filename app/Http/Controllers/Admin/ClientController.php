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


    public function update(ClientUpdateRequest $request) {}

    public function destroy(Request $request) {}

    public function getClientsList()
    {
        $data = User::latest()->get();
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
                $btns = <<<HTML
                    <div class="dropdown d-flex justify-content-center">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-btn"
                             data-id="{$row->id}"
                             data-name = "{$row->name}"
                             data-username = "{$row->username}"
                             data-email = "{$row->email}"
                             data-hours = "{$row->hours}"
                              data-bs-toggle="modal"
                              data-bs-target = "#editClientModal"
                              href="javascript:void(0);"><i class="bx bx-edit me-0 me-2 text-primary"></i>{$edit_text}</a></li>
                             <li>
                              <a class="dropdown-item delete-btn"
                                data-id = "{$row->id}"
                              href="javascript:void(0);"><i class="bx bx-trash me-0 me-2 text-danger"></i>{$delete_text}</a></li>
                          </ul>
                        </div>
                HTML;

                if (auth('admin')->user()->hasAbilityTo('edit clients')) {
                    return $btns;
                }
                return;
            })
            ->rawColumns(['actions' , 'image'])
            ->make(true);
    }
}

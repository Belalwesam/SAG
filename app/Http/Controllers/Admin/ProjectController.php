<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $clients = User::all();
        return view('admin.pages.projects.index', compact('clients'));
    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());
        return http_response_code(200);
    }
    public function update(ProjectRequest $request)
    {
        $project = Project::findOrFail($request->id);
        $project->update($request->validated());
        return http_response_code(200);
    }

    public function destroy(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $project->delete();
        return http_response_code(200);
    }

    public function getProjectsList()
    {
        $data = Project::latest()->get();

        if (request()->client_id) {
            $client = User::findOrFail(request()->client_id);
            $data = $client->projects()->latest()->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('user_id', function ($row) {
                return $row->user->name;
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
                             data-user = "{$row->user_id}"
                              data-bs-toggle="modal"
                              data-bs-target = "#editProjectModal"
                              href="javascript:void(0);"><i class="bx bx-edit me-0 me-2 text-primary"></i>{$edit_text}</a></li>
                             <li>
                              <a class="dropdown-item delete-btn"
                                data-id = "{$row->id}"
                              href="javascript:void(0);"><i class="bx bx-trash me-0 me-2 text-danger"></i>{$delete_text}</a></li>
                          </ul>
                        </div>
                HTML;

                if (auth('admin')->user()->hasAbilityTo('edit projects')) {
                    return $btns;
                }
                return;
            })
            ->rawColumns(['actions', 'user_id'])
            ->make(true);
    }
}

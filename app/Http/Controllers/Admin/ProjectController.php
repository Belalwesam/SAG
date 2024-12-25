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

    public function getProjectsList(Request $request)
    {
        $query = Project::query();
    
        // Apply the date filter if provided
        if ($request->created_at) {
            $query->whereDate('created_at', $request->created_at);
        }
    
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('user_id', function ($row) {
                return $row->user->name; // Assuming a relationship exists between Project and User
            })
            ->addColumn('actions', function ($row) {
                $edit_text = trans('general.edit');
                $delete_text = trans('general.delete');
                $btns = <<<HTML
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item edit-btn"
                                   data-id="{$row->id}" 
                                   data-name="{$row->name}" 
                                   data-user_id="{$row->user_id}" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#editProjectModal">
                                   {$edit_text}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item delete-btn" 
                                   data-id="{$row->id}">
                                   {$delete_text}
                                </a>
                            </li>
                        </ul>
                    </div>
                HTML;
    
                if (auth('admin')->user()->hasAbilityTo('edit projects')) {
                    return $btns;
                }
                return '';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    
}

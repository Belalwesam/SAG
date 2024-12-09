<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    }
}

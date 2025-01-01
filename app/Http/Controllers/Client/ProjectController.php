<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        return view('client.pages.projects.index');
    }

    public function getProjectsList(Request $request)
    {
        $data = auth()->user()->projects()->latest();
        $data = $data->when($request->date_from, function ($query) use ($request) {
            $query->where('created_at', '>=', $request->date_from);
        })
            ->when($request->date_to, function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to);
            })
            ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            });
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('user_id', function ($row) {
                return $row->user->name;
            })
            ->rawColumns(['user_id'])
            ->make(true);
    }
}

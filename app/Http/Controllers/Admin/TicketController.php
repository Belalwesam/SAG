<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function index()
    {
        return view('admin.pages.tickets.index');
    }

    public function getTicketsList()
    {
        $data = Ticket::latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y h:i a');
            })
            ->editColumn('status', function ($row) {
                $colors_array = [
                    "pending" => "warning",
                    "processing" => "info",
                    "completed" => "success",
                    "rejected" => "danger"
                ];

                $status_text = __($row->status);
                $btns = <<<HTML
                        <span class="badge rounded-pill bg-{$colors_array[$row->status]}">{$status_text}</span>
            HTML;
                return $btns;
            })
            ->editColumn('user_id', function ($row) {
                return $row->user->name;
            })
            ->editColumn('priority', function ($row) {
                $colors_array = [
                    "medium" => "warning",
                    "low" => "success",
                    "high" => "danger"
                ];

                $priority_text = __($row->priority);
                $btns = <<<HTML
                        <span class="badge rounded-pill bg-{$colors_array[$row->priority]}">{$priority_text}</span>
            HTML;
                return $btns;
            })
            ->editColumn('project_id', function ($row) {
                return $row->project->name;
            })
            ->editColumn('ticket_id', function ($row) {
                $show_route = route('admin.tickets.show', $row->ticket_id);
                return <<<HTML
                        <a href="{$show_route}">{$row->ticket_id}</a>
                     HTML;
            })
            ->addColumn('actions', function ($row) {
                $show_text = __("show details");
                $show_route = route('admin.tickets.show', $row->ticket_id);
                $delete_text = trans('general.delete');
                $btns = <<<HTML
                <div class="dropdown d-flex justify-content-center">
                    <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                          href="{$show_route}"><i class="bx bx-show me-0 me-2 text-success"></i>{$show_text}</a></li>
                         <li>
                      </ul>
                    </div>
            HTML;
                return $btns;
            })
            ->rawColumns(['actions', 'priority', 'status', 'ticket_id'])
            ->make(true);
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::with('files', 'user')->where('ticket_id', $ticket_id)->firstOrFail();
        $admins = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->get();
        return view('admin.pages.tickets.show', compact('ticket' , 'admins'));
    }
}

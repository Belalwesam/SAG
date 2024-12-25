<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function index()
    {
        return view('admin.pages.tickets.index');
    }

    public function getTicketsList(Request $request)
    {
        $data = Ticket::latest();

        if (auth('admin')->user()->getRoleNames()[0] == 'Supervisor') {
            $data = auth('admin')->user()->tickets()->latest();
        }
        $data = $data->when($request->status, function ($query) use ($request) {
            return $query->where('status', $request->status);
        })
            ->when($request->date_from, function ($query) use ($request) {
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
        return view('admin.pages.tickets.show', compact('ticket', 'admins'));
    }


    public function update(Request $request)
    {
        $ticket = Ticket::findOrFail($request->id);

        $ticket->update(['admin_id' => $request->admin_id]);



        if ($request->status == 'rejected') {
            $ticket->update([
                'status' => 'rejected',
                'admin_id' => null,
                "estimated_hours" => null,
                "handeled" => 0,
                "handeled_at" => null
            ]);
            return response()->json(["message" => __("ticket rejected")]);
        }

        if ($request->estimated_hours > $ticket->user->hours) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'estimated_hours' => [__("no enough hours")],
            ]);
        }

        if ($request->estimated_hours) {
            $ticket->update([
                "status" => $request->status,
                "estimated_hours" => $request->estimated_hours
            ]);
            if ($request->status == 'completed') {
                $ticket->update([
                    "handeled" => 1,
                    "handeled_at" => now()
                ]);

                $client = $ticket->user;
                $client->update(["hours" => $client->hours - $ticket->estimated_hours]);
            }
        } else {
            if (in_array($request->status, ["processing", "completed"])) {
                if (!$request->estimated_hours) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'estimated_hours' => [__("please provide hours")],
                    ]);
                }
                $ticket->update([
                    "status" => $request->status,
                    "estimated_hours" => $request->estimated_hours
                ]);
                if ($request->status == 'completed') {
                    $ticket->update([
                        "handeled" => 1,
                        "handeled_at" => now()
                    ]);

                    $client = $ticket->user;
                    $client->update(["hours" => $client->hours - $ticket->estimated_hours]);
                }
            }
        }
        return http_response_code(200);
    }


    public function client_tickets($id)
    {
        $client = User::findOrFail($id);
        $pending_tickets = $client->ticketsFiltered('pending')->count();
        $completed_tickets = $client->ticketsFiltered('completed')->count();
        $processing_tickets = $client->ticketsFiltered('processing')->count();
        $rejected_tickets = $client->ticketsFiltered('rejected')->count();
        $total_tickets = $client->tickets->count();

        // total spent maintenance hours
        $total_maintenance_time = $client->ticketsFiltered('completed')->sum('estimated_hours');


        // month counts
        $last_month_tickets = $client->tickets()->whereNot('status', 'rejected')->whereMonth(
            'created_at',
            '=',
            Carbon::now()->subMonth()->month
        )->count();


        $this_month_tickets = $client->tickets()->whereNot('status', 'rejected')->whereMonth(
            'created_at',
            '=',
            Carbon::now()->month
        )->count();
        return view('admin.pages.tickets.client-tickets', get_defined_vars());
    }


    public function getClientTicketsList($id)
    {
        $client = User::findOrFail($id);
        $data = $client->tickets()->latest()->get();
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

    public function conversation($ticket_id)
    {
        $ticket = Ticket::with('messages')->where('ticket_id', $ticket_id)->firstOrFail();
        return view('admin.pages.tickets.conversation', compact('ticket'));
    }

    public function send_message(MessageRequest $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);

        $ticket->messages()->create([
            "message" => $request->message,
            "user_id" => $ticket->user->id,
            "admin_id" => auth('admin')->user()->id,
            "sender" => "admin"
        ]);

        return back();
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Models\Ticket;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Client\TicketSubmitRequest;

class TicketController extends Controller
{
    public function index()
    {
        return view('client.pages.tickets.index');
    }

    public function create()
    {
        $projects = auth()->user()->projects;
        return view('client.pages.tickets.create', compact('projects'));
    }

    public function store(TicketSubmitRequest $request)
    {
        $maintenance_hours = Project::findOrFail($request->project_id)->hours;

        if ($maintenance_hours < 1) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'project_id' => [__("project refill")],
            ]);
        }

        $ticket_id = uniqid();
        $ticket = auth()->user()->tickets()->create([
            "subject" => $request->subject,
            "project_id" => $request->project_id,
            "description" => $request->description,
            "priority" => $request->priority,
            "ticket_id" => $ticket_id
        ]);
        if ($request->hiddenFileInput && count($request->hiddenFileInput) > 0) {

            $folderName = $ticket_id;
            $path = storage_path('app/public/tickets/' . $folderName);
            if (!file_exists($path)) {
                mkdir($path, 0777, true); // Create the folder with 0777 permissions and ensure directories are created recursively
                chmod($path, 0777); // Set permissions to 777
            }
            foreach ($request->hiddenFileInput as $file) {
                $file_type = '';
                $mime_type = $file->getMimeType();
                if (str_starts_with($mime_type, 'image/')) {
                    $file_type = 'image';
                }
                if (str_starts_with($mime_type, 'video/')) {
                    $file_type = 'video';
                }
                if (str_starts_with($mime_type, 'application/pdf')) {
                    $file_type = 'pdf';
                }

                $storage_path = $path;
                $path = Storage::putFileAs('public/tickets/' . $ticket_id, $file, $file->getClientOriginalName());
                $ticket->files()->create([
                    "type" => $file_type,
                    "path" => $path
                ]);
            }
        }

        return back()->with('success', __("general.create_success"));
    }


    public function getTicketsList(Request $request)
    {
        $data = auth()->user()->tickets()->latest();
        $data = $data->when($request->status, function ($query) use ($request) {
            return $query->where('status', $request->status);
        })->when($request->priority, function ($query) use ($request) {
            return $query->where('priority', $request->priority);
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
                $show_route = route('client.tickets.show', $row->ticket_id);
                return <<<HTML
                            <a href="{$show_route}">{$row->ticket_id}</a>
                         HTML;
            })
            ->addColumn('actions', function ($row) {
                $show_text = __("show details");
                $show_route = route('client.tickets.show', $row->ticket_id);
                $delete_text = trans('general.delete');
                $btns = <<<HTML
                    <div class="dropdown d-flex justify-content-center">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                              href="{$show_route}"><i class="bx bx-show me-0 me-2 text-success"></i>{$show_text}</a></li>
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
        $ticket = Ticket::with('files', 'project', 'messages')->where('ticket_id', $ticket_id)->firstOrFail();
        return view('client.pages.tickets.show', compact('ticket'));
    }


    public function conversation($ticket_id)
    {
        $ticket = auth()->user()->tickets()->with('messages')->where('ticket_id', $ticket_id)->firstOrFail();
        return view('client.pages.tickets.conversation', compact('ticket'));
    }

    public function send_message(MessageRequest $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);

        $ticket->messages()->create([
            "message" => $request->message,
            "user_id" => auth()->user()->id,
            "admin_id" => $ticket->admin?->id,
            "sender" => "client"
        ]);

        return back();
    }
}

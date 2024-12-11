<?php

namespace App\Http\Controllers\Client;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Client\TicketSubmitRequest;

class TicketController extends Controller
{
    public function index()
    {
        return ('here are the tickets index');
    }

    public function create()
    {
        $projects = auth()->user()->projects;
        return view('client.pages.tickets.create', compact('projects'));
    }

    public function store(TicketSubmitRequest $request)
    {
        $ticket_id = uniqid();
        $ticket = auth()->user()->tickets()->create([
            "subject" => $request->subject,
            "project_id" => $request->project_id,
            "description" => $request->description,
            "priority" => $request->priority,
            "ticket_id" => $ticket_id
        ]);
        if ($request->hiddenFileInput && count($request->hiddenFileInput) > 0) {
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

                $storage_path = 'public/tickets/' . $ticket->ticket_id;
                $path = Storage::putFileAs($storage_path, $file, $file->getClientOriginalName());
                $ticket->files()->create([
                    "type" => $file_type,
                    "path" => $path
                ]);
            }
        }

        return back()->with('success', __("general.create_success"));
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $user = auth()->user()->tickets()->create([
            "subject" => $request->subject,
            "project_id" => $request->project_id,
            "description" => $request->description,
            "priority" => $request->priority,
            "ticket_id" => $ticket_id
        ]);
    }
}

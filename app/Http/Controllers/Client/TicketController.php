<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\TicketSubmitRequest;
use Illuminate\Http\Request;

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
        dd($request->all());
    }
}

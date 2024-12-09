<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return ('here are the tickets index');
    }

    public function create()
    {
        return view('client.pages.tickets.create');
    }
}

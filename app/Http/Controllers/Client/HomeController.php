<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $client = auth()->user();

        $pending_tickets = $client->ticketsFiltered('pending')->count();
        $completed_tickets = $client->ticketsFiltered('completed')->count();
        $processing_tickets = $client->ticketsFiltered('processing')->count();
        $total_tickets = $client->tickets->count();

        // total spent maintenance hours
        $total_maintenance_time = $client->ticketsFiltered('completed')->sum('estimated_hours');
        return view('client.pages.index', get_defined_vars());
    }
}

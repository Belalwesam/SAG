<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $admin = auth('admin')->user();
        if ($admin->getRoleNames()[0] == 'Supervisor') {
            $processing_tickets = $admin->tickets()->where('status', 'processing')->count();
            $completed_tickets = $admin->tickets()
                ->where('status', 'completed')
                ->where('handeled', 1)
                ->whereNotNull('handeled_at')
                ->count();
            $total_maintenance_hours = $admin->tickets()
                ->where('status', 'completed')
                ->where('handeled', 1)
                ->whereNotNull('handeled_at')
                ->sum('estimated_hours');
            $data["processing_tickets"] = $processing_tickets;
            $data["completed_tickets"] = $completed_tickets;
            $data["total_maintenance_hours"] = $total_maintenance_hours;
            $data["total_tickets"] = $admin->tickets->count();
        } elseif ($admin->getRoleNames()[0] == 'Super Admin') {
            $pending_tickets = $admin->tickets()->where('status', 'pending')->count();
            $rejected_tickets = $admin->tickets()->where('status', 'rejected')->count();
            $processing_tickets = $admin->tickets()->where('status', 'processing')->count();
            $completed_tickets = $admin->tickets()
                ->where('status', 'completed')
                ->where('handeled', 1)
                ->whereNotNull('handeled_at')
                ->count();
            $total_maintenance_hours = $admin->tickets()
                ->where('status', 'completed')
                ->where('handeled', 1)
                ->whereNotNull('handeled_at')
                ->sum('hours');
            $data["pending_tickets"] = $pending_tickets;
            $data["rejected_tickets"] = $rejected_tickets;
            $data["processing_tickets"] = $processing_tickets;
            $data["completed_tickets"] = $completed_tickets;
            $data["total_maintenance_hours"] = $total_maintenance_hours;
            $data["clients"] = User::count();
            $data["projects"] = Project::count();
        }
        return view('admin.pages.index', compact('data'));
    }
}

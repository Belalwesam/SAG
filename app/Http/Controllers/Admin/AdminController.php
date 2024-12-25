<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;

class AdminController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return view('admin.pages.admins.index', compact('roles'));
    }

    public function getAdminsList()
    {
        $data = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super admin');
        })->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('role', function ($row) {
                return $row->getRole();
            })
            ->addColumn('initials', function ($row) {
                $initials = "<div class='avatar'>
                            <span class='avatar-initial rounded-circle bg-info'>{$row->getInitials()}</span>
                        </div>";

                return $initials;
            })
            ->addColumn('actions', function ($row) {
                $edit_text = trans('general.edit');
                $delete_text = trans('general.delete');
                $role = $row->roles[0];

                $show_text = __("show details");
                $show_route = route('admin.admins.show', $row->id);
                $btns = <<<HTML
                    <div class="dropdown d-flex justify-content-center">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item edit-btn"
                             data-id="{$row->id}"
                             data-name = "{$row->name}"
                             data-username = "{$row->username}"
                             data-email = "{$row->email}"
                             data-role = "{$role->id}"
                              data-bs-toggle="offcanvas"
                              data-bs-target = "#offcanvasEditAdmin"
                              href="javascript:void(0);"><i class="bx bx-edit me-0 me-lg-2 text-primary"></i>{$edit_text}</a></li>
                             <li>
                              <a class="dropdown-item delete-btn"
                                data-id = "{$row->id}"
                              href="javascript:void(0);"><i class="bx bx-trash me-0 me-lg-2 text-danger"></i>{$delete_text}</a></li>
                              <li>
                              <a class="dropdown-item"
                              href="{$show_route}"><i class="bx bx-show me-0 me-lg-2 text-warning"></i>{$show_text}</a></li>
                          </ul>
                        </div>
                HTML;

                return $btns;
            })
            ->rawColumns(['initials', 'actions'])
            ->make(true);
    }

    public function store(AdminStoreRequest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->syncRoles(Role::find($request->role));
        return http_response_code(200);
    }

    public function update(AdminUpdateRequest $request)
    {
        $admin = Admin::findOrFail($request->id);
        $admin->update($request->validated());
        $admin->syncRoles(Role::find($request->role));
        if ($request->has('password') && $request->filled('password')) {
            $admin->update(['password' => bcrypt($request->password)]);
        }
        return http_response_code(200);
    }
    public function destroy(Request $request)
    {
        Admin::findOrFail($request->id)->delete();
        return http_response_code(200);
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        $pending_tickets = $admin->ticketsFiltered('pending')->count();
        $completed_tickets = $admin->ticketsFiltered('completed')->count();
        $processing_tickets = $admin->ticketsFiltered('processing')->count();
        $rejected_tickets = $admin->ticketsFiltered('rejected')->count();
        $total_tickets = $admin->tickets->count();

        // total spent maintenance hours
        $total_maintenance_time = $admin->ticketsFiltered('completed')->sum('estimated_hours');


        // month counts
        $last_month_tickets = $admin->tickets()->whereNot('status', 'rejected')->whereMonth(
            'created_at',
            '=',
            Carbon::now()->subMonth()->month
        )->count();


        $this_month_tickets = $admin->tickets()->whereNot('status', 'rejected')->whereMonth(
            'created_at',
            '=',
            Carbon::now()->month
        )->count();
        return view('admin.pages.admins.show', get_defined_vars());
    }

    public function getAdminTicketsList($id)
    {
        $admin = Admin::findOrFail($id);
        $data = $admin->tickets()->latest()->get();
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
}

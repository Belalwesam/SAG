@extends('admin.layout.app')
@section('title')
    @lang('nav.dashboard')
@endsection
@section('content')
    @if (auth('admin')->user()->getRoleNames()[0] == 'Super Admin')
        admin
    @elseif(auth('admin')->user()->getRoleNames()[0] == 'Supervisor')
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('processing tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['processing_tickets'] }}</h4>
                                </div>
                                <small>{{ __('processing tickets') }}</small>
                            </div>
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bx-cog bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('completed tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['completed_tickets'] }}</h4>
                                </div>
                                <small>{{ __('completed tickets') }}</small>
                            </div>
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-check bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('total tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['total_tickets'] }}</h4>
                                </div>
                                <small>{{ __('total tickets') }}</small>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="bx bx-list-ul bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('total maintenance hours') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['total_maintenance_hours'] }}</h4>
                                </div>
                                <small>{{ __('total maintenance hours') }}</small>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="bx bx-wrench bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@extends('client.layout.app')

@section('title')
    {{ __('submit new ticket') }}
@endsection
{{-- main content --}}
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">{{ __('tickets list') }} /</span>
        {{ __('ticket #', ['ticket' => $ticket->ticket_id]) }}
    </h4>
    <div class="row gy-4">
        <div class="col-xl-8 col-lg-7 col-md-7">
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ __('subject') }}
                </h5>
                <div class="card-body">
                    {{ $ticket->subject }}
                </div>
            </div>
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ __('description') }}
                </h5>
                <div class="card-body">
                    {{ $ticket->description }}
                </div>
            </div>
            <!-- Activity Timeline -->
            <div class="card mb-4">
                <h5 class="card-header">{{ __('files') }}</h5>
                <div class="card-body">
                    <ul class="timeline">
                        @foreach ($ticket->files as $file)
                            @if ($file->type == 'pdf')
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-primary"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <small class="text-muted">{{ $file->getSize() }}</small>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="me-3">
                                                <img src="{{ asset('/dashboard/assets/img/icons/misc/pdf.png') }}"
                                                    alt="PDF image" width="20" class="me-2">
                                                <span class="fw-bold text-body">{{ basename($file->path) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @elseif($file->type == 'video')
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-danger"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <small class="text-muted">{{ $file->getSize() }}</small>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="me-3">
                                                <img src="{{ asset('/dashboard/assets/img/icons/misc/video.png') }}"
                                                    alt="PDF image" width="20" class="me-2">
                                                <span class="fw-bold text-body">{{ basename($file->path) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @elseif($file->type == 'image')
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-success"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <small class="text-muted">{{ $file->getSize() }}</small>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="me-3">
                                                <img src="{{ asset('/dashboard/assets/img/icons/misc/jpg.png') }}"
                                                    alt="PDF image" width="20" class="me-2">
                                                <span class="fw-bold text-body">{{ basename($file->path) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- /Activity Timeline -->
            <!-- /Invoice table -->
        </div>
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="pb-2 border-bottom mb-4">{{ __('details') }}</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">{{ __('ID') }}:</span>
                                <span>{{ $ticket->ticket_id }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">{{ __('admins.created_at') }}:</span>
                                <span>{{ $ticket->created_at->format('d-m-Y h:i') }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">{{ __('project') }}:</span>
                                <span>{{ $ticket->project->name }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">{{ __('priority') }}:</span>
                                @if ($ticket->priority == 'medium')
                                    <span class="badge bg-label-success">{{ __($ticket->priority) }}</span>
                                @elseif($ticket->priority == 'low')
                                    <span class="badge bg-label-warning">{{ __($ticket->priority) }}</span>
                                @elseif($ticket->priority == 'high')
                                    <span class="badge bg-label-danger">{{ __($ticket->priority) }}</span>
                                @endif
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">{{ __('status') }}:</span>
                                @if ($ticket->status == 'processing')
                                    <span class="badge bg-label-info">{{ __($ticket->status) }}</span>
                                @elseif($ticket->status == 'pending')
                                    <span class="badge bg-label-warning">{{ __($ticket->status) }}</span>
                                @elseif($ticket->status == 'rejected')
                                    <span class="badge bg-label-danger">{{ __($ticket->status) }}</span>
                                @elseif($ticket->status == 'completed')
                                    <span class="badge bg-label-success">{{ __($ticket->status) }}</span>
                                @endif
                            </li>
                            @if ($ticket->admin_id)
                                <li class="mb-3">
                                    <span class="fw-bold me-2">{{ __('ticket official') }}:</span>
                                    <span>{{ $ticket->admin->name }}</span>
                                </li>
                            @endif
                            @if ($ticket->estimated_hours)
                                <li class="mb-3">
                                    <span class="fw-bold me-2">{{ __('estimated hours') }}:</span>
                                    <span><strong>{{ $ticket->estimated_hours }}</strong>
                                        @if ($ticket->estimated_hours >= 1)
                                            {{ __('time hours') }}
                                        @else
                                            {{ __('minutes') }}
                                        @endif
                                    </span>
                                </li>
                            @endif
                            @if ($ticket->handeled)
                                <li class="mb-3">
                                    <span class="fw-bold me-2">{{ __('completed at') }}:</span>
                                    <span>{{ \Carbon\Carbon::parse($ticket->handeled_at)->format('d-m-Y h:i') }}</span>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

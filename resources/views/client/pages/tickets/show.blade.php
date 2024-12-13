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
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">Username:</span>
                                <span>violet.dev</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Email:</span>
                                <span>vafgot@vultukir.org</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Status:</span>
                                <span class="badge bg-label-success">Active</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Role:</span>
                                <span>Author</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Tax id:</span>
                                <span>Tax-8965</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Contact:</span>
                                <span>(123) 456-7890</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Languages:</span>
                                <span>French</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Country:</span>
                                <span>England</span>
                            </li>
                        </ul>
                        {{-- <div class="d-flex justify-content-center pt-3">
                            <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                                data-bs-toggle="modal">Edit</a>
                            <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- /User Card -->
            <!-- Plan Card -->
            <!-- /Plan Card -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->

        <!--/ User Content -->
    </div>
@endsection

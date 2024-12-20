@extends('admin.layout.app')

@section('title')
    {{ __('submit new ticket') }}
@endsection
{{-- main content --}}
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">{{ __('tickets list') }} /</span>
        {{ __('ticket #', ['ticket' => $ticket->ticket_id]) }}
        @if ($ticket->status == 'rejected')
            <span class="badge rounded-pill bg-danger">{{ __('rejected') }}</span>
        @elseif($ticket->status == 'completed')
            <span class="badge rounded-pill bg-success">{{ __('completed') }}</span>
        @endif
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
            @if (auth('admin')->user()->hasAbilityTo('edit tickets'))
                <div class="card mb-4">
                    <h5 class="card-header">
                        {{ __('general.actions') }}
                    </h5>
                    <div class="card-body">
                        @if (in_array($ticket->status, ['rejected', 'completed']))
                            {{ __('closed ticket') }}
                        @else
                            <button class="btn btn-primary w-100" data-bs-target="#editTicketModal" data-bs-toggle="modal">
                                {{ __('general.edit') }}
                            </button>
                        @endif
                    </div>
                </div>
            @endif
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="pb-2 border-bottom mb-4">{{ __('details') }}</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">{{ __('client') }}:</span>
                                <span>{{ $ticket->user->name }}</span>
                            </li>
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

            @if (auth('admin')->user()->getRoleNames()[0] == 'Super Admin' || auth('admin')->user()->id == $ticket->admin_id)
                <div class="card mb-3">
                    <div class="card-body">
                        <a href="{{ route('admin.tickets.conversation', $ticket->ticket_id) }}"
                            class="btn btn-primary w-100 text-white">
                            <i class='bx bx-chat mx-2'></i> {{ __('go to conversation') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <div class="modal fade" id="editTicketModal" tabindex="-1" aria-labelledby="editTicketModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTicketModalLabel">{{ __('edit ticket') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="editTicketForm">
                        <div class="form-group mb-3">
                            <label for="estimated_hours" class="form-label">{{ __('estimated time') }}</label>
                            <input type="number" step="0.5" name="estimated_hours"
                                value="{{ $ticket->estimated_hours }}" placeholder="{{ __('estimated time') }}"
                                id="estimated_hours" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="admin_id" class="form-label">{{ __('admin') }}</label>
                            <select name="admin_id" id="admin_id" class="form-select">
                                @forelse ($admins as $admin)
                                    <option value="{{ $admin->id }}" @selected($admin->id == $ticket->admin_id)>{{ $admin->name }}
                                    </option>
                                @empty
                                    <option value="">{{ __('no admins found') }}</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">{{ __('status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="rejected" @selected($ticket->status == 'rejected')>{{ __('rejected') }}</option>
                                {{-- <option value="pending" @selected($ticket->status == 'pending')>{{ __('pending') }}</option> --}}
                                <option value="processing" @selected($ticket->status == 'processing')>{{ __('processing') }}</option>
                                <option value="completed" @selected($ticket->status == 'completed')>{{ __('completed') }}</option>
                            </select>
                        </div>
                        <div class="alert alert-solid-info " role="alert">
                            <div class="mb-2">
                                <i class='bx bxs-check-shield mr-2'></i> {{ __('warning') }}
                            </div>
                            {!! __('directions') !!}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit-edit-btn" class="btn btn-primary">@lang('general.edit')</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('general.cancel')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('body').on('click', '#submit-edit-btn', function() {
            let data = {
                _token: "{!! csrf_token() !!}",
                status: $('#status').val(),
                estimated_hours: $('#estimated_hours').val(),
                admin_id: $('#admin_id').val(),
                id: "{{ $ticket->id }}"
            }

            let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

            $.ajax({
                method: 'PATCH',
                url: "{!! route('admin.tickets.update') !!}",
                data: data,
                beforeSend: function() {
                    formBtn.html(
                        '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                    )
                    formBtn.prop('disabled', true)
                },
                success: function(response) {
                    successMessage("@lang('general.edit_success')")
                    $('#editTicketModal').modal('toggle')
                    datatable.ajax.reload()
                },
                error: function(response) {
                    errorMessage("@lang('general.error')")
                    displayErrors(response, false)
                },
            }).done(function() {
                formBtn.html("@lang('general.edit')")
                formBtn.prop('disabled', true)
            }).fail(function() {
                formBtn.html("@lang('general.edit')")
                formBtn.prop('disabled', false)
            })
        })
    </script>
@endsection

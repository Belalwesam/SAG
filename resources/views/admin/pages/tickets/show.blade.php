@extends('admin.layout.app')
@section('css-vendor')
    <style>
        .container {
            border: 2px solid #dededeb9;
            background-color: #f1f1f19c;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        /* Darker chat container */
        .darker {
            border-color: #cccccca6;
            background-color: #fdfcfc8c;
        }

        /* Clear floats */
        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Style images */
        .container img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        /* Style the right image */
        .container .avatar.right {
            float: right;
            margin-left: 20px;
            margin-right: 0;
        }

        /* Style time text */
        .time-right {
            float: right;
            color: #aaa;
        }

        /* Style time text */
        .time-left {
            float: left;
            color: #999;
        }

        .left-float-test {
            float: left;
        }

        #messages-container {
            max-height: 45vh;
            overflow-y: scroll;
        }

        p {
            font-size: .9rem;
        }

        .time-left,
        .time-left {
            font-size: 0.7rem;
        }
    </style>
@endsection
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
            <div class="card">
                <h5 class="card-header text-center">
                    {{ __('messages') }}
                </h5>
                <div class="row justify-content-center">
                    <div class="card-body">
                        <div id="messages-container">
                            @forelse ($ticket->messages as $message)
                                @if ($message->sender == 'client')
                                    <div class="container darker">
                                        @if ($message->user->image)
                                            <div class="avatar avatar-md right">
                                                <img src="{{ Storage::url($message->user->image) }}" alt="Avatar"
                                                    class="rounded-circle">
                                            </div>
                                        @else
                                            <div class="avatar avatar-lg right">
                                                <span class="avatar-initial rounded-circle bg-info">
                                                    {{ $message->user->getInitials() }}</span>
                                            </div>
                                        @endif
                                        <p class="mb-0 fw-bold">{!! $message->user->name !!}</p>
                                        <p>{!! $message->message !!}</p>
                                        <span class="time-left">{{ $message->created_at->format('d-m-Y h:i a') }}</span>
                                    </div>
                                @elseif($message->sender == 'admin')
                                    <div class="container">
                                        <div class="avatar avatar-md left-float-test me-3">
                                            <span class="avatar-initial rounded-circle bg-info">
                                                {{ $message->admin->getInitials() }}
                                            </span>
                                        </div>
                                        <p class="mb-0 fw-bold">{!! $message->admin->name !!}</p>
                                        <p>{!! $message->message !!}</p>
                                        <span class="time-right">{{ $message->created_at->format('d-m-Y h:i a') }}</span>
                                    </div>
                                @endif
                            @empty
                                <h1 class="text-center">
                                    {{ __('no messages') }}
                                </h1>
                            @endforelse
                        </div>
                        @if (true)
                            <div class="mt-2">
                                <form action="{{ route('admin.tickets.send-message') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="message" class="form-label">
                                            {{ __('message') }}
                                        </label>
                                        <textarea name="message" id="message" cols="30" rows="5"
                                            class="form-control @error('message')
                                    is-invalid
                                @enderror"
                                            placeholder="{{ __('message') }}"></textarea>
                                    </div>
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('send') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
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

            {{-- @if (auth('admin')->user()->getRoleNames()[0] == 'Super Admin' || auth('admin')->user()->id == $ticket->admin_id)
                <div class="card mb-3">
                    <div class="card-body">
                        <a href="{{ route('admin.tickets.conversation', $ticket->ticket_id) }}"
                            class="btn btn-primary w-100 text-white">
                            <i class='bx bx-chat mx-2'></i> {{ __('go to conversation') }}
                        </a>
                    </div>
                </div>
            @endif --}}
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
        // Wait for the DOM to fully load
        document.addEventListener("DOMContentLoaded", function() {
            const scrollableElement = document.getElementById("messages-container");
            scrollableElement.scrollTop = scrollableElement.scrollHeight;
        });
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

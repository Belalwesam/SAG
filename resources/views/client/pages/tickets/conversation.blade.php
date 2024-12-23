@extends('client.layout.app')
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
    {{ __('conversation', ['ticket' => $ticket->ticket_id]) }}
@endsection
@section('content')
    <div class="card">
        <div class="row justify-content-center">
            <div class="card-body">
                <div id="messages-container">
                    @forelse ($ticket->messages as $message)
                        @if ($message->sender == 'client')
                            <div class="container darker">
                                @if ($message->user->image)
                                    <div class="avatar avatar-xl right">
                                        <img src="{{ Storage::url($message->user->image) }}" alt="Avatar"
                                            class="rounded-circle">
                                    </div>
                                @else
                                    <div class="avatar avatar-lg right">
                                        <span class="avatar-initial rounded-circle bg-info">
                                            {{ $message->user->getInitials() }}</span>
                                    </div>
                                @endif

                                <p>{!! $message->message !!}</p>
                                <span class="time-left">{{ $message->created_at->format('d-m-Y h:i a') }}</span>
                            </div>
                        @elseif($message->sender == 'admin')
                            <div class="container">
                                <div class="avatar avatar-lg left-float-test me-3">
                                    <span class="avatar-initial rounded-circle bg-info">
                                        {{ $message->admin->getInitials() }}
                                    </span>
                                </div>
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
                <div class="mt-2">
                    <form action="{{ route('client.tickets.send-message') }}" method="POST">
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
    </script>
@endsection

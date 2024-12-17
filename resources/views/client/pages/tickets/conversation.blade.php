@extends('client.layout.app')
@section('css-vendor')
    <style>
        .container {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        /* Darker chat container */
        .darker {
            border-color: #ccc;
            background-color: #ddd;
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
            height: 45vh;
            overflow-y: scroll;
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
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>

                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                    <div class="container">
                        <div class="avatar avatar-lg left-float-test me-3">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hello. How are you today?</p>
                        <span class="time-right">11:00</span>
                    </div>
                    <div class="container darker">
                        <div class="avatar avatar-lg right">
                            <span class="avatar-initial rounded-circle bg-info">cl</span>
                        </div>
                        <p>Hey! I'm fine. Thanks for asking!</p>
                        <span class="time-left">11:01</span>
                    </div>
                </div>
                <div class="mt-2">
                    <form action="#">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">
                                {{ __('message') }}
                            </label>
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                                placeholder="{{ __('message') }}"></textarea>
                        </div>
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

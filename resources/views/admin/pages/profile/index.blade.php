@extends('admin.layout.app')

@section('title')
    {{ __('profile') }}
@endsection
{{-- main content --}}
@section('content')
    <div class="card">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">{{ __('profile') }}</h5>
        </div>
        <div class="card-body pt-4">
            @if (session('success'))
                <div class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <i class="bx bx-xs bx-check me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('name') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="basic-default-name"
                            placeholder="{{ __('name') }}" value="{{ auth('admin')->user()->name }}">
                        @error('name')
                            <small class="text-danger fw-bold">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('username') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="basic-default-name"
                            placeholder="{{ __('username') }}" value="{{ auth('admin')->user()->username }}">
                        @error('username')
                            <small class="text-danger fw-bold">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('email') }}</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" id="basic-default-name"
                            placeholder="{{ __('email') }}" value="{{ auth('admin')->user()->email }}">
                        @error('email')
                            <small class="text-danger fw-bold">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('password') }}</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" id="basic-default-name"
                            placeholder="********">
                        @error('password')
                            <small class="text-danger fw-bold">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('image') }}</label>
                    <div class="col-sm-10">
                        @if (auth('admin')->user()->image)
                            <label for="image" class="avatar avatar-xl">
                                <img src="{{ Storage::url(auth('admin')->user()->image) }}" alt="Avatar"
                                    class="rounded-circle">
                            </label>
                        @else
                            <label for="image" class="avatar avatar-xl">
                                <span
                                    class="avatar-initial rounded-circle bg-info">{{ auth('admin')->user()->getInitials() }}</span>
                            </label>
                        @endif
                        <input type="file" name="image" id="image" style="visibility: hidden">
                        @error('image')
                            <small class="text-danger fw-bold">
                                {{ $message }}
                            </small>
                        @enderror
                        <input type="hidden" value="{{ auth('admin')->user()->id }}" name="id">
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">{{ __('general.edit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

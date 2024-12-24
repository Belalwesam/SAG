@extends('admin.layout.app')

@section('title')
    @lang('nav.admins')
@endsection
{{-- main content --}}
@section('content')
    <div class="card">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">@lang('nav.categories')</h5>
        </div>
        <div class="card-body pt-4">
            <form>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('name') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" placeholder="{{ __('name') }}"
                            value="{{ auth('admin')->user()->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('username') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name"
                            placeholder="{{ __('username') }}" value="{{ auth('admin')->user()->username }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('email') }}</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="basic-default-name" placeholder="{{ __('email') }}"
                            value="{{ auth('admin')->user()->email }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">{{ __('password') }}</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="basic-default-name" placeholder="********">
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

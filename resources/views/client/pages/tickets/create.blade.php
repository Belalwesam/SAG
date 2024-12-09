@extends('client.layout.app')

@section('title')
    {{ __('submit new ticket') }}
@endsection

{{-- main content --}}
@section('content')
    <div class="card">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0"> {{ __('submit new ticket') }}</h5>
            {{-- check if auth user has ability to create  --}}
            <a href="{{ route('client.tickets.index') }}" class="btn btn-success"><i
                    class="bx bx-chevron-right me-0 me-lg-2"></i><span
                    class="d-none d-lg-inline-block">{{ __('tickets list') }}</span></a>
        </div>
        <div class="card-datatable table-responsive p-5">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="subject" class="form-label">
                        {{ __('subject') }}
                    </label>
                    <input type="text" name="subject" id="subject" placeholder="{{ __('subject') }}"
                        class="form-control">
                    @error('subject')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="subject" class="form-label">
                        {{ __('project') }}
                    </label>
                    <select name="project_id" id="project_id" class="form-select" id="project_id">

                        @forelse ($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->name }}
                            </option>
                        @empty
                            <option value="">{{ __('there are no options') }}</option>
                        @endforelse
                    </select>
                    @error('project')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </form>
        </div>
    </div>
@endsection

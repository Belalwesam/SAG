@extends('client.layout.app')
@section('css-vendor')
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/libs/dropzone/dropzone.css') }}" />
@endsection
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
            @if (session('success'))
                <div class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <i class="bx bx-xs bx-check me-2"></i>
                    {{ __('ticket created') }}
                </div>
            @endif
            <form action="{{ route('client.tickets.store') }}" method="POST" enctype="multipart/form-data">
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
                <div class="form-group mb-4">
                    <label for="subject" class="form-label">
                        {{ __('priority') }}
                    </label>
                    <select name="priority" id="priority" class="form-select" id="priority">
                        <option value="low">{{ __('low') }}</option>
                        <option value="medium">{{ __('medium') }}</option>
                        <option value="high">{{ __('high') }}</option>
                    </select>
                    @error('project')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="subject" class="form-label">
                        {{ __('description') }}
                    </label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="5"
                        placeholder="{{ __('description') }}"></textarea>
                    @error('description')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="subject" class="form-label">
                        {{ __('attachments') }}
                    </label>
                </div>
                <input type="file" name="hiddenFileInput[]" id="hiddenFileInput"
                    style="opacity: 0; visibility:hidden; height:0; position:absolute;">
                <div class="form-group mb-4">
                    <div class="dropzone needsclick" id="dropzone-multi">
                        <div class="dz-message needsclick">
                            Drop files here or click to upload
                            <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                <strong>not</strong> actually
                                uploaded.)</span>
                        </div>
                        <div class="fallback">
                            <input name="file" type="file" />
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('general.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('/dashboard/assets/vendor/libs/dropzone/dropzone.js') }}"></script>

    <script>
        const previewTemplate = `<div class="dz-preview dz-file-preview">
        <div class="dz-details">
        <div class="dz-thumbnail">
            <img data-dz-thumbnail>
            <span class="dz-nopreview">No preview</span>
            <div class="dz-success-mark"></div>
            <div class="dz-error-mark"></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <div class="progress">
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
            </div>
        </div>
        <div class="dz-filename" data-dz-name></div>
        <div class="dz-size" data-dz-size></div>
        </div>
        </div>`;


        const dropzoneMulti = new Dropzone('#dropzone-multi', {
            previewTemplate: previewTemplate,
            parallelUploads: 1,
            maxFilesize: 5,
            addRemoveLinks: true,
            url: "{{ route('client.tickets.store') }}",
            paramName: "files[]",
        });

        // Reference the hidden file input
        const hiddenFileInput = document.querySelector("#hiddenFileInput");

        // Use a DataTransfer object to manage files
        const dataTransfer = new DataTransfer();

        // Function to update the hidden input with the current Dropzone files
        function updateHiddenInput() {
            // Clear the DataTransfer object first to avoid stale files
            dataTransfer.items.clear();

            // Add each file from Dropzone to the DataTransfer object
            dropzoneMulti.getAcceptedFiles().forEach((file) => {
                dataTransfer.items.add(file); // Add files to DataTransfer
            });

            // Update the hidden input with the files from the DataTransfer
            hiddenFileInput.files = dataTransfer.files;
        }

        // Ensure the hidden input is updated every time files are added or removed
        dropzoneMulti.on("addedfile", updateHiddenInput); // When a file is added
        dropzoneMulti.on("removedfile", updateHiddenInput); // When a file is removed

        // Manually trigger updateHiddenInput if needed (e.g., after Dropzone processing completes)
        dropzoneMulti.on("complete", updateHiddenInput);
    </script>
@endsection

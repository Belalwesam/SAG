@extends('admin.layout.app')

@section('title')
    {{ __('projects list') }}
@endsection

@section('css-vendor')
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('/dashboard/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('/dashboard/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/libs/select2/select2.css') }}" />
@endsection

{{-- main content --}}
@section('content')
    <div class="card">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">{{ __('projects list') }}</h5>
            {{-- check if auth user has ability to create  --}}
            @if (auth('admin')->user()->hasAbilityTo('create projects'))
                <button class="btn btn-primary" data-bs-target="#addProjectModal" data-bs-toggle="modal"><i
                        class="bx bx-plus me-0 me-lg-2"></i><span
                        class="d-none d-lg-inline-block">{{ __('add new project') }}</span></button>
            @endif
        </div>
        <div class="container my-3">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="date_from" class="form-label">
                        {{ __('date from') }}
                    </label>
                    <input type="date" name="date_from" id="date_from" class="form-control search-field">
                </div>
                <div class="col-12 col-md-6">
                    <label for="date_to" class="form-label">
                        {{ __('date to') }}
                    </label>
                    <input type="date" name="date_to" id="date_to" class="form-control search-field">
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-categories table border-top">
                <thead>
                    <tr>
                        <th>{{ __('name') }}</th>
                        <th>{{ __('client') }}</th>
                        <th>{{ __('hours') }}</th>
                        <th>@lang('categories.created_at')</th>
                        <th class="d-flex justify-content-center" data-searchable="false" data-orderable="false">
                            @lang('general.actions')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">{{ __('add new project') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="addProjectForm">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('name') }}</label>
                            <input type="text" name="name" placeholder="{{ __('name') }}" id="name"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="hours" class="form-label">{{ __('hours') }}</label>
                            <input type="number" step="1" name="hours" placeholder="{{ __('hours') }}"
                                id="hours" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="user_id" class="form-label">{{ __('client') }}</label>
                            <select name="user_id" id="user_id" class="form-select">
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit-create-btn" class="btn btn-primary">@lang('general.create')</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('general.cancel')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel">@lang('general.edit')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="editCategoryForm">
                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">@lang('categories.name')</label>
                            <input type="text" name="edit_name" placeholder="@lang('categories.name')" id="edit_name"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_hours" class="form-label">{{ __('hours') }}</label>
                            <input type="number" step="1" name="edit_hours" placeholder="{{ __('hours') }}"
                                id="edit_hours" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_user_id" class="form-label">{{ __('client') }}</label>
                            <select name="edit_user_id" id="edit_user_id" class="form-select">
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="edit_id">
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


@section('script-vendor')
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-buttons/datatables-buttons.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/jszip/jszip.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/pdfmake/pdfmake.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/datatables-buttons/buttons.print.js') }}"></script>
    <script src="{{ asset('/dashboard/assets/vendor/libs/select2/select2.js') }}"></script>
@endsection
@section('script')
    <script>
        $('document').ready(function() {
            let datatable;

            function populateTable() {
                datatable = $('.datatables-categories').DataTable({
                    language: {
                        sLengthMenu: '_MENU_',
                        search: '',
                        searchPlaceholder: '@lang('general.search')..',
                        paginate: {
                            previous: '@lang('general.previous')',
                            next: '@lang('general.next')'
                        }
                    },
                    ordering: false,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        method: "GET",
                        url: "{!! route('admin.projects.projects_list') !!}",
                        data: {
                            date_from: $('#date_from').val(),
                            date_to: $("#date_to").val(),
                        }
                    },
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'user_id',
                            name: 'user_id'
                        },
                        {
                            data: 'hours',
                            name: 'hours'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            name: 'actions',
                            data: 'actions',
                            searchable: false,
                            orderable: false
                        },
                    ],
                })

                // to make the datatables inputs appear larger
                setTimeout(() => {
                    $('.dataTables_filter .form-control').removeClass('form-control-sm');
                    $('.dataTables_length .form-select').removeClass('form-select-sm');
                })
            }
            populateTable()
            $('body').on('change', '.search-field', function() {
                datatable.destroy();
                populateTable()
            })
            // ----- crud operations

            //create new ajax request
            $('body').on('click', '#submit-create-btn', function() {
                let data = {
                    _token: "{!! csrf_token() !!}",
                    name: $('#name').val(),
                    hours: $('#hours').val(),
                    user_id: $('#user_id').val()
                }
                let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

                $.ajax({
                    method: 'POST',
                    url: "{!! route('admin.projects.store') !!}",
                    data: data,
                    beforeSend: function() {
                        formBtn.html(
                            '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                        )
                        formBtn.prop('disabled', true)
                    },
                    success: function(response) {
                        successMessage("@lang('general.create_success')")
                        $('#addProjectModal').modal('toggle')
                        document.getElementById("addProjectForm").reset();
                        datatable.ajax.reload()
                    },
                    error: function(response) {
                        errorMessage("@lang('general.error')")
                        displayErrors(response, false)
                    },
                }).done(function() {
                    formBtn.html("@lang('general.create')")
                    formBtn.prop('disabled', false)
                    $('#addProjectModal').modal('toggle')
                }).fail(function() {
                    formBtn.html("@lang('general.create')")
                    formBtn.prop('disabled', false)
                })
            })

            //populate table when pressing edit admin (from table)
            $('body').on('click', '.edit-btn', function() {
                $('#edit_name').val($(this).data('name'))
                $('#edit_hours').val($(this).data('hours'))
                $('#edit_user_id').val($(this).data('user'))
                $('#edit_id').val($(this).data('id'))
            })
            //edit ajax request
            $('body').on('click', '#submit-edit-btn', function() {
                let data = {
                    _token: "{!! csrf_token() !!}",
                    name: $('#edit_name').val(),
                    hours: $('#edit_hours').val(),
                    user_id: $('#edit_user_id').val(),
                    id: $('#edit_id').val(),
                }
                let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

                $.ajax({
                    method: 'PATCH',
                    url: "{!! route('admin.projects.update') !!}",
                    data: data,
                    beforeSend: function() {
                        formBtn.html(
                            '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                        )
                        formBtn.prop('disabled', true)
                    },
                    success: function(response) {
                        successMessage("@lang('general.edit_success')")
                        $('#editProjectModal').modal('toggle')
                        datatable.ajax.reload()
                    },
                    error: function(response) {
                        errorMessage("@lang('general.error')")
                        displayErrors(response, true)
                    },
                }).done(function() {
                    formBtn.html("@lang('general.edit')")
                    formBtn.prop('disabled', false)
                }).fail(function() {
                    formBtn.html("@lang('general.edit')")
                    formBtn.prop('disabled', false)
                })
            })

            //delete btn (from table)
            $('body').on('click', '.delete-btn', function() {
                let id = $(this).data('id')
                Swal.fire({
                    title: "@lang('general.confirmation')",
                    text: " @lang('general.cant_revert')",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "@lang('general.cancel')",
                    confirmButtonText: "@lang('general.delete')",
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        //ajax delete call
                        let data = {
                            _token: "{!! csrf_token() !!}",
                            id: id,
                        }
                        $.ajax({
                            method: 'DELETE',
                            url: "{!! route('admin.projects.delete') !!}",
                            data: data,
                            success: function(response) {
                                successMessage("@lang('general.edit_success')")
                                datatable.ajax.reload()
                            },
                            error: function(response) {
                                errorMessage("@lang('general.error')")
                            },
                        })
                    }
                });
            })
        })
    </script>
@endsection

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
        <div class="card-datatable table-responsive">
            <div class="row m-3">
                <!-- Filter by Created At -->
                <div class="col-md-3">
                    <label for="created-at" class="form-label"><b>{{ __('date') }}</b></label>
                    <input type="date" id="created-at" class="form-control" />
                </div>
            </div>
            
            <table class="datatables-categories table border-top">
                <thead>
                    <tr>
                        <th>{{ __('name') }}</th>
                        <th>{{ __('client') }}</th>
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
        // Initialize DataTable
        let datatable = $('.datatables-categories').DataTable({
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
                url: "{!! route('admin.projects.projects_list') !!}",
                data: function(d) {
                    // Pass the created_at filter to the server
                    d.created_at = $('#created-at').val();
                }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'user_id', name: 'user_id' },
                { data: 'created_at', name: 'created_at' },
                {
                    name: 'actions',
                    data: 'actions',
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                },
            ],
            dom: '<"row mx-2"' +
                '<"col-md-2"<"me-3"l>>' +
                '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-secondary dropdown-toggle mx-3',
                    text: '<i class="bx bx-upload me-2"></i>Export',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="bx bx-printer me-2"></i>Print',
                            className: 'dropdown-item',
                            exportOptions: { columns: [0, 1, 2] }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="bx bx-file me-2"></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: { columns: [0, 1, 2] }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'dropdown-item',
                            exportOptions: { columns: [0, 1, 2] }
                        }
                    ]
                }
            ]
        });

        // Reload the table when the date filter changes
        $('#created-at').on('change', function() {
            datatable.ajax.reload();
        });

        // Adjust input styles
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm');
        });

        // CRUD Operations (Preserved from Original Code)

        // Create new AJAX request
        $('body').on('click', '#submit-create-btn', function() {
            let data = {
                _token: "{!! csrf_token() !!}",
                name: $('#name').val(),
                user_id: $('#user_id').val()
            }
            let formBtn = $(this);

            $.ajax({
                method: 'POST',
                url: "{!! route('admin.projects.store') !!}",
                data: data,
                beforeSend: function() {
                    formBtn.html('<span class="spinner-border" role="status" aria-hidden="true"></span>');
                    formBtn.prop('disabled', true);
                },
                success: function(response) {
                    successMessage("@lang('general.create_success')");
                    $('#addProjectModal').modal('toggle');
                    document.getElementById("addProjectForm").reset();
                    datatable.ajax.reload();
                },
                error: function(response) {
                    errorMessage("@lang('general.error')");
                    displayErrors(response, false);
                }
            }).done(function() {
                formBtn.html("@lang('general.create')");
                formBtn.prop('disabled', false);
            }).fail(function() {
                formBtn.html("@lang('general.create')");
                formBtn.prop('disabled', false);
            });
        });

        // Populate the form when pressing edit (from table)
        $('body').on('click', '.edit-btn', function() {
            $('#edit_name').val($(this).data('name'));
            $('#edit_user_id').val($(this).data('user'));
            $('#edit_id').val($(this).data('id'));
        });

        // Edit AJAX request
        $('body').on('click', '#submit-edit-btn', function() {
            let data = {
                _token: "{!! csrf_token() !!}",
                name: $('#edit_name').val(),
                user_id: $('#edit_user_id').val(),
                id: $('#edit_id').val(),
            }
            let formBtn = $(this);

            $.ajax({
                method: 'PATCH',
                url: "{!! route('admin.projects.update') !!}",
                data: data,
                beforeSend: function() {
                    formBtn.html('<span class="spinner-border" role="status" aria-hidden="true"></span>');
                    formBtn.prop('disabled', true);
                },
                success: function(response) {
                    successMessage("@lang('general.edit_success')");
                    $('#editProjectModal').modal('toggle');
                    datatable.ajax.reload();
                },
                error: function(response) {
                    errorMessage("@lang('general.error')");
                    displayErrors(response, true);
                }
            }).done(function() {
                formBtn.html("@lang('general.edit')");
                formBtn.prop('disabled', false);
            }).fail(function() {
                formBtn.html("@lang('general.edit')");
                formBtn.prop('disabled', false);
            });
        });

        // Delete button (from table)
        $('body').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: "@lang('general.confirmation')",
                text: "@lang('general.cant_revert')",
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
                    let data = { _token: "{!! csrf_token() !!}", id: id };
                    $.ajax({
                        method: 'DELETE',
                        url: "{!! route('admin.projects.delete') !!}",
                        data: data,
                        success: function(response) {
                            successMessage("@lang('general.delete_success')");
                            datatable.ajax.reload();
                        },
                        error: function(response) {
                            errorMessage("@lang('general.error')");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

@extends('admin.layout.app')

@section('title')
    {{ __('clients list') }}
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
            <h5 class="card-title mb-0">{{ __('clients list') }}</h5>
            {{-- check if auth user has ability to create  --}}
            @if (auth('admin')->user()->hasAbilityTo('create clients'))
                <button class="btn btn-primary" data-bs-target="#addClientModal" data-bs-toggle="modal"><i
                        class="bx bx-plus me-0 me-lg-2"></i><span
                        class="d-none d-lg-inline-block">{{ __('add new client') }}</span></button>
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
                        <th>{{ __('image') }}</th>
                        <th>@lang('categories.name')</th>
                        <th>{{ __('email') }}</th>
                        <th>@lang('categories.created_at')</th>
                        <th class="d-flex justify-content-center" data-searchable="false" data-orderable="false">
                            @lang('general.actions')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Add Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">{{ __('add new client') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="addClientForm">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('name') }}</label>
                            <input type="text" name="name" placeholder="{{ __('name') }}" id="name"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">{{ __('username') }}</label>
                            <input type="text" name="username" placeholder="{{ __('username') }}" id="username"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('email') }}</label>
                            <input type="email" name="email" placeholder="{{ __('email') }}" id="email"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{ __('password') }}</label>
                            <input type="password" name="password" placeholder="{{ __('password') }}" id="password"
                                class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="image" class="form-label">{{ __('image') }}</label>
                            <input type="file" name="image" id="image" class="form-control">
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
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">@lang('general.edit')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="editCategoryForm">
                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">{{ __('name') }}</label>
                            <input type="text" name="edit_name" placeholder="{{ __('name') }}" id="edit_name"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_username" class="form-label">{{ __('username') }}</label>
                            <input type="text" name="edit_username" placeholder="{{ __('username') }}"
                                id="edit_username" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_email" class="form-label">{{ __('email') }}</label>
                            <input type="email" name="edit_email" placeholder="{{ __('email') }}" id="edit_email"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_password" class="form-label">{{ __('password') }}</label>
                            <input type="password" name="edit_password" placeholder="{{ __('password') }}"
                                id="edit_password" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_image" class="form-label">{{ __('image') }}</label>
                            <input type="file" name="edit_image" id="edit_image" class="form-control">
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
            //initialise datatbles
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
                    processing: true,
                    serverSide: true,
                    ajax: {
                        method: "GET",
                        url: "{!! route('admin.clients.clients_list') !!}",
                        data: {
                            date_from: $('#date_from').val(),
                            date_to: $("#date_to").val(),
                        }
                    },
                    columns: [{
                            data: "image",
                            name: "image"
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
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
                    dom: '<"row mx-2"' +
                        '<"col-md-2"<"me-3"l>>' +
                        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                        '>t' +
                        '<"row mx-2"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    buttons: [{
                            extend: 'collection',
                            className: 'btn btn-label-secondary dropdown-toggle mx-3',
                            text: '<i class="bx bx-upload me-2"></i>Export',
                            buttons: [{
                                extend: 'csv',
                                text: '<i class="bx bx-file me-2" ></i>Csv',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1, 2, 3],
                                    // prevent avatar to be display
                                    format: {
                                        body: function(inner, coldex, rowdex) {
                                            if (inner.length <= 0) return inner;
                                            var el = $.parseHTML(inner);
                                            var result = '';
                                            $.each(el, function(index, item) {
                                                if (item.classList !== undefined &&
                                                    item
                                                    .classList.contains('user-name')
                                                ) {
                                                    result = result + item.lastChild
                                                        .firstChild.textContent;
                                                } else if (item.innerText ===
                                                    undefined) {
                                                    result = result + item
                                                        .textContent;
                                                } else result = result + item
                                                    .innerText;
                                            });
                                            return result;
                                        }
                                    }
                                }
                            }]
                        },

                    ]
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
                let fd = new FormData();
                fd.append('name', $('#name').val())
                fd.append('username', $('#username').val())
                fd.append('email', $('#email').val())
                fd.append('password', $('#password').val())
                fd.append('_token', "{!! csrf_token() !!}")

                if (document.getElementById('image').files[0]) {
                    fd.append('image', document.getElementById('image').files[0])
                }
                let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

                $.ajax({
                    method: 'POST',
                    url: "{!! route('admin.clients.store') !!}",
                    data: fd,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {
                        formBtn.html(
                            '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                        )
                        formBtn.prop('disabled', true)
                    },
                    success: function(response) {
                        successMessage("@lang('general.create_success')")
                        $('#addClientModal').modal('toggle')
                        document.getElementById("addClientForm").reset();
                        datatable.ajax.reload()
                    },
                    error: function(response) {
                        errorMessage("@lang('general.error')")
                        displayErrors(response, false)
                    },
                }).done(function() {
                    formBtn.html("@lang('general.create')")
                    formBtn.prop('disabled', false)
                    $('#addClientModal').modal('toggle')
                }).fail(function() {
                    formBtn.html("@lang('general.create')")
                    formBtn.prop('disabled', false)
                })
            })

            //populate table when pressing edit admin (from table)
            $('body').on('click', '.edit-btn', function() {
                $('#edit_name').val($(this).data('name'))
                $('#edit_email').val($(this).data('email'))
                $('#edit_username').val($(this).data('username'))
                $('#edit_id').val($(this).data('id'))
            })
            //edit ajax request
            $('body').on('click', '#submit-edit-btn', function() {
                let fd = new FormData();
                fd.append('name', $('#edit_name').val())
                fd.append('id', $('#edit_id').val())
                fd.append('username', $('#edit_username').val())
                fd.append('email', $('#edit_email').val())
                fd.append('password', $('#edit_password').val())
                fd.append('_token', "{!! csrf_token() !!}")
                fd.append('_method', "PATCH")

                if (document.getElementById('edit_image').files[0]) {
                    fd.append('image', document.getElementById('edit_image').files[0])
                }
                let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

                $.ajax({
                    method: 'POST',
                    url: "{!! route('admin.clients.update') !!}",
                    data: fd,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        formBtn.html(
                            '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                        )
                        formBtn.prop('disabled', true)
                    },
                    success: function(response) {
                        successMessage("@lang('general.edit_success')")
                        $('#editClientModal').modal('toggle')
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
                            url: "{!! route('admin.clients.delete') !!}",
                            data: data,
                            success: function(response) {
                                successMessage("@lang('general.delete_success')")
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

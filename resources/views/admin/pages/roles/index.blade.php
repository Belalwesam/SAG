@extends('admin.layout.app')
@section('css-vendor')
@section('title')
    @lang('roles.roles_and_permissions')
@endsection
<link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet"
    href="{{ asset('/dashboard/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet"
    href="{{ asset('/dashboard/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/dashboard/assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('content')
<h4 class="py-3 breadcrumb-wrapper mb-2">@lang('roles.roles')</h4>

<p>
    @lang('roles.roles_list')
</p>
<!-- Role cards -->
<div class="row g-4">
    @foreach ($roles as $role)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">@lang('roles.total_users') {{ count($role->users) }}</h6>
                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                            @foreach ($role->users as $admin)
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    title="" class="avatar avatar-sm"
                                    data-bs-original-title="{{ $admin->name }}">
                                    <span
                                        class="avatar-initial rounded-circle bg-label-secondary">{{ $admin->getInitials() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">
                                @if (app()->getLocale() == 'ar')
                                    {{ $role->name_ar }}
                                @else
                                    {{ $role->name }}
                                @endif
                            </h4>
                            @if (auth('admin')->user()->hasAbilityTo('edit roles'))
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                    data-name = "{{ $role->name }}" data-id = "{{ $role->id }}"
                                    data-name-ar = "{{ $role->name_ar }}"
                                    data-permissions = "{{ $role->permissions->pluck('id') }}"
                                    class="role-edit-btn"><small>@lang('roles.edit_role')</small></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card h-100">
            <div class="row h-100">
                {{-- <div class="col-sm-5">
                    <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                        <img src="{{ asset('/dashboard/assets/img/illustrations/lady-with-laptop-light.png') }}"
                            class="img-fluid" alt="Image" width="100"
                            data-app-light-img="illustrations/lady-with-laptop-light.png"
                            data-app-dark-img="illustrations/lady-with-laptop-dark.png">
                    </div>
                </div> --}}
                <div class="col-sm-7">
                    <div class="card-body">
                        @if (auth('admin')->user()->hasAbilityTo('create roles'))
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap add-new-role">
                                @lang('roles.create_role')
                            </button>
                        @endif
                        <p class="mb-0">@lang('roles.roles_create_message')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top">
                    <thead>
                        <tr>
                            <th></th>
                            <th>@lang('tables.name')</th>
                            <th>@lang('tables.role')</th>
                            <th>@lang('admins.created_at')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Role Table -->
    </div>
</div>
<!--/ Role cards -->



<!-- Add Role Modal -->
<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="role-title">@lang('roles.create_role')</h3>
                </div>
                <!-- Add role form -->
                <form id="addRoleForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework"
                    onsubmit="return false" novalidate="novalidate">
                    <div class="col-12 mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="name">{{ __('name en') }}</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="{{ __('name en') }}" tabindex="-1">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                    <div class="col-12 mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="name_ar">{{ __('name ar') }}</label>
                        <input type="text" id="name_ar" name="name_ar" class="form-control"
                            placeholder="{{ __('name ar') }}" tabindex="-1">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                    <div class="col-12">
                        <h5>@lang('roles.permissions')</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">
                                            @lang('roles.adminstrator_access')
                                            <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title=""
                                                data-bs-original-title="Allows a full access to the system"
                                                aria-label="Allows a full access to the system"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                                <label class="form-check-label" for="selectAll">
                                                    @lang('general.select_all')</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($permissions as $key => $value)
                                        <tr>
                                            <td class="text-nowrap">{{ ucwords($key) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach ($value as $permission)
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input permission-checkbox"
                                                                value={{ $permission->id }} type="checkbox">
                                                            <label class="form-check-label">
                                                                @if (app()->getLocale() == 'ar')
                                                                    {{ $permission->name_ar }}
                                                                @else
                                                                    {{ $permission->name }}
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    {{-- <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input permission-checkbox"
                                                                value="users" type="checkbox">
                                                            <label class="form-check-label"> Write
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                value="admins" type="checkbox">
                                                            <label class="form-check-label"> Create
                                                            </label>
                                                        </div> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" id="submit-create-btn"
                            class="btn btn-primary me-sm-3 me-1">@lang('general.create')</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            @lang('general.cancel')
                        </button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->
<!-- / Add Role Modal -->

<!-- Edit Role Modal -->
<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-new-role">
        <div class="modal-content p-3 p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3 class="role-title">@lang('roles.edit_role')</h3>
                </div>
                <!-- Edit role form -->
                <form id="editRoleForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework"
                    onsubmit="return false" novalidate="novalidate">
                    <div class="col-12 mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="edit_name">{{ __('name en') }}</label>
                        <input type="text" id="edit_name" name="edit_name" class="form-control"
                            placeholder="{{ __('name en') }}" tabindex="-1">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                    <div class="col-12 mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="edit_name_ar">{{ __('name ar') }}</label>
                        <input type="text" id="edit_name_ar" name="edit_name_ar" class="form-control"
                            placeholder="{{ __('name ar') }}" tabindex="-1">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                    <div class="col-12">
                        <h5>@lang('roles.permissions')</h5>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">
                                            @lang('roles.adminstrator_access')
                                            <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title=""
                                                data-bs-original-title="Allows a full access to the system"
                                                aria-label="Allows a full access to the system"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="editSelectAllCheckbox">
                                                <label class="form-check-label" for="editSelectAllCheckbox">
                                                    @lang('general.select_all')</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($permissions as $key => $value)
                                        <tr>
                                            <td class="text-nowrap">{{ ucwords($key) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach ($value as $permission)
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input edit_permission-checkbox"
                                                                value={{ $permission->id }} type="checkbox">
                                                            <label class="form-check-label"> {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <input type="hidden" id="edit_id">
                    <div class="col-12 text-center">
                        <button type="button" id="submit-edit-btn"
                            class="btn btn-primary me-sm-3 me-1">@lang('general.edit')</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            @lang('general.cancel')
                        </button>
                    </div>
                </form>
                <!--/ Edit role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Edit Role Modal -->
<!-- / Edit Role Modal -->
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

        //create datatable
        let table = $('.datatables-users')
        table.DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.roles.role_users') }}",
            columns: [{
                    data: 'initials',
                    name: 'initials',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
                            columns: [1,2 , 3],
                            // prevent avatar to be display
                            format: {
                                body: function(inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = '';
                                    $.each(el, function(index, item) {
                                        if (item.classList !== undefined && item
                                            .classList.contains('user-name')) {
                                            result = result + item.lastChild
                                                .firstChild.textContent;
                                        } else if (item.innerText ===
                                            undefined) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                }
                            }
                        }
                    }]
                },

            ]
        })
        //handle select all checkbox
        $('body').on('change', '#selectAllCheckbox', function() {
            if ($(this).is(":checked")) {
                $('.permission-checkbox').prop('checked', true)
            } else {
                $('.permission-checkbox').prop('checked', false)
            }
        })
        /* the create part */
        //create new ajax request
        $('body').on('click', '#submit-create-btn', function() {
            let permissions = $('.permission-checkbox:checked').map(
                function() { //collect selected checkboxes
                    return $(this).val()
                }).get()
            let data = {
                _token: "{!! csrf_token() !!}",
                name: $('#name').val(),
                name_ar: $('#name_ar').val(),
                permissions: permissions
            }

            let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

            $.ajax({
                method: 'POST',
                url: "{!! route('admin.roles.store') !!}",
                data: data,
                beforeSend: function() {
                    formBtn.html(
                        '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                    )
                    formBtn.prop('disabled', true)
                },
                success: function(response) {
                    successMessage("@lang('general.create_success')")
                    $('#addRoleModal').modal('toggle')
                    document.getElementById("addRoleForm").reset();
                },
                error: function(response) {
                    errorMessage("@lang('general.error')")
                    displayErrors(response, false)
                },
            }).done(function() {
                formBtn.html("@lang('general.create')")
                formBtn.prop('disabled', false)
            }).fail(function() {
                formBtn.html("@lang('general.create')")
                formBtn.prop('disabled', false)
            })
        })


        /* the edit part */
        //handle select all checkbox (in edit mode)
        $('body').on('change', '#editSelectAllCheckbox', function() {
            if ($(this).is(":checked")) {
                $('.edit_permission-checkbox').prop('checked', true)
            } else {
                $('.edit_permission-checkbox').prop('checked', false)
            }
        })

        //clicking the edit button transfers data to the form
        $('body').on('click', '.role-edit-btn', function() {
            $(".is-invalid").each(function() {
                $(this).removeClass("is-invalid");
                $('.invalid-feedback').remove();
            });
            $('.edit_permission-checkbox').each(function() {
                $(this).prop('checked', false)
            })
            let permissions = $(this).data('permissions')
            let name = $(this).data('name')
            let id = $(this).data('id')
            $('#edit_name').val(name)
            $('#edit_name_ar').val($(this).data('name-ar'))
            $('#edit_id').val(id)
            $('.edit_permission-checkbox').each(function() {
                let permissionId = +($(this).val())
                if (permissions.includes(permissionId)) {
                    $(this).prop('checked', true)
                }
            })
        })
        //edit ajax request
        $('body').on('click', '#submit-edit-btn', function() {
            let permissions = $('.edit_permission-checkbox:checked').map(
                function() { //collect selected checkboxes
                    return $(this).val()
                }).get()
            let data = {
                _token: "{!! csrf_token() !!}",
                name: $('#edit_name').val(),
                name_ar: $('#edit_name_ar').val(),
                id: $('#edit_id').val(),
                permissions: permissions
            }
            let formBtn = $(this) // the button that sends the reuquest (to minipulate ui)

            $.ajax({
                method: 'PATCH',
                url: "{!! route('admin.roles.update') !!}",
                data: data,
                beforeSend: function() {
                    formBtn.html(
                        '<span class="spinner-border" role="status" aria-hidden="true"></span>'
                    )
                    formBtn.prop('disabled', true)
                },
                success: function(response) {
                    successMessage("@lang('general.edit_success')")
                    $('#editRoleModal').modal('toggle')
                    document.getElementById("editRoleForm").reset();
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
    })
</script>
@endsection

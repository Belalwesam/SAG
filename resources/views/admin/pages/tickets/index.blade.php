@extends('admin.layout.app')

@section('title')
    {{ __('tickets list') }}
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
            <h5 class="card-title mb-0">{{ __('tickets list') }}</h5>
        </div>
        <div class="container my-3">
            <div class="row">
                <div class="col-12 col-md-3">
                    <label for="date_from" class="form-label">
                        {{ __('date from') }}
                    </label>
                    <input type="date" name="date_from" id="date_from" class="form-control search-field">
                </div>
                <div class="col-12 col-md-3">
                    <label for="date_to" class="form-label">
                        {{ __('date to') }}
                    </label>
                    <input type="date" name="date_to" id="date_to" class="form-control search-field">
                </div>
                <div class="col-12 col-md-3">
                    <label for="status" class="form-label">
                        {{ __('status') }}
                    </label>
                    <select name="status" id="status" class="form-select search-field">
                        <option value="">{{ __('please select') }}</option>
                        <option value="pending">{{ __('pending') }}</option>
                        <option value="processing">{{ __('processing') }}</option>
                        <option value="completed">{{ __('completed') }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label for="priority" class="form-label">
                        {{ __('priority') }}
                    </label>
                    <select name="priority" id="priority" class="form-select search-field">
                        <option value="">{{ __('please select') }}</option>
                        <option value="low">{{ __('low') }}</option>
                        <option value="medium">{{ __('medium') }}</option>
                        <option value="high">{{ __('high') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-categories table border-top">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('client') }}</th>
                        <th>{{ __('project') }}</th>
                        <th>{{ __('priority') }}</th>
                        <th>{{ __('status') }}</th>
                        <th>@lang('categories.created_at')</th>
                        <th class="d-flex justify-content-center" data-searchable="false" data-orderable="false">
                            @lang('general.actions')</th>
                    </tr>
                </thead>
            </table>
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
                        url: "{!! route('admin.tickets.tickets_list') !!}",
                        data: {
                            date_from: $('#date_from').val(),
                            date_to: $("#date_to").val(),
                            status: $("#status").val(),
                            priority: $("#priority").val(),
                        }
                    },
                    columns: [{
                            data: 'ticket_id',
                            name: 'ticket_id'
                        },
                        {
                            data: 'user_id',
                            name: 'user_id'
                        },
                        {
                            data: 'project_id',
                            name: 'project_id'
                        },
                        {
                            data: 'priority',
                            name: 'priority'
                        },
                        {
                            data: 'status',
                            name: 'status'
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
                                    columns: [0, 1, 2, 3, 4, 5],
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
                            }, ]
                        },

                    ]
                })
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
        })
    </script>
@endsection

@extends('client.layout.app')

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
            {{-- check if auth user has ability to create  --}}
            <a href="{{ route('client.tickets.create') }}" class="btn btn-primary"><i
                    class="bx bx-plus me-0 me-lg-2"></i><span
                    class="d-none d-lg-inline-block">{{ __('submit new ticket') }}</span></a>
        </div>
        <div class="card-datatable table-responsive">
            <div class="row m-3">
                <!-- Filter by Created At -->
                <div class="col-md-3">
                    <label for="created-at" class="form-label"><b>{{ __('date') }}</b></label>
                    <input type="date" id="created-at" class="form-control" />
                </div>
            <table class="datatables-categories table border-top">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
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
        // Add a date input filter in the header
        let dateFilter = `<div class="mb-3">
            <label for="created-at" class="form-label">{{ __('Filter by Date') }}</label>
            <input type="date" id="created-at" class="form-control" />
        </div>`;
        $('.dataTables_wrapper').before(dateFilter);

        // Initialize datatables
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
                url: "{!! route('client.tickets.tickets_list') !!}",
                data: function(d) {
                    d.created_at = $('#created-at').val(); // Add created_at filter to AJAX request
                }
            },
            columns: [
                { data: 'ticket_id', name: 'ticket_id' },
                { data: 'project_id', name: 'project_id' },
                { data: 'priority', name: 'priority' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                {
                    name: 'actions',
                    data: 'actions',
                    searchable: false,
                    orderable: false
                },
            ],
        });

        // Reload the table when the date filter changes
        $('#created-at').on('change', function() {
            datatable.ajax.reload();
        });

        // To make the datatables inputs appear larger
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm');
        });

        // ----- CRUD operations 
        // Delete btn (from table)
    });
</script>

@endsection

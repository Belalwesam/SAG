@extends('admin.layout.app')
@section('title')
    @lang('nav.dashboard')
@endsection
@section('content')
    @if (auth('admin')->user()->getRoleNames()[0] == 'Super Admin')
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('clients') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['clients'] }}</h4>
                                </div>
                                <small>{{ __('clients') }}</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-user"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('rejected tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['rejected_tickets'] }}</h4>
                                </div>
                                <small>{{ __('rejected tickets') }}</small>
                            </div>
                            <span class="badge bg-label-danger rounded p-2">
                                <i class="bx bx-window-close bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('pending tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['pending_tickets'] }}</h4>
                                </div>
                                <small>{{ __('pending tickets') }}</small>
                            </div>
                            <span class="badge bg-label-warning rounded p-2">
                                <i class="bx bx-time bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('processing tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['processing_tickets'] }}</h4>
                                </div>
                                <small>{{ __('processing tickets') }}</small>
                            </div>
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bx-cog bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('completed tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['completed_tickets'] }}</h4>
                                </div>
                                <small>{{ __('completed tickets') }}</small>
                            </div>
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-check bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('total tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['total_tickets'] }}</h4>
                                </div>
                                <small>{{ __('total tickets') }}</small>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="bx bx-list-ul bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('total maintenance hours') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['total_maintenance_hours'] }}</h4>
                                </div>
                                <small>{{ __('total maintenance hours') }}</small>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="bx bx-wrench bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('projects') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['projects'] }}</h4>
                                </div>
                                <small>{{ __('projects') }}</small>
                            </div>
                            <span class="badge bg-label-danger rounded p-2">
                                <i class="bx bx-code-alt bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div class="card">
                    <h5 class="card-header">{{ __('tickets') }}</h5>
                    <div class="card-body">
                        <canvas id="doughnutChart" class="chartjs mb-4" data-height="350"></canvas>
                        <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                            <li class="ct-series-0 d-flex flex-column">
                                <h5 class="mb-0 fw-bold" style="font-size: 0.9rem">{{ __('rejected') }}</h5>
                                <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                    style="background-color: rgb(214, 48, 48); width: 35px; height: 6px"></span>
                            </li>
                            <li class="ct-series-1 d-flex flex-column">
                                <h5 class="mb-0 fw-bold" style="font-size: 0.9rem">{{ __('pending') }}</h5>
                                <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                    style="background-color: rgb(205, 208, 40); width: 35px; height: 6px"></span>
                            </li>
                            <li class="ct-series-2 d-flex flex-column">
                                <h5 class="mb-0 fw-bold" style="font-size: 0.9rem">{{ __('processing') }}</h5>
                                <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                    style="background-color: rgb(52, 173, 253); width: 35px; height: 6px"></span>
                            </li>
                            <li class="ct-series-2 d-flex flex-column">
                                <h5 class="mb-0 fw-bold" style="font-size: 0.9rem">{{ __('completed') }}</h5>
                                <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                    style="background-color: rgb(132, 253, 52); width: 35px; height: 6px"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth('admin')->user()->getRoleNames()[0] == 'Supervisor')
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('processing tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['processing_tickets'] }}</h4>
                                </div>
                                <small>{{ __('processing tickets') }}</small>
                            </div>
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bx-cog bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('completed tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['completed_tickets'] }}</h4>
                                </div>
                                <small>{{ __('completed tickets') }}</small>
                            </div>
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-check bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('total tickets') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['total_tickets'] }}</h4>
                                </div>
                                <small>{{ __('total tickets') }}</small>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="bx bx-list-ul bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <span>{{ __('total maintenance hours') }}</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $data['total_maintenance_hours'] }}</h4>
                                </div>
                                <small>{{ __('total maintenance hours') }}</small>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class="bx bx-wrench bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <script src="{{ asset('/dashboard/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script>
        const purpleColor = '#836AF9',
            yellowColor = '#ffe800',
            cyanColor = '#d63030',
            orangeColor = '#FF8132',
            orangeLightColor = '#cdd028',
            oceanBlueColor = '#299AFF',
            greyColor = '#4F5D70',
            greyLightColor = '#EDF1F4',
            blueColor = '#4ffd34',
            blueLightColor = '#34adfd';
        let borderColor, axisColor;
        const doughnutChart = document.getElementById('doughnutChart');
        if (doughnutChart) {
            const doughnutChartVar = new Chart(doughnutChart, {
                type: 'doughnut',
                data: {
                    labels: ["{{ __('rejected') }}", "{{ __('pending') }}", '{{ __('processing') }}',
                        '{{ __('completed') }}'
                    ],
                    datasets: [{
                        data: ["{{ $data['rejected_tickets'] }}", "{{ $data['pending_tickets'] }}",
                            "{{ $data['processing_tickets'] }}",
                            "{{ $data['completed_tickets'] }}"
                        ],
                        backgroundColor: [cyanColor, orangeLightColor, blueLightColor, blueColor],
                        borderWidth: 0,
                        pointStyle: 'rectRounded'
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 500
                    },
                    cutout: '68%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.labels || '',
                                        value = context.parsed;
                                    const output = ' ' + label + ' : ' + value + ' %';
                                    return output;
                                }
                            },
                            // Updated default tooltip UI
                            rtl: isRtl,
                            backgroundColor: config.colors.white,
                            titleColor: config.colors.black,
                            bodyColor: config.colors.black,
                            borderWidth: 1,
                            borderColor: borderColor
                        }
                    }
                }
            });
        }
    </script>
@endsection

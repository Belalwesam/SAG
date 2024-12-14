@extends('client.layout.app')
@section('title')
    @lang('nav.dashboard')
@endsection
@section('content')
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="content-left">
                            <span>{{ __('hours') }}</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $client->hours }}</h4>
                            </div>
                            <small>{{ __('hours') }}</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
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
                            <span>{{ __('pending tickets') }}</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $pending_tickets }}</h4>
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
                                <h4 class="mb-0 me-2">{{ $processing_tickets }}</h4>
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
                                <h4 class="mb-0 me-2">{{ $completed_tickets }}</h4>
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
                                <h4 class="mb-0 me-2">{{ $total_tickets }}</h4>
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
                                <h4 class="mb-0 me-2">{{ $total_maintenance_time }}</h4>
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

    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="card">
                <h5 class="card-header">User by Devices</h5>
                <div class="card-body">
                    <canvas id="doughnutChart" class="chartjs mb-4" data-height="350"></canvas>
                    <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                        <li class="ct-series-0 d-flex flex-column">
                            <h5 class="mb-0 fw-bold">Desktop</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(102, 110, 232); width: 35px; height: 6px"></span>
                            <div class="text-muted">80 %</div>
                        </li>
                        <li class="ct-series-1 d-flex flex-column">
                            <h5 class="mb-0 fw-bold">Tablet</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(40, 208, 148); width: 35px; height: 6px"></span>
                            <div class="text-muted">10 %</div>
                        </li>
                        <li class="ct-series-2 d-flex flex-column">
                            <h5 class="mb-0 fw-bold">Mobile</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(253, 172, 52); width: 35px; height: 6px"></span>
                            <div class="text-muted">10 %</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/dashboard/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
    <script>
        const purpleColor = '#836AF9',
            yellowColor = '#ffe800',
            cyanColor = '#28dac6',
            orangeColor = '#FF8132',
            orangeLightColor = '#FDAC34',
            oceanBlueColor = '#299AFF',
            greyColor = '#4F5D70',
            greyLightColor = '#EDF1F4',
            blueColor = '#2B9AFF',
            blueLightColor = '#84D0FF';
        let borderColor, axisColor;
        const doughnutChart = document.getElementById('doughnutChart');
        if (doughnutChart) {
            const doughnutChartVar = new Chart(doughnutChart, {
                type: 'doughnut',
                data: {
                    labels: ['Tablet', 'Mobile', 'Desktop'],
                    datasets: [{
                        data: [10, 10, 80],
                        backgroundColor: [cyanColor, orangeLightColor, config.colors.primary],
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

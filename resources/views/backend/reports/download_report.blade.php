@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Downloads') }}</h5>
            </div>
           
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>
    </form>
    <div class="card-body overflow-auto">
        <div class="row">
            <div class="col-12">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3 navtab-active">
                    <p class="text-title-thin text-uppercase">Downloads</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $downloads_count = 0;

                                if ($date != null) {
                                    $downloads_count = \App\ReportDownload::whereBetween('created_at', [$start_date, $end_date])
                                        ->count();
                                }

                                else {
                                    $downloads_count = \App\ReportDownload::count();
                                }
                            @endphp

                            {{ $downloads_count }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="fw-600">
                    Downloads
                </span>
            </div>
            <div class="card-body overflow-auto">
                <canvas id="downloadChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="fw-600">
                    Downloads
                </span>
            </div>
            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>File Name</th>
                            <th>Username</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_downloads as $key => $al_d)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ date('Y-m-d', strtotime($al_d->created_at)) }}</td>
                                <td>{{ $al_d->file_name }}</td>
                                <td>{{ $al_d->username }}</td>
                                <td>{{ $al_d->ip_address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $all_downloads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
    <script type="text/javascript">

    var chart_labels = new Array();
    var chart_downloads = new Array();

    @if ($date != null)
        @php
            $sorted_by_date_downloads = [];
        @endphp

        @foreach ($period as $date_period)
            chart_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")
            
            @php
                $sorted_by_date_downloads[] = \App\ReportDownload::whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->count();
            @endphp
        @endforeach

        @foreach ($sorted_by_date_downloads as $date_downloads)
            chart_downloads.push("{{ $date_downloads }}")
        @endforeach
    @else 
        @foreach ($days as $key => $day)
            chart_labels.push("{{ $current_month }} {{ $day }}")
        @endforeach

        @foreach ($downloads as $key => $download)
            chart_downloads.push("{{ $download }}")
        @endforeach
    @endif

   
    
    var downloads = document.getElementById('downloadChart').getContext('2d'); 
    var downloadChart = new Chart(downloads, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Downloads',
                data: chart_downloads,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
						autoSkip: true,
						maxTicksLimit: 10,
						maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
					},
					afterCalculateTickRotation : function (self) {
						self.labelRotation = 90; //Or any other rotation of x-labels you need.
					}
				}
            }
        }
    });
    </script>  
@endsection

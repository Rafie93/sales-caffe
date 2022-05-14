@extends('app.app')
@section('content')
     <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                               
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li class="active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                    <br/><br/>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-1">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Pesanan Masuk Hari Ini </div>
                                        <div class="stat-digit">{{orderTodayIn()}} Pesanan </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-2">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Pendapatan Masuk Hari Ini</div>
                                        <div class="stat-digit"> Rp. {{number_format(pendapatanTodayIn())}}</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-3">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Pesanan Bulan Ini</div>
                                        <div class="stat-digit"> {{orderMonthIn()}} Pesanan</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-two">
                                    <div class="widget-icon color-4">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-text">Pendapatan Bulan Ini</div>
                                        <div class="stat-digit">Rp. {{number_format(pendapatanMonthIn())}}</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Produk Terjual dalam Tahun {{date('Y')}} </h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                            <li class="card-collapse"><i class="fa fa-window-restore"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sales-chart  card-content">
                                    <canvas id="sales-yearly-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                       
                        <!-- /# column -->
                        <div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Produk Terjual dalam Tahun {{date('Y')}} (Bulan) </h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                            <li class="card-collapse"><i class="fa fa-window-restore"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sales-chart  card-content">
                                    <canvas id="sales-monthly-chart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Jumlah Penjualan Tahun {{date('Y')}} (Harian) </h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                            <li class="card-collapse"><i class="fa fa-window-restore"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sales-chart card-content">
                                    <canvas id="saless-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->

                        <div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Jumlah Penjualan Tahun {{date('Y')}} (Bulanan)</h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                            <li class="card-collapse"><i class="fa fa-window-restore"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sales-chart  card-content">
                                    <canvas id="saless-m-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                  </div>
                 <!-- /# card -->
             </div>
             <!-- /# column -->
         </div>
         <!-- /# row -->
     </div>
     <!-- /# main content -->
 </div>
@endsection
@section('script')
    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
    {{-- <script src="assets/js/lib/chart-js/chartjs-init.js"></script> --}}
    <!-- // Chart js -->
    <!--  Datamap -->
    <script src="assets/lib/lobipanel/js/lobipanel.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js"></script>  
    <script>
         $( function() {
			 initFirebaseMessagingRegistration();
             $.ajax({
                url: "{{ route('dashboard.getPenjualanProductYearly') }}",
                type: "GET",
                dataType: 'json',
                success: function(rtnData) {
                    $.each(rtnData, function(dataType, data) {
                        // alert(data.datasets);
                        console.log(data.labels);

                        var ctx = document.getElementById("sales-yearly-chart").getContext("2d");
                        var config = {
                            type: 'line',
                            defaultFontFamily: 'Montserrat',
                            data: {
                                datasets: data.datasets,
                                labels: data.labels
                            },
                            options:  {
                                responsive: true,
                                tooltips: {
                                    mode: 'index',
                                    titleFontSize: 12,
                                    titleFontColor: '#000',
                                    bodyFontColor: '#000',
                                    backgroundColor: '#fff',
                                    titleFontFamily: 'Montserrat',
                                    bodyFontFamily: 'Montserrat',
                                    cornerRadius: 3,
                                    intersect: false,
                                },
                                legend: {
                                    labels: {
                                        usePointStyle: true,
                                        fontFamily: 'Montserrat',
                                    },
                                },
                                scales: {
                                    xAxes: [{
                                        display: true,
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        scaleLabel: {
                                            display: false,
                                            labelString: 'Month'
                                        }
                                            }],
                                    yAxes: [{
                                        display: true,
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Value'
                                        }
                                            }]
                                },
                                title: {
                                    display: false,
                                    text: 'Normal Legend'
                                }
                            }
                        };
                        window.myLine = new Chart(ctx, config);
                    });
                },
                error: function(rtnData) {
                    alert('error' + rtnData);
                }
            });
            $.ajax({
                url: "{{ route('dashboard.getPenjualanProductMonthly') }}",
                type: "GET",
                dataType: 'json',
                success: function(rtnData) {
                    $.each(rtnData, function(dataType, data) {
                        // alert(data.datasets);
                        console.log(data.labels);

                        var ctx = document.getElementById("sales-monthly-chart").getContext("2d");
                        var config = {
                            type: 'line',
                            defaultFontFamily: 'Montserrat',
                            data: {
                                datasets: data.datasets,
                                labels: data.labels
                            },
                            options:  {
                                responsive: true,
                                tooltips: {
                                    mode: 'index',
                                    titleFontSize: 12,
                                    titleFontColor: '#000',
                                    bodyFontColor: '#000',
                                    backgroundColor: '#fff',
                                    titleFontFamily: 'Montserrat',
                                    bodyFontFamily: 'Montserrat',
                                    cornerRadius: 3,
                                    intersect: false,
                                },
                                legend: {
                                    labels: {
                                        usePointStyle: true,
                                        fontFamily: 'Montserrat',
                                    },
                                },
                                scales: {
                                    xAxes: [{
                                        display: true,
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        scaleLabel: {
                                            display: false,
                                            labelString: 'Month'
                                        }
                                            }],
                                    yAxes: [{
                                        display: true,
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Value'
                                        }
                                            }]
                                },
                                title: {
                                    display: false,
                                    text: 'Normal Legend'
                                }
                            }
                        };
                        window.myLine = new Chart(ctx, config);
                    });
                },
                error: function(rtnData) {
                    alert('error' + rtnData);
                }
            });

            $.ajax({
                url: "{{ route('dashboard.getSalesHarian') }}",
                method: "GET",
                success: function(data) {
                    console.log(data);
                    var label = [];
                    var value = [];
                    for (var i in data) {
                        label.push(data[i].date);
                        value.push(data[i].jumlah);
                    }
                    var ctx = document.getElementById('saless-chart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: label,
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                backgroundColor: 'rgb(252, 116, 101)',
                                borderColor: 'rgb(255, 255, 255)',
                                data: value
                            }]
                        },
                        options: {}
                    });
                }
            });
            $.ajax({
                url: "{{ route('dashboard.getSalesBulanan') }}",
                method: "GET",
                success: function(data) {
                    console.log(data);
                    var label = [];
                    var value = [];
                    for (var i in data) {
                        label.push(data[i].date);
                        value.push(data[i].jumlah);
                    }
                    var ctx = document.getElementById('saless-m-chart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: label,
                            datasets: [{
                                label: 'Jumlah Transaksi (Bulanan)',
                                backgroundColor: 'rgb(252, 116, 101)',
                                borderColor: 'rgb(255, 255, 255)',
                                data: value
                            }]
                        },
                        options: {}
                    });
                }
            });
         });
    </script>
@endsection
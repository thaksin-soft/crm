<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-3 lao-font">

                        <div style="background: #e1e1e1" class="p-4 m-2">

                            <form action="" id="form-set-search-conclude-track">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="rd-container mt-2">ເດືອນປີ
                                            <input type="radio" checked="checked" name="time_option_all_track"
                                                value="bymonth" onchange="load_conclude_track_report()">
                                            <span class="rd-checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="{{ date('m') }}"
                                                onchange="load_conclude_track_report()" name="month">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="{{ date('Y') }}"
                                                onchange="load_conclude_track_report()" name="year">
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-2">
                                        <label class="rd-container mt-2">ຊ່ວງວັນທີ່
                                            <input type="radio" name="time_option_all_track" value="bydate"
                                                onchange="load_conclude_track_report()">
                                            <span class="rd-checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-3">

                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                                name="start_date" onchange="load_conclude_track_report()">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-3">

                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                                name="end_date" onchange="load_conclude_track_report()">
                                        </div>
                                    </div>

                                </div> --}}


                            </form>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-primary"><i class="fa fa-users" aria-hidden="true"></i>
                                        ລູກຄ້າຕິດຕໍ່ຫາທັງໝົດ: <span id="all-qty"></span> ຄົນ</h4>
                                    <h4 class="text-success"><i class="fa fa-phone" aria-hidden="true"></i>
                                        ຕິດຕໍ່ຫາລູກຄ້າ: <span id="contract-qty"></span> ຄົນ</h4>
                                    <h4 class="text-danger"><i class="fa fa-times" aria-hidden="true"></i>
                                        ຍັງບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ: <span id="nocontract-qty"></span> ຄົນ
                                    </h4>
                                </div>
                            </div>
                            <div id="all-chart" style="width: 100%; height: 500px;"></div>
                        </div>

                        <div style="background: #e1e1e1" class="p-4 m-2">

                            <form action="" id="form-set-search-compare-track">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="text-center text-primary">ລາຍງານການປຽບທຽບການເຄື່ອນໄຫວ 2 ເດືອນ</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control"
                                                                aria-label="month" value="{{ date('m') - 1 }}"
                                                                name="month1">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control"
                                                                aria-label="year" value="{{ date('Y') }}"
                                                                name="year1">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-1">
                                                <h6 class="mt-2">ທຽບກັບ</h6>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control"
                                                                aria-label="month" value="{{ date('m') }}"
                                                                name="month2">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control"
                                                                aria-label="year" value="{{ date('Y') }}"
                                                                name="year2">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-2">
                                                <input type="radio" name="choose" value="inquire" checked> ສອບຖາມ<br>
                                                <input type="radio" name="choose" value="buy"> ຊື້<br>
                                                <input type="radio" name="choose" value="nobuy"> ບໍ່ຊື້<br>
                                                <input type="radio" name="choose" value="wait"> ລໍຖ້າຕັດສິນໃຈ<br>
                                                <input type="radio" name="choose" value="no_contract">
                                                ບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ<br>
                                                <button type="button" class="btn btn-info"
                                                    onclick="load_report_compare()"><i class="fa fa-refresh"
                                                        aria-hidden="true"></i> load</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </form>
                            <div id="chart-content"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
<script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
    load_conclude_track_report();

    function load_conclude_track_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-con-nocontract') }}",
            type: "GET",
            data: $('#form-set-search-conclude-track').serialize(),
            success: function(value) {

                $.unblockUI();
                var all_qty = value.all_qty;
                var contract_qty = value.contract_qty;
                var wait_qty = value.wait_qty;
                $("#all-qty").html(all_qty);
                $("#contract-qty").html(contract_qty);
                $("#nocontract-qty").html(wait_qty);
                // Load google charts
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                // Draw the chart and set the chart values
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', ''],
                        ['ຕິດຕໍ່ຫາລູກຄ້າ', contract_qty],
                        ['ຍັງບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ', wait_qty]
                    ]);

                    // Optional; add a title and set the width and height of the chart
                    var options = {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 16,
                                fontFamily: "saysettha OT"
                            }
                        }
                    };

                    // Display the chart inside the <div> element with id="piechart"
                    var chart = new google.visualization.PieChart(document.getElementById('all-chart'));
                    chart.draw(data, options);
                }
            }
        })
    }

    function load_report_compare() {
        let choose = $("#form-set-search-compare-track input[name='choose']:checked").val();
        if (choose == 'inquire') {
            load_compare_track_report();
        } else if (choose == 'buy') {
            load_compare_buy_report();
        } else if (choose == 'nobuy') {
            load_compare_nobuy_report();
        } else if (choose == 'wait') {
            load_compare_wait_report();
        } else if (choose == 'no_contract') {
            load_compare_nocontract_report();
        }

    }

    function load_compare_nocontract_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-compare-nocontract') }}",
            type: "GET",
            data: $('#form-set-search-compare-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var d1 = data.data1;
                var d2 = data.data2;
                var date = data.date;
                var month1 = data.month1;
                var month2 = data.month2;

                $('#chart-content').html('');
                $('#chart-content').html(
                    '<canvas id="movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ເດືອນ: " + month1,
                            data: d1,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: 'rgb(255, 73, 0, 0.5)',
                        }, {
                            label: "ເດືອນ: " + month2,
                            data: d2,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }],
                    },
                    options: {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 16,
                                fontFamily: "saysettha OT"
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        }

                    }
                });

            }
        })
    }

    function load_compare_wait_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-compare-wait') }}",
            type: "GET",
            data: $('#form-set-search-compare-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var d1 = data.data1;
                var d2 = data.data2;
                var date = data.date;
                var month1 = data.month1;
                var month2 = data.month2;

                $('#chart-content').html('');
                $('#chart-content').html(
                    '<canvas id="movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ເດືອນ: " + month1,
                            data: d1,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: 'rgb(255, 73, 0, 0.5)',
                        }, {
                            label: "ເດືອນ: " + month2,
                            data: d2,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }],
                    },
                    options: {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 16,
                                fontFamily: "saysettha OT"
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        }

                    }
                });

            }
        })
    }

    function load_compare_nobuy_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-compare-nobuy') }}",
            type: "GET",
            data: $('#form-set-search-compare-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var d1 = data.data1;
                var d2 = data.data2;
                var date = data.date;
                var month1 = data.month1;
                var month2 = data.month2;

                $('#chart-content').html('');
                $('#chart-content').html(
                    '<canvas id="movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ເດືອນ: " + month1,
                            data: d1,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: 'rgb(255, 73, 0, 0.5)',
                        }, {
                            label: "ເດືອນ: " + month2,
                            data: d2,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }],
                    },
                    options: {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 16,
                                fontFamily: "saysettha OT"
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        }

                    }
                });

            }
        })
    }

    function load_compare_buy_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-compare-buy') }}",
            type: "GET",
            data: $('#form-set-search-compare-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var d1 = data.data1;
                var d2 = data.data2;
                var date = data.date;
                var month1 = data.month1;
                var month2 = data.month2;

                $('#chart-content').html('');
                $('#chart-content').html(
                    '<canvas id="movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ເດືອນ: " + month1,
                            data: d1,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: 'rgb(255, 73, 0, 0.5)',
                        }, {
                            label: "ເດືອນ: " + month2,
                            data: d2,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }],
                    },
                    options: {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 16,
                                fontFamily: "saysettha OT"
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        }

                    }
                });

            }
        })
    }

    function load_compare_track_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-compare-track') }}",
            type: "GET",
            data: $('#form-set-search-compare-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var d1 = data.data1;
                var d2 = data.data2;
                var date = data.date;
                var month1 = data.month1;
                var month2 = data.month2;
                $('#chart-content').html('');
                $('#chart-content').html(
                    '<canvas id="movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ເດືອນ: " + month1,
                            data: d1,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: 'rgb(255, 73, 0, 0.5)',
                        }, {
                            label: "ເດືອນ: " + month2,
                            data: d2,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }],
                    },
                    options: {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 16,
                                fontFamily: "saysettha OT"
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        }

                    }
                });

            }
        })
    }
</script>

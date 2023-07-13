<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        @include('dashboard-layouts.marketing-report-all-track');
                        <hr class="pb-4">
                        @include('dashboard-layouts.marketing-report-amass-track');
                        <hr>
                        @include('dashboard-layouts.marketing-report-effective-track');
                        <hr>
                        @include('dashboard-layouts.marketing-report-conclude-track');
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    ///////////////////////////////////////////////////////////////
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });

    function clear_chart() {
        var chart = new Chart("movement-chart");
        // destory old
        chart.destroy();

    }
    load_all_track_report();

    function load_all_track_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-track-all') }}",
            type: "GET",
            data: $('#form-set-search-all-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var date = data.dates;
                var inquire = data.inquire;
                var purchased = data.purchased;
                var no_purchased = data.no_purchased;
                var waiting = data.waiting;
                var no_contract = data.no_contract;
                $('#chart-content').html('');
                $('#chart-content').html(
                    '<canvas id="movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ສອບຖາມ",
                            data: inquire,
                            borderColor: "green",
                            fill: true,
                            backgroundColor: 'rgb(152, 247, 142, 0.5)',
                        }, {
                            label: "ຊື້",
                            data: purchased,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }, {
                            label: "ບໍ່ຊື້",
                            data: no_purchased,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: '#FF6A6A',
                        }, {
                            label: "ລໍຖ້າຕັດສິນໃຈ",
                            data: waiting,
                            borderColor: "yellow",
                            fill: true,
                            backgroundColor: '#FBFF6A',
                        }, {
                            label: "ບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ",
                            data: no_contract,
                            borderColor: "black",
                            fill: true,
                            backgroundColor: '#000000',
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
    load_amass_track_report();

    function load_amass_track_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-track-amass') }}",
            type: "GET",
            data: $('#form-set-search-amass-track').serialize(),
            success: function(data) {
                $.unblockUI();
                var date = data.dates;
                var all_inquire = data.all_inquire;
                var all_purchased = data.all_purchased;
                var all_nopurchased = data.all_nopurchased;
                var all_waiting = data.all_waiting;
                var all_no_contract = data.all_no_contract;
                $('#amass-chart-content').html('');
                $('#amass-chart-content').html(
                    '<canvas id="all-movement-chart" style="height:350px;max-height:350px;"></canvas>');
                new Chart("all-movement-chart", {
                    type: "line",
                    data: {
                        labels: date,
                        datasets: [{
                            label: "ສອບຖາມ",
                            data: all_inquire,
                            borderColor: "green",
                            fill: true,
                            backgroundColor: 'rgb(152, 247, 142, 0.5)',
                        }, {
                            label: "ຊື້",
                            data: all_purchased,
                            borderColor: "blue",
                            fill: true,
                            backgroundColor: 'rgb(95, 128, 255, 0.4)',
                        }, {
                            label: "ບໍ່ຊື້",
                            data: all_nopurchased,
                            borderColor: "red",
                            fill: true,
                            backgroundColor: '#FF6A6A',
                        }, {
                            label: "ລໍຖ້າຕັດສິນໃຈ",
                            data: all_waiting,
                            borderColor: "yellow",
                            fill: true,
                            backgroundColor: '#FBFF6A',
                        }, {
                            label: "ບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ",
                            data: all_no_contract,
                            borderColor: "black",
                            fill: true,
                            backgroundColor: '#000',
                        }]
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

    load_effective();

    function load_effective() {
        $.blockUI({
            message: ''
        });

        var month = $("#search-month").val();
        var year = $("#search-year").val();
        $.ajax({
            url: "{{ route('load-effective-bymonth') }}",
            type: "GET",
            data: $("#form-set-search-effective").serialize(),
            success: function(e) {
                $.unblockUI();
                if (e.max == 0) {
                    $("#max-contract").html('...NoData...');
                    $("#average-contract").html('...NoData...');
                    $("#min-contract").html('...NoData...');
                } else {
                    $("#max-contract").html(e.max);
                    $("#average-contract").html(e.average);
                    $("#min-contract").html(e.min);
                }


            }
        });
    }
    load_conclude_track_report();

    function load_conclude_track_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('report-marketing-track-conclude') }}",
            type: "GET",
            data: $('#search-conclude-track').serialize(),
            success: function(value) {
                $.unblockUI();
                var all_purchased = value.all_purchased;
                var all_no_purchased = value.all_no_purchased;
                var all_waiting = value.all_waiting;
                var all_no_contract = value.all_no_contract;
                // Load google charts
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);
                // Draw the chart and set the chart values
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', ''],
                        ['ຊື້', all_purchased],
                        ['ບໍ່ຊື້', all_no_purchased],
                        ['ລໍຖ້າຕັດສິນໃຈ', all_waiting],
                        ['ບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ', all_no_contract]
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
</script>

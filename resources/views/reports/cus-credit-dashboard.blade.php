<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-3 lao-font">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div style="background: #fcf8f8" class="p-4 m-2 shadow p-3 mb-5 bg-white rounded">
                                    <form action="" id="form-set-search-credit">
                                        <h4 class="text-primary"><i class="fa fa-users" aria-hidden="true"></i>
                                            ລາຍງານແຍກຕາມການອະນຸມັດ: </h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="rd-container mt-2">ເດືອນປີ
                                                    <input type="radio" checked="checked" name="choose" value="bymonth"
                                                        onchange="load_credit_report()">
                                                    <span class="rd-checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control"
                                                        value="{{ date('m') }}" name="month">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control"
                                                        value="{{ date('Y') }}" name="year">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="rd-container mt-2">ທັງໝົດ:
                                                    <input type="radio" name="choose" value="bydate">
                                                    <span class="rd-checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-6">
                                                    <input type="date" class="form-control"
                                                        value="{{ date('Y-m-d') }}" name="startdate"
                                                        onchange="cleardata_credit()" id="startdate">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-2">
                                                    <input type="date" class="form-control"
                                                        value="{{ date('Y-m-d') }}" name="enddate"
                                                        onchange="cleardata_credit()" id="enddate">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="rd-container mt-1">ປະເພດສິນຄ້າ
                                                    <input type="radio" name="choose" value="bydateandcat">
                                                    <span class="rd-checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group mb-6">
                                                    <select class="form-select form-control"
                                                        aria-label="Default select example" id="selectcategory"
                                                        name="cbocategory" onclick="cleardata_credit()">
                                                        {{-- <option selected>.....</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">

                                                <button type="button" class="btn btn-success"
                                                    onclick="load_report_compare()"><i class="fa fa-refresh"
                                                        aria-hidden="true"></i>ເບິ່ງຂໍ້ມູນ</button>
                                            </div>

                                        </div>

                                    </form>
                                    <h4 class="text-primary"><i class="fa fa-users" aria-hidden="true"></i>
                                        ລູກຄ້າສິນເຊື່ອທັງໝົດ: <span id="all-qty"></span> ຄົນ</h4>
                                    <h4 class="text-success"><i class="fa fa-phone" aria-hidden="true"></i>
                                        ອະນຸມັດ: <span id="contract-qty"></span> ຄົນ</h4>
                                    <h4 class="text-danger"><i class="fa fa-times" aria-hidden="true"></i>
                                        ບໍ່ອະນຸມັດ: <span id="nocontract-qty"></span> ຄົນ
                                    </h4>
                                    <h4 class="text-yellow"><i class="fa fa-refresh" aria-hidden="true"></i>
                                        ລໍຖ້າອະນຸມັດ: <span id="waitcontract"></span> ຄົນ
                                    </h4>
                                    <div id="all-chart" style="width: 100%; height: 250px;" class="lao-font">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div style="background: #fcf8f8" class="p-4 m-2 shadow p-3 mb-5 bg-white rounded">
                                    <h4 class="text-primary"><i class="fa fa-home" aria-hidden="true"></i>
                                        ແຍກຕາມປະເພດສິນຄ້າທີ່ຮັບການອະນຸມັດ:</h4>

                                    <table class="table table-bordered" id="table-category-product">
                                        <thead>
                                            <tr>
                                                <th scope="col">ລ/ດ</th>
                                                <th scope="col">ປະເພດສິນຄ້າ</th>
                                                <th scope="col">ຈຳນວນ</th>
                                                <th scope="col">ມູນຄ່າ</th>
                                                <th scope="col">ເປີເຊັນ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categorytotal">
                                        </tbody>
                                    </table>

                                </div>
                                <div style="background: #fcf8f8" class="p-4 m-2 shadow p-3 mb-5 bg-white rounded">
                                    <h4 class="text-primary"><i class="fa fa-home" aria-hidden="true"></i>
                                        ລູກຄ້າສິນເຊື່ອແຍກຕາມບໍລິສັດ:</h4>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">ລ/ດ</th>
                                                <th scope="col">ຊື່ບໍລິສັດ</th>
                                                <th scope="col">ຈຳນວນລູກຄ້າ</th>
                                                <th scope="col">ມູນຄ່າ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="companycredittotal">

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div style="background: #fcf8f8" class="p-4 m-2 shadow p-3 mb-5 bg-white rounded">
                                    <form action="" id="form-set-search-credit">
                                        <h4 class="text-primary"><i class="fa fa-users" aria-hidden="true"></i>
                                            ລາຍງານແຍກຕາມບໍລິສັດ: </h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">

                                                <label class="rd-container mt-2">ເດືອນປີ
                                                    <input type="radio" checked="checked" name="choose" value="bymonth"
                                                        onchange="load_credit_report()">
                                                    <span class="rd-checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control"
                                                        value="{{ date('m') }}" name="month">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control"
                                                        value="{{ date('Y') }}" name="year">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="rd-container mt-2">ທັງໝົດ:
                                                    <input type="radio" name="choose" value="bydate">
                                                    <span class="rd-checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-6">
                                                    <input type="date" class="form-control"
                                                        value="{{ date('Y-m-d') }}" name="startdate"
                                                        onchange="cleardata_credit()" id="startdate">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-2">
                                                    <input type="date" class="form-control"
                                                        value="{{ date('Y-m-d') }}" name="enddate"
                                                        onchange="cleardata_credit()" id="enddate">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="rd-container mt-1">ປະເພດສິນຄ້າ
                                                    <input type="radio" name="choose" value="bydateandcat">
                                                    <span class="rd-checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group mb-6">
                                                    <select class="form-select form-control"
                                                        aria-label="Default select example" id="selectcategory"
                                                        name="cbocategory" onclick="cleardata_credit()">
                                                        {{-- <option selected>.....</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">

                                                <button type="button" class="btn btn-success"
                                                    onclick="load_report_compare()"><i class="fa fa-refresh"
                                                        aria-hidden="true"></i>ເບິ່ງຂໍ້ມູນ</button>
                                            </div>

                                        </div>

                                    </form>
                                    <h4 class="text-primary"><i class="fa fa-users" aria-hidden="true"></i>
                                        ລູກຄ້າສິນເຊື່ອທັງໝົດ: <span id="all-qty"></span> ຄົນ</h4>
                                    <h4 class="text-success"><i class="fa fa-phone" aria-hidden="true"></i>
                                        ອະນຸມັດ: <span id="contract-qty"></span> ຄົນ</h4>
                                    <h4 class="text-danger"><i class="fa fa-times" aria-hidden="true"></i>
                                        ບໍ່ອະນຸມັດ: <span id="nocontract-qty"></span> ຄົນ
                                    </h4>
                                    <h4 class="text-yellow"><i class="fa fa-refresh" aria-hidden="true"></i>
                                        ລໍຖ້າອະນຸມັດ: <span id="waitcontract"></span> ຄົນ
                                    </h4>
                                    <div id="all-chart" style="width: 100%; height: 500px;"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div style="background: #fcf8f8" class="p-4 m-2 shadow p-3 mb-5 bg-white rounded">
                                    <h4 class="text-primary"><i class="fa fa-home" aria-hidden="true"></i>
                                        ແຍກຕາມປະເພດສິນຄ້າທີ່ຮັບການອະນຸມັດ:</h4>

                                    <table class="table table-bordered" id="table-category-product">
                                        <thead>
                                            <tr>
                                                <th scope="col">ລ/ດ</th>
                                                <th scope="col">ປະເພດສິນຄ້າ</th>
                                                <th scope="col">ຈຳນວນ</th>
                                                <th scope="col">ມູນຄ່າ</th>
                                                <th scope="col">ເປີເຊັນ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categorytotal">
                                        </tbody>
                                    </table>

                                </div>
                                <div style="background: #fcf8f8" class="p-4 m-2 shadow p-3 mb-5 bg-white rounded">
                                    <h4 class="text-primary"><i class="fa fa-home" aria-hidden="true"></i>
                                        ລູກຄ້າສິນເຊື່ອແຍກຕາມບໍລິສັດ:</h4>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">ລ/ດ</th>
                                                <th scope="col">ຊື່ບໍລິສັດ</th>
                                                <th scope="col">ຈຳນວນລູກຄ້າ</th>
                                                <th scope="col">ມູນຄ່າ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="companycredittotal">

                                        </tbody>
                                    </table>

                                </div>
                            </div>
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

    function cleardata_credit() {
        $("#categorytotal").html('');
        $("#companycredittotal").html('');
    }

    load_credit_report();

    function load_credit_report() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-credit-report') }}",
            type: "GET",
            data: $('#form-set-search-credit').serialize(),
            success: function(value) {

                $.unblockUI();
                var all_qty = value.allcredit;
                var contract_qty = value.approvecredit;
                var wait_qty = value.noapprovecredit;
                var waitapprove_qty = value.waitapprove;
                $("#all-qty").html(all_qty);
                $("#contract-qty").html(contract_qty);
                $("#nocontract-qty").html(wait_qty);
                $("#waitcontract").html(waitapprove_qty);
                // Load google charts
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                // Draw the chart and set the chart values
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', ''],
                        ['ອະນຸມັດ', contract_qty],
                        ['ບໍ່ອະນຸມັດ', wait_qty],
                        ['ລໍຖ້າອະນຸມັດ', waitapprove_qty]
                    ]);

                    // Optional; add a title and set the width and height of the chart
                    var options = {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 13,
                                fontFamily: "Noto Sans Lao"
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

    function load_credit_report_bydate() {

        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-credit-report-bydate') }}",
            type: "GET",
            data: $('#form-set-search-credit').serialize(),
            success: function(value) {
                $.unblockUI();
                var category = value.category;
                var set_startdate = value.set_startdate;
                var set_enddate = value.set_enddate;
                var categorybydate = value.sqlbycategory;
                var companycredit = value.companycredit;
                var all_qty = value.allcredit;
                var contract_qty = value.approvecredit;
                var wait_qty = value.noapprovecredit;
                var waitapprove_qty = value.waitapprove;
                $("#all-qty").html(all_qty);
                $("#contract-qty").html(contract_qty);
                $("#nocontract-qty").html(wait_qty);
                $("#waitcontract").html(waitapprove_qty);
                $("#set_startdate").html(set_startdate);
                $("#set_enddate").html(set_enddate);
                // Load google charts
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                // Draw the chart and set the chart values
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', ''],
                        ['ອະນຸມັດ', contract_qty],
                        ['ບໍ່ອະນຸມັດ', wait_qty],
                        ['ລໍຖ້າອະນຸມັດ', waitapprove_qty]
                    ]);

                    // Optional; add a title and set the width and height of the chart
                    var options = {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 13,
                                fontFamily: "Noto Sans Lao"
                            }
                        }
                    };

                    // Display the chart inside the <div> element with id="piechart"
                    var chart = new google.visualization.PieChart(document.getElementById('all-chart'));
                    chart.draw(data, options);
                }
                $.each(category, function(index, item) {
                    $("#categorytotal").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.item_type}</td>
                                            <td>${item.itemtype_qty}</td>
                                            <td>${item.itemtype_sum}</td>
                                            <td></td>
                                        </tr>`);



                })
                $.each(companycredit, function(index, item) {
                    $("#companycredittotal").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.cc_name}</td>
                                            <td>${item.numlist}</td>
                                            <td>${item.sum_amount}</td>
                                            <td></td>
                                        </tr>`);



                })

                $("#selectcategory").html(`<option value="">...</option>`);
                $.unblockUI();
                $.each(categorybydate, function(index, item) {
                    $("#selectcategory").append(
                        `<option value="${item.item_type}">${item.item_type}</option>`);
                })

                $.unblockUI();

            }
        })
    }

    function load_credit_report_bydate_cat() {
        let startdate = $("#startdate").val();
        let enddate = $("#enddate").val();
        let cbocategory = $("#selectcategory").val();

        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-credit-report-bydate_cat') }}",
            type: "GET",
            data: {
                'startdate': startdate,
                'enddate': enddate,
                'cbocategory': cbocategory
            },
            success: function(value) {
                $.unblockUI();
                var category = value.category;
                var set_startdate = value.set_startdate;
                var set_enddate = value.set_enddate;
                var categorybydate = value.sqlbycategory;
                var companycredit = value.companycredit;
                var all_qty = value.allcredit;
                var contract_qty = value.approvecredit;
                var wait_qty = value.noapprovecredit;
                var waitapprove_qty = value.waitapprove;
                $("#all-qty").html(all_qty);
                $("#contract-qty").html(contract_qty);
                $("#nocontract-qty").html(wait_qty);
                $("#waitcontract").html(waitapprove_qty);
                $("#set_startdate").html(set_startdate);
                $("#set_enddate").html(set_enddate);
                // Load google charts
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                // Draw the chart and set the chart values
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', ''],
                        ['ອະນຸມັດ', contract_qty],
                        ['ບໍ່ອະນຸມັດ', wait_qty],
                        ['ລໍຖ້າອະນຸມັດ', waitapprove_qty]
                    ]);

                    // Optional; add a title and set the width and height of the chart
                    var options = {
                        legend: {
                            display: true,
                            labels: {
                                fontColor: "black",
                                fontSize: 13,
                                fontFamily: "Noto Sans Lao"
                            }
                        }
                    };

                    // Display the chart inside the <div> element with id="piechart"
                    var chart = new google.visualization.PieChart(document.getElementById('all-chart'));
                    chart.draw(data, options);
                }
                $.each(category, function(index, item) {
                    $("#categorytotal").append(`<tr>
                                    <td>${index+1}</td>
                                    <td>${item.item_type}</td>
                                    <td>${item.itemtype_qty}</td>
                                    <td>${item.itemtype_sum}</td>
                                    <td></td>
                                </tr>`);



                })
                $.each(companycredit, function(index, item) {
                    $("#companycredittotal").append(`<tr>
                                    <td>${index+1}</td>
                                    <td>${item.cc_name}</td>
                                    <td>${item.numlist}</td>
                                    <td>${item.sum_amount}</td>
                                    <td></td>
                                </tr>`);



                })
                $.unblockUI();

            }
        })
    }

    function load_report_compare() {
        let choose = $("#form-set-search-credit input[name='choose']:checked").val();

        if (choose == 'bymonth') {
            load_credit_report();
        } else if (choose == 'bydate') {
            load_credit_report_bydate()
        } else if (choose == 'bydateandcat') {
            load_credit_report_bydate_cat()
        };
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

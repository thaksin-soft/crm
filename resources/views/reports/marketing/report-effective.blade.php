<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                            ປະສິດທິພາບການຕິດຕໍ່ຫາລູກຄ້າ</h4>
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="container mt-2">ເດືອນປີ
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" aria-label="month"
                                        value="{{ $set_month }}" onchange="load_report_bymonth()" id="search-month">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" aria-label="year"
                                        value="{{ $set_year }}" onchange="load_report_bymonth()" id="search-year">
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>ວັນທີ່ບັນທຶກເຂົ້າລະບົບ</th>
                                        <th>ຊື່ລູກຄ້າ</th>
                                        <th>ເບິໂທ</th>
                                        <th>ລາຍການ</th>
                                        <th>ຜູ້ຕິດຕໍ່</th>
                                    </tr>
                                    <tbody>
                                        @foreach ($data as $key => $item)

                                            <tr style="background: #ffd3d7!important;">
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->tr_name }}</td>
                                                <td>{{ $item->tr_tel }}</td>

                                                @php
                                                    $product_name = '';
                                                    $product = App\Models\ProductCustomerInterest::where('tr_code', $item->tr_code)->get();
                                                    foreach ($product as $pro_value) {
                                                        if ($product_name == '') {
                                                            $product_name = $pro_value->cus_interest_product;
                                                        } else {
                                                            $product_name = $product_name . ', ' . $pro_value->cus_interest_product;
                                                        }
                                                    }
                                                @endphp
                                                <td>{{ $product_name }}</td>
                                                <td>{{ $item->emp_name }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <span>{{ $data->links('vendor.pagination.custom') }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i>
                                    ສະຫຼູບພະນັກງານຄ້າງຕິດຕໍ່ລູກຄ້າ</h4>
                                <form action="" id="form-search-no-contract">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="container mt-2">ເດືອນປີ
                                                <input type="radio" checked="checked" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" aria-label="month"
                                                    value="{{ $set_month }}" onchange="load_no_contract_bymonth()"
                                                    name="search-month">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" aria-label="year"
                                                    value="{{ $set_year }}" onchange="load_no_contract_bymonth()"
                                                    name="search-year">
                                            </div>
                                        </div>

                                    </div>
                                </form>

                                <ol style="font-size: 20px" id="no-contract-list">

                                </ol>

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

    function load_report_bymonth() {
        $.blockUI({
            message: ''
        });
        var month = $("#search-month").val();
        var year = $("#search-year").val();
        $.ajax({
            url: "{{ route('session-set-marketing-report') }}",
            type: "GET",
            data: {
                'm': month,
                'y': year
            },
            success: function(e) {
                console.log(e);
                if (e == 'success') {
                    location.reload();
                }
            }
        })
    }
    load_no_contract_bymonth();

    function load_no_contract_bymonth() {
        $.blockUI({
            message: ''
        });
        var month = $("#form-search-no-contract input[name='search-month']").val();
        var year = $("#form-search-no-contract input[name='search-year']").val();
        $.ajax({
            url: "{{ route('load-no-contract-report') }}",
            type: "GET",
            data: {
                'm': month,
                'y': year
            },
            success: function(e) {
                $.unblockUI();
                console.log(e);
                $("#no-contract-list").html('');
                let all_qty = 0;
                $.each(e, function(index, item) {
                    all_qty += item.qty;
                    $("#no-contract-list").append(
                        `<li class="text-danger"><b class="text-primary">${item.emp_name}:</b> ${item.qty} ຄົນ</li>`
                    );

                });
                $("#no-contract-list").append(
                    `<hr><h5 class="text-danger">ຄ້າງຕິດຕໍ່ທັງໝົດ: ${all_qty} ຄົນ</h5>`);
            }
        });
    }
</script>

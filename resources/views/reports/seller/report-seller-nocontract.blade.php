<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            ລາຍການທີ່ຍັງບໍໄດ້ຕິດຕໍ່
                        </h4>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ເດືອນ</span>
                                    </div>
                                    <input type="number" class="form-control" aria-label="month"
                                        value="{{ $set_month }}" onchange="load_report_bymonth()" id="search-month">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ປີ</span>
                                    </div>
                                    <input type="number" class="form-control" aria-label="year"
                                        value="{{ $set_year }}" onchange="load_report_bymonth()" id="search-year">
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th>code</th>
                                <th>ຊື່ລູກຄ້າ</th>
                                <th>ເບິໂທ</th>
                                <th>ລາຍການ</th>
                                <th>ຜູ້ຕິດຕໍ່</th>
                                <th width="50">ເບິ່ງ</th>
                            </tr>
                            <tbody>
                                @foreach ($data as $key => $item)

                                    <tr style="background: #ffd3d7!important;">
                                        <td>{{ $item->tr_code }}</td>
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
                                        <td><a href="" class="text-info"><i class="fa fa-eye"
                                                    aria-hidden="true"></i></a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <span>{{ $data->links('vendor.pagination.custom') }}</span>



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
            url: "{{ route('session-set-seller-report-nocon') }}",
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
</script>

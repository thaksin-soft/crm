<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ລາຍການເຄື່ອນໄຫວ
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
                                <th>ຊື່ລູກຄ້າ</th>
                                <th>ລາຍການ</th>
                                <th>ລູກຄ້າຕິດຕໍ່</th>
                                <th>ຕິດຕໍ່ຫາລູກຄ້າ</th>
                                <th>ສຳເລັດ</th>
                                <th width="50"></th>
                            </tr>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    @php
                                        $tr_code = $item->tr_code;
                                        $cus_name = $item->tr_name;
                                        
                                        $tr_date = $item->created_at;
                                        $con_date = '';
                                        $status = $item->status;
                                        if ($status == 'ຕິດຕໍ່ສຳເລັດ') {
                                            $con_cus = App\Models\ContractCustomer::where('tr_code', $tr_code)->get();
                                            if ($con_cus[0]->status == 'ລໍຖ້າການຕັດສິນໃຈ') {
                                                $color = '#fdff70!important';
                                            } else {
                                                $color = '#abfbbd!important';
                                            }
                                        } else {
                                            $color = '#ffd3d7!important';
                                        }
                                        
                                    @endphp
                                    <tr style="background: {{ $color }};">
                                        <td>{{ $cus_name }}</td>
                                        @php
                                            $product_name = '';
                                            $product = App\Models\ProductCustomerInterest::where('tr_code', $tr_code)->get();
                                            foreach ($product as $pro_value) {
                                                if ($product_name == '') {
                                                    $product_name = $pro_value->cus_interest_product;
                                                } else {
                                                    $product_name = $product_name . ', ' . $pro_value->cus_interest_product;
                                                }
                                            }
                                        @endphp
                                        <td>{{ $product_name }}</td>
                                        @if ($status == 'ຕິດຕໍ່ສຳເລັດ')
                                            <td>{{ $tr_date }} <i class="fa fa-check text-success"
                                                    aria-hidden="true"></i></td>
                                            <td>{{ $con_cus[0]->created_at }}</td>
                                            @if ($con_cus[0]->status != 'ລໍຖ້າການຕັດສິນໃຈ')
                                                @php
                                                    $cus_decide = App\Models\CustomerDecides::where('tr_code', $tr_code)->get();
                                                @endphp
                                                @if (count($cus_decide) > 0)
                                                    <td>{{ $cus_decide[0]->created_at }}</td>
                                                @else
                                                    <td>{{ $con_cus[0]->status }}</td>
                                                @endif

                                            @else
                                                <td>{{ $con_cus[0]->status }}</td>
                                            @endif

                                        @else
                                            <td>{{ $tr_date }} <i class="fa fa-times text-danger"
                                                    aria-hidden="true"></i></td>
                                            <td>{{ $status }}</td>
                                            <td>{{ $status }}</td>

                                        @endif
                                        <td></td>
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
            url: "{{ route('session-set-seller-report-movement') }}",
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

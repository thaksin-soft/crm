<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                            ການຕິດຕໍ່ລູກຄ້າປະຈຳວັນຂອງ ພະນັກງານຂາຍ</h4>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ວັນທີ່</span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="date"
                                        value="{{ date('Y-m-d') }}" id="search-date" onchange="load_data()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ພະນັກງານຂາຍ</span>
                                    </div>
                                    <select name="cb_emp" id="cb_emp" class="form-control" onchange="load_data()">
                                        @php
                                            $emp_seller = App\Models\User::join('role_user', 'role_user.user_id', '=', 'users.id')
                                                ->join('crm_employee', 'crm_employee.id', '=', 'users.emp_id')
                                                ->select('crm_employee.*')
                                                ->where('role_user.role_id', 3)
                                                ->get();
                                            $emp_id = $emp_seller[0]->id;
                                        @endphp
                                        @foreach ($emp_seller as $item)
                                            <option value="{{ $item->id }}">{{ $item->emp_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                {{-- <button class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i>
                                    ຄົ້ນຫາ</button> --}}
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ເວລາຕິດຕໍ່</th>
                                        <th>ລູກຄ້າ</th>
                                        <th>ລາຍການ</th>
                                        <th>ຍີ່ຫໍ່</th>
                                        <th>ສະຖານະ</th>
                                    </tr>
                                    <tbody id="list-table">
                                        @php
                                            $data = App\Models\ContractCustomer::join('crm_track_online', 'crm_track_online.tr_code', 'crm_contract_customer.tr_code')
                                                ->join('crm_brands', 'crm_brands.id', 'crm_contract_customer.prb_id')
                                                ->where('crm_track_online.emp_id', $emp_id)
                                                ->where('crm_contract_customer.created_at', 'LIKE', '%' . date('Y-m-d') . '%')
                                                ->select('crm_contract_customer.created_at', 'crm_contract_customer.product_purchased', 'crm_contract_customer.status', 'crm_track_online.tr_name', 'crm_brands.brand_name')
                                                ->get();
                                        @endphp
                                        @if (count($data) > 0)
                                            @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td>{{ $value->tr_name }}</td>
                                                    <td>{{ $value->product_purchased }}</td>
                                                    <td>{{ $value->brand_name }}</td>
                                                    <td>{{ $value->status }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <h1 class="text-center text-danger">---ບໍ່ມີຂໍ້ມູນ---</h1>
                                                </td>
                                            </tr>
                                        @endif



                                    </tbody>
                                </table>
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

    function load_data() {
        let date = $("#search-date").val();
        let emp_id = $("#cb_emp").val();
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-emp-con-bydate') }}",
            type: 'GET',
            data: {
                'date': date,
                'emp_id': emp_id
            },
            success: function(e) {
                var value = JSON.parse(e);
                $("#list-table").html('');
                if (value.length == 0) {
                    $("#list-table").append('<tr>' +
                        '<td colspan="6">' +
                        '<h1 class="text-center text-danger">---ບໍ່ມີຂໍ້ມູນ---</h1>' +
                        '</td>' +
                        '</tr>');
                } else {
                    $.each(value, function(i, item) {
                        $("#list-table").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + item.created_at + '</td>' +
                            '<td>' + item.tr_name + '</td>' +
                            '<td>' + item.product_purchased + '</td>' +
                            '<td>' + item.brand_name + '</td>' +
                            '<td>' + item.status + '</td>' +
                            '</tr>');
                    })
                }

                $.unblockUI();
            }
        })
    }
</script>

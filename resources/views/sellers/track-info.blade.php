<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-info-circle" aria-hidden="true"></i> ຂໍ້ມູນຕິດຕໍ່ລູກຄ້າ
                        </h4>
                        <div class="row">
                            {{-- ຂໍ້ມູນລູກຄ້າຕິດຕໍ່ຫາ --}}
                            @foreach ($data as $key => $item)
                                @php
                                    
                                    $tr_name = $item->tr_name;
                                    $tr_tel = $item->tr_tel;
                                    $tr_date = $item->created_at;
                                    $address = $item->tr_cus_address;
                                    
                                    //ດຶງຂໍ້ມູນມາຈາກການຕິດຕໍ່ຫາລູກຄ້າ
                                    $con_cus = App\Models\ContractCustomer::where('tr_code', $item->tr_code)
                                        ->where('status', '!=', 'ກຳລັງຕິດຕໍ່')
                                        ->select('crm_contract_customer.*')
                                        ->orderBy('id', 'desc')
                                        ->first();
                                @endphp

                                <div class="col-md-6 mb-3">
                                    <div class="seller-track-info p-2">
                                        <p class="text-center text-danger">{{ $tr_date }}</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6><b>ຊື່ລູກຄ້າ:</b> <span
                                                        class="text-primary">{{ $tr_name }}</span>
                                                </h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6><b>ເບິໂທ:</b> <span
                                                        class="text-primary">{{ $tr_tel }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <h6><b>ທີ່ຢູ່:</b> <span class="text-primary">{{ $address }}</span>
                                        </h6>
                                        {{-- ກວດສອບວ່າໄດ້ມີການຕິດຕໍ່ຫາລູກຄ້າຫຼືຍັງ ຖ້າຕິດຕໍແລ້ວໄປດຶງຂໍ້ມູນມາຈາກການຕິດຕໍ່ --}}
                                        @if ($con_cus)
                                            @php
                                                $con_status = $con_cus->status;
                                                //ດຶງຂໍ້ມູນສິນຄ້າຈາກການສອບຖາມລູກຄ້າ
                                                $con_product = App\Models\ProductCustomerContract::where('tr_code', $item->tr_code)->get();
                                                if (count($con_product)) {
                                                    $cc_id = $con_product[0]->cc_id;
                                                }
                                            @endphp
                                            <table class="table">
                                                @foreach ($con_product as $con_p_key => $con_pro_item)
                                                    <tr>
                                                        <td width="50">{{ $con_p_key + 1 }}</td>
                                                        <td>{{ $con_pro_item->product_purchased }}</td>
                                                        <td>{{ $con_pro_item->pr_size }}</td>
                                                        <td>{{ $con_pro_item->item_brand }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @else
                                            {{-- ກໍລະນີຍັງບໍ່ທັນຕິດຕໍ່ຫາລູກຄ້າ ໃຫ້ດຶງຂໍ້ມູນສິນຄ້າຈາກລູກຄ້າຕິດຕໍ່ --}}
                                            @php
                                                //ດຶງຂໍ້ມູນສິນຄ້າຈາກການຕິດຕໍ່ຂອງລູກຄ້າ
                                                $interest_pro = App\Models\ProductCustomerInterest::where('tr_code', $item->tr_code)->get();
                                            @endphp
                                            <table class="table">
                                                @foreach ($interest_pro as $interest_p_key => $interest_pro_item)
                                                    <tr>
                                                        <td width="50">
                                                            {{ $interest_p_key + 1 }}
                                                        </td>
                                                        <td>
                                                            {{ $interest_pro_item->cus_interest_product }}
                                                        </td>
                                                        <td>
                                                            {{ $interest_pro_item->pr_size }}
                                                        </td>
                                                        <td>
                                                            {{ $interest_pro_item->item_brand }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif

                                        <hr>
                                        {{-- ສ່ວນນີ້ແມ່ນສ່ວນທີ່ກວດສອບວ່າຂໍ້ມູນຈະໄປທີ່ function ໃດຕໍ່ --}}
                                        @if ($item->status == 'ລໍຖ້າຕິດຕໍ່')
                                            {{-- ຍັງບໍ່ທັນຕິດຕໍ່ລູກຄ້າ --}}
                                            <form action="{{ route('contract-customer') }}" method="GET"
                                                id="form-con-cus-{{ $item->id }}">
                                                @csrf
                                                <input type="hidden" name="track_id" value="{{ $item->id }}">
                                                <input type="hidden" name="track_code" value="{{ $item->tr_code }}">

                                                <button class="btn btn-sm btn-danger" type="button"
                                                    id="btn-con-cus-{{ $item->id }}"><i
                                                        class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                                    ຢືນຢັນຕິດຕໍ່ຫາລູກຄ້າ</button>
                                            </form>
                                            <script>
                                                $(document).ready(function(e) {
                                                    $('button#btn-con-cus-' + {{ $item->id }}).click(function(e) {
                                                        let $form = $('#form-con-cus-' + {{ $item->id }}).closest('form');
                                                        Swal.fire({
                                                            title: '<span class="lao-font">ຢືນຢັນການຕິດຕໍ່</span> ?',
                                                            html: '<span class="lao-font">ຖ້າຢືນຢັນ ຈະບັນທືກຂໍ້ມູນການຕິດຕໍ່ລູກຄ້າ ອັດຕະໂນມັດ !!!</span>',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: '<span class="lao-font">ຢືນຢັນ</span>'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $form.submit();
                                                            }
                                                        });
                                                    })
                                                })
                                            </script>
                                        @else
                                            {{-- ກວດສອບວ່າ ລູກຄ້າຢູ່ໃນສະຖານະໃດ (ລໍຖ້າຕັດສິນໃຈ ຫຼື ບໍ່ຊື້) --}}

                                            @if ($con_status == 'ຊື້')
                                                <form action="{{ route('customer-purchase') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="track_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="track_code"
                                                        value="{{ $item->tr_code }}">
                                                    <button class="btn btn-sm btn-primary"><i class="fa fa-money"
                                                            aria-hidden="true"></i>
                                                        ລູກຄ້າຊື້ສິນຄ້າ</button>
                                                </form>
                                            @else
                                                <form action="{{ route('call-check-back') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="cc_id" value="{{ $cc_id }}">
                                                    <input type="hidden" name="track_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="track_code"
                                                        value="{{ $item->tr_code }}">
                                                    <button class="btn btn-sm btn-warning"><i
                                                            class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                                        ຕິດຕໍ່ຫາລູກຄ້າຄືນ</button>
                                                </form>
                                            @endif

                                        @endif

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>
<script>
    function validate(form) {
        if (!form) {
            alert('Please correct the errors in the form!');
            return false;
        } else {
            return confirm('Do you really want to submit the form?');
            /*  */
        }

    }
</script>

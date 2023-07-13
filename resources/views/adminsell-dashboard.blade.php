<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 mt-3 lao-font py-8">
                    <h4 class="text-info"><i class="fa fa-commenting" aria-hidden="true"></i>
                        ຂໍ້ມູນການຕິດຕໍ່ຊື້ສິນຄ້າ
                        ຂອງລູກຄ້າ</h4>


                    <div class="row">

                        <div class="col-md-12">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ລຳດັບ</th>
                                        <th>ຊື່ລູກຄ້າ</th>
                                        <th>ສິນຄ້າທີ່ລູກຄ້າສົນໃຈ</th>
                                        <th>ຜູ້ຕິດຕໍ່ຫາລູກຄ້າ</th>
                                        <th>ສະຖານະ</th>
                                        <th width="20"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        @php
                                            $product_list = '';
                                            //ດຶງຂໍ້ມູນສິນຄ້າທີ່ລູກຄ້າສົນໃຈ
                                            $product = App\Models\ProductCustomerInterest::where('tr_code', $item->tr_code)->get();
                                            foreach ($product as $i => $pro_item) {
                                                if ($product_list == '') {
                                                    $product_list = $pro_item->cus_interest_product;
                                                } else {
                                                    $product_list = $product_list . ', ' . $pro_item->cus_interest_product;
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->tr_name }}</td>
                                            <td>{{ $product_list }}</td>
                                            <td>{{ $item->emp_name }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <a href="#" class="text-info"><i class="fa fa-eye"
                                                        aria-hidden="true"></i></a>
                                            </td>
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

    function search_track_by_date(date) {
        $.ajax({
            url: '/set-date-search-tract',
            type: 'GET',
            data: {
                'date': date
            },
            success: function(e) {
                console.log(e);
            }
        })
    }
</script>

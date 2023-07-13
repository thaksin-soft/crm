<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ລູກຄ້າຊື້ສິນຄ້າ
                        </h4>
                        <form action="" method="POST" id="form-customer-purchased">
                            @csrf
                            <input type="hidden" name="txt_track_id" value="{{ $t_id }}">

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="text-drak"><i class="fa fa-user" aria-hidden="true"></i> ລູກຄ້າ
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">ລະຫັດ</label>
                                            <input type="text" class="form-control" value="{{ $t_code }}"
                                                readonly name="txt_track_code"><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">ຊື່ລູກຄ້າ</label>
                                            <input type="text" class="form-control" value="{{ $data->tr_name }}"
                                                readonly name="txt_cus_name"><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">ທີ່ຢູ່</label>
                                            <input type="text" class="form-control"
                                                value="{{ $data->tr_cus_address }}" readonly
                                                name="txt_cus_address"><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">ເບິໂທ</label>
                                            <input type="text" class="form-control" value="{{ $data->tr_tel }}"
                                                readonly name="txt_cus_tel"><br>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row mb-4">

                                <div class="col-md-12">
                                    <h5 class="text-drak"><i class="fa fa-product-hunt" aria-hidden="true"></i>
                                        ລາຍການສິນຄ້າ
                                    </h5>
                                    <table class="table">
                                        <tr>
                                            <th>ສິນຄ້າທີ່ລູກຄ້າສົນໃຈ</th>
                                            <th>ສິນຄ້າ</th>
                                            <th>ຮູບແບບສິນຄ້າ</th>
                                            <th>ຍີ່ຫໍ້</th>
                                            <th>ຂະໜາດ</th>
                                        </tr>
                                        <tbody id="product-table">
                                            @foreach ($con_cus_product as $pro_key => $product_item)
                                                <tr>
                                                    <td>{{ $product_item->product_purchased }}<input type="hidden"
                                                            name="txt_product_purchased[]"
                                                            value="{{ $product_item->product_purchased }}">
                                                    </td>

                                                    <td>{{ $product_item->item_category }}
                                                        <input type="hidden"
                                                            value="{{ $product_item->item_category }}"
                                                            name="cb_categroy[]">
                                                    </td>
                                                    <td>{{ $product_item->item_pattern }}<input type="hidden"
                                                            value="{{ $product_item->item_pattern }}"
                                                            name="cb_pattern[]"></td>
                                                    <td>{{ $product_item->item_brand }}<input type="hidden"
                                                            value="{{ $product_item->item_brand }}"
                                                            name="cb_brand[]"></td>
                                                    <td>{{ $product_item->product_size }}<input type="hidden"
                                                            name="txt_size[]"
                                                            value="{{ $product_item->product_size }}">
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="text-drak"><i class="fa fa-user" aria-hidden="true"></i>
                                        ຂໍ້ມູນການຂາຍ
                                    </h5>
                                    <label for="">ເລກບິນ</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="txt_bill_id" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button"
                                                onclick="search_bill_from_sml()"><i class="fa fa-search"
                                                    aria-hidden="true"></i> ກວດສອບບິນຂາຍ</button>
                                        </div>
                                    </div>
                                    <label for="">ວັນທີ່ຂາຍ</label>
                                    <input type="text" class="form-control" name="txt_date_sale" readonly>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-md-12" style="padding-right: 12%; padding-left: 10%">
                                    <div id="sale-list"></div>

                                </div>
                            </div>

                        </form>
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
        $('#form-customer-purchased').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '<span class="lao-font">ຢືນຢັນ</span> ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.blockUI({
                        message: ''
                    });
                    $.ajax({
                        url: "{{ route('save-customer-purchased') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(e) {
                            $.unblockUI();
                            console.log(e);
                            if (e == 'success') {
                                window.location.href =
                                    "{{ route('seller-track-show') }}";
                            }
                        }
                    });
                }
            })
        })

    });

    function search_bill_from_sml() {
        let bill_id = $("#form-customer-purchased input[name='txt_bill_id']").val();
        if (bill_id == '') {
            $("#form-customer-purchased input[name='txt_bill_id']").focus();
        } else {
            $.blockUI({
                message: ''
            });
            $.ajax({
                url: "{{ route('seller-search-bill-sale') }}",
                type: "POST",
                data: {
                    'doc_no': bill_id
                },
                success: function(e) {
                    $.unblockUI();
                    let status = e.bill;
                    if (status == 'exit') {
                        let doc_date = e.doc_date;
                        $("#sale-list").html(`<button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        ບັນທຶກການຊື້</button>`);
                        $("#form-customer-purchased input[name='txt_date_sale']").val(doc_date);
                    } else {
                        $("#sale-list").html(`<h6 class="text-danger">ບໍ່ມີຂໍ້ມູນ...!!</h6>`);
                    }
                }
            });
        }
    }

    function load_product_category(id) {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('sell-load-product-category') }}",
            type: "POST",
            data: {
                'id': id
            },
            success: function(result) {
                $('#cb_pro_cate').html('');
                $.each(result, function(index, item) {
                    $('#cb_pro_cate').append('<option value="' + item.id + '">' + item.prc_name +
                        '</option>');
                });
                $.unblockUI();
            }
        });
    }
</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 lao-font">
                    <div class="m-3">
                        <h4 class="text-info text-center"><i class="fa fa-info-circle" aria-hidden="true"></i>
                            ຕິດຕໍ່ລູກຄ້າ
                        </h4>
                        <form action="{{ route('save-contract-customer') }}" method="POST"
                            id="form-save-con-customer">
                            @csrf
                            <input type="hidden" name="txt_track_id" value="{{ $t_id }}">
                            <div class="row">
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
                                <div class="col-md-12">
                                    <h5 class="text-drak"><i class="fa fa-product-hunt" aria-hidden="true"></i>
                                        ສິນຄ້າ
                                        <button class="btn btn-sm btn-info" type="button" data-toggle="modal"
                                            data-target="#modal-add-product"><i class="fa fa-cart-plus"
                                                aria-hidden="true"></i></button> <button class="btn btn-sm btn-danger"
                                            type="button" onclick="remove_product_item()"><i class="fa fa-minus"
                                                aria-hidden="true"></i></button>
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
                                            @foreach ($interest_pro as $pro_key => $product_item)
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
                            <div class="row">
                                <div class="col-md-12" style="padding-right: 12%; padding-left: 10%">
                                    <hr>
                                    <button class="btn btn-danger" type="button" onclick="not_by_product()"><i
                                            class="fa fa-times" aria-hidden="true"></i>
                                        ບໍ່ຊື້</button>

                                    <button class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>
                                        ຊື້</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="modal-add-product">
        <div class="modal-dialog modal-lg lao-font">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ເລືອກລາຍການສິນຄ້າ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">


                            <form action="" id="form-search-product">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="rd-container">Odien
                                            <input type="radio" checked name="rd_company" value="odien">
                                            <span class="rd-checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="rd-container">P$P
                                            <input type="radio" name="rd_company" value="pp">
                                            <span class="rd-checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">ຊື່ສິນຄ້າ ຫຼື ລຸ້ນ</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="..." name="fillter">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-info m-0 p-0 pl-2 pr-2"><i class="fa fa-search"
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>

                    <table class="table">
                        <tr>
                            <th width="50">ລຳດັບ</th>
                            <th>ສິນຄ້າທີ່ລູກຄ້າສົນໃຈ</th>
                            <th>ສິນຄ້າ</th>
                            <th>ຮູບແບບສິນຄ້າ</th>
                            <th>ຍີ່ຫໍ້</th>
                            <th>ຂະໜາດ</th>
                        </tr>
                        <tbody id="table-product-choose">

                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function remove_product_item() {
        var rowctr = document.getElementById("product-table").rows.length - 1;
        document.getElementById("product-table").deleteRow(rowctr);
    }

    function add_product_item(code, pname, cate_name, pattern_name, brand_name, size_name) {
        let ch = 0;
        $('#product-table tr').each(function() {
            let pro_name = $(this).find("td:first").html();
            if (pro_name == pname) {
                ch = 1;
                return;
            }
        });
        if (ch == 0) {
            $("#product-table").append(`<tr>
            <td>${pname}</td>
            <td>${cate_name}<input type="hidden" name="txt_pro_cus_interest[]" value="${pname}">
            <input type="hidden" value="${cate_name}" name="cb_categroy[]"></td>
            <td>${pattern_name}<input type="hidden" value="${pattern_name}" name="cb_pattern[]"></td>
            <td>${brand_name}<input type="hidden" value="${brand_name}" name="cb_brand[]"></td>
            <td>${size_name}<input type="hidden" name="txt_size[]" value="${size_name}"></td>
            </tr>`);
        }
    }

    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form-save-con-customer').submit(function(e) {
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
                    let track_id = $('#form-save-con-customer input[name="txt_track_id"]')
                        .val();
                    let track_code = $('#form-save-con-customer input[name="txt_track_code"]')
                        .val();
                    $.ajax({
                        url: "{{ route('save-contract-customer') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(e) {
                            console.log(e);
                            if (e == 'success') {
                                window.location.href =
                                    "/customer-purchase?track_id=" + track_id +
                                    "&track_code=" + track_code;
                            }
                        }
                    });
                }
            })
        })

        $("#form-search-product").submit(function(e) {
            e.preventDefault();
        })
        $("#form-search-product input[name='fillter']").keyup(function(e) {
            let fillter = $(this).val();
            if (fillter == '') return;
            $.ajax({
                url: "{{ route('search-product-from-sml') }}",
                type: "GET",
                data: $("#form-search-product").serialize(),
                success: function(e) {
                    $('#table-product-choose').html('');
                    $.each(e, function(index, item) {
                        $('#table-product-choose').append(`<tr>
                                <td>${index+1}</td>
                                <td><a href="#" data-toggle="modal" onclick="add_product_item('${item.code}', '${item.pro_name}', '${item.cate_name}', '${item.pattern_name}', '${item.brand_name}', '${item.size_name}')" data-dismiss="modal">${item.pro_name}</a></td>
                                <td>${item.cate_name}</td>
                                <td>${item.pattern_name}</td>
                                <td>${item.brand_name}</td>
                                <td>${item.size_name}</td>
                            </tr>`);
                    });
                }
            });
        })
    });

    function load_product_category(id, key) {
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
                $('#cb_pro_cate_' + key).html('');
                $.each(result, function(index, item) {
                    $('#cb_pro_cate_' + key).append('<option value="' + item.id + '">' + item
                        .prc_name +
                        '</option>');
                });
                $.unblockUI();
            }
        });
    }

    function not_by_product() {
        Swal.fire({
            title: '<span class="lao-font">ເຫດຜົນທີ່ບໍ່ຊື້</span>',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            preConfirm: (data) => {

                var note = data.replace(' ', '');
                if (note == '') {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="lao-font">ແຈ້ງເຕືອນ</span>',
                        html: '<span class="lao-font">ທ່ານຕ້ອງໃສ່ ເຫດຜົນກ່ອນ !!!</span>'
                    });
                } else {
                    $.blockUI({
                        message: ''
                    });
                    var formData = $('#form-save-con-customer').serializeArray();
                    formData.push({
                        name: "txt_nobuy_note",
                        value: note
                    });
                    $.ajax({
                        url: "{{ route('save-customer-cancel') }}",
                        type: "POST",
                        data: formData,
                        success: function(e) {
                            console.log(e);
                            $.unblockUI();
                            if (e == 'success') {
                                window.location.href =
                                    "{{ route('seller-track-show') }}";
                            }
                        }
                    });
                }
            }
        })

    }

    function waiting_desides() {
        Swal.fire({
            title: '<span class="lao-font">ເຫດຜົນ</span>',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            preConfirm: (data) => {

                var note = data.replace(' ', '');
                if (note == '') {
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="lao-font">ແຈ້ງເຕືອນ</span>',
                        html: '<span class="lao-font">ທ່ານຕ້ອງໃສ່ ເຫດຜົນກ່ອນ !!!</span>'
                    });
                } else {
                    $.blockUI({
                        message: ''
                    });
                    var formData = $('#form-save-con-customer').serializeArray();
                    formData.push({
                        name: "txt_waiting_note",
                        value: note
                    });
                    $.ajax({
                        url: "{{ route('save-customer-waiting-decide') }}",
                        type: "POST",
                        data: formData,
                        success: function(e) {
                            console.log(e);
                            $.unblockUI();
                            if (e == 'success') {
                                window.location.href =
                                    "{{ route('seller-track-show') }}";
                            }
                        }
                    });
                }

            }
        })

    }
</script>

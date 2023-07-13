<x-app-layout>
    <style>
        #product-item {
            border: 1px solid;
        }

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <h3 class="text-info"><i class="fa fa-commenting" aria-hidden="true"></i>
                        ແກ້ໄຂຂໍ້ມູນລູກຄ້າຕິດຕໍ່ຊື້ສິນຄ້າ</h3>
                    <hr>
                    <form action="{{ route('track-online.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data" id="form-edit-track">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tr_code" value="{{ $data->tr_code }}">
                        <div class="mb-4 p-4" style="background: #c9c9c9!important">
                            <h5 class="text-primary"><u><i class="fa fa-users" aria-hidden="true"></i>
                                    ຂໍ້ມູນລູກຄ້າ</u>
                            </h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="txt_cus_name"><span class="text-danger">*</span>
                                            <b>ຊື່ລູກຄ້າ</b></label>
                                        <input type="text" class="form-control" id="txt_c_name" name="txt_c_name"
                                            aria-describedby="" placeholder="..." required
                                            value="{{ $data->tr_name }}">

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cb_gender"><span class="text-danger">*</span>
                                            <b>ເພດ</b></label>
                                        <select name="cb_gender" id="cb_gender" class="form-control">
                                            @if ($data->tr_gender == 'ຊາຍ')
                                                <option value="ຊາຍ" selected>ຊາຍ</option>
                                                <option value="ຍິງ">ຍິງ</option>
                                            @else
                                                <option value="ຊາຍ">ຊາຍ</option>
                                                <option value="ຍິງ" selected>ຍິງ</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="txt_cus_address"> <b>ທີ່ຢູ່</b></label>
                                        <input type="text" class="form-control" id="txt_cus_address"
                                            name="txt_cus_address" aria-describedby="" placeholder="..."
                                            value="{{ $data->tr_cus_address }}">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="txt_tel"><span class="text-danger">*</span> <b>ເບິໂທ</b></label>
                                        <input type="number" class="form-control" id="txt_tel" name="txt_tel"
                                            aria-describedby="" placeholder="..." required
                                            value="{{ $data->tr_tel }}">

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cb_contract_option"><span class="text-danger">*</span>
                                            <b>ຊ່ອງທາງການຕິດຕໍ່</b></label>
                                        <select name="cb_contract_option" id="cb_contract_option" class="form-control"
                                            required>
                                            <?php
                                            $s_selected = '';
                                            $w_selected = '';
                                            $f_selected = '';
                                            if ($data->tr_con_channel == 'facebook') {
                                                $f_selected = 'selected';
                                            } elseif ($data->tr_con_channel == 'whatsapp') {
                                                $w_selected = 'selected';
                                            } elseif ($data->tr_con_channel == 'ໜ້າຮ້ານ') {
                                                $s_selected = 'selected';
                                            }
                                            
                                            ?>
                                            <option value="facebook" {{ $f_selected }}>Facebook</option>
                                            <option value="whatsapp" {{ $w_selected }}>What's App</option>
                                            <option value="ໜ້າຮ້ານ" {{ $s_selected }}>ໜ້າຮ້ານ</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="cb_contract_from"><span class="text-danger">*</span> <b>ຈາກ
                                                (ຊື່ຊ່ອງທາງລູກຄ້າຕິດຕໍ່)</b></label>
                                        <select name="cb_contract_from" id="cb_contract_from" class="form-control"
                                            required>
                                            <?php
                                            $selected1 = '';
                                            $selected2 = '';
                                            $selected3 = '';
                                            $selected4 = '';
                                            $selected5 = '';
                                            $selected6 = '';
                                            if ($data->tr_con_from == 'Odienmall ໂອດ່ຽນມໍ') {
                                                $selected1 = 'selected';
                                            } elseif ($data->tr_con_from == 'Odienmall Pakse ໂອດ່ຽນມໍ ປາກເຊ') {
                                                $selected2 = 'selected';
                                            } elseif ($data->tr_con_from == 'ຂາຍສົ່ງແອທົ່ວລາວ') {
                                                $selected3 = 'selected';
                                            } elseif ($data->tr_con_from == 'OD Shop') {
                                                $selected4 = 'selected';
                                            } elseif ($data->tr_con_from == 'Midea Lao') {
                                                $selected5 = 'selected';
                                            } elseif ($data->tr_con_from == 'Odien Air Conditioning') {
                                                $selected6 = 'selected';
                                            }
                                            
                                            ?>
                                            <option value="Odienmall ໂອດ່ຽນມໍ" {{ $selected1 }}>Odienmall ໂອດ່ຽນມໍ
                                            </option>
                                            <option value="Odienmall Pakse ໂອດ່ຽນມໍ ປາກເຊ" {{ $selected2 }}>Odienmall
                                                Pakse ໂອດ່ຽນມໍ ປາກເຊ
                                            </option>
                                            <option value="ຂາຍສົ່ງແອທົ່ວລາວ" {{ $selected3 }}>ຂາຍສົ່ງແອທົ່ວລາວ
                                            </option>
                                            <option value="OD Shop" {{ $selected4 }}>OD Shop</option>
                                            <option value="Midea Lao" {{ $selected5 }}>Midea Lao</option>
                                            <option value="Odien Air Conditioning" {{ $selected6 }}>Odien Air
                                                Conditioning</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txt_cus_facebook"><span class="text-danger">*</span>
                                            <b>ຊື່ແຟສລູກຄ້າ
                                                ຫຼື
                                                ເບີ
                                                whatsapp
                                            </b></label>
                                        <input type="text" class="form-control" id="txt_cus_facebook"
                                            name="txt_cus_facebook" aria-describedby="" placeholder="..." required
                                            value="{{ $data->tr_cus_facebook }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="file" id="upload_file" name="upload_file[]"
                                                onchange="preview_image();" multiple accept="image/*" required />
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="clear_image()"><i class="fa fa-times-circle"
                                                    aria-hidden="true"></i> clear ຮູບ</button>
                                        </div>
                                    </div>
                                    <div id="image_preview" class=""></div>

                                </div>

                            </div>
                        </div>

                        <div class="mb-4 p-4" style="background: #c9c9c9!important">
                            <h5 class="text-primary"><u><i class="fa fa-product-hunt" aria-hidden="true"></i>
                                    ຂໍ້ມູນສິນຄ້າ</u> <button class="btn btn-sm btn-info" type="button"
                                    data-toggle="modal" data-target="#modal-add-product"><i class="fa fa-cart-plus"
                                        aria-hidden="true"></i></button> <button class="btn btn-sm btn-danger"
                                    type="button" onclick="remove_product_item()"><i class="fa fa-minus"
                                        aria-hidden="true"></i></button></h5>
                            <div class="row">

                                @foreach ($depend as $depend_item)
                                    @php
                                        if ($old_depend_id == $depend_item->id) {
                                            $checked = 'checked';
                                        } else {
                                            $checked = '';
                                        }
                                        
                                    @endphp
                                    <div class="col-sm-2">
                                        <label class="rd-container">{{ $depend_item->depend_name }}
                                            <input type="radio" {{ $checked }} name="depend"
                                                value="{{ $depend_item->id }}" onchange="load_employee(this.value)">
                                            <span class="rd-checkmark"></span>
                                        </label>
                                    </div>
                                @endforeach


                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div id="product-items" class="p-3"
                                        style="background: #eeeded!important">
                                        <table class="table">
                                            <tr>
                                                <th>ສິນຄ້າທີ່ລູກຄ້າສົນໃຈ</th>
                                                <th>ສິນຄ້າ</th>
                                                <th>ຮູບແບບສິນຄ້າ</th>
                                                <th>ຍີ່ຫໍ້</th>
                                                <th>ຂະໜາດ</th>
                                            </tr>
                                            <tbody id="product-table">
                                                @foreach ($product as $pro_key => $product_item)
                                                    <tr>
                                                        <td>{{ $product_item->cus_interest_product }}<input
                                                                type="hidden" name="txt_pro_cus_interest[]"
                                                                value="{{ $product_item->cus_interest_product }}">

                                                        </td>
                                                        <td>{{ $product_item->item_category }}<input type="hidden"
                                                                value="{{ $product_item->item_category }}"
                                                                name="cb_categroy[]"></td>
                                                        <td>{{ $product_item->item_pattern }}<input type="hidden"
                                                                value="{{ $product_item->item_pattern }}"
                                                                name="cb_pattern[]"></td>
                                                        <td>{{ $product_item->item_brand }}<input type="hidden"
                                                                value="{{ $product_item->item_brand }}"
                                                                name="cb_brand[]"></td>
                                                        <td>{{ $product_item->pr_size }}<input type="hidden"
                                                                name="txt_size[]"
                                                                value="{{ $product_item->pr_size }}"></td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6 for="txt_note" class="text-danger"> <b>ໝາຍເຫດ</b></h6>
                                        <textarea name="txt_note" id="txt_note" class="form-control"
                                            rows="5">{{ $data->note }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="mb-3 p-4" style="background: #c9c9c9!important">
                            <h5 class="text-primary"><u><i class="fa fa-male" aria-hidden="true"></i>
                                    ພະນັກງານຕິດຕໍ່ຫາລູກຄ້າ</u></h5>
                            <div class="row" id="employee-section">
                                @foreach ($emp_seller as $key => $emp_item)
                                    <?php
                                    $checked = '';
                                    if ($data->emp_id == $emp_item->id) {
                                        $checked = 'checked';
                                    }
                                    
                                    ?>
                                    <div class="col-md-3">
                                        <label class="rd-container"><a href="#" data-toggle="modal"
                                                data-target="#modal-show-seller-track-list">{{ $emp_item->emp_name }}</a>
                                            <input type="radio" {{ $checked }} name="rd_employee"
                                                value="{{ $emp_item->id }}">
                                            <span class="rd-checkmark"></span>
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>


                        <hr>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                            ບັນທືກ</button>
                    </form>
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
    function load_employee(depend_id) {
        $.ajax({
            url: "{{ route('jq-load-employee') }}",
            type: 'GET',
            data: {
                'id': depend_id
            },
            success: function(e) {
                $("#employee-section").html('');
                var checked = 'checked';
                $.each(e, function(index, item) {
                    $("#employee-section").append('<div class="col-md-3">' +
                        '<label class="rd-container"><a href="#" data-toggle="modal"' +
                        'data-target="#modal-show-seller-track-list">' + item.emp_name +
                        ' </a>' +
                        '<input type="radio" ' + checked + ' name="rd_employee"' +
                        'value="' + item.id + '">' +
                        '<span class="rd-checkmark"></span>' +
                        '</label>' +
                        '</div>');
                    checked = '';
                })
            }
        })
    }

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
        $("#form-edit-track").submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let qty_product = $("#product-table tr").length;
            if (qty_product == 0) {
                Swal.fire({
                    icon: 'error',
                    title: '<span>Error !!</span>',
                    html: '<span class="lao-font text-center">ເພີ່ມຂໍ້ມູນລູກຄ້າກ່ອນ</span>'
                })
                return;
            }
            $.ajax({
                url: url,
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //$("#preview").fadeOut();
                    $.blockUI({
                        message: ''
                    });
                },
                success: function(data) {
                    console.log(data);
                    $.unblockUI();
                    if (data == 'index') {
                        window.location.href = "{{ route('track-online.index') }}";
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        });

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

    function load_product_category(id, i) {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('admin-load-product-category') }}",
            type: "GET",
            data: {
                'id': id
            },
            success: function(e) {
                $.unblockUI();
                $('#cb_pro_cate_' + i).html('');
                $.each(e, function(index, item) {
                    $('#cb_pro_cate_' + i).append('<option value="' + item.id + '">' + item
                        .prc_name +
                        '</option>');
                });
            }
        });
    }

    function clear_image() {
        $('#image_preview').html('');
        $('#upload_file').val('');
    }

    function preview_image() {
        $('#image_preview').html('');
        var total_file = document.getElementById("upload_file").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                "' width='200' height='200' class='m-2'>");
        }
    }
</script>

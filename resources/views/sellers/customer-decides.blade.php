<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-sticky-note" aria-hidden="true"></i>
                            ຂໍ້ມູນການຕັດສິນໃຈຂອງລູກຄ້າ
                        </h4>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="container"><a>ຊື້</a>
                                    <input type="radio" checked name="decide_status" value="ຊື້"
                                        onchange="set_deside_status(this.value)">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="container"><a>ບໍ່ຊື້</a>
                                    <input type="radio" name="decide_status" value="ບໍ່ຊື້"
                                        onchange="set_deside_status(this.value)">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="container"><a>ລໍຖ້າຕັດສິນໃຈ</a>
                                    <input type="radio" name="decide_status" value="ລໍຖ້າຕັດສິນໃຈ"
                                        onchange="set_deside_status(this.value)">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div style="margin-left: 50px; margin-right: 50px">
                                    <form action="" id="form-buy">
                                        @csrf
                                        <div>
                                            <label for="txt_bill_id">ເລກບິນ</label>
                                            <input type="text" name="txt_bill_id" id="txt_bill_id" class="form-control"
                                                required>
                                        </div>
                                        <div class="mt-2">
                                            <label for="txt_sale_date">ວັນທີ່ຊື້</label>
                                            <input type="date" name="txt_sale_date" id="txt_sale_date"
                                                class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div><br>
                                        <button class="btn btn-success"><i class="fa fa-floppy-o"
                                                aria-hidden="true"></i> ບັນທືກ</button>
                                    </form>
                                    <form action="" id="form-no-buy" style="display: none">
                                        @csrf
                                        <div>
                                            <label for="txt_nb_note">ເຫດຜົນບໍ່ຊື້</label>
                                            <textarea name="txt_nb_note" id="txt_nb_note" class="form-control" rows="5"
                                                required></textarea>
                                        </div><br>
                                        <button class="btn btn-success"><i class="fa fa-floppy-o"
                                                aria-hidden="true"></i> ບັນທືກ</button>

                                    </form>
                                    <form action="" id="form-waiting" style="display: none">
                                        @csrf
                                        <div>
                                            <label for="txt_w_note">ເຫດຜົນ</label>
                                            <textarea name="txt_w_note" id="txt_w_note" class="form-control" rows="5"
                                                required></textarea>
                                        </div><br>
                                        <button class="btn btn-success"><i class="fa fa-floppy-o"
                                                aria-hidden="true"></i> ບັນທືກ</button>

                                    </form>
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

    function set_deside_status(status) {
        if (status == 'ຊື້') {
            $('#form-buy').show();
            $('#form-no-buy').hide();
            $('#form-waiting').hide();
        } else if (status == 'ບໍ່ຊື້') {
            $('#form-buy').hide();
            $('#form-no-buy').show();
            $('#form-waiting').hide();
        } else if (status == 'ລໍຖ້າຕັດສິນໃຈ') {
            $('#form-buy').hide();
            $('#form-no-buy').hide();
            $('#form-waiting').show();
        }
    }

    function confirm_contract_customer(id) {
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນ </span>?',
            icon: 'question',
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
                    url: "{{ route('seller-confirm-contract-customer') }}",
                    type: "GET",
                    data: {
                        'track_id': id
                    },
                    success: function(e) {
                        console.log(e);
                        if (e == 'success') {
                            location.replace("{{ route('seller-previous-tracking') }}");
                        }
                    }
                })
            }
        })
    }
</script>

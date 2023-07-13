<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-users" aria-hidden="true"></i> ລູກຄ້າສິນເຊື່ອທີ່ບໍ່ອະນຸມັດ</h4>
                        <hr>

                        <div class="row">
                            <div class="col-sm-12">
                                <form action="" id="form-add-credit-cus">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h6 class="text-primary"><i class="fa fa-th-list" aria-hidden="true"></i>
                                                ລາຍຊື່ລູກຄ້າສິນເຊື່ອທີ່ບໍ່ອະນຸມັດ</h6>
                                            <div class="input-group mb-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">ວັນທີ:</span>
                                                </div>
                                                <input type="date" class="form-control" id="search-date-start"
                                                    onchange="load_report_bydate()">
                                                <input type="date" class="form-control" id="search-date-end" value=""
                                                    onchange="load_report_bydate()">
                                            </div>



                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <table class="table">
                                                <tr>
                                                    <th>ເລກທີເອກະສານ</th>
                                                    <th>ວັນທີ</th>
                                                    <th>ຊື່ລູກຄ້າ</th>
                                                    <th>ໂທລະສັບ</th>
                                                    <th>ສິນຄ້າ</th>
                                                    <th>ປະເພດສິນຄ້າ</th>
                                                    <th>ພະນັກງານຂາຍ</th>
                                                    <th>ສະຖານະ</th>
                                                    <th>ການອະນຸມັດ</th>
                                                </tr>
                                                <tbody class="text-primary">
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ $item->doc_run }}</td>
                                                            <td>{{ $item->doc_date }}</td>
                                                            <td>{{ $item->cus_name }}</td>
                                                            <td>{{ $item->cus_tel }}</td>
                                                            <td>{{ $item->item_name }}</td>
                                                            <td>{{ $item->item_type }}</td>
                                                            <td>{{ $item->creator }}</td>
                                                            <td>{{ $item->approve_status }}</td>
                                                            <td>
                                                                @if ($item->approve_status == 'ບໍ່ອະນຸມັດ')
                                                                    <button type="button" class="btn btn-success"
                                                                        onclick="confirm_contract_customer({{ $item->doc_run }})"><i
                                                                            class="fa fa-floppy-o"
                                                                            aria-hidden="true"></i>
                                                                        ໂອນໄປບໍລິສັດອື່ນ</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        <span>{{ $data->links('vendor.pagination.custom') }}</span>


                                    </div>
                            </div>
                        </div>
                        <br>

                        </form>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ຂໍ້ມູນລູກຄ້າທີ່ໂອນໄປ</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{-- <form action="" method="GET">
                                        @csrf
                                        <div>
                                            <input type="hidden" id="custId" name="custId">
                                            <label for="txt_nb_note">ເຫດຜົນບໍ່ອະນຸມັດ</label>
                                            <textarea name="txt_nb_note" id="txt_nb_note" class="form-control"
                                                rows="5" required></textarea>
                                        </div><br>
                                        <button class="btn btn-success" onclick="confirm_noapprove()""><i class="
                                            fa fa-floppy-o"
                                            aria-hidden="true"></i>
                                            ບັນທືກ</button>

                                    </form> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ປິດ</button>
                                </div>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function confirm_contract_customer(id) {
        console.log(id)
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນການອະນຸມັດ </span>?',
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
                    url: "{{ route('Approve-confirm') }}",
                    type: "GET",
                    data: {
                        'doc_run': id
                    },
                    success: function(e) {
                        console.log(e);
                        if (e == 'success') {
                            location.replace("{{ route('load-credit-cus-all') }}");
                        }
                    }
                })
            }
        })
    }

    $(document).ready(function() {
        $(".noapprove").click(function() {
            $('.modal-title').text('ບັນທຶກເຫດຜົນ');
            $("#myModal").modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            let doc_run = $('#custId').val(data[0]);
            let note = $('#txt_nb_note').val();

        });

    });

    function confirm_noapprove() {

        $.ajax({
            url: "",
            type: "POST",
            data: {
                'doc_run': $('#custId').val(),
                'note': $('#txt_nb_note').val()
            },
            success: function(e) {
                console.log(e);
                if (e == 'success') {
                    location.replace("{{ route('load-credit-cus-all') }}");
                }
            }
        })
    }

    function load_report_bydate() {
        $.blockUI({
            message: ''
        });
        var start_date = $("#search-date-start").val();
        var end_date = $("#search-date-end").val();
        $.ajax({
            url: "{{ route('set-startdate-creditreport') }}",
            type: "GET",
            data: {
                'start_date': start_date,
                'end_date': end_date
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

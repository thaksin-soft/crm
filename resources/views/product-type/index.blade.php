<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 mt-3 lao-font py-8">
                    <h4 class="text-info"><i class="fa fa-pied-piper" aria-hidden="true"></i> ປະເພດສິນຄ້າ</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('pro-type.store') }}">
                                @csrf

                                <!-- full Name -->
                                <div>
                                    <label for="prt_code"><span class="text-danger">*</span> Code</label>

                                    <x-input id="prt_code" class="form-control" type="text" name="prt_code"
                                        :value="old('prt_code')" required autofocus placeholder="..." />
                                </div>

                                <!-- full Name -->
                                <div class="mt-4">
                                    <label for="prt_name"><span class="text-danger">*</span> ຊື່ປະເພດສິນຄ້າ</label>

                                    <x-input id="prt_name" class="form-control" type="text" name="prt_name"
                                        :value="old('prt_name')" required autofocus placeholder="..." />
                                </div>

                                <div class="flex items-center justify-end mt-4">


                                    <x-button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        {{ __(' ບັນທຶກ') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ລຳດັບ</th>
                                        <th>Code</th>
                                        <th>ຊື່ປະເພດສິນຄ້າ</th>
                                        <th width="30">ແກ້ໄຂ</th>
                                        <th width="30">ລຶບ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key =>$item)
                                    <tr>
                                        <td>{{ ($key + 1) }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->prt_name }}</td>
                                        <td class="text-center">
                                            <a href="#" class="text-warning" data-toggle="modal"
                                                data-target="#modal-edit-emp"
                                                onclick="set_edit_prt({{ $item->id }}, '{{ $item->code }}', '{{ $item->prt_name }}')"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="text-danger"
                                                onclick="delete_product_type({{ $item->id }})"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></a>

                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="modal-edit-emp">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header lao-font">
                    <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ແກ້ໄຂຂໍ້ມູນ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body lao-font">
                    <form method="POST" action="" id="form-edit-prt">
                        @csrf
                        <input type="hidden" name="prt_id">
                        <!-- full Name -->
                        <div>
                            <label for="edit_code"><span class="text-danger">*</span> Code</label>

                            <x-input class="form-control" type="text" name="edit_code" :value="old('edit_code')"
                                required autofocus placeholder="..." />
                        </div>

                        <div class="mt-4">
                            <label for="edit_prt_name"><span class="text-danger">*</span> ຊື່ຍີ່ຫໍ້ສິນຄ້າ</label>

                            <x-input class="form-control" type="text" name="edit_prt_name" :value="old('edit_prt_name')"
                                required autofocus placeholder="..." />
                        </div>


                        <div class="flex items-center justify-end mt-4">


                            <x-button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                {{ __(' ບັນທຶກ') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="close-edit">Close</button>
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
    $('#form-edit-prt').submit(function(e) {
        e.preventDefault();
        $('#close-edit').click();
        var id = $('#form-edit-prt input[name="prt_id"]').val();
        var url = "pro-type/" + id;
        $.blockUI({
            message: 'ກຳລັງແກ້ໄຂ'
        });
        $.ajax({
            url: url,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(e) {
                $.unblockUI();
                console.log(e);
                if (e == 'success') {
                    location.reload();
                }
            }
        });
    });
});

function set_edit_prt(id, code, brand_name) {
    $('#form-edit-prt input[name="prt_id"]').val(id);
    $('#form-edit-prt input[name="edit_code"]').val(code);
    $('#form-edit-prt input[name="edit_prt_name"]').val(brand_name);
}

function delete_product_type(id) {
    Swal.fire({
        title: '<span class="lao-font">ຢືນຢັນການລຶບຂໍ້ມູນ </span>?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<span class="lao-font">ຢືນຢັນ</span>'
    }).then((result) => {
        var url = 'pro-type/' + id;
        var token = $("meta[name='csrf-token']").attr("content");
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: token,
                    id: id
                },
                success: function(e) {
                    console.log(e);
                    if (e == 'success') {
                        location.reload();
                    }
                }
            })
        }
    })
}
</script>
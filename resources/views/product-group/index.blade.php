<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 mt-3 lao-font py-8">
                    <h4 class="text-info"><i class="fa fa-object-group" aria-hidden="true"></i> ກຸ່ມສິນຄ້າ</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('pro-group.store') }}" id="form-group">
                                @csrf
                                {{-- ເລືອກກຸ່ມສິນຄ້າມາຈາກຖານຂໍ້ມູນ sml --}}
                                <label for="from_base"><span class="text-danger">*</span> ກຸ່ມສິນຄ້າຈາກ
                                    SML</label>

                                <input type="text" name="group_fb_name" id="group_fb_name"
                                    class="text-center form-control" required readonly
                                    style="border: aquamarine 1px solid">
                                <div class="input-group mb-3">
                                    <input type="text" name="group_fb_code" id="group_fb_code" class="text-center"
                                        required readonly style="border: aquamarine 1px solid">
                                    <input type="text" class="form-control" name="from_base" id="from_base" readonly
                                        required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text p-0">
                                            <button class="btn btn-primary m-0" type="button"
                                                data-target="#modal-add-from-base" data-toggle="modal"
                                                onclick="set_add_group_fb('add')"><i class="fa fa-search"
                                                    aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- full Name -->
                                <div>
                                    <label for="prg_name"><span class="text-danger">*</span> ຊື່ກຸ່ມສິນຄ້າ</label>

                                    <x-input id="prg_name" class="form-control" type="text" name="prg_name"
                                        :value="old('prg_name')" required autofocus placeholder="..." />
                                </div>
                                <!-- User Role -->
                                <div class="mt-4">
                                    <label for="prg_note">ໝາຍເຫດ</label>

                                    <textarea name="prg_note" id="prg_note" class="form-control" rows="5"></textarea>
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
                                        <th>ຊື່ກຸ່ມສິນຄ້າ</th>
                                        <th>code (sml)</th>
                                        <th width="30">ແກ້ໄຂ</th>
                                        <th width="30">ລຶບ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->prg_name }}</td>
                                            <td>{{ $item->code_fb }}</td>
                                            <td class="text-center">
                                                <a href="#" class="text-warning" data-toggle="modal"
                                                    data-target="#modal-edit-emp"
                                                    onclick="set_edit_emp({{ $item->id }}, '{{ $item->prg_name }}', 
                                                    '{{ $item->note }}', '{{ $item->code_fb }}', '{{ $item->from_base }}')"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="text-danger"
                                                    onclick="delete_employee({{ $item->id }})"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a>

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
                    <form method="POST" action="" id="form-edit-prg">
                        @csrf
                        {{-- ເລືອກກຸ່ມສິນຄ້າມາຈາກຖານຂໍ້ມູນ sml --}}
                        <label for="from_base"><span class="text-danger">*</span> ກຸ່ມສິນຄ້າຈາກ
                            SML</label>

                        <input type="text" name="group_fb_name" id="group_fb_name" class="text-center form-control"
                            required readonly style="border: aquamarine 1px solid">
                        <div class="input-group mb-3">
                            <input type="text" name="group_fb_code" id="group_fb_code" class="text-center" required
                                readonly style="border: aquamarine 1px solid">
                            <input type="text" class="form-control" name="from_base" id="from_base" readonly required>
                            <div class="input-group-prepend">
                                <span class="input-group-text p-0">
                                    <button class="btn btn-primary m-0" type="button" data-target="#modal-add-from-base"
                                        data-toggle="modal" onclick="set_add_group_fb('edit')"><i class="fa fa-search"
                                            aria-hidden="true"></i></button>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="prg_id">
                        <!-- full Name -->
                        <div>
                            <label for="edit_prg_name"><span class="text-danger">*</span> ຊື່ກຸ່ມສິນຄ້າ</label>

                            <x-input class="form-control" type="text" name="edit_prg_name"
                                :value="old('edit_prg_name')" required autofocus placeholder="ຊື່ກຸ່ມສິນຄ້າ..." />
                        </div>

                        <div class="mt-4">
                            <label for="edit_note"><span class="text-danger">*</span> ໝາຍເຫດ</label>

                            <textarea name="edit_note" id="edit_note" class="form-control" rows="5"></textarea>
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
    <!-- The Modal -->
    <div class="modal" id="modal-add-from-base">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" id="add-states">
                    <div class="tab">
                        <button class="tablinks active" onclick="load_group_from_base(event, 'odien')">Odien</button>
                        <button class="tablinks" onclick="load_group_from_base(event, 'p&p')">P&P</button>
                    </div>

                    <div id="odien" class="tabcontent" style="display: block">
                        <h3>Odien</h3>
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>Code</th>
                                <th>ຊື່ກຸ່ມສິນຄ້າ</th>
                            </tr>
                            <tbody id="fb-odien-table">

                            </tbody>
                        </table>
                    </div>

                    <div id="p&p" class="tabcontent">
                        <h3>P&P</h3>
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>Code</th>
                                <th>ຊື່ກຸ່ມສິນຄ້າ</th>
                            </tr>
                            <tbody id="fb-pp-table"></tbody>
                        </table>
                    </div>
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
    function set_add_group_fb(states) {
        $("#add-states").val(states);
    }
    load_fb_pp();

    function load_fb_pp() {
        $.ajax({
            type: "GET",
            url: "{{ Route('fetch-group-fb-pp') }}",
            success: function(e) {

                $("#fb-pp-table").html('');
                $.each(e, function(i, item) {
                    let base = 'p&p';
                    let code = item.code;
                    let name = item.name_1;
                    for (let i = 0; i < name.length; i++) {
                        name = name.replace('"', '');
                    }

                    $("#fb-pp-table").append(`<tr>
                    <td><button class="btn btn-sm btn-outline-success" 
                    data-dismiss="modal" onclick="get_group_fb('${code}','${name}','${base}')">
                    <i class="fa fa-check-circle-o" aria-hidden="true">
                    </i></button></td>
                    <td>${item.code}</td>
                    <td>${name}</td></tr>`);

                })
            }
        })

    }
    load_fb_odien();

    function load_fb_odien() {
        $.ajax({
            type: "GET",
            url: "{{ Route('fetch-group-fb-odien') }}",
            success: function(e) {
                //console.log(e);
                $("#fb-odien-table").html('');
                $.each(e, function(i, item) {
                    let base = 'odien';
                    let code = item.code;
                    let name = item.name_1;
                    for (let i = 0; i < name.length; i++) {
                        name = name.replace('"', '');
                    }

                    $("#fb-odien-table").append(`<tr>
                    <td><button class="btn btn-sm btn-outline-success" 
                    data-dismiss="modal" onclick="get_group_fb('${code}','${name}','${base}')">
                    <i class="fa fa-check-circle-o" aria-hidden="true">
                    </i></button></td>
                    <td>${item.code}</td>
                    <td>${name}</td></tr>`);
                })
            }
        })

    }

    function get_group_fb(code, name, base) {
        let states = $("#add-states").val();
        if (states == 'add') {
            $("#form-group input[name='from_base']").val(base);
            $("#form-group input[name='group_fb_code']").val(code);
            $("#form-group input[name='group_fb_name']").val(name);
        } else {
            $("#form-edit-prg input[name='from_base']").val(base);
            $("#form-edit-prg input[name='group_fb_code']").val(code);
            $("#form-edit-prg input[name='group_fb_name']").val(name);
        }

    }

    function load_group_from_base(evt, fbName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(fbName).style.display = "block";
        evt.currentTarget.className += " active";

    }
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form-edit-prg').submit(function(e) {
            e.preventDefault();
            $('#close-edit').click();
            var id = $('#form-edit-prg input[name="prg_id"]').val();
            var url = "pro-group/" + id;
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

    function set_edit_emp(id, prg_name, note, code_fb, from_base) {
        $("#form-edit-prg input[name='from_base']").val(from_base);
        $("#form-edit-prg input[name='group_fb_code']").val(code_fb);
        $("#form-edit-prg input[name='group_fb_name']").val('');
        //
        $('#form-edit-prg input[name="prg_id"]').val(id);
        $('#form-edit-prg input[name="edit_prg_name"]').val(prg_name);
        $('#form-edit-prg textarea[name="edit_note"]').text(note);
    }

    function delete_employee(id) {
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນການລຶບຂໍ້ມູນ </span>?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<span class="lao-font">ຢືນຢັນ</span>'
        }).then((result) => {
            var url = 'pro-group/' + id;
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

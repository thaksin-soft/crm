<x-app-layout>


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
                    <div class="tab">
                        <button class="tablinks active" onclick="load_emp_from_base(event, 'odien')">Odien</button>
                        <button class="tablinks" onclick="load_emp_from_base(event, 'p&p')">P&P</button>
                    </div>

                    <div id="odien" class="tabcontent" style="display: block">
                        <h3>Odien</h3>
                        <table class="table">
                            <tr>
                                <th>ລຳດັບ</th>
                                <th>Code</th>
                                <th>ຊື່ພະນັກງານ</th>
                            </tr>
                            <tbody id="fb-odien-table">

                            </tbody>
                        </table>
                    </div>

                    <div id="p&p" class="tabcontent">
                        <h3>P&P</h3>
                        <table class="table">
                            <tr>
                                <th>ລຳດັບ</th>
                                <th>Code</th>
                                <th>ຊື່ພະນັກງານ</th>
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 mt-3 lao-font py-8">
                    <h4 class="text-info"><i class="fa fa-users" aria-hidden="true"></i> ຂໍ້ມູນພະນັກງານ</h4>
                    <div class="row">
                        <div class="col-md-3">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>ແຈ້ງເຕືອນ!</strong> {{ $errors->first() }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('employee.store') }}" id="form-emp">
                                @csrf
                                {{-- ເລືອກລະຫັດພະນັກງານມາຈາກຖານຂໍ້ມູນ sml --}}
                                <label for="from_base"><span class="text-danger">*</span> ຂໍ້ມູນພະນັກງານຈາກ
                                    SML</label>

                                <input type="
                                    text" class="form-control text-center" id="emp_fb_name" name="emp_fb_name"
                                    readonly>
                                <div class="input-group mb-3">
                                    <input type="text" name="emp_fb_code" id="emp_fb_code" class="text-center"
                                        required readonly style="border: aquamarine 1px solid">
                                    <input type="text" name="from_base" id="from_base" class="text-center form-control"
                                        required readonly style="border: aquamarine 1px solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text p-0">
                                            <button class="btn btn-primary m-0" type="button"
                                                data-target="#modal-add-from-base" data-toggle="modal"><i
                                                    class="fa fa-search" aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <div style="background: #e6e6e6; padding: 7px; margin-bottom: 10px;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <!-- full Name -->
                                            <div class="mt-4">

                                                <label for="emp_name"><span class="text-danger">*</span> ຊື່</label>

                                                <x-input id="emp_name" class="form-control" type="text"
                                                    name="emp_name" :value="old('emp_name')" required autofocus />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4">
                                                <label for="emp_lname"><span class="text-danger">*</span>
                                                    ນາມສະກຸນ</label>

                                                <x-input id="emp_lname" class="form-control" type="text"
                                                    name="emp_lname" :value="old('emp_lname')" required autofocus />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4">
                                                <label for="gender"><span class="text-danger">*</span> ເພດ</label>

                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="ຊາຍ">ຊາຍ</option>
                                                    <option value="ຍິງ">ຍິງ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <!-- tel -->
                                            <div class="mt-4">
                                                <label for="tel"><span class="text-danger">*</span> ເບິໂທ</label>

                                                <x-input id="tel" class="form-control" type="text" name="tel"
                                                    :value="old('tel')" required autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="background: #e6e6e6; padding: 7px; margin-bottom: 10px;">
                                    <h6 class="text-primary">ສັງກັດ</h6>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="emp-warehouse"
                                                    name="type_emp" value-data="warehouse" checked
                                                    onchange="set_emp_type('general')">
                                                <label class="custom-control-label" for="emp-warehouse">ພະນັກງານທົ່ວໄປ
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="emp-general"
                                                    name="type_emp" value-data="general"
                                                    onchange="set_emp_type('warehouse')">
                                                <label class="custom-control-label" for="emp-general">ພະນັກງານສາງ
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <label for="warehouse"><span class="text-danger">*</span>
                                                ປະຈຳສາງ</label>
                                            <select name="warehouse" id="warehouse" class="form-control"
                                                disabled></select>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mt-4">
                                                <label for="depend"><span class="text-danger">*</span>
                                                    ກຸ່ມພະນັກງານ</label>

                                                <select name="depend" id="depend" class="form-control" required>
                                                    @foreach ($depend as $item)
                                                        <option value="{{ $item->id }}">{{ $item->depend_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- User Role -->
                                            <div class="mt-4">
                                                <label for="password_confirmation"><span class="text-danger">*</span>
                                                    ຕຳແໜ່ງ</label>
                                                <select name="user_role" id="user_role" class="form-control" required>
                                                    <option value="">...</option>
                                                    @foreach ($role as $item)
                                                        <option value="{{ $item->name }}">{{ $item->display_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div style="background: #e6e6e6; padding: 7px; margin-bottom: 10px;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <!-- Name -->
                                            <div class="mt-4">
                                                <label for="name"><span class="text-danger">*</span>
                                                    <b>User</b></label>

                                                <x-input id="name" class="form-control" type="text" name="name"
                                                    :value="old('name')" required autofocus />
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <!-- Email Address -->
                                            <div class="mt-4">
                                                <label for="email"><span class="text-danger">*</span>
                                                    <b>E-mail</b></label>

                                                <x-input id="email" class="form-control" type="email" name="email"
                                                    :value="old('email')" required />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- Password -->
                                            <div class="mt-4">
                                                <label for="password"><span class="text-danger">*</span>
                                                    <b>Password</b></label>

                                                <x-input id="password" class="form-control" type="password"
                                                    name="password" required autocomplete="new-password" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- Confirm Password -->
                                            <div class="mt-4">
                                                <label for="password_confirmation"><span class="text-danger">*</span>
                                                    <b>Confirm
                                                        Password</b></label>

                                                <x-input id="password_confirmation" class="form-control"
                                                    type="password" name="password_confirmation" required />
                                            </div>
                                        </div>
                                    </div>
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
                                        <th>ຊື່ພະນັກງານ</th>
                                        <th>ຊື່ເຂົ້າລະບົບ</th>
                                        <th>Email</th>
                                        <th>ຕຳແໜ່ງ</th>
                                        <th>ສັງກັດ</th>
                                        <th width="30">ແກ້ໄຂ</th>
                                        <th width="30">ລຶບ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $item->emp_name }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->display_name }}</td>
                                            <td>{{ $item->depend_name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('employee.edit', $item->id) }}"
                                                    class="text-warning">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            </td>
                                            <td class="text-center">

                                                @if ($item->display_name != 'Superadministrator')
                                                    <a href="#" class="text-danger"
                                                        onclick="delete_employee({{ $item->id }})"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                @endif


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
    <!-- The Modal -->

</x-app-layout>


<script>
    load_fb_pp();

    function load_fb_pp() {
        $.ajax({
            type: "GET",
            url: "{{ Route('fetch-emp-fb-pp') }}",
            success: function(e) {
                //console.log(e);
                $("#fb-pp-table").html('');
                $.each(e, function(i, item) {
                    $("#fb-pp-table").append(`<tr>
                <td><button class="btn btn-sm btn-outline-success" 
                data-dismiss="modal" onclick="get_emp_fb('${item.code}','${item.name_1}','p&p')">
                <i class="fa fa-check-circle-o" aria-hidden="true">
                </i></button></td>
                <td>${item.code}</td>
                <td>${item.name_1}</td></tr>`);
                })
            }
        })

    }
    load_fb_odien();

    function load_fb_odien() {
        $.ajax({
            type: "GET",
            url: "{{ Route('fetch-emp-fb-odien') }}",
            success: function(e) {
                //console.log(e);
                $("#fb-odien-table").html('');
                $.each(e, function(i, item) {
                    $("#fb-odien-table").append(`<tr>
                    <td><button class="btn btn-sm btn-outline-success" 
                    data-dismiss="modal" onclick="get_emp_fb('${item.code}','${item.name_1}','odien')">
                    <i class="fa fa-check-circle-o" aria-hidden="true">
                    </i></button></td>
                    <td>${item.code}</td>
                    <td>${item.name_1}</td></tr>`);
                })
            }
        })

    }

    load_warehouse_fromOdien();

    function load_warehouse_fromOdien() {
        $.ajax({
            type: "GET",
            url: "{{ Route('fetch-warehouse-from-odien') }}",
            success: function(e) {
                $("#warehouse").html('');
                $.each(e, function(i, item) {
                    $("#warehouse").append(`<option value="${item.code}">${item.code} ${item.name_1}</option>`);
                })
            }
        })

    }

    function set_emp_type(emp_type) {
        if (emp_type == 'warehouse') {
            $('#warehouse').prop('disabled', false);
        } else {
            $('#warehouse').prop('disabled', true);
        }
    }

    function get_emp_fb(code, name, base) {
        $("#form-emp input[name='from_base']").val(base);
        $("#form-emp input[name='emp_fb_code']").val(code);
        $("#form-emp input[name='emp_fb_name']").val(name);
    }

    function load_emp_from_base(evt, fbName) {
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
        $('#form-edit-emp').submit(function(e) {
            e.preventDefault();
            $('#close-edit').click();
            var user_id = $('#form-edit-emp input[name="user_id"]').val();
            var url = "employee/" + user_id;
            $.blockUI({
                message: 'ກຳລັງແກ້ໄຂ'
            });
            $.ajax({
                url: url,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(e) {
                    $.unblockUI();
                    if (e == 'success') {
                        location.reload();
                    }
                }
            })
        })

    })

    function set_edit_emp(id, emp_id, emp_name, name, email, tel) {
        $('#form-edit-emp input[name="user_id"]').val(id);
        $('#form-edit-emp input[name="emp_id"]').val(emp_id);
        $('#form-edit-emp input[name="edit_emp_name"]').val(emp_name);
        $('#form-edit-emp input[name="edit_tel"]').val(tel);
        $('#form-edit-emp input[name="edit_name"]').val(name);
        $('#form-edit-emp input[name="edit_email"]').val(email);
    }

    function delete_employee(id) {
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນການລຶບຂໍ້ມູນ </span>?',
            html: '<span class="lao-font">ຖ້າລຶບ user ໃດ. user ນັ້ນຈະບໍສາມາດເຂົ້າລະບົບໄດ້</span>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<span class="lao-font">ຢືນຢັນ</span>'
        }).then((result) => {
            var url = 'employee/' + id;
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

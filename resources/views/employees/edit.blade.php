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
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">

                        <h4 class="text-info"><i class="fa fa-users" aria-hidden="true"></i> ແກ້ໄຂຂໍ້ມູນພະນັກງານ
                        </h4>
                        <form method="POST" action="{{ route('employee.update', $data[0]->emp_id) }}" id="form-emp">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-5">

                                    {{-- ເລືອກລະຫັດພະນັກງານມາຈາກຖານຂໍ້ມູນ sml --}}
                                    <label for="
                                        from_base"><span class="text-danger">*</span> ຂໍ້ມູນພະນັກງານຈາກ
                                        SML</label>
                                    <input type="text" class="form-control text-center" id="emp_fb_name"
                                        name="emp_fb_name" readonly value="{{ $data[0]->emp_name_fb }}">
                                    <div class="input-group mb-3">
                                        <input type="text" name="emp_fb_code" id="emp_fb_code" class="text-center"
                                            required readonly style="border: aquamarine 1px solid"
                                            value="{{ $data[0]->code_fb }}">
                                        <input type="text" name="from_base" id="from_base"
                                            class="text-center form-control" required readonly
                                            style="border: aquamarine 1px solid" value="{{ $data[0]->from_base }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text p-0">
                                                <button class="btn btn-primary m-0" type="button"
                                                    data-target="#modal-add-from-base" data-toggle="modal"><i
                                                        class="fa fa-search" aria-hidden="true"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- full Name -->
                                    <div>
                                        <label for="emp_name"><span class="text-danger">*</span> ຊື່</label>

                                        <x-input id="emp_name" class="form-control" type="text" name="emp_name"
                                            :value="old('emp_name')" required autofocus placeholder="ຊື່..."
                                            value="{{ $data[0]->emp_name }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="emp_lname"><span class="text-danger">*</span> ນາມສະກຸນ</label>

                                        <x-input id="emp_lname" class="form-control" type="text" name="emp_lname"
                                            :value="old('emp_lname')" required autofocus placeholder="ນາມສະກຸນ..."
                                            value="{{ $data[0]->emp_lname }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="gender"><span class="text-danger">*</span> ເພດ</label>

                                        <select name="gender" id="gender" class="form-control" required>
                                            @if ($data[0]->emp_gender == 'ຊາຍ')
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
                                    <div>
                                        <label for="depend"><span class="text-danger">*</span> ສັງກັດ</label>

                                        <select name="depend" id="depend" class="form-control" required>
                                            @foreach ($depend as $item)
                                                @if ($data[0]->depend_id == $item->id)
                                                    <option value="{{ $item->id }}" selected>
                                                        {{ $item->depend_name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->depend_name }}
                                                    </option>
                                                @endif

                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- User Role -->
                                    <div>
                                        <label for="password_confirmation"><span class="text-danger">*</span>
                                            ຕຳແໜ່ງ</label>
                                        <select name="user_role" id="user_role" class="form-control" required>
                                            <option value="">...</option>
                                            @foreach ($role as $item)
                                                @if ($data[0]->role_name == $item->display_name)
                                                    <option value="{{ $item->name }}" selected>
                                                        {{ $item->display_name }}</option>
                                                @else
                                                    <option value="{{ $item->name }}">
                                                        {{ $item->display_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- tel -->
                                    <div>
                                        <label for="tel"><span class="text-danger">*</span> ເບິໂທ</label>

                                        <x-input id="tel" class="form-control" type="text" name="tel"
                                            :value="old('tel')" required autofocus placeholder="ເບິໂທຂອງພະນັກງານ..."
                                            value="{{ $data[0]->tel }}" />
                                    </div>
                                </div>

                            </div>
                            <hr>


                            <div class="flex items-center justify-end mt-4">


                                <x-button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    {{ __(' ບັນທຶກ') }}
                                </x-button>
                            </div>
                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>
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
</script>

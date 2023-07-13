<div style="background: #e1e1e1" class="p-4">
    <h4 class="text-info"><i class="fa fa-volume-control-phone" aria-hidden="true"></i>
        ປະສິດທິພາບການຕິດຕໍ່ຫາລູກຄ້າ</h4>
    <hr>
    <form action="" id="form-set-search-effective">
        <div class="row">
            <div class="col-sm-2">
                <label class="rd-container mt-2">ເດືອນປີ
                    <input type="radio" checked="checked" name="time_option" value="bymonth"
                        onchange="load_effective()">
                    <span class="rd-checkmark"></span>
                </label>
            </div>
            <div class="col-sm-2">
                <div class="input-group mb-3">
                    <input type="number" class="form-control" aria-label="month" value="{{ $set_month }}"
                        onchange="load_effective()" id="effective-month" name="effective_month">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group mb-3">
                    <input type="number" class="form-control" aria-label="year" value="{{ $set_year }}"
                        onchange="load_effective()" id="effective-year" name="effective_year">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-2">
                <label class="rd-container mt-2">ຊ່ວງວັນທີ່
                    <input type="radio" name="time_option" value="bydate" onchange="load_effective()">
                    <span class="rd-checkmark"></span>
                </label>
            </div>
            <div class="col-sm-4">
                <div class="input-group mb-3">

                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="start-date"
                        name="start_date" onchange="load_effective()">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group mb-3">

                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="end-date"
                        name="end_date" onchange="load_effective()">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ພະນັກງານຂາຍ</span>
                    </div>
                    <select name="cb_employee" id="cb_employee" class="form-control" onchange="load_effective()">
                        <option value="all">ທຸກຄົນ...</option>
                        @foreach ($emp_seller as $emp_item)
                            <option value="{{ $emp_item->id }}">{{ $emp_item->emp_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-8">

            </div>
        </div>
    </form>
    <div class="p-3">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="p-2 bg-primary text-white" style="border-radius: 8px">
                            <h4 class="text-center">ຕ່ຳສຸດ</h4>
                            <hr>
                            <p class="text-center" id="min-contract" style="font-size: 1.5em"></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-2 bg-warning text-white" style="border-radius: 8px">
                            <h4 class="text-center">ສະເລ່ຍ</h4>
                            <hr>
                            <p class="text-center" id="average-contract" style="font-size: 1.5em"></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-2 bg-danger text-white" style="border-radius: 8px">
                            <h4 class="text-center">ສູງສຸດ</h4>
                            <hr>
                            <p class="text-center" id="max-contract" style="font-size: 1.5em"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

</div>

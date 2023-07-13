<div class="row">
    <div class="col-md-12">
        <div style="background: #e1e1e1" class="p-4">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center">ປະລິມານລູກຄ້າສອບຖາມປະຈຳວັນສະສົມ</h4>
                </div>
            </div>
            <form action="" id="form-set-search-amass-track">
                <div class="row">
                    <div class="col-sm-2">
                        <label class="rd-container mt-2">ເດືອນປີ
                            <input type="radio" checked="checked" name="time_option_all_track" value="bymonth"
                                onchange="load_amass_track_report()">
                            <span class="rd-checkmark"></span>
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-label="month" value="{{ $set_month }}"
                                onchange="load_amass_track_report()" name="month">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-label="year" value="{{ $set_year }}"
                                onchange="load_amass_track_report()" name="year">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label class="rd-container mt-2">ຊ່ວງວັນທີ່
                            <input type="radio" name="time_option_all_track" value="bydate"
                                onchange="load_amass_track_report()">
                            <span class="rd-checkmark"></span>
                        </label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">

                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="start_date"
                                onchange="load_amass_track_report()">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3">

                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="end_date"
                                onchange="load_amass_track_report()">
                        </div>
                    </div>

                </div>

            </form>
            <div id="amass-chart-content">

            </div>

        </div>

    </div>
</div>

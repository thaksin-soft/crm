<div class="row">
    <div class="col-md-12">
        <div style="background: #e1e1e1" class="p-4">

            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center">ສະຫຼຸບລວມ</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <form action="" id="search-conclude-track">
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="rd-container mt-2">ເດືອນປີ
                                    <input type="radio" checked="checked" name="time_option_all_track" value="bymonth"
                                        onchange="load_conclude_track_report()">
                                    <span class="rd-checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" value="{{ $set_month }}"
                                        onchange="load_conclude_track_report()" name="month">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" value="{{ $set_year }}"
                                        onchange="load_conclude_track_report()" name="year">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="rd-container mt-2">ຊ່ວງວັນທີ່
                                    <input type="radio" name="time_option_all_track" value="bydate"
                                        onchange="load_conclude_track_report()">
                                    <span class="rd-checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">

                                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        name="start_date" onchange="load_conclude_track_report()">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">

                                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        name="end_date" onchange="load_conclude_track_report()">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="ch-container mt-2">ເພດ
                                    <input type="checkbox" name="bygender" value="bygender"
                                        onchange="load_conclude_track_report()">
                                    <span class="ch-checkmark"></span>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <select name="cb_cus_gender" id="cb_cus_gender" class="form-control"
                                    onchange="load_conclude_track_report()">
                                    <option value="ຊາຍ">ຊາຍ</option>
                                    <option value="ຍິງ">ຍິງ</option>
                                </select>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="col-sm-5">
                    <div id="all-chart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>


        </div>
    </div>
</div>

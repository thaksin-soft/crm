<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li class="model-item"><a href="/"><i class="fa fa-home"></i> Dashboard</a></li>

            <li class="lao-font model-item"><a><i class="fa fa-flag" aria-hidden="true"></i> ລາຍງານ <span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="model-item"><a
                            href="{{ route('report-track-movment-admin') }}">ລາຍງານການເຄື່ອນໄຫວ</a>
                    </li>
                    <li class="model-item"><a
                            href="{{ route('report-seller-nocontrack-admin') }}">ລາຍງານລາຍການທີ່ຍັງບໍຕິດຕໍ່</a>
                    </li>
                    <li class="model-item"><a href="{{ route('report-cus-purchased-admin') }}">ລາຍງານລູກຄ້າຊື້</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="lao-font model-item"><a><i class="fa fa-edit"></i> ລາຍການ<span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="model-item"><a href="#">ລາຍການ</a></li>
                </ul>
            </li> --}}

        </ul>
        <ul class="nav side-menu">
            <li class="lao-font model-item"><a href="#"><i class="fa fa-edit"></i> ແອັດມີນເພຈ<span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="model-item"><a href="{{ route('track-online.create') }}">ເພີ່ມລາຍການ</a></li>
                    <li class="model-item"><a href="{{ route('track-online.index') }}">ຂໍ້ມູນລາຍການ</a></li>
                    <li class="model-item"><a
                            href="{{ route('report-track-movment-adminpage') }}">ລາຍງານການເຄື່ອນໄຫວ</a></li>
                    <li class="model-item"><a
                            href="{{ route('report-seller-nocontrack-adminpage') }}">ລາຍງານລາຍການທີ່ຍັງບໍຕິດຕໍ່</a>
                    </li>
                    <li class="model-item"><a
                            href="{{ route('report-cus-purchased-adminpage') }}">ລາຍງານລູກຄ້າຊື້</a>
                    </li>
                </ul>
            </li>
        </ul>



        <ul class="nav side-menu">
            <li class="lao-font model-item"><a href="#"><i class="fa fa-edit"></i> ການຕະຫຼາດ<span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                <li class="model-item lao-font"><a href="{{ route('track-online.create') }}"><i class="fa fa-plus-circle"
                        aria-hidden="true"></i> ເພີ່ມລາຍການ</a></li>
            <li class="model-item lao-font"><a href="{{ route('track-online.index') }}"><i class="fa fa-list"
                        aria-hidden="true"></i> ຂໍ້ມູນລາຍການ</a></li>
            <li class="lao-font model-item"><a href="{{ route('seller-track-show') }}"><i class="fa fa-edit"></i>
                    ຂໍ້ມູນລູກຄ້າຕິດຕໍ່</a></li>
            <li class="lao-font model-item"><a href="{{ route('load-credit-cus-all') }}"><i
                        class="fa fa-credit-card"></i>
                    ຂໍ້ມູນລູກຄ້າສິນເຊື່ອ</a></li>
                    <li class="model-item"><a href="{{ route('report-track-movment') }}">ລາຍງານການເຄື່ອນໄຫວ</a>
                    </li>
                    <li class="model-item"><a
                            href="{{ route('report-seller-nocontrack') }}">ລາຍງານລາຍການທີ່ຍັງບໍຕິດຕໍ່</a>
                    </li>
                    <li class="model-item"><a href="{{ route('report-cus-purchased') }}">ລາຍງານລູກຄ້າຊື້</a>
                    </li>
                    <li class="model-item"><a
                            href="{{ route('load-list-noapprove') }}">ລູກຄ້າສິນເຊື່ອທີ່ບໍ່ອະນຸມັດ</a>
                    </li>



                </ul>
            </li>
        </ul>


        <ul class="nav side-menu">
            <li class="lao-font model-item"><a href="#"><i class="fa fa-edit"></i> ການຕະຫຼາດ<span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                <li class="lao-font model-item"><a href="{{ route('con-no-contract-customer') }}"><i class="fa fa-flag"
                        aria-hidden="true"></i> ສະຫຼຸບການເຄື່ອນໄຫວ</a></li>
            <li class="lao-font model-item"><a href="{{ route('report-effective-contract') }}"><i class="fa fa-flag"
                        aria-hidden="true"></i> ຄ້າງຕິດຕໍ່ລູກຄ້າ</a></li>
            <li class="lao-font model-item"><a href="{{ route('cus-credit-dashboard') }}"><i class="fa fa-credit-card"
                        aria-hidden="true"></i>
                    ລາຍງານລູກຄ້າສິນເຊື່ອ</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>

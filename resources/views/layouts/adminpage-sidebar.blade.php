<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li class="model-item"><a href="/"><i class="fa fa-home"></i> Dashboard</a></li>

            <li class="lao-font model-item"><a><i class="fa fa-edit"></i> ລາຍການ<span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="model-item"><a href="{{ route('track-online.create') }}">ເພີ່ມລາຍການ</a></li>
                    <li class="model-item"><a href="{{ route('track-online.index') }}">ຂໍ້ມູນລາຍການ</a></li>
                </ul>
            </li> 
            <li class="lao-font model-item"><a><i class="fa fa-flag" aria-hidden="true"></i> ລາຍງານ <span
                        class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
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
    </div>
</div>

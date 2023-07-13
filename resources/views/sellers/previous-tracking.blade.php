<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4 class="text-info"><i class="fa fa-info-circle" aria-hidden="true"></i>
                        </h4>
                        <div class="row">
                            @foreach ($data as $key => $item)
                                <div class="col-md-4">
                                    <div class="seller-track-info p-2">
                                        <h5><b>ຊື່ລູກຄ້າ:</b> <span class="text-primary">{{ $item->tr_name }}</span>
                                        </h5>
                                        <h5><b>ເບິໂທ:</b> <span class="text-primary">{{ $item->tr_tel }}</span></h5>
                                        <h5><b>ລາຍການ:</b> <span
                                                class="text-primary">{{ $item->cus_interest_product }}</span></h5>
                                        <h5><b>ຫຍີ່ຫໍ້:</b> <span class="text-primary">{{ $item->brand_name }}</span>
                                        </h5>
                                        <hr>
                                        <button class="btn btn-sm btn-success"
                                            onclick="confirm_contract_customer({{ $item->id }})"><i
                                                class="fa fa-check-circle-o" aria-hidden="true"></i>
                                            ຢືນຢັນການຕິດຕໍ່</button>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

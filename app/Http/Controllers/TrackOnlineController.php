<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Depend;
use App\Models\Brands;
use App\Models\Employees;
use App\Models\User;
use App\Models\ProductGroup;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Models\TrackOnline;
use App\Models\CaptureImage;
use App\Models\ContractCustomer;
use App\Models\CustomerDecides;
use App\Models\ProductCustomerInterest;
use App\Models\ProductCustomerContract;
use App\Models\ProductCustomerDecide;
use Illuminate\Support\Facades\DB;

class TrackOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->session()->has('m-seller-search-track') && $request->session()->get('y-seller-search-track')) {
            $set_month = $request->session()->get('m-seller-search-track');
            $set_year = $request->session()->get('y-seller-search-track');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }  
        $data = TrackOnline::join('crm_employee', 'crm_employee.id', 'crm_track_online.emp_id')
        ->whereMonth('crm_track_online.created_at', $set_month)
        ->whereYear('crm_track_online.created_at', $set_year)
        ->where('crm_track_online.emp_id', auth()->user()->emp_id)
        ->select('crm_track_online.*', 'crm_employee.emp_name', 'crm_employee.emp_lname')
        ->orderBy('crm_track_online.id', 'DESC')
        ->paginate(10);
        return view('track-online.index', compact('data', 'set_year', 'set_month'));
    }

    public function set_date_search_tract(Request $request)
    {
        $request->session()->push('ract-date', $request->date);
        $date = $request->session()->pull('ract-date', $request->date);
        return response()->json($date);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brands::all();
        $group = ProductGroup::all();
        $type = ProductType::all();
        $pg_id = $group[0]->id;
        $cate = ProductCategory::where('pg_id', $pg_id)->get();
        
        //select employee depend
        $load_d = User::join('crm_employee', 'crm_employee.id', 'users.emp_id')
        ->select('crm_employee.depend_id')
        ->where('users.id', auth()->user()->id)
        ->get();
        $depend_id = $load_d[0]->depend_id;
        $emp_seller = User::join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('crm_employee', 'crm_employee.id', '=', 'users.emp_id')
        ->select('crm_employee.*')
        ->where('role_user.role_id', 3)
        ->where('crm_employee.depend_id', $depend_id)
        ->get();
        $depend = Depend::find($depend_id)->get();
        return view('track-online.create', compact('brand', 'type', 'group', 'cate', 'emp_seller', 'depend', 'depend_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'txt_cus_name' => 'required|string|max:255',
            'txt_tel' => 'required|string|max:255',
            'cb_contract_option' => 'required|string|max:50',
            'cb_contract_from' => 'required|string|max:50',
            'txt_cus_facebook' => 'required|max:100',
        ]);
        $tr_code = date('ymdhis').'-'.auth()->id();

        for ($i=0; $i < count($request->txt_pro_cus_interest); $i++) { 
            $max_id = ProductCustomerInterest::max('id') + 1;
            $pro_cus_inter = new ProductCustomerInterest();
            $pro_cus_inter->id = $max_id;
            $pro_cus_inter->tr_code = $tr_code;
            
            $pro_cus_inter->item_category = $request->cb_categroy[$i];
            $pro_cus_inter->item_pattern = $request->cb_pattern[$i];
            $pro_cus_inter->cus_interest_product = $request->txt_pro_cus_interest[$i];
            $pro_cus_inter->pr_size = $request->txt_size[$i];
            $pro_cus_inter->item_brand = $request->cb_brand[$i];
            $pro_cus_inter->save();
        }
        //
        $max_id = TrackOnline::max('id') + 1;
        $track = new TrackOnline();
        $track->id = $max_id;
        $track->tr_code = $tr_code;
        $track->tr_name = $request->txt_cus_name;
        $track->tr_gender = $request->cb_gender;
        $track->tr_tel = $request->txt_tel;
        $track->tr_cus_facebook = $request->txt_cus_facebook;
        $track->tr_cus_address = $request->txt_cus_address;
        $track->tr_con_channel = $request->cb_contract_option;
        $track->tr_con_from = $request->cb_contract_from;

        $track->emp_id = $request->rd_employee;
        $track->status = 'ລໍຖ້າຕິດຕໍ່';
        $track->note = $request->txt_note;
        $track->dates = date('Y-m-d');
        $track->complete_status = 'ລໍຖ້າຕິດຕໍ່';
        if ($track->save()) {
            //ບັນທືກຮູບ
            $images = $request->file('upload_file');
            foreach($images as $image) {
                $img_name = date('ymdhis').'-'.$image->getClientOriginalName();
                
                $image->move(public_path().'/tract-online-image/', $img_name);

                $cap = new CaptureImage();
                $cap->tr_code = $tr_code;
                $cap->image_name = $img_name;
                $cap->save();
            }
            //return redirect()->route('track-online.index');
            return 'index';
        } else {
            return 'create';
            //return redirect()->route('track-online.create');
        }
    }

    public function load_product_category(Request $request)
    {
        $cate = ProductCategory::where('pg_id', $request->id)->get();
        return response()->json($cate);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TrackOnline::find($id);
        $depend = Depend::all();
        
        //load old depend from employee
        
        $employee = Employees::where('id', $data->emp_id)->get();
        $old_depend_id = $employee[0]['depend_id'];
        $emp_seller = User::join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('crm_employee', 'crm_employee.id', '=', 'users.emp_id')
        ->select('crm_employee.*')
        ->where('role_user.role_id', 3)
        ->where('crm_employee.depend_id', $old_depend_id)
        ->get();

        $product = ProductCustomerInterest::where('tr_code', $data->tr_code)->get();

        return view('track-online.edit', compact('emp_seller', 'data', 'product', 'depend', 'old_depend_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'txt_c_name' => 'required|string|max:255',
            'txt_tel' => 'required|string|max:255',
            'cb_contract_option' => 'required|string|max:50',
            'cb_contract_from' => 'required|string|max:50',
            'txt_cus_facebook' => 'required|max:100',
            'txt_cus_facebook' => 'required',
        ]);
        //ລຶບລາຍການສິນຄ້າເກົ່າ ແລະ ບັນທືກລາຍການສິນຄ້າໃໝ່
        $tr_code = $request->tr_code;
        $old_product = ProductCustomerInterest::where('tr_code', $tr_code)->delete();
        for ($i=0; $i < count($request->txt_pro_cus_interest); $i++) { 
            $max_id = ProductCustomerInterest::max('id') + 1;
            $pro_cus_inter = new ProductCustomerInterest();
            $pro_cus_inter->id = $max_id;
            $pro_cus_inter->tr_code = $tr_code;
            
            $pro_cus_inter->item_category = $request->cb_categroy[$i];
            $pro_cus_inter->item_pattern = $request->cb_pattern[$i];
            $pro_cus_inter->cus_interest_product = $request->txt_pro_cus_interest[$i];
            $pro_cus_inter->pr_size = $request->txt_size[$i];
            $pro_cus_inter->item_brand = $request->cb_brand[$i];
            $pro_cus_inter->save();
        }

        ////ແກ້ໄຂຂໍ້ມູນ
        $track = TrackOnline::find($id);
        $track->tr_name = $request->txt_c_name;
        $track->tr_gender = $request->cb_gender;
        $track->tr_tel = $request->txt_tel;
        $track->tr_cus_facebook = $request->txt_cus_facebook;
        $track->tr_cus_address = $request->txt_cus_address;
        $track->tr_con_channel = $request->cb_contract_option;
        $track->tr_con_from = $request->cb_contract_from;

        $track->emp_id = $request->rd_employee;
        $track->status = 'ລໍຖ້າຕິດຕໍ່';
        $track->note = $request->txt_note;
        if ($track->save()) {
            //ລຶບຮູບເກົ່າກອ່ນບັນທືກຮູບໃໝ່
            $old_img = CaptureImage::where('tr_code', $tr_code)->get();
            //
            foreach ($old_img as $key => $img_item) {
                $image_name = $img_item->image_name;
                $id = $img_item->id;
                $image_path = public_path()."/tract-online-image/{$image_name}";
                if (file_exists($image_path)) {
                    unlink($image_path);
                    $img_status = CaptureImage::find($id);
                    $img_status->delete();
                }
                //
                
            }
            //ບັນທືກຮູບ
            $images = $request->file('upload_file');
            foreach($images as $image) {
                $img_name = date('ymdhis').'-'.$image->getClientOriginalName();
                
                $image->move(public_path().'/tract-online-image/', $img_name);

                $cap = new CaptureImage();
                $cap->tr_code = $tr_code;
                $cap->image_name = $img_name;
                $cap->save();
            }
            //return redirect()->route('track-online.index');
            return 'index';
            ///
        } else {
            return 'error';
            //return redirect()->route('track-online.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        //
    }

    public function load_seller_tract(Request $request){
        $sell_id = auth()->User()->emp_id;
        $data = DB::select('select crm_track_online.* FROM crm_track_online WHERE crm_track_online.emp_id = :id 
        AND crm_track_online.tr_code NOT IN (SELECT tr_code FROM public.crm_customer_decides) 
        order by crm_track_online.id ASC', ['id' => $sell_id]);
        return view('sellers.track-info', compact('data'));
    }

 
    public function call_check_customer(Request $request)
    {
        $t_id = $request->track_id;
        $cc_id = $request->cc_id;
        $t_code = $request->track_code;
        $data = TrackOnline::find($t_id);

        $interest_pro = ProductCustomerContract::where('cc_id', $cc_id)
        ->get();
        return view('sellers.call-customer-back', compact('t_id', 't_code', 'data', 'interest_pro'));
    }

    public function customer_decides(Request $request)
    {
        $t_id = $request->track_id;
        $t_code = $request->track_code;
        
        return view('sellers.customer-decides', compact('t_id', 't_code'));
    }

    public function contract_customer(Request $request)
    {
        $t_id = $request->track_id;
        $t_code = $request->track_code;
        $data = TrackOnline::find($t_id);
        //ກວດສອບວ່າມີການບັນທືກແລ້ວ ຫຼື ຍັງ
        $check = ContractCustomer::where('status', 'ກຳລັງຕິດຕໍ່')
        ->where('tr_code', $t_code)->get();
        if (count($check) == 0) {
            //ຖ້າຍັງບໍ່ມີການຕິດຕໍ່ໃຫ້ຕິດຕໍ່ໃໝ່
            $max_id = ContractCustomer::max('id') + 1;
            $con = new ContractCustomer();
            $con->id = $max_id;            
            $con->tr_code = $t_code;
            $con->status = 'ກຳລັງຕິດຕໍ່';
            $con->note = null;
            $con->save();
            DB::update("UPDATE crm_track_online SET complete_status = 'ກຳລັງຕິດຕໍ່' WHERE tr_code = ?", [$t_code]);
        }
        //
        $interest_pro = ProductCustomerInterest::where('tr_code', $t_code)->get();
        return view('sellers.contract-customer', compact('t_id', 't_code', 'data', 'interest_pro'));
    }
    
    public function save_contract_customer(Request $request)
    {
        //ກວດສອບຂໍ້ມູນກ່ອນບັນທືກ ເພື່ອບໍ່ໃຫ້ບັນທືກຂໍ້ມູນຊ້ຳ
        $check = ContractCustomer::where('status', 'ຊື້')
        ->where('tr_code', $request->txt_track_code)
        ->get();
        if (count($check) == 0) {
            //ບັນທືກຂໍ້ມູນ
            $max_id = ContractCustomer::max('id') + 1;
            $con = new ContractCustomer();
            $con->id = $max_id;            
            $con->tr_code = $request->txt_track_code;            
            $con->status = 'ຊື້';
            $con->note = null;
            $con->save();
            if ($con) {
                DB::update("UPDATE crm_track_online SET complete_status = 'ຊື້' WHERE tr_code = ?",[$request->txt_track_code]);
                $cc_id = $con->id;
                for ($i=0; $i < count($request->txt_product_purchased); $i++) { 
                    $max_id = ProductCustomerContract::max('id') + 1;
                    $pro_cus_con = new ProductCustomerContract();
                    $pro_cus_con->id = $max_id;
                    $pro_cus_con->tr_code = $request->txt_track_code;
                    $pro_cus_con->item_category = $request->cb_categroy[$i];
                    $pro_cus_con->item_pattern = $request->cb_pattern[$i];
                    $pro_cus_con->product_purchased = $request->txt_product_purchased[$i];
                    $pro_cus_con->product_size = $request->txt_size[$i];
                    $pro_cus_con->item_brand = $request->cb_brand[$i];
                    $pro_cus_con->cc_id = $cc_id;
                    $pro_cus_con->save();
                }
                //ແກ້ໄຂສະຖານະຈາກລໍຖ້າຕິດຕໍ່ ໄປເປັນຕິດຕໍ່ສຳເລັດ
                $status = TrackOnline::find($request->txt_track_id);
                $status->status = 'ຕິດຕໍ່ສຳເລັດ';
                $status->save();
                if ($status) {
                    return response()->json('success');
                }else {
                    return response()->json('fail');
                }
            } else {
                return response()->json('fail');
            }
        }else{
            return response()->json('success');
        }
            
    }

    public function save_customer_waiting_decide(Request $request)
    {
        $max_id = ContractCustomer::max('id') + 1;
            $con = new ContractCustomer();
            $con->id = $max_id;
            $con->tr_code = $request->txt_track_code;
            $con->status = 'ລໍຖ້າການຕັດສິນໃຈ';
            $con->note = $request->txt_waiting_note;
            $con->save();
            if ($con) {
                DB::update("UPDATE crm_track_online SET complete_status = 'ລໍຖ້າການຕັດສິນໃຈ' WHERE tr_code = ?", [$request->txt_track_code]);
                $cc_id = $con->id;
                for ($i=0; $i < count($request->txt_product_purchased); $i++) { 
                    $max_id = ProductCustomerContract::max('id') + 1;
                    $pro_cus_con = new ProductCustomerContract();
                    $pro_cus_con->id = $max_id;
                    $pro_cus_con->tr_code = $request->txt_track_code;
                    $pro_cus_con->item_category = $request->cb_categroy[$i];
                    $pro_cus_con->item_pattern = $request->cb_pattern[$i];
                    $pro_cus_con->product_purchased = $request->txt_product_purchased[$i];
                    $pro_cus_con->product_size = $request->txt_size[$i];
                    $pro_cus_con->item_brand = $request->cb_brand[$i];
                    $pro_cus_con->cc_id = $cc_id;
                    $pro_cus_con->save();
                }
                //ແກ້ໄຂສະຖານການຕິດຕໍ່ຂອງລູກຄ້າ ຈາກລໍຖ້າຕິດຕໍ່ ເປັນ ຕິດຕໍ່ສຳເລັດ
                
                $status = TrackOnline::find($request->txt_track_id);
                $status->status = 'ຕິດຕໍ່ສຳເລັດ';
                $status->save();
                if($status){
                    return response()->json('success');
                } else {
                    return response()->json('success');
                }
                
            } else {
                return response()->json('fail');
            }
    }
    public function save_customer_cancel(Request $request)
    {
        //ກວດສອບຂໍ້ມູນກ່ອນບັນທືກ ເພື່ອບໍ່ໃຫ້ບັນທືກຂໍ້ມູນຊ້ຳ
        $check = ContractCustomer::where('status', 'ບໍ່ຊື້')
        ->where('tr_code', $request->txt_track_code)
        ->get();
        if (count($check) == 0) {
            $max_id = ContractCustomer::max('id') + 1;
            $con = new ContractCustomer();
            $con->id = $max_id;
            $con->tr_code = $request->txt_track_code;
            $con->status = 'ບໍ່ຊື້';
            $con->note = $request->txt_nobuy_note;
            $con->save();
            if ($con) {
                DB::update("UPDATE crm_track_online SET complete_status = 'ບໍ່ຊື້' WHERE tr_code = ?", [$request->txt_track_code]);
                $cc_id = $con->id;
                for ($i=0; $i < count($request->txt_product_purchased); $i++) { 
                    $max_id = ProductCustomerContract::max('id') + 1;
                    $pro_cus_con = new ProductCustomerContract();
                    $pro_cus_con->id = $max_id;
                    $pro_cus_con->tr_code = $request->txt_track_code;
                    $pro_cus_con->item_category = $request->cb_categroy[$i];
                    $pro_cus_con->item_pattern = $request->cb_pattern[$i];
                    $pro_cus_con->product_purchased = $request->txt_product_purchased[$i];
                    $pro_cus_con->product_size = $request->txt_size[$i];
                    $pro_cus_con->item_brand = $request->cb_brand[$i];
                    $pro_cus_con->cc_id = $cc_id;
                    $pro_cus_con->save();
                }
                //ແກ້ໄຂສະຖານະຈາກລໍຖ້າຕິດຕໍ່ ໄປເປັນຕິດຕໍ່ສຳເລັດ
                $status = TrackOnline::find($request->txt_track_id);
                $status->status = 'ຕິດຕໍ່ສຳເລັດ';
                $status->save();
                if($status){
                    $max_id = CustomerDecides::max('id') + 1;
                    $cus_decide = new CustomerDecides();
                    $cus_decide->id = $max_id;
                    $cus_decide->tr_code = $request->txt_track_code;
                    $cus_decide->decide_status = 'ບໍ່ຊື້';
                    $cus_decide->cus_name = $request->txt_cus_name;
                    $cus_decide->cus_address = $request->txt_cus_address;
                    $cus_decide->cus_tel = $request->txt_cus_tel;
                    $cus_decide->bill_id = null;
                    $cus_decide->date_sale = null;
                    $cus_decide->description = $request->txt_nobuy_note;
                    $cus_decide->save();
                    if ($cus_decide) {
                        for ($i=0; $i < count($request->txt_product_purchased); $i++) { 
                            $max_id = ProductCustomerDecide::max('id') + 1;
                            $pro_cus_con = new ProductCustomerDecide();
                            $pro_cus_con->id = $max_id;
                            $pro_cus_con->tr_code = $request->txt_track_code;
                            $pro_cus_con->item_category = $request->cb_categroy[$i];
                            $pro_cus_con->item_pattern = $request->cb_pattern[$i];
                            $pro_cus_con->product_buy = $request->txt_product_purchased[$i];
                            $pro_cus_con->size = $request->txt_size[$i];
                            $pro_cus_con->item_brand = $request->cb_brand[$i];
                            $pro_cus_con->save();
                        }
                        return response()->json('success');
                    }else {
                        return response()->json('fail');
                    }
                } else {
                    return response()->json('fail');
                }
                
            } else {
                return response()->json('fail');
            }
        } else {
            return response()->json('success');
        }
    }

    public function customer_purchase(Request $request)
    {
        $t_id = $request->track_id;
        $t_code = $request->track_code;
        $data = ContractCustomer::join('crm_track_online', 'crm_track_online.tr_code', 'crm_contract_customer.tr_code')
        ->where('crm_contract_customer.tr_code', $t_code)
        ->select('crm_contract_customer.*', 'crm_track_online.tr_name', 'crm_track_online.tr_cus_address', 'crm_track_online.tr_tel')
        ->orderBy('crm_contract_customer.id', 'desc')
        ->first();
        $cc_id = $data->id;
        $con_cus_product = ProductCustomerContract::where('cc_id', $cc_id)
        ->get();
        return view('sellers.customer-purchase', compact('t_id', 't_code', 'data', 'con_cus_product'));
    }

    public function save_customer_purchased(Request $request)
    {
        $max_id = CustomerDecides::max('id') + 1;
        $cus_decide = new CustomerDecides();
        $cus_decide->id = $max_id;
        $cus_decide->tr_code = $request->txt_track_code;
        $cus_decide->decide_status = 'ຊື້';
        $cus_decide->cus_name = $request->txt_cus_name;
        $cus_decide->cus_address = $request->txt_cus_address;
        $cus_decide->cus_tel = $request->txt_cus_tel;
        $cus_decide->bill_id = $request->txt_bill_id;
        $cus_decide->date_sale = $request->txt_date_sale;
        $cus_decide->description = $request->txt_nobuy_note;
        $cus_decide->save();
        if ($cus_decide) {
            for ($i=0; $i < count($request->txt_product_purchased); $i++) { 
                $max_id = ProductCustomerDecide::max('id') + 1;
                $pro_cus_con = new ProductCustomerDecide();
                $pro_cus_con->id = $max_id;
                $pro_cus_con->tr_code = $request->txt_track_code;
                $pro_cus_con->item_category = $request->cb_categroy[$i];
                $pro_cus_con->item_pattern = $request->cb_pattern[$i];
                $pro_cus_con->product_buy = $request->txt_product_purchased[$i];
                $pro_cus_con->size = $request->txt_size[$i];
                $pro_cus_con->item_brand = $request->cb_brand[$i];
                $pro_cus_con->save();
            }
            return response()->json('success');
        }else {
            return response()->json('fail');
        }
    }

    

}
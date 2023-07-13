<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackOnline;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashbourdController extends Controller
{
    public function index(Request $request){

        if (Auth::user()->hasRole('marketing')) {
            $set_month = date('m');
            $set_year = date('Y');
            $emp_seller = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('crm_employee', 'crm_employee.id', '=', 'users.emp_id')
            ->select('crm_employee.*')
            ->where('role_user.role_id', 3)->get();

            return view('marketing-dashboard', compact('emp_seller','set_month', 'set_year'));

        } else if (Auth::user()->hasRole('superadministrator')){
            return view('admin-dashboard');
        } else if (Auth::user()->hasRole('seller')){
            return view('seller-dashboard');
        } else if (Auth::user()->hasRole('adminpage')){
            return view('adminpage-dashboard');
        } else if (Auth::user()->hasRole('adminsell')){
            $data = TrackOnline::join('crm_employee', 'crm_employee.id','=', 'crm_track_online.emp_id')
        ->select('crm_track_online.*', 'crm_employee.emp_name')
        ->orderBy('crm_track_online.id', 'DESC')->paginate(10);
            return view('adminsell-dashboard', compact('data'));
        }  else {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

    public function con_noContract_customer()
    {
        return view('reports.con-nocontract-cus');
    }
    public function report_cust_credit()
    {
        return view('reports.cus-credit-dashboard');
    }

    public function load_track_conclude(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        //ຈຳນວນລູກຄ້າຕິດຕໍ່ທັງໝົດ
        $all = DB::select("SELECT count(*) as qty FROM crm_track_online
        WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y",['m' => $month, 'y' => $year]);
        $all_qty = $all[0]->qty;

        //ຈຳນວນທີ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າແລ້ວ
        $contract = DB::select("SELECT count(*) as qty FROM crm_track_online WHERE status = 'ຕິດຕໍ່ສຳເລັດ'
        AND EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y",['m' => $month, 'y' => $year]);
        $contract_qty = $contract[0]->qty;

        //ຈຳນວນທີ່ຍັງບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ
        $wait = DB::select("SELECT count(*) as qty FROM crm_track_online WHERE status = 'ລໍຖ້າຕິດຕໍ່'
        AND EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y",['m' => $month, 'y' => $year]);
        $wait_qty = $wait[0]->qty;

        //ຈຳນວນລູກຄ້າຕັດສິນໃຈຊື້
        $all_purchased = DB::select("SELECT count(*) as qty from crm_contract_customer WHERE status = 'ຊື້'
        AND EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y",['m' => $month, 'y' => $year]);
        $purchased_qty = $all_purchased[0]->qty;

        //ຈຳນວນລູກຄ້າຕັດສິນໃຈບໍ່ຊື້
        $all_nopurchased = DB::select("SELECT count(*) as qty from crm_contract_customer WHERE status = 'ບໍ່ຊື້'
        AND EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y",['m' => $month, 'y' => $year]);
        $nopurchased_qty = $all_nopurchased[0]->qty;

        //ຈຳນວນລູກຄ້າລໍຖ້າຕັດສິນໃຈ
        $waiting_qty = $contract_qty - ($purchased_qty+$nopurchased_qty);
        return response()->json(['all_qty'=>$all_qty, 'contract_qty'=>$contract_qty, 'wait_qty'=>$wait_qty,
        'purchased_qty'=>$purchased_qty, 'nopurchased_qty'=>$nopurchased_qty, 'waiting_qty'=>$waiting_qty]);

    }

    public function cust_credit(Request $request){
        $base = $request->session()->get('choose-base');
        $month = $request->month;
        $year = $request->year;
        //ລູກຄ້າສິນເຊື່ອທັງໝົດ
        
        $allcredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE  EXTRACT(MONTH FROM doc_date) = :m and EXTRACT(YEAR FROM doc_date) = :y",['m' => $month, 'y' => $year]);
        $all_qty_credit = $allcredit[0]->qty;
        //ລູກຄ້າທີ່ອະນຸມັດ
        $approvecredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE approve_status='ອະນຸມັດ' AND EXTRACT(MONTH FROM doc_date) = :m and EXTRACT(YEAR FROM doc_date) = :y",['m' => $month, 'y' => $year]);
        $approve_qty_credit = $approvecredit[0]->qty;

        //ຈຳນວນທີ່ບໍ່ອະນຸມັດ
        $noapprovecredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE approve_status='ບໍ່ອະນຸມັດ' AND EXTRACT(MONTH FROM doc_date) = :m and EXTRACT(YEAR FROM doc_date) = :y",['m' => $month, 'y' => $year]);
        $noapprove_qty_credit = $noapprovecredit[0]->qty;

        //ຈຳນວນທີ່ລໍຖ້າອະນຸມັດ
        $waitapprove = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE approve_status isnull AND EXTRACT(MONTH FROM doc_date) = :m and EXTRACT(YEAR FROM doc_date) = :y",['m' => $month, 'y' => $year]);
        $wait_qty_credit = $waitapprove[0]->qty;

        return response()->json(['allcredit'=>$all_qty_credit, 'approvecredit'=>$approve_qty_credit, 'noapprovecredit'=>$noapprove_qty_credit,
        'waitapprove'=>$wait_qty_credit]);
     }
    public function cust_credit_bydate(Request $request){
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        //ລູກຄ້າສິນເຊື່ອທັງໝົດ
        $allcredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE  doc_date BETWEEN :startdate and :enddate",['startdate' => $startdate, 'enddate' => $enddate]);
        $all_qty_credit = $allcredit[0]->qty;
        //ລູກຄ້າທີ່ອະນຸມັດ
        $approvecredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE approve_status='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate",['startdate' => $startdate, 'enddate' => $enddate]);
        $approve_qty_credit = $approvecredit[0]->qty;

        //ຈຳນວນທີ່ບໍ່ອະນຸມັດ
        $noapprovecredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE approve_status='ບໍ່ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate",['startdate' => $startdate, 'enddate' => $enddate]);
        $noapprove_qty_credit = $noapprovecredit[0]->qty;

        //ຈຳນວນທີ່ລໍຖ້າອະນຸມັດ
        $waitapprove = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE approve_status isnull AND  doc_date BETWEEN :startdate and :enddate",['startdate' => $startdate, 'enddate' => $enddate]);
        $wait_qty_credit = $waitapprove[0]->qty;

        $sqlcategory = DB::select("SELECT  item_type,count(item_type) as itemtype_qty,sum(item_price) as itemtype_sum FROM crm_c_product  where approve_status='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate group by item_type",['startdate' => $startdate, 'enddate' => $enddate]);

        $sqlcompany = DB::select("SELECT (select cc_name from crm_credit_companies where cc_id = a.company_id) as cc_name, count(doc_run)as numlist,sum(item_price)as sum_amount FROM crm_c_product a where approve_status='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate group by cc_name",['startdate' => $startdate, 'enddate' => $enddate]);


        $sqlbycategory = DB::select("select item_type from crm_c_product where approve_status ='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate group by item_type",['startdate' => $startdate, 'enddate' => $enddate]);


        return response()->json(['allcredit'=>$all_qty_credit, 'approvecredit'=>$approve_qty_credit, 'noapprovecredit'=>$noapprove_qty_credit,
        'waitapprove'=>$wait_qty_credit,'category'=>$sqlcategory,'companycredit'=>$sqlcompany,'sqlbycategory'=>$sqlbycategory]);
    }

    public function cust_credit_bydate_category(Request $request){
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $category = $request->cbocategory;

        $request->session()->put('startdate-marketing-report-credit', $startdate);
        $request->session()->put('enddate-marketing-report-credit', $enddate);

        $set_startdate = $request->session()->get('startdate-marketing-report-credit');
        $set_enddate = $request->session()->get('enddate-marketing-report-credit');
        //ລູກຄ້າສິນເຊື່ອທັງໝົດ
        $allcredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE  item_type = :category AND doc_date BETWEEN :startdate and :enddate",['category'=>$category,'startdate' => $set_startdate, 'enddate' => $set_enddate]);
        $all_qty_credit = $allcredit[0]->qty;
        //ລູກຄ້າທີ່ອະນຸມັດ
        $approvecredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE item_type = :category AND approve_status='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate",['category'=>$category,'startdate' => $set_startdate, 'enddate' => $set_enddate]);
        $approve_qty_credit = $approvecredit[0]->qty;

        //ຈຳນວນທີ່ບໍ່ອະນຸມັດ
        $noapprovecredit = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE item_type = :category AND approve_status='ບໍ່ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate",['category'=>$category,'startdate' => $set_startdate, 'enddate' => $set_enddate]);
        $noapprove_qty_credit = $noapprovecredit[0]->qty;

        //ຈຳນວນທີ່ລໍຖ້າອະນຸມັດ
        $waitapprove = DB::select("SELECT count(doc_run) as qty FROM crm_c_product
        WHERE item_type = :category AND approve_status isnull AND  doc_date BETWEEN :startdate and :enddate",['category'=>$category,'startdate' => $set_startdate, 'enddate' => $set_enddate]);
        $wait_qty_credit = $waitapprove[0]->qty;

        $sqlcategory = DB::select("SELECT  item_type,count(item_type) as itemtype_qty,sum(item_price) as itemtype_sum FROM crm_c_product  where item_type = :category AND approve_status='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate group by item_type",['category'=>$category,'startdate' => $set_startdate, 'enddate' => $set_enddate]);

        $sqlcompany = DB::select("SELECT (select cc_name from crm_credit_companies where cc_id = a.company_id) as cc_name, count(doc_run)as numlist,sum(item_price)as sum_amount FROM crm_c_product a where item_type = :category AND approve_status='ອະນຸມັດ' AND  doc_date BETWEEN :startdate and :enddate group by cc_name",['category'=>$category,'startdate' => $set_startdate, 'enddate' => $set_enddate]);


        return response()->json(['allcredit'=>$all_qty_credit, 'approvecredit'=>$approve_qty_credit, 'noapprovecredit'=>$noapprove_qty_credit,
        'waitapprove'=>$wait_qty_credit,'companycredit'=>$sqlcompany,'category'=>$sqlcategory,'set_startdate'=>$set_startdate,'set_enddate'=>$set_enddate]);
    }
}
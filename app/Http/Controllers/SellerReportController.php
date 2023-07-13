<?php

namespace App\Http\Controllers;

use App\Models\CustomcreditModel;
use Illuminate\Http\Request;
use App\Models\ProductCustomerInterest;
use App\Models\CustomerDecides;
use App\Models\TrackOnline;
use Illuminate\Support\Facades\DB;

class SellerReportController extends Controller
{
    public function search_track_bycustomer(Request $request)
    {
        $fillter = $request->fillter;
        $data = TrackOnline::join('crm_employee', 'crm_employee.id', 'crm_track_online.emp_id')
        ->where('crm_track_online.emp_id', auth()->user()->emp_id)
        ->where('crm_track_online.tr_name','LIKE','%'.$fillter.'%')
        ->select('crm_track_online.*', 'crm_employee.emp_name', 'crm_employee.emp_lname')
        ->orderBy('crm_track_online.id', 'DESC')
        ->get();
        $product_list = array();
        foreach ($data as $key => $value) {
            $product = ProductCustomerInterest::where('tr_code', $value->tr_code)->get();
            $product_list[] = $product;
        }
        return response()->json(['data'=>$data, 'product'=>$product_list]);
    }
    public function report_track_movement(Request $request)
    {
        $sell_id = auth()->User()->emp_id;
        if ($request->session()->has('m-seller-report-movement') && $request->session()->get('y-seller-report-movement')) {
            $set_month = $request->session()->get('m-seller-report-movement');
            $set_year = $request->session()->get('y-seller-report-movement');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }
        //////////////////////////////////////
        $data = TrackOnline::whereMonth('created_at', $set_month)
        ->whereYear('created_at', $set_year)
        ->where('emp_id', $sell_id)
        ->paginate(10);
        return view('reports.seller.report-movement-sale', compact('data', 'set_month', 'set_year'));
    }

    public function report_seller_nocontrack(Request $request)
    {
        $sell_id = auth()->User()->emp_id;
        if ($request->session()->has('m-seller-report-nocontract') && $request->session()->get('y-seller-report-nocontract')) {
            $set_month = $request->session()->get('m-seller-report-nocontract');
            $set_year = $request->session()->get('y-seller-report-nocontract');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }
        /* $data = TrackOnline::whereMonth('created_at', $set_month)
        ->whereYear('created_at', $set_year)
        ->where('emp_id', $sell_id)
        ->where('status', 'ລໍຖ້າຕິດຕໍ່')
        ->paginate(10); */
        $data = TrackOnline::join('crm_employee', 'crm_employee.id', 'crm_track_online.emp_id')
        ->whereMonth('crm_track_online.created_at', $set_month)
        ->whereYear('crm_track_online.created_at', $set_year)
        ->where('crm_track_online.emp_id', $sell_id)
        ->where('crm_track_online.status', 'ລໍຖ້າຕິດຕໍ່')
        ->select('crm_track_online.*', 'crm_employee.emp_name', 'crm_employee.emp_lname')
        ->paginate(10);
        return view('reports.seller.report-seller-nocontract', compact('data', 'set_month', 'set_year'));
    }

    public function report_cus_purchased(Request $request)
    {
        $sell_id = auth()->User()->emp_id;
        if ($request->session()->has('m-seller-report-purchased') && $request->session()->get('y-seller-report-purchased')) {
            $set_month = $request->session()->get('m-seller-report-purchased');
            $set_year = $request->session()->get('y-seller-report-purchased');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }
        $data = CustomerDecides::join('crm_track_online', 'crm_track_online.tr_code', 'crm_customer_decides.tr_code')
        ->whereMonth('crm_customer_decides.created_at', $set_month)
        ->whereYear('crm_customer_decides.created_at', $set_year)
        ->where('crm_track_online.emp_id', $sell_id)
        ->where('crm_customer_decides.decide_status', 'ຊື້')
        ->select('crm_customer_decides.*', 'crm_track_online.created_at as track_date')
        ->orderBy('id','DESC')
        ->paginate(10);
        return view('reports.seller.report-cus-purchased', compact('data', 'set_month', 'set_year'));
    }

    public function load_list_cus_all(Request $request)
    {

        $sell_id = auth()->User()->emp_id;
        if ($request->session()->has('m-seller-report-purchased') && $request->session()->get('y-seller-report-purchased')) {
            $set_month = $request->session()->get('m-seller-report-purchased');
            $set_year = $request->session()->get('y-seller-report-purchased');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }
        $data = CustomcreditModel::join('crm_c_customer','crm_c_product.c_cus_id','crm_c_customer.c_cus_id')
        ->select('crm_c_product.*','crm_c_customer.cus_name','crm_c_customer.cus_tel')
        ->OrderBy('doc_run','DESC')
        ->Paginate(10);
        return view('reports.seller.report-credit-moment', compact('data'));
    }

    public function load_list_noapprove(Request $request)
    {
        $data = CustomcreditModel::join('crm_c_customer','crm_c_product.c_cus_id','crm_c_customer.c_cus_id')
        ->select('crm_c_product.*','crm_c_customer.cus_name','crm_c_customer.cus_tel')
        ->where('approve_status','ບໍ່ອະນຸມັດ')
        ->OrderBy('doc_run','DESC')
        ->Paginate(10);
        return view('reports.seller.customer-credit-noapprove', compact('data'));
    }

    public function load_list_cus_bydate(Request $request)
    {
        $start_date = $request->session()->get('start-date-creditreport-all');
        $end_date = $request->session()->get('end-date-creditreport-all');
        $sell_id = auth()->User()->emp_id;
        $data = CustomcreditModel::join('crm_c_customer','crm_c_product.c_cus_id','crm_c_customer.c_cus_id')
        ->whereDate('crm_c_product.created_at',$start_date)
        ->whereDate('crm_c_product.created_at',$end_date)
        ->select('crm_c_product.*')
        ->OrderBy('doc_run','DESC')
        ->Paginate(10);
        return view('reports.seller.report-credit-moment', compact('data','start_date','end_date'));
    }

    public function Approve_confirm(Request $request)
    {
        $doc_id = $request->doc_run;
        $date = date('Y-m-d H:i:s');
       $data= DB::update("UPDATE public.crm_c_product SET approve_status ='ອະນຸມັດ',updated_at ='$date' WHERE doc_run ='$doc_id'");
       if($data){
        return response()->json('success');
       }
    }
    public function credit_no_approve(Request $request){
        $doc_id = $request->doc_run;
        $note = $request->note;
        $date = date('Y-m-d H:i:s');
        $data= DB::update("UPDATE public.crm_c_product SET approve_status ='ບໍ່ອະນຸມັດ',updated_at ='$date',note ='$note' WHERE doc_run ='$doc_id'");
       if($data){
        return response()->json('success');
       }else{
        return response()->json('fail');
       }

    }

    public function loadbill_sml(Request $request)
    {
        $sell_id = auth()->User()->emp_id;

        $data = DB::select("SELECT doc_no,doc_date,(select name_1 from ar_customer where code = a.cust_code) as cust_name,total_amount from ic_trans where sale_code:sell_id",['sell_id'=>$sell_id]);
        return response()->json(['data'=>$data]);
    }

}
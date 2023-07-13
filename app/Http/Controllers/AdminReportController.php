<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractCustomer;
use App\Models\CustomerDecides;
use App\Models\TrackOnline;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function report_track_movement(Request $request)
    {
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
        ->paginate(10);
        return view('reports.admin.report-movement-sale', compact('data', 'set_month', 'set_year'));
    }
 
    public function report_seller_nocontrack(Request $request)
    {
        if ($request->session()->has('m-seller-report-nocontract') && $request->session()->get('y-seller-report-nocontract')) {
            $set_month = $request->session()->get('m-seller-report-nocontract');
            $set_year = $request->session()->get('y-seller-report-nocontract');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }
        $data = TrackOnline::whereMonth('created_at', $set_month)
        ->whereYear('created_at', $set_year)
        ->where('status', 'ລໍຖ້າຕິດຕໍ່')
        ->paginate(10);
        return view('reports.admin.report-seller-nocontract', compact('data', 'set_month', 'set_year'));
    }

    public function report_cus_purchased(Request $request)
    {
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
        ->where('crm_customer_decides.decide_status', 'ຊື້')
        ->select('crm_customer_decides.*', 'crm_track_online.created_at as track_date')
        ->paginate(10);
        return view('reports.admin.report-cus-purchased', compact('data', 'set_month', 'set_year'));
    }
}
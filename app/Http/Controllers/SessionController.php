<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{	
	public function set_choose_base(Request $request)
    {
        $base = $request->base;
        $request->session()->put('choose-base', $base);
        return response()->json('success');
    }
    public function set_report_movement_month_year(Request $request)
    {
        $month = (int)$request->m;
        if ($month < 10) {
            $month = '0'.$month;
        }
        $year = $request->y;
        $request->session()->put('m-seller-report-movement', $month);
        $request->session()->put('y-seller-report-movement', $year);
        return response()->json('success');
    }

    public function set_report_nocon_month_year(Request $request)
    {
        $month = (int)$request->m;
        if ($month < 10) {
            $month = '0'.$month;
        }
        $year = $request->y;
        $request->session()->put('m-seller-report-nocontract', $month);
        $request->session()->put('y-seller-report-nocontract', $year);
        return response()->json('success');
    }

    public function set_report_purchased_month_year(Request $request)
    {
        $month = (int)$request->m;
        if ($month < 10) {
            $month = '0'.$month;
        }
        $year = $request->y;
        $request->session()->put('m-seller-report-purchased', $month);
        $request->session()->put('y-seller-report-purchased', $year);
        return response()->json('success');
    }

    public function set_search_track_month_year(Request $request)
    {
        $month = (int)$request->m;
        if ($month < 10) {
            $month = '0'.$month;
        }
        $year = $request->y;
        $request->session()->put('m-seller-search-track', $month);
        $request->session()->put('y-seller-search-track', $year);
        return response()->json('success');
    }

    public function set_marketing_report_month_year(Request $request){
        $month = (int)$request->m;
        if ($month < 10) {
            $month = '0'.$month;
        }
        $year = $request->y;
        $request->session()->put('m-marketing-report', $month);
        $request->session()->put('y-marketing-report', $year);
        return response()->json('success');
    }

    public function set_startdate_enddate_report(Request $request){
        $start_date = $request->start;
        $end_date = $request->end;
        $request->session()->put('start-date-report-all', $start_date);
        $request->session()->put('end-date-report-all', $end_date);
        return response()->json('success');
    }
	
}
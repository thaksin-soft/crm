<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackOnline;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MarketingReportController extends Controller
{
    public function createDateRangeArray($strDateFrom,$strDateTo)
    {
        $aryRange = [];
    
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    public function createDayRangeArray($strDateFrom,$strDateTo)
    {
        $aryRange = [];
    
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('d', $iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('d', $iDateFrom));
            }
        }
        return $aryRange;
    }
 
    public function report_effective_contract(Request $request)
    {
        if ($request->session()->has('m-marketing-report') && $request->session()->get('y-marketing-report')) {
            $set_month = $request->session()->get('m-marketing-report');
            $set_year = $request->session()->get('y-marketing-report');
        } else {
            $set_month = date('m');
            $set_year = date('Y');
        }   
        $emp_seller = User::join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('crm_employee', 'crm_employee.id', '=', 'users.emp_id')
        ->select('crm_employee.*')
        ->where('role_user.role_id', 3)->get();
         
        $data = TrackOnline::join('crm_employee', 'crm_employee.id', 'crm_track_online.emp_id')
        ->whereMonth('crm_track_online.created_at', $set_month)
        ->whereYear('crm_track_online.created_at', $set_year)
        ->where('crm_track_online.status', 'ລໍຖ້າຕິດຕໍ່')
        ->select('crm_track_online.*', 'crm_employee.emp_name', 'crm_employee.emp_lname')
        ->paginate(10);
        
        return view('reports.marketing.report-effective', compact('data', 'set_month', 'set_year', 'emp_seller'));
        
    } 

    public function report_emp_contract_bydate(Request $request)
    {
        return view('reports.marketing.report-emp-con-bydate');
    }

    public function load_emp_con_bydate(Request $request)
    {
        $emp_id = $request->emp_id;
        $date = $request->date;
        $data = DB::table('crm_contract_customer')
        ->join('crm_track_online', 'crm_track_online.tr_code', 'crm_contract_customer.tr_code')
        ->join('crm_brands', 'crm_brands.id', 'crm_contract_customer.prb_id')
        ->where('crm_track_online.emp_id', $emp_id)
        ->where('crm_contract_customer.created_at', 'LIKE', '%' . $date . '%')
        ->select('crm_contract_customer.created_at', 'crm_contract_customer.product_purchased', 'crm_contract_customer.status', 'crm_track_online.tr_name', 'crm_brands.brand_name')
        ->get();
        echo json_encode($data);
        
        //return response()->json($data);
    }
    public function load_track_effective(Request $request)
    {
        $option = $request->time_option;
        $emp_id = $request->cb_employee;
        if ($option == 'bymonth') {
            $month = $request->effective_month;
            $year = $request->effective_year;
            $qty_day = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
            $dates = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                if ($i < 10) {
                    $i = '0'.$i;
                }
                if ($request->month == date('m') && $i == date('d')) {
                    $qty_day = $i;
                }
                $dates[] = $i;
            }
            if ($emp_id == 'all') {
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສູງສຸດ
                $max = 0;
                $max_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND
                EXTRACT(MONTH FROM t1.created_at) = :m and EXTRACT(YEAR FROM t1.created_at) = :y
                ORDER BY difference DESC limit 1;", ['m' => $month, 'y' => $year]);
                if (count($max_contract) > 0) {
                    foreach ($max_contract as $key => $value) {
                        $max = $value->difference;
                    }
                } else {
                    $max = '';
                }
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ຕ່ຳສຸດ
                $min = 0;
                $min_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND
                EXTRACT(MONTH FROM t1.created_at) = :m and EXTRACT(YEAR FROM t1.created_at) = :y
                ORDER BY difference ASC limit 1;", ['m' => $month, 'y' => $year]);
                if (count($min_contract) > 0) {
                    foreach ($min_contract as $key => $value) {
                        $min = $value->difference;
                    }
                } else {
                    $min = '';
                }
 
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສະເລ່ຍ
                $average = 0;
                $average_contract = DB::select("SELECT SUM(t2.created_at - t1.created_at) / COUNT(t1.created_at) AS average
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND
                EXTRACT(MONTH FROM t1.created_at) = :m and EXTRACT(YEAR FROM t1.created_at) = :y;", ['m' => $month, 'y' => $year]);
                
                if (count($average_contract) > 0) {
                    foreach ($average_contract as $key => $value) {
                        $average = $value->average;
                    }
                } else {
                    $average = '';
                }
                $average = strstr($average, '.', true);
                return response()->json(['max'=>$max, 'min'=>$min, 'average'=>$average]);
            } else {
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສູງສຸດ
                $max = 0;
                $max_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.emp_id = :emp_id AND
                EXTRACT(MONTH FROM t1.created_at) = :m and EXTRACT(YEAR FROM t1.created_at) = :y
                ORDER BY difference DESC limit 1;", ['m' => $month, 'y' => $year, 'emp_id'=>$emp_id]);
                if (count($max_contract) > 0) {
                    foreach ($max_contract as $key => $value) {
                        $max = $value->difference;
                    }
                } else {
                    $max = '';
                }
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ຕ່ຳສຸດ
                $min = 0;
                $min_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.emp_id = :emp_id AND
                EXTRACT(MONTH FROM t1.created_at) = :m and EXTRACT(YEAR FROM t1.created_at) = :y
                ORDER BY difference ASC limit 1;", ['m' => $month, 'y' => $year, 'emp_id'=>$emp_id]);
                if (count($min_contract) > 0) {
                    foreach ($min_contract as $key => $value) {
                        $min = $value->difference;
                    }
                } else {
                    $min = '';
                }

                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສະເລ່ຍ
                $average = 0;
                $average_contract = DB::select("SELECT SUM(t2.created_at - t1.created_at) / COUNT(t1.created_at) AS average
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.emp_id = :emp_id AND
                EXTRACT(MONTH FROM t1.created_at) = :m and EXTRACT(YEAR FROM t1.created_at) = :y;", 
                ['m' => $month, 'y' => $year, 'emp_id'=>$emp_id]);
              
                if (count($average_contract) > 0) {
                    foreach ($average_contract as $key => $value) {
                        $average = $value->average;
                    }
                } else {
                    $average = '';
                }
                $average = strstr($average, '.', true);
                return response()->json(['max'=>$max, 'min'=>$min, 'average'=>$average]);
            }
            
        } else {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            if ($emp_id == 'all') {
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສູງສຸດ
                $max = 0;
                $max_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.created_at between :start AND :end
                ORDER BY difference DESC limit 1;", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);
                foreach ($max_contract as $key => $value) {
                    $max = $value->difference;
                }
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ຕ່ຳສຸດ
                $min = 0;
                $min_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND
                t1.created_at between :start AND :end
                ORDER BY difference ASC limit 1;", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);
                foreach ($min_contract as $key => $value) {
                    $min = $value->difference;
                }

                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສະເລ່ຍ
                $average = 0;
                $average_contract = DB::select("SELECT SUM(t2.created_at - t1.created_at) / COUNT(t1.created_at) AS average
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND
                t1.created_at between :start AND :end", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);
                if (count($average_contract) > 0) {
                    foreach ($average_contract as $key => $value) {
                        $average = $value->average;
                    }
                } else {
                    $average = '';
                }
                $average = strstr($average, '.', true);
                return response()->json(['max'=>$max, 'min'=>$min, 'average'=>$average]);
            } else {
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສູງສຸດ
                //$max = ''; $min = ''; $average = '';
                $max_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.emp_id = :emp_id AND t1.created_at between :start AND :end
                ORDER BY difference DESC limit 1;", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59', 'emp_id'=>$emp_id]);
                if (count($max_contract) > 0) {
                    foreach ($max_contract as $key => $value) {
                        $max = $value->difference;
                    }
                } else {
                    $max = '';
                }
                
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ຕ່ຳສຸດ
                $min_contract = DB::select("SELECT t1.tr_code,  t1.created_at as input_date, t2.created_at as contract_date, 
                t2.status, t2.created_at - t1.created_at AS difference
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.emp_id = :emp_id AND
                t1.created_at between :start AND :end
                ORDER BY difference ASC limit 1;", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59', 'emp_id'=>$emp_id]);
                if (count($min_contract) > 0) {
                    foreach ($min_contract as $key => $value) {
                        $min = $value->difference;
                    }
                } else {
                    $min = '';
                }
                //ດຶງຂໍ້ມູນເວລາຕິດຕໍ່ສະເລ່ຍ
                
                $average_contract = DB::select("SELECT SUM(t2.created_at - t1.created_at) / COUNT(t1.created_at) AS average
                FROM public.crm_track_online AS t1, public.crm_contract_customer AS t2
                WHERE t1.tr_code = t2.tr_code AND t2.status = 'ກຳລັງຕິດຕໍ່' AND t1.emp_id = :emp_id AND
                t1.created_at between :start AND :end", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59', 'emp_id'=>$emp_id]);
                if (count($average_contract) > 0) {
                    foreach ($average_contract as $key => $value) {
                        $average = $value->average;
                    }
                } else {
                    $average = '';
                }
                $average = strstr($average, '.', true);
                //
                return response()->json(['max'=>$max, 'min'=>$min, 'average'=>$average]);
            }
            
        }

    }
    
    public function load_track_all(Request $request)
    {
        $option = $request->time_option_all_track;
        if ($option == 'bymonth') {
            $month = $request->month;
            $year = $request->year;
            $qty_day = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
            $dates = [];

            for ($i = 1; $i <= $qty_day; $i++) {
                if ($i < 10) {
                    $i = '0'.$i;
                }

                if ($request->month == date('m') && $i == date('d')) {
                    $qty_day = $i;
                }
                $dates[] = $i;
            }

            //ດຶງຂໍ້ມູນສອບຖາມ
            $inquire = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y 
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);
            $inquire_data = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->days == $i) {
                        $inquire_data[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $inquire_data[] = 0;
                }
            }
            //ດຶງຂໍ້ມູນການຕິດຕໍ່ວ່າລູກຄ້າຕັດສິນໃຈແບບໃດ
            //ດຶງຂໍ້ມູນລູກຄ້າຊື້
            $inquire = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ຊື້'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);
            $purchased_data = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->days == $i) {
                        $purchased_data[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $purchased_data[] = 0;
                }
            }
            //ດຶງຂໍ້ມູນລູກຄ້າບໍ່ຊື້
            $inquire = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ບໍ່ຊື້'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);
            $no_purchased_data = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->days == $i) {
                        $no_purchased_data[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $no_purchased_data[] = 0;
                }
            }
            
            //ດຶງຂໍ້ມູນລູກຄ້າລໍຖ້າການຕັດສິນໃຈ
            $inquire = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);
            $waiting_data = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->days == $i) {
                        $waiting_data[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $waiting_data[] = 0;
                }
            }

            //ດຶງຂໍ້ມູນລູກຄ້າລໍຖ້າຕິດຕໍ່
            $inquire = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າຕິດຕໍ່'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);
            $no_contract_data = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->days == $i) {
                        $no_contract_data[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $no_contract_data[] = 0;
                }
            }
            return response()->json(['dates'=>$dates, 'inquire'=>$inquire_data, 
            'purchased'=>$purchased_data, 'no_purchased'=>$no_purchased_data, 'waiting'=>$waiting_data, 'no_contract'=>$no_contract_data]);

        } else {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $date1_ts = strtotime($start_date);
            $date2_ts = strtotime($end_date);
            $diff = $date2_ts - $date1_ts;
            $qty_day = round($diff / 86400);
            $dates = $this->createDateRangeArray($start_date, $end_date);

            //ດຶງຂໍ້ມູນສອບຖາມ
            $inquire = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE dates between :start AND :end GROUP BY date ", ['start' => $start_date, 'end' => $end_date]);

            $inquire_data = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $inquire_data[] = $value->qty;
                        $ch = 1; 
                    }
                }
                if ($ch == 0) {
                    $inquire_data[] = 0;
                }
            }

            //ດຶງຂໍ້ມູນການຕິດຕໍ່ວ່າລູກຄ້າຕັດສິນໃຈແບບໃດ
            //ດຶງຂໍ້ມູນຊື້
            $inquire = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE dates between :start AND :end AND complete_status = 'ຊື້' GROUP BY date ", ['start' => $start_date, 'end' => $end_date]);

            $purchased_data = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $purchased_data[] = $value->qty;
                        $ch = 1; 
                    }
                }
                if ($ch == 0) {
                    $purchased_data[] = 0;
                }
            }
            //ດຶງຂໍ້ມູນບໍ່ຊື້
            $inquire = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE dates between :start AND :end AND complete_status = 'ບໍ່ຊື້' GROUP BY date ", ['start' => $start_date, 'end' => $end_date]);

            $no_purchased_data = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $no_purchased_data[] = $value->qty;
                        $ch = 1; 
                    }
                }
                if ($ch == 0) {
                    $no_purchased_data[] = 0;
                }
            }
            //ດຶງຂໍ້ມູນລໍຖ້າການຕັດສິນໃຈ
            $waiting_data = [];
            $inquire = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE dates between :start AND :end AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ' GROUP BY date ", ['start' => $start_date, 'end' => $end_date]);
            for ($i = 0; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $waiting_data[] = $value->qty;
                        $ch = 1; 
                    }
                }
                if ($ch == 0) {
                    $waiting_data[] = 0;
                }
            }
            //ດຶງຂໍ້ມູນລໍຖ້າຕິດຕໍ່
            $no_contract_data = [];
            $inquire = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE dates between :start AND :end AND complete_status = 'ລໍຖ້າຕິດຕໍ່' GROUP BY date ", ['start' => $start_date, 'end' => $end_date]);
            for ($i = 0; $i <= $qty_day; $i++) {
                $ch = 0;
                foreach ($inquire as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $no_contract_data[] = $value->qty;
                        $ch = 1; 
                    }
                }
                if ($ch == 0) {
                    $no_contract_data[] = 0;
                }
            }
            
            $days = $this->createDayRangeArray($start_date, $end_date);
            return response()->json(['dates'=>$days, 'inquire'=>$inquire_data, 'purchased'=>$purchased_data, 
            'no_purchased'=>$no_purchased_data, 'waiting'=>$waiting_data, 'no_contract'=>$no_contract_data]);
        }
        
    }

    public function load_track_amass(Request $request)
    {
        $option = $request->time_option_all_track;
        if ($option == 'bymonth') {
            $month = $request->month;
            $year = $request->year;
            $qty_day = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31
            $dates = [];
            for ($i = 1; $i <= $qty_day; $i++) {
                if ($i < 10) {
                    $i = '0'.$i;
                }
                if ($request->month == date('m') && $i == date('d')) {
                    $qty_day = $i;
                }
                $dates[] = $i;
            }

            //ດຶງຂໍ້ມູນສອບຖາມ
            $inquire = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y 
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);

            $inquire_collect = 0;
            $all_inquire = [];
            
            for ($i = 1; $i <= $qty_day; $i++) {
                foreach ($inquire as $key => $value) {
                    if ($value->days == $i) {
                        $inquire_collect = $inquire_collect + $value->qty;
                    }
                }
                $all_inquire[] = $inquire_collect;
            }
            //ດຶງຂໍ້ມູນການຕິດຕໍ່ວ່າລູກຄ້າຕັດສິນໃຈແບບໃດ
            //ລູກຄ້າຊື້ສະສົມ
            $purchased = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ຊື້'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);

            $purchased_collect = 0;
            $all_purchased = [];
            
            for ($i = 1; $i <= $qty_day; $i++) {
                foreach ($purchased as $key => $value) {
                    if ($value->days == $i) {
                        $purchased_collect = $purchased_collect + $value->qty;
                    }
                }
                $all_purchased[] = $purchased_collect;
            }

            //ລູກຄ້າບໍ່ຊື້ສະສົມ
            $nopurchased = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ບໍ່ຊື້'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);

            $nopurchased_collect = 0;
            $all_nopurchased = [];
            
            for ($i = 1; $i <= $qty_day; $i++) {
                foreach ($nopurchased as $key => $value) {
                    if ($value->days == $i) {
                        $nopurchased_collect = $nopurchased_collect + $value->qty;
                    }
                }
                $all_nopurchased[] = $nopurchased_collect;
            }
            //ລູກຄ້າລໍຖ້າຕັດສິນໃຈສະສົມ
            $waiting = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);

            $waiting_collect = 0;
            $all_waiting = [];
            
            for ($i = 1; $i <= $qty_day; $i++) {
                foreach ($waiting as $key => $value) {
                    if ($value->days == $i) {
                        $waiting_collect = $waiting_collect + $value->qty;
                    }
                }
                $all_waiting[] = $waiting_collect;
            }
            //ລູກຄ້າລໍຖ້າຕັດສິນໃຈສະສົມ
            $no_contract = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າຕິດຕໍ່'
            GROUP BY dates, days ORDER BY days", ['m' => $month, 'y' => $year]);

            $no_contract_collect = 0;
            $all_no_contract = [];
            
            for ($i = 1; $i <= $qty_day; $i++) {
                foreach ($no_contract as $key => $value) {
                    if ($value->days == $i) {
                        $no_contract_collect = $no_contract_collect + $value->qty;
                    }
                }
                $all_no_contract[] = $no_contract_collect;
            }
            //
            return response()->json(['dates'=>$dates, 'all_inquire'=>$all_inquire, 'all_purchased'=>$all_purchased, 
            'all_nopurchased'=>$all_nopurchased, 'all_waiting'=>$all_waiting, 'all_no_contract'=>$all_no_contract]);

        } else {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $date1_ts = strtotime($start_date);
            $date2_ts = strtotime($end_date);
            $diff = $date2_ts - $date1_ts;
            $qty_day = round($diff / 86400);
            $dates = $this->createDateRangeArray($start_date, $end_date);

            //ດຶງຂໍ້ມູນສອບຖາມ
            $inquire = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE created_at between :start AND :end GROUP BY date ", ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);

            $inquire_collect = 0;
            $all_inquire = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                foreach ($inquire as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $inquire_collect = $inquire_collect + $value->qty;
                    }
                }
                $all_inquire[] = $inquire_collect;
            }
            //ດຶງຂໍ້ມູນການຕິດຕໍ່ວ່າລູກຄ້າຕັດສິນໃຈແບບໃດ
            //ດຶງຂໍ້ມູນຊື້
            $purchased = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE created_at between :start AND :end AND complete_status = 'ຊື້' GROUP BY date ", 
            ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);

            $purchased_collect = 0;
            $all_purchased = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                foreach ($purchased as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $purchased_collect = $purchased_collect + $value->qty;
                    }
                }
                $all_purchased[] = $purchased_collect;
            }

            //ດຶງຂໍ້ມູນບໍ່ຊື້
            $nopurchased = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE created_at between :start AND :end AND complete_status = 'ຊື້' GROUP BY date ", 
            ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);

            $nopurchased_collect = 0;
            $all_nopurchased = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                foreach ($nopurchased as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $nopurchased_collect = $nopurchased_collect + $value->qty;
                    }
                }
                $all_nopurchased[] = $nopurchased_collect;
            }
            
            //ດຶງຂໍ້ມູນລໍຖ້າການຕັດສິນໃຈ
            $waiting = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE created_at between :start AND :end AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ' GROUP BY date ", 
            ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);

            $waiting_collect = 0;
            $all_waiting = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                foreach ($waiting as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $waiting_collect = $waiting_collect + $value->qty;
                    }
                }
                $all_waiting[] = $waiting_collect;
            }
            //ດຶງຂໍ້ມູນລໍຖ້າຕິດຕໍ່
            $no_contract = DB::select("SELECT COUNT(*) as qty, to_char(created_at, 'YYYY-MM-DD') as date FROM crm_track_online
            WHERE created_at between :start AND :end AND complete_status = 'ລໍຖ້າຕິດຕໍ່' GROUP BY date ", 
            ['start' => $start_date.' 00:00:00', 'end' => $end_date.' 23:59:59']);

            $no_contract_collect = 0;
            $all_no_contract = [];
            //ກວດສອບຂໍ້ມູນໃຫ້ຖືກກັບວັນທີ່ ແລະ ເກັບໄວ້ໃນ array
            for ($i = 0; $i <= $qty_day; $i++) {
                foreach ($no_contract as $key => $value) {
                    if ($value->date == $dates[$i]) {
                        $no_contract_collect = $no_contract_collect + $value->qty;
                    }
                }
                $all_no_contract[] = $no_contract_collect;
            }

            $days = $this->createDayRangeArray($start_date, $end_date);
            return response()->json(['dates'=>$days, 'all_inquire'=>$all_inquire, 'all_purchased'=>$all_purchased, 
            'all_nopurchased'=>$all_nopurchased, 'all_waiting'=>$all_waiting, 'all_no_contract'=>$all_no_contract]);
            
        }
        
    }

    public function load_track_conclude(Request $request)
    {
        $bygender = $request->bygender;
        if (!isset($bygender)) {
            $gender = '';
        } else {
            $gender = $request->cb_cus_gender;
        }
        $option = $request->time_option_all_track;
        if ($option == 'bymonth') {
            $month = $request->month;
            $year = $request->year;
            //ດຶງຂໍ້ມູນການຕິດຕໍ່ວ່າລູກຄ້າຕັດສິນໃຈແບບໃດ
            //ລຸກຄ້າຊື້
            $purchased = DB::select("SELECT COUNT(*) as qty FROM crm_track_online
                WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y and 
                tr_gender LIKE '%".$gender."%' AND complete_status = 'ຊື້'", 
                ['m' => $month, 'y' => $year]);
            $all_purchased = $purchased[0]->qty;

            //ລຸກຄ້າບໍ່ຊື້
            $nopurchased = DB::select("SELECT COUNT(*) as qty FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y and 
            tr_gender LIKE '%".$gender."%' AND complete_status = 'ບໍ່ຊື້'", 
            ['m' => $month, 'y' => $year]);
            $all_nopurchased = $nopurchased[0]->qty;

            //ລຸກຄ້າລໍຖ້າຕັດສິນໃຈ
            $waiting = DB::select("SELECT COUNT(*) as qty FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y and 
            tr_gender LIKE '%".$gender."%' AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ'", 
            ['m' => $month, 'y' => $year]);
            $all_waiting = $waiting[0]->qty;
            
            //ລຸກຄ້າລໍຖ້າຕັດສິນໃຈ
            $no_contract = DB::select("SELECT COUNT(*) as qty FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y and 
            tr_gender LIKE '%".$gender."%' AND complete_status = 'ລໍຖ້າຕິດຕໍ່'", 
            ['m' => $month, 'y' => $year]);
            $all_no_contract = $no_contract[0]->qty;
            
            return response()->json(['all_purchased'=>$all_purchased,'all_no_purchased'=>$all_nopurchased,
            'all_waiting'=>$all_waiting, 'all_no_contract'=>$all_no_contract]);
            
        } else {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            //ດຶງຂໍ້ມູນການຕິດຕໍ່ວ່າລູກຄ້າຕັດສິນໃຈແບບໃດ
            $purchased = DB::select("SELECT COUNT(*) AS qty FROM crm_track_online
                WHERE dates between :start AND :end and tr_gender LIKE '%".$gender."%' AND complete_status = 'ຊື້' ", 
                ['start' => $start_date, 'end'=>$end_date]);
            $all_purchased = $purchased[0]->qty;
            
            //ບໍ່ຊື້
            $nopurchased = DB::select("SELECT COUNT(*) AS qty FROM crm_track_online
                WHERE dates between :start AND :end and tr_gender LIKE '%".$gender."%' AND complete_status = 'ບໍ່ຊື້' ", 
                ['start' => $start_date, 'end'=>$end_date]);
            $all_nopurchased = $nopurchased[0]->qty;

            //ລໍຖ້າຕັດສິນໃຈ
            $waiting = DB::select("SELECT COUNT(*) AS qty FROM crm_track_online
                WHERE dates between :start AND :end and tr_gender LIKE '%".$gender."%' AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ' ", 
                ['start' => $start_date, 'end'=>$end_date]);
            $all_waiting = $waiting[0]->qty;

            //ລໍຖ້າຕັດສິນໃຈ
            $no_contract = DB::select("SELECT COUNT(*) AS qty FROM crm_track_online
                WHERE dates between :start AND :end and tr_gender LIKE '%".$gender."%' AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ' ", 
                ['start' => $start_date, 'end'=>$end_date]);
            $all_no_contract = $no_contract[0]->qty;

            return response()->json(['all_purchased'=>$all_purchased,'all_no_purchased'=>$all_nopurchased,
            'all_waiting'=>$all_waiting, 'all_no_contract'=>$all_no_contract]);
        }
        
    }
    
    public function load_no_contract_report(Request $request){
        $month = (int)$request->m;
        if ($month < 10) {
            $month = '0'.$month;
        }
        $year = $request->y;
        $request->session()->put('m-marketing-report', $month);
        $request->session()->put('y-marketing-report', $year);

        $set_month = $request->session()->get('m-marketing-report');
        $set_year = $request->session()->get('y-marketing-report');
        $data = DB::select("SELECT t1.emp_id, t2.emp_name, t2.emp_lname, count(*) as qty
        FROM crm_track_online t1, crm_employee t2
        WHERE t1.emp_id = t2.id and t1.status = 'ລໍຖ້າຕິດຕໍ່' and EXTRACT(MONTH FROM t1.created_at) = ? and EXTRACT(YEAR FROM t1.created_at) = ? GROUP BY t1.emp_id, t2.emp_name, t2.emp_lname ORDER BY qty DESC", [$set_month, $set_year]);
       
        return $data;
    }

    public function load_track_compare(Request $request)
    {
        $month1 = $request->month1;
        if ($month1 < 10) {
            $month1 = '0'.$month1;
        }
        $month2 = $request->month2;
        if ($month2 < 10) {
            $month2 = '0'.$month2;
        }
        $year1 = $request->year1;
        $year2 = $request->year2;
        $choose = $request->choose;
        //
        $qty_day1 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates1 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month1 == date('m') && $i == date('d')) {
                $qty_day1 = $i;
            }
            $dates1[] = $i;
        }
        ///
        $qty_day2 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates2 = [];
        for ($i = 1; $i <= $qty_day2; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month2 == date('m') && $i == date('d')) {
                $qty_day2 = $i;
            }
            $dates2[] = $i;
        }

        if ($choose == 'inquire') {
            //ດຶງຂໍ້ມູນສອບຖາມ 1
            $inquire1 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y 
            GROUP BY dates, days ORDER BY days", ['m' => $month1, 'y' => $year1]);
            $inquire_data1 = [];
            for ($i = 1; $i <= $qty_day1; $i++) {
                $ch = 0;
                foreach ($inquire1 as $key => $value) {
                    if ($value->days == $i) {
                        $inquire_data1[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $inquire_data1[] = 0;
                }
            }
            //ດຶງຂໍ້ມູນສອບຖາມ 2
            $inquire2 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y 
            GROUP BY dates, days ORDER BY days", ['m' => $month2, 'y' => $year2]);
            $inquire_data2 = [];
            for ($i = 1; $i <= $qty_day2; $i++) {
                $ch = 0;
                foreach ($inquire2 as $key => $value) {
                    if ($value->days == $i) {
                        $inquire_data2[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $inquire_data2[] = 0;
                }
            }
            $return_date = array();
            if (count($dates1) > count($dates2)) {
                $return_date = $dates1;
            } else {
                $return_date = $dates2;
            }
            return response()->json(['choose'=>$choose, 'data1'=>$inquire_data1, 'data2'=>$inquire_data2, 'date'=>$return_date, 'month1'=>$month1, 'month2'=>$month2]);
        }
    }

    public function load_buy_compare(Request $request)
    {
        $month1 = $request->month1;
        if ($month1 < 10) {
            $month1 = '0'.$month1;
        }
        $month2 = $request->month2;
        if ($month2 < 10) {
            $month2 = '0'.$month2;
        }
        $year1 = $request->year1;
        $year2 = $request->year2;
        $choose = $request->choose;
        //
        $qty_day1 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates1 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month1 == date('m') && $i == date('d')) {
                $qty_day1 = $i;
            }
            $dates1[] = $i;
        }
        ///
        $qty_day2 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates2 = [];
        for ($i = 1; $i <= $qty_day2; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month2 == date('m') && $i == date('d')) {
                $qty_day2 = $i;
            }
            $dates2[] = $i;
        }
        //ດຶງຂໍ້ມູນລູກຄ້າຊື້
        //ເດືອນທຳອິດ
        $inquire1 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
        WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ຊື້'
        GROUP BY dates, days ORDER BY days", ['m' => $month1, 'y' => $year1]);
        $purchased_data1 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            $ch = 0;
            foreach ($inquire1 as $key => $value) {
                if ($value->days == $i) {
                    $purchased_data1[] = $value->qty;
                    $ch = 1; 
                    break;
                }
            }
            if ($ch == 0) {
                $purchased_data1[] = 0;
            }
        }
        //ເດືອນທີ່ສອງ
        $inquire2 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
        WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ຊື້'
        GROUP BY dates, days ORDER BY days", ['m' => $month2, 'y' => $year2]);
        $purchased_data2 = [];
        for ($i = 1; $i <= $qty_day2; $i++) {
            $ch = 0;
            foreach ($inquire2 as $key => $value) {
                if ($value->days == $i) {
                    $purchased_data2[] = $value->qty;
                    $ch = 1; 
                    break;
                }
            }
            if ($ch == 0) {
                $purchased_data2[] = 0;
            }
        }

        $return_date = array();
        if (count($dates1) > count($dates2)) {
            $return_date = $dates1;
        } else {
            $return_date = $dates2;
        }
        return response()->json(['data1'=>$purchased_data1, 'data2'=>$purchased_data2, 'date'=>$return_date, 'month1'=>$month1, 'month2'=>$month2]);
    }

    public function load_nobuy_compare(Request $request)
    {
        $month1 = $request->month1;
        if ($month1 < 10) {
            $month1 = '0'.$month1;
        }
        $month2 = $request->month2;
        if ($month2 < 10) {
            $month2 = '0'.$month2;
        }
        $year1 = $request->year1;
        $year2 = $request->year2;
        //
        $qty_day1 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates1 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month1 == date('m') && $i == date('d')) {
                $qty_day1 = $i;
            }
            $dates1[] = $i;
        }
        ///
        $qty_day2 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates2 = [];
        for ($i = 1; $i <= $qty_day2; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month2 == date('m') && $i == date('d')) {
                $qty_day2 = $i;
            }
            $dates2[] = $i;
        }
        //ດຶງຂໍ້ມູນລູກຄ້າບໍ່ຊື້
        //ເດືອນທຳອິດ
        $inquire1 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ບໍ່ຊື້'
            GROUP BY dates, days ORDER BY days", ['m' => $month1, 'y' => $year1]);
            $no_purchased_data1 = [];
            for ($i = 1; $i <= $qty_day1; $i++) {
                $ch = 0;
                foreach ($inquire1 as $key => $value) {
                    if ($value->days == $i) {
                        $no_purchased_data1[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $no_purchased_data1[] = 0;
                }
            }
        //ເດືອນທີ່ສອງ
        $inquire2 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
        WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ບໍ່ຊື້'
        GROUP BY dates, days ORDER BY days", ['m' => $month2, 'y' => $year2]);
        $no_purchased_data2 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            $ch = 0;
            foreach ($inquire2 as $key => $value) {
                if ($value->days == $i) {
                    $no_purchased_data2[] = $value->qty;
                    $ch = 1; 
                    break;
                }
            }
            if ($ch == 0) {
                $no_purchased_data2[] = 0;
            }
        }

        $return_date = array();
        if (count($dates1) > count($dates2)) {
            $return_date = $dates1;
        } else {
            $return_date = $dates2;
        }
        return response()->json(['data1'=>$no_purchased_data1, 'data2'=>$no_purchased_data2, 'date'=>$return_date, 'month1'=>$month1, 'month2'=>$month2]);
    }

    public function load_wait_compare(Request $request)
    {
        $month1 = $request->month1;
        if ($month1 < 10) {
            $month1 = '0'.$month1;
        }
        $month2 = $request->month2;
        if ($month2 < 10) {
            $month2 = '0'.$month2;
        }
        $year1 = $request->year1;
        $year2 = $request->year2;
        //
        $qty_day1 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates1 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month1 == date('m') && $i == date('d')) {
                $qty_day1 = $i;
            }
            $dates1[] = $i;
        }
        ///
        $qty_day2 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates2 = [];
        for ($i = 1; $i <= $qty_day2; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month2 == date('m') && $i == date('d')) {
                $qty_day2 = $i;
            }
            $dates2[] = $i;
        }
        //ລໍຖ້າການຕັດສິນໃຈ
        //ເດືອນທຳອິດ
        $inquire1 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ'
            GROUP BY dates, days ORDER BY days", ['m' => $month1, 'y' => $year1]);
            $waiting_data1 = [];
            for ($i = 1; $i <= $qty_day1; $i++) {
                $ch = 0;
                foreach ($inquire1 as $key => $value) {
                    if ($value->days == $i) {
                        $waiting_data1[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $waiting_data1[] = 0;
                }
            }
        //ເດືອນທີ່ສອງ
        $inquire2 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າການຕັດສິນໃຈ'
            GROUP BY dates, days ORDER BY days", ['m' => $month2, 'y' => $year2]);
            $waiting_data2 = [];
            for ($i = 1; $i <= $qty_day2; $i++) {
                $ch = 0;
                foreach ($inquire2 as $key => $value) {
                    if ($value->days == $i) {
                        $waiting_data2[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $waiting_data2[] = 0;
                }
            }

        $return_date = array();
        if (count($dates1) > count($dates2)) {
            $return_date = $dates1;
        } else {
            $return_date = $dates2;
        }
        return response()->json(['data1'=>$waiting_data1, 'data2'=>$waiting_data2, 'date'=>$return_date, 'month1'=>$month1, 'month2'=>$month2]);
    }

    public function load_nocontract_compare(Request $request)
    {
        $month1 = $request->month1;
        if ($month1 < 10) {
            $month1 = '0'.$month1;
        }
        $month2 = $request->month2;
        if ($month2 < 10) {
            $month2 = '0'.$month2;
        }
        $year1 = $request->year1;
        $year2 = $request->year2;
        //
        $qty_day1 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates1 = [];
        for ($i = 1; $i <= $qty_day1; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month1 == date('m') && $i == date('d')) {
                $qty_day1 = $i;
            }
            $dates1[] = $i;
        }
        ///
        $qty_day2 = cal_days_in_month(CAL_GREGORIAN, $month1, $year1); // 31
        $dates2 = [];
        for ($i = 1; $i <= $qty_day2; $i++) {
            if ($i < 10) {
                $i = '0'.$i;
            }
            if ($request->month2 == date('m') && $i == date('d')) {
                $qty_day2 = $i;
            }
            $dates2[] = $i;
        }
        //ດຶງບໍ່ໄດ້ຕິດຕໍ່ຫາລູກຄ້າ
        //ເດືອນທຳອິດ
        $inquire1 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າຕິດຕໍ່'
            GROUP BY dates, days ORDER BY days", ['m' => $month1, 'y' => $year1]);
            $no_contract_data1 = [];
            for ($i = 1; $i <= $qty_day1; $i++) {
                $ch = 0;
                foreach ($inquire1 as $key => $value) {
                    if ($value->days == $i) {
                        $no_contract_data1[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $no_contract_data1[] = 0;
                }
            }
        //ເດືອນທີ່ສອງ
        $inquire2 = DB::select("SELECT COUNT(*) as qty, dates, to_char(created_at, 'DD') as days FROM crm_track_online
            WHERE EXTRACT(MONTH FROM created_at) = :m and EXTRACT(YEAR FROM created_at) = :y AND complete_status = 'ລໍຖ້າຕິດຕໍ່'
            GROUP BY dates, days ORDER BY days", ['m' => $month2, 'y' => $year2]);
            $no_contract_data2 = [];
            for ($i = 1; $i <= $qty_day1; $i++) {
                $ch = 0;
                foreach ($inquire2 as $key => $value) {
                    if ($value->days == $i) {
                        $no_contract_data2[] = $value->qty;
                        $ch = 1; 
                        break;
                    }
                }
                if ($ch == 0) {
                    $no_contract_data2[] = 0;
                }
            }

        $return_date = array();
        if (count($dates1) > count($dates2)) {
            $return_date = $dates1;
        } else {
            $return_date = $dates2;
        }
        return response()->json(['data1'=>$no_contract_data1, 'data2'=>$no_contract_data2, 'date'=>$return_date, 'month1'=>$month1, 'month2'=>$month2]);
    }

}
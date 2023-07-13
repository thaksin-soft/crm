<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $od_url = "http://10.0.40.135:5000";
    private $pp_url = "http://10.0.40.135:4000";

    public function search_product_from_sml(Request $request)
    {
        $fillter = $request->fillter;
        $fillter = str_replace(' ', '',$fillter);
        $company = $request->rd_company;
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        if ($company == 'pp') {
            curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/load_crm_search_product/'.$fillter);
        } else {
            curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/load_crm_search_product/'.$fillter);
        }

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);
        curl_close($curl_handle);
        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        $data = array();
        foreach ($response_data as $key => $value) {
            $code = $value->code;
            $pro_name = $value->name_1;
            $pro_name = str_replace('"','',$pro_name);
            $cate_name = $value->cate_name;
            $cate_name = str_replace('"','',$cate_name);
            $pattern_name = $value->pattern_name;
            $pattern_name = str_replace('"','',$pattern_name);
            $brand_name = $value->brand_name;
            $brand_name = str_replace('"','',$brand_name);
            $size_name = $value->size_name;
            $size_name = str_replace('"','',$size_name);
            $data[] = ['code'=>$code, 'pro_name'=>$pro_name, 'cate_name'=>$cate_name,'pattern_name'=>$pattern_name,'brand_name'=>$brand_name,'size_name'=>$size_name];
        }
        return $data;
    }

    public function fetch_emp_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_emp');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }


    public function fetch_emp_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_emp');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_group_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_group');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }


    public function fetch_group_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_group');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_cate_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_cate');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }


    public function fetch_cate_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_cate');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }
    public function fetch_brand_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_brand');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }


    public function fetch_brand_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_brand');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_warehouse_from_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_warehouse');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function seller_check_bill_sale_from_sml(Request $request)
    {
        $doc_no = $request->doc_no;
         // Initiate curl session in a variable (resource)
         $curl_handle = curl_init();
         // Set the curl URL option
         curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/load_bill_on_sale/'.$doc_no);

         // This option will return data as a string instead of direct output
         curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

         // Execute curl & store data in a variable
         $curl_data = curl_exec($curl_handle);

         curl_close($curl_handle);

         // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        if (count($response_data) > 0) {
            $sale_date = $response_data[0]->doc_date;
            $orgDate = $sale_date;
            $newDate = date("Y-m-d", strtotime($orgDate));
            return response()->json(['bill'=>'exit', 'doc_date'=>$newDate]);
        } else {
            // Initiate curl session in a variable (resource)
            $curl_handle = curl_init();
            // Set the curl URL option
            curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/load_bill_on_sale/'.$doc_no);

            // This option will return data as a string instead of direct output
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

            // Execute curl & store data in a variable
            $curl_data = curl_exec($curl_handle);

            curl_close($curl_handle);

            // Decode JSON into PHP array
            $response_data = json_decode($curl_data);
            if (count($response_data) > 0) {
                $sale_date = $response_data[0]->doc_date;
                $orgDate = $sale_date;
                $newDate = date("Y-m-d", strtotime($orgDate));
                return response()->json(['bill'=>'exit', 'doc_date'=>$newDate]);
            } else {
                return response()->json(['bill'=>'no']);
            }
        }
    }
}

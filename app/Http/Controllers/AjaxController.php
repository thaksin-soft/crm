<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AjaxController extends Controller
{
    public function load_emp_jq(Request $request)
    {
        $depend_id = $request->id;
        $emp_seller = User::join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('crm_employee', 'crm_employee.id', '=', 'users.emp_id')
        ->select('crm_employee.*')
        ->where('role_user.role_id', 3)
        ->where('crm_employee.depend_id', $depend_id)
        ->get();
        return response()->json($emp_seller);
    }
}
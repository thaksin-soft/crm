<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employees;
use App\Models\Depend;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depend = Depend::orderBy('id', 'ASC')->get();
        $data = Employees::join('users', 'users.emp_id', '=', 'crm_employee.id')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->join('crm_depend', 'crm_depend.id', 'crm_employee.depend_id')
        ->orderBy('crm_employee.id', 'DESC')
        ->select('users.*', 'crm_employee.id AS emp_id','crm_employee.emp_name', 
        'crm_employee.emp_lname', 'crm_employee.emp_gender', 'crm_employee.tel', 
        'roles.display_name', 'crm_depend.depend_name')->paginate(20);
        $role = DB::select("SELECT * FROM public.roles ORDER BY id ASC ", []);
        //dd($data);
        return view('employees.index', compact('data', 'depend', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'emp_name' => 'required|string|max:255',
            'emp_lname' => 'required|string|max:50',
            'tel' => 'required|string|max:30',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        //ກວດສອບພະນັກງານກ່ອນບັນທືກ
        $old_emp = Employees::where('crm_employee.code_fb', $request->emp_fb_code)
        ->where('crm_employee.from_base', $request->from_base)
        ->get();
        if (count($old_emp) == 0) {
            //ບັນທືກຂໍ້ມູນພະນັກງານ
            $emp = new Employees();
            $emp->emp_name = $request->emp_name;
            $emp->emp_lname = $request->emp_lname;
            $emp->emp_gender = $request->gender;
            $emp->tel = $request->tel;
            $emp->email = $request->email;
            $emp->depend_id = $request->depend;
            $emp->code_fb = $request->emp_fb_code;
            $emp->from_base = $request->from_base;
            $emp->emp_name_fb = $request->emp_fb_name;
            $emp->save();
            $emp_id = $emp->id;
            //
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'emp_id' => $emp_id,
                'warehouse_code' => $request->warehouse,
                'depend_id' => $request->depend,
            ]);
            
            $user->attachRole($request->user_role);
            event(new Registered($user));
            
            return redirect()->back();
        } else {
            $emp_id = $old_emp[0]->id;
            //ກວດສອບຂໍ້ມູນຈາກຕາຕາລາງ ຜູ້ໃຊ້
            $old_user = User::join('role_user', 'role_user.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->where('emp_id', $emp_id)
            ->select('users.*', 'roles.name as role_name')
            ->get();
            if (count($old_user) > 0) {
                $old_position = $old_user[0]->role_name;
            } else {
                $old_position = '';
            }
            if ($old_position != $request->user_role) {
                DB::update('update crm_employee set depend_id = ? where id = ?',[$request->depend,$emp_id]);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'emp_id' => $emp_id,
                    'warehouse_code' => $request->warehouse,
                    'depend_id' => $request->depend,
                ]);
                
                $user->attachRole($request->user_role);
                event(new Registered($user));
                
                return redirect()->back();
            } else {
                return redirect()->back()->withErrors(['ພະນັກງານທ່ານນີ້ໄດ້ເພີ່ມເຂົ້າລະບົບ ແລ້ວ!! User:'.$old_emp[0]->name]);
            }
            
        }

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
        $depend = Depend::all();
        $data = Employees::join('users', 'users.emp_id', '=', 'crm_employee.id')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->where('users.id', $id)
        ->select('users.*', 'crm_employee.id AS emp_id','crm_employee.emp_name', 'crm_employee.emp_lname', 
        'crm_employee.emp_gender', 'crm_employee.tel', 'crm_employee.code_fb', 'crm_employee.from_base', 'crm_employee.emp_name_fb',
         'roles.display_name as role_name')->get();
        $role = DB::select("SELECT * FROM public.roles ORDER BY id ASC", []);
        return view('employees.edit', compact('data', 'depend', 'role'));
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
            'emp_name' => 'required|string|max:255',
            'emp_lname' => 'required|string|max:50',
            'tel' => 'required|string|max:30',
        ]);
        //ກວດສອບພະນັກງານກ່ອນບັນທືກ
        $emp = Employees::find($id);
        $emp->emp_name = $request->emp_name;
        $emp->emp_lname = $request->emp_lname;
        $emp->emp_gender = $request->gender;
        $emp->tel = $request->tel;
        $emp->depend_id = $request->depend;
        $emp->code_fb = $request->emp_fb_code;
        $emp->from_base = $request->from_base;
        $emp->emp_name_fb = $request->emp_fb_name;
        $emp->save();
        if ($emp) {
            return redirect('/employee');
        }else{
            echo 'Error';
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
        $delete = User::find($id);
        $delete->delete();
        return response()->json('success');
    }

    
}
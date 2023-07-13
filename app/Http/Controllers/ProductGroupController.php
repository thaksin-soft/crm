<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductGroup;
use App\Models\ProductCategory;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductGroup::orderBy('id', 'ASC')->get();
        return view('product-group.index', compact('data'));
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
        //ບັນທືກຂໍ້ມູນ
        try {
            $prg = new ProductGroup();
            $prg->prg_name = $request->prg_name;
            $prg->note = $request->note;
            $prg->code_fb = $request->group_fb_code;
            $prg->from_base = $request->from_base;
            $prg->save();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error');
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
        //
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
        $prg = ProductGroup::find($id);
        $prg->prg_name = $request->edit_prg_name;
        $prg->note = $request->edit_note;
        $prg->code_fb = $request->group_fb_code;
        $prg->from_base = $request->from_base;
        $prg->save();
        if ($prg) {
            return response()->json('success');
        }else{
            return response()->json('fail');
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
        //ກວດສອບ
        $check_cate = ProductCategory::where('pg_id', $id)->get();
        if (count($check_cate) == 0) {
            $delete = ProductGroup::find($id);
            $delete->delete();
            return response()->json('success');
        } else {
            return response()->json('fail');
        }
        
    }
}
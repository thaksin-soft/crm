<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductGroup;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pro_group = ProductGroup::all();
        $data = ProductCategory::join('crm_product_group', 'crm_product_group.id', '=', 'crm_product_category.pg_id')
        ->select('crm_product_category.*', 'crm_product_group.prg_name')
        ->orderBy('crm_product_category.id', 'ASC')
        ->get();
        return view('product-category.index', compact('data', 'pro_group'));
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
            $cate = new ProductCategory();
            $cate->pg_id = $request->pro_group;
            $cate->prc_name = $request->prc_name;
            $cate->note = $request->prc_note;
            $cate->code_fb = $request->group_fb_code;
            $cate->from_base = $request->from_base;
            $cate->save();
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
        $cate = ProductCategory::find($id);
        $cate->pg_id = $request->pro_group_edit;
        $cate->prc_name = $request->edit_prc_name;
        $cate->note = $request->edit_note;
        $cate->code_fb = $request->group_fb_code;
        $cate->from_base = $request->from_base;
        $cate->save();
        if ($cate) {
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
        $delete = ProductCategory::find($id);
        $delete->delete();
        return response()->json('success');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brands;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Brands::orderBy('id', 'ASC')->get();
        return view('brands.index', compact('data'));
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
            $brand = new Brands();
            $brand->code = $request->brand_code;
            $brand->brand_name = $request->brand_name;
            $brand->code_fb = $request->group_fb_code;
            $brand->from_base = $request->from_base;
            $brand->save();
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
        $brand = Brands::find($id);
        $brand->code = $request->edit_code;
        $brand->brand_name = $request->edit_brand_name;
        $brand->code_fb = $request->group_fb_code;
        $brand->from_base = $request->from_base;
        $brand->save();
        if ($brand) {
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
        $delete = Brands::find($id);
        $delete->delete();
        return response()->json('success');
    }
}
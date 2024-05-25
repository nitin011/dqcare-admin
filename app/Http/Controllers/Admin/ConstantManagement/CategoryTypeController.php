<?php

namespace App\Http\Controllers\Admin\ConstantManagement;

use App\Http\Controllers\Controller;
use App\Models\CategoryType;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
        try {
            $category_type = CategoryType::all();
            return view('backend.constant-management.category-type.index', compact('category_type'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view('backend.constant-management.category-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'allowed_level' => 'required',
            // 'remark' => 'required',
        ]);
        //
        try {
            $data = new CategoryType();
            $data->name=$request->name;
            $data->code=$request->code;
            $data->allowed_level=$request->allowed_level;
            $data->permission_id=$request->permission_id;
            $data->remark=$request->remark;
            $data->save();
            return redirect(route('panel.constant_management.category_type.index'))->with('success', 'Category Group created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryType  $categoryType
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryType $categoryType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryType  $categoryType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category_type = CategoryType::whereId($id)->first();
        return view('backend.constant-management.category-type.edit', compact('category_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryType  $categoryType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // return $request->all();
        try {
            $data = CategoryType::whereId($id)->first();
            $data->name=$request->name;
            $data->allowed_level=$request->allowed_level;
            $data->code=$request->code;
            $data->permission_id=$request->permission_id;
            $data->remark=$request->remark;
            $data->save();
            return redirect(route('panel.constant_management.category_type.index'))->with('success', 'Category Group update successfully.');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryType  $categoryType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chk = CategoryType::whereId($id)->delete();
        if ($chk) {
            Category::where('category_type_id',$id)->delete();
            return back()->with('success', 'Category Group Deleted Successfully!');
        }
    }
}

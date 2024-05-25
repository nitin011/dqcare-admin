<?php 
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App\Http\Controllers\Admin\ConstantManagement;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type_id,Request $request)
    {
        
        try {
            if($request->has('level')){
                $level = $request->get('level');
            }else{
                $level = 1;
            }
            $nextlevel = $level + 1;
            if($request->has('parent_id')){
                $category = fetchGetData('App\Models\Category',['category_type_id','level','parent_id'],[$type_id,$level,$request->get('parent_id')]);
            }else{
                $category = fetchGetData('App\Models\Category',['category_type_id','level'],[$type_id,$level]);
            }
            // $category = Category::all();
            return view('backend.constant-management.category.index', compact('category','level','nextlevel','type_id'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type_id,$level =1,$parent_id = null)
    {
        // $prev_level = $level - 1;
        
        return view('backend.constant-management.category.create',compact('type_id','level','parent_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'required',
            'level' => 'required',
            'category_type_id' => 'required',
        ]);
        //
        // return $request->all();
        try {
            $data = new Category();
            $data->name=$request->name;
            $data->level=$request->level;
            $data->category_type_id=$request->category_type_id;
            $data->parent_id=$request->parent_id;
            if ($request->hasFile('icon')) {
                $image = $request->file('icon');
                $path = storage_path('app/public/backend/category-icon');
                $imageName = 'category-icon' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->icon=$imageName;
            }
            $data->save();

            return redirect('panel/category/view/'.$request->category_type_id.'?level='.$request->level.'&parent_id='.$request->parent_id)->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::whereId($id)->first();
        $type_id = $category->category_type_id;
        $level = $category->level;
        $parent_id = $category->parent_id;
        return view('backend.constant-management.category.edit', compact('category','type_id','level','parent_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'level' => 'required',
            'category_type_id' => 'required',
        ]);
        // return $request->all();
        $data = Category::findOrFail($id);
        try {
            if ($request->hasFile('icon')) {
                if ($data->icon != null) {
                    unlinkfile(storage_path() . '/app/public/backend/category-icon', $data->icon);
                }
                $image = $request->file('icon');
                $path = storage_path('app/public/backend/category-icon');
                $imageName = 'category-icon' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->icon=$imageName;
            }            
            $data->name=$request->name;
            $data->level=$request->level;
            $data->category_type_id=$request->category_type_id;
            $data->parent_id=$request->parent_id;
            $data->save();
         
            return redirect(route('panel.constant_management.category.index',$request->category_type_id))->with('success', 'Category update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
            deleteSubCategory($id);
        $chk = Category::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Category Deleted Successfully!');
        }
    }
}

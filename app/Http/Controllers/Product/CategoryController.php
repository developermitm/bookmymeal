<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Role;
use App\Models\Permission; 
use App\Models\SubCategory;
use DB;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{   
    
    public function __construct(){
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function list()
    {  
        $categories = Category::paginate(10);
        return view('admin.category.list', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = Category::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;     
        
        $categoryImage = '';
        
        if ($files = $request->file('category_image')) {
           $categoryImage = $files->getClientOriginalExtension();
           $categoryImage = 'category_'.$lastId.'.'.$categoryImage; 
           $files->move(public_path().'/category/', $categoryImage);
        }

        $insert = Category::Create([
            'category_name' => $request->category_name,
            'description' => !empty($request->description) ? $request->description : '' ,
            'category_order' => !empty($request->orderNo) ? $request->orderNo : '',
            'category_image' => $categoryImage,
            'status' => !empty($request->status) ? $request->status : 0 ,
        ]);

        if($insert){
            return redirect('category-list')->with('message', 'Category details added successfully !');   
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
        $getDetails = Category::orderBy('category_name', 'asc')->where('id', $id)->first();
        return view('admin.category.edit', compact('getDetails'));
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
        $categoryImage = !empty($request->hiddenBanner) ? $request->hiddenBanner : '' ;
        
        if ($files = $request->file('category_image')) {
           $categoryImage = $files->getClientOriginalExtension();
           $categoryImage = 'category_'.$id.'.'.$categoryImage; 
           $files->move(public_path().'/category/', $categoryImage);
        }

        $updateArr = [
            'category_name' => $request->category_name,
            'description' => !empty($request->description) ? $request->description : '' ,
            'category_order' => !empty($request->orderNo) ? $request->orderNo : '',
            'category_image' => $categoryImage,
            'status' => !empty($request->status) ? $request->status : 0 ,
        ];

        $update = Category::find($id)->update($updateArr);

        if($update){
            return redirect()->route('category.edit', $id)->with('message', 'Category details updated successfully !');
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
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('message', 'Category deleted successfully!');
    }
}

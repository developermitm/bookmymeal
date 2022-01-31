<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAddon;
use Illuminate\Http\Request;
use App\Models\Category;
class ProductAddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getResults = ProductAddon::orderBy('id', 'desc')->get();
        return view('admin.addon.list', compact('getResults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::select('category_name', 'id')->orderBy('category_name', 'asc')->get();
        return view('admin.addon.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = ProductAddon::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;     
        $addonImage = '';
        
        if ($files = $request->file('addon_image')) {
           $addonImage = $files->getClientOriginalExtension();
           $addonImage = 'addon_'.$lastId.'.'.$addonImage; 
           $files->move(public_path().'/addon/', $addonImage);
        }

        $insert = ProductAddon::Create([
            'category_id' => $request->category,
            'name' => !empty($request->addon_name) ? $request->addon_name : '' ,
            'qty' => !empty($request->quantity) ? $request->quantity : '',
            'addon_image' => $addonImage,
            'status' => !empty($request->status) ? $request->status : 0 ,
            'price' => !empty($request->price) ? $request->price : 0 ,
            'addon_desc' =>!empty($request->description) ? $request->description : 0 ,
        ]);

        if($insert){
            return redirect('admin/addon')->with('message', 'Addon details added successfully !');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductAddon  $productAddon
     * @return \Illuminate\Http\Response
     */
    public function show(ProductAddon $productAddon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductAddon  $productAddon
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductAddon $productAddon, $id)
    {
        $getDetails = ProductAddon::find($id);
        $categories = Category::select('category_name', 'id')->orderBy('category_name', 'asc')->get();
        return view('admin.addon.edit', compact('categories', 'getDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductAddon  $productAddon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductAddon $productAddon, $id)
    {   
        $addonImage = !empty($request->hiddenAddonImage) ? $request->hiddenAddonImage : '' ;
        
        if ($files = $request->file('addon_image')) {
            $addonImage = $files->getClientOriginalExtension();
            $addonImage = 'addon_'.$lastId.'.'.$addonImage; 
            $files->move(public_path().'/addon/', $addonImage);
         }

        $updateArr = [
            'category_id' => $request->category,
            'name' => !empty($request->addon_name) ? $request->addon_name : '' ,
            'qty' => !empty($request->quantity) ? $request->quantity : '',
            'addon_image' => $addonImage,
            'status' => !empty($request->status) ? $request->status : 0 ,
            'price' => !empty($request->price) ? $request->price : 0 ,
            'addon_desc' =>!empty($request->description) ? $request->description : 0 ,
        ];

        $update = ProductAddon::find($id)->update($updateArr);

        if($update){
            return redirect()->route('addon.edit', $id)->with('message', 'Addon details updated successfully !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductAddon  $productAddon
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductAddon $productAddon, $id)
    {
        $addon = ProductAddon::findOrFail($id);
        $addon->delete();
        return redirect()->back()->with('message', 'Addon deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Role;
use App\Models\Products;
use App\Models\Permission;

class BannerController extends Controller
{   
    public function __construct(){
        $this->middleware(['auth']); 
        $this->middleware(function ($request, $next){
            if(auth()->user()->role != 1){
                if ($this->checkPermisstion() == false){
                  return redirect('user/dashboard');
                  exit();
                }else{ return $next($request); }
            }else{ return $next($request); }
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function checkPermisstion(){
        $userRole = auth()->user()->user_role;
        $getRoles = Role::find($userRole);
        $allpermisions =  json_decode($getRoles->permission);
        $sectionPer = Permission::where('name', 'LIKE', 'banner')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list()
    {
        $banners = Banner::paginate(10);
        return view('admin.banner.list',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $products = Products::select('id', 'title')->get();
        return view('admin.banner.add', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = Banner::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    

        $input = request()->validate([
            'product' => 'required|max:255',
            'fromTime' => 'required',
        ]);
        $userId = auth()->user()->id;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);
        
        $bannerImage = '';
        $productId = $request->product;
        if ($files = $request->file('bannerImage')) {
           $bannerImage = $files->getClientOriginalExtension();
           $bannerImage = 'banner_'.$lastId.'.'.$bannerImage; 
           $files->move(public_path().'/banner/', $bannerImage);
        }

        $insert = Banner::Create([
            'page' => $request->page,
            'place' => $request->place,
            'addedBy' => $addedby,
            'num' =>  $request->order_num,
            'image_ext' => $bannerImage,
            'status' => $request->status,
            'product_id' => $request->product,
            'from_time' => strtotime($request->fromTime),
        ]);
        
        if($insert){
            return redirect('banner-list')->with('message', 'Banner details added successfully!');
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
        $getDetails = Banner::find($id);
        $products = Products::select('id', 'title')->get();
        return view('admin.banner.edit', compact('getDetails', 'products'));
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

        $input = request()->validate([
            'product' => 'required|max:255',
            'fromTime' => 'required',
        ]);
        $userId = auth()->user()->id;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);

        $bannerImage = !empty($request->hiddenPic) ? $request->hiddenPic :  '';
        $productId = $request->product;
        if ($files = $request->file('bannerImage')) {
           $bannerImage = $files->getClientOriginalExtension();
           $bannerImage = 'banner_'.$id.'.'.$bannerImage; 
           $path = public_path('banner/'.$bannerImage); 
           if(file_exists($path)){ unlink($path); } 
           $files->move(public_path().'/banner/', $bannerImage);
        }
        
        $updateArr = [
            'page' => $request->page,
            'place' => $request->place,
            'addedBy' => $addedby,
            'num' =>  $request->order_num,
            'image_ext' => $bannerImage,
            'status' => $request->status,
            'product_id' => $request->product,
            'from_time' => strtotime($request->fromTime),
        ];

        $update = Banner::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Banner details updated successfully !');
            return redirect()->route('banner.edit', $id);
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
        $offer = Banner::findOrFail($id);
        $offer->delete();
        return redirect()->back()->with('message', 'Banner deleted successfully!');
    }
}

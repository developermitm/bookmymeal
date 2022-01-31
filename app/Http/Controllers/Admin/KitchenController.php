<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kitchen;
use Validator;
use Session;
class KitchenController extends Controller
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
        $kitchens = Kitchen::orderBy('id', 'desc')->paginate(10);
        return view('admin.kitchen.list',compact('kitchens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kitchen.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = Kitchen::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    

        $input = $request->validate([
            'owner_name' => 'required',
            'kitchen_name' => 'required|unique:kitchen',
            'mobile_num' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:12',
        ]);

        $kitchen_image = '';
      
        if ($files = $request->file('kitchen_image')) {
           $kitchen_image = $files->getClientOriginalExtension();
           $kitchen_image = 'kitchen_'.$lastId.'.'.$kitchen_image; 
           $files->move(public_path().'/kitchen/', $kitchen_image);
        }

        $insert = Kitchen::Create([
            'owner_name' => $request->owner_name,
            'kitchen_name' => $request->kitchen_name,
            'address' => $request->address,
            'image' => $kitchen_image,
            'status' => $request->status,
            'lat' => $request->lat,
            'lang'=>$request->lang,
            'mobile_num' => $request->mobile_num
        ]);
        
        if($insert){
            return redirect('kitchen-list')->with('message', 'Kitchen details added successfully!');
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
        $getDetails = Kitchen::find($id);
        return view('admin.kitchen.edit', compact('getDetails'));
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
            'owner_name' => 'required',
            "kitchen_name" => 'required|unique:kitchen,kitchen_name,'.$id,
            'mobile_num' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:12',
        ]);

        $kitchen_image = !empty($request->hiddenPic) ? $request->hiddenPic :  '';
        $productId = $request->product;
        if ($files = $request->file('kitchen_image')) {
           $kitchen_image = $files->getClientOriginalExtension();
           $kitchen_image = 'kitchen_'.$id.'.'.$kitchen_image; 
           $path = public_path('kitchen/'.$kitchen_image); 
           if(file_exists($path)){ unlink($path); } 
           $files->move(public_path().'/kitchen/', $kitchen_image);
        }

        $updateArr = [
            'owner_name' => $request->owner_name,
            'kitchen_name' => $request->kitchen_name,
            'address' => $request->address,
            'image' => $kitchen_image,
            'status' => $request->status,
            'lat' => $request->lat,
            'lang'=>$request->lang,
            'mobile_num' => $request->mobile_num
        ];

        $update = Kitchen::find($id)->update($updateArr);
    
        if($update){
            return redirect()->route('kitchens.edit', $id)->with('message', 'Kitchen details updated successfully');
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
        $appuser = Kitchen::findOrFail($id);
        $appuser->delete();
        return redirect()->back()->with('message', 'Kitchen deleted successfully!');
    }
}

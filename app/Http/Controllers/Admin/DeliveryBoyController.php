<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryUser;
use App\Models\DeliveryUserDoc;
use Session;
class DeliveryBoyController extends Controller
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
        $users = DeliveryUser::orderBy('id', 'desc')->paginate(10);
        return view('admin.deliveryBoy.list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.deliveryBoy.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = DeliveryUser::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    

        $input = request()->validate([
            'name' => 'required',
            'mobile_no' => 'required|min:10|max:10|unique:delivery_user',
        ]);

        $deliveryBoyImage = '';
      
        if ($files = $request->file('deliveryBoyImage')) {
           $deliveryBoyImage = $files->getClientOriginalExtension();
           $deliveryBoyImage = 'deliveryBoy_'.$lastId.'.'.$deliveryBoyImage; 
           $files->move(public_path().'/deliveryBoy/image/', $deliveryBoyImage);
        }

        $imageArr = [];
        if ($request->hasFile('documents')) {
            $image = $request->file('documents');
            $i = 0;
            foreach ($image as $files) {
                $i++;  
                $destinationPath = public_path('/deliveryBoy/doc');
                $file_name = $lastId.'_'.$i.'.'.$files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name);
                $imageArr[] = $file_name;
            }
          }

        $identity = rand(1111111111,9999999999); 
        $insert = DeliveryUser::Create([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'image' => $deliveryBoyImage,
            'date_of_joining' => $request->date_of_joining,
            'lat' => $request->lat,
            'lang'=>$request->lang,
            'identity_number' => $request->identity_number,
            'status' => $request->status,
            'identity_number' =>$identity,
        ]);

        $insertId = $insert->id;
        
        if(isset($imageArr) && !empty($imageArr)){
            foreach ($imageArr as $row) {
                $insert = DeliveryUserDoc::Create([
                    'delivery_user_id' => $insertId,
                    'document' => $row
                ]);
            }
        }

        
        if($insert){
            return redirect('delivery-boy-list')->with('message', 'Delivery Boy details added successfully!');
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
        $docs = DeliveryUserDoc::where(['delivery_user_id' => $id])->get();
        $getDetails = DeliveryUser::find($id);
        return view('admin.deliveryBoy.edit', compact('getDetails', 'docs'));
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
        $getDetails = DeliveryUser::find($id);
        $input = request()->validate([
            'name' => 'required',
            'mobile_no' => 'required|min:10|max:10|unique:delivery_user,mobile_no,'.$getDetails->id,
        ]);

        $deliveryBoyImage = !empty($request->hiddenPic) ? $request->hiddenPic :  '';
        $productId = $request->product;
        if ($files = $request->file('deliveryBoyImage')) {
           $deliveryBoyImage = $files->getClientOriginalExtension();
           $deliveryBoyImage = 'deliveryBoy_'.$id.'.'.$deliveryBoyImage; 
           $path = public_path('deliveryBoy/image/'.$deliveryBoyImage); 
           if(file_exists($path)){ unlink($path); } 
           $files->move(public_path().'/deliveryBoy/image/', $deliveryBoyImage);
        }

        $imageArr = [];
        if ($request->hasFile('documents')) {
            $image = $request->file('documents');
            $i = 0;
            foreach ($image as $files) {
                $i++;  
                $destinationPath = public_path('/deliveryBoy/doc');
                $file_name = $id.'_'.$i.'.'.$files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name);
                $imageArr[] = $file_name;
            }
        }

        
        $updateArr = [
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'image' => $deliveryBoyImage,
            'date_of_joining' => $request->date_of_joining,
            'lat' => $request->lat,
            'lang'=>$request->lang,
            'identity_number' => $request->identity_number,
            'status' => $request->status,
        ];

        $update = DeliveryUser::find($id)->update($updateArr);

        if(isset($imageArr) && !empty($imageArr)){
            foreach ($imageArr as $row) {
                $insert = DeliveryUserDoc::Create([
                    'delivery_user_id' => $id,
                    'document' => $row
                ]);
            }
        }
        
        if($update){
            return redirect()->route('delivery-boy.edit', $id)->with('message', 'Delivery Boy details updated successfully');
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
        $appuser = DeliveryUser::findOrFail($id);
        $appuser->delete();
        return redirect()->back()->with('message', 'Delivery User deleted successfully!');
    }

    public function deleteDeliveryBoyDoc(Request $request){
        $id = $request->id;
        $doc = $request->doc;
        $delete = DeliveryUserDoc::findOrFail($id);
        $delete->delete();
        $path = public_path('deliveryBoy/doc/'.$doc); 
        if(file_exists($path)){ unlink($path); } 
        return json_encode(['status' => 'success', 'msg' => "Deleted successfully !"]);
    }
}

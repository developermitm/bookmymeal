<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Shipping;

use Session;
class ShippingController extends Controller
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
        $shippings = Shipping::orderBy('id', 'desc')->paginate(10);
        return view('admin.setting.shipping.list',compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.shipping.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = request()->validate([
            'minimum_order_amount' => 'required',
            'shipping_amount'=> 'required|lt:minimum_order_amount',
        ]);

        $latestData = Shipping::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    

        $insert = Shipping::Create([
            'min_amount' => $request->minimum_order_amount,
            'shipping_cost' => $request->shipping_amount,
            'status' => $request->status,
        ]);
        
        if($insert){
            return redirect('shipping-list')->with('message', 'Shipping Cost details added successfully!');
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
        $getDetails = Shipping::select('id', 'min_amount', 'shipping_cost', 'status')->first();
        return view('admin.setting.shipping.edit', compact('getDetails'));
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
            'minimum_order_amount' => 'required',
            'shipping_amount'=> 'required|lt:minimum_order_amount',
        ]);
        
        $updateArr = [
            'min_amount' => $request->minimum_order_amount,
            'shipping_cost' => $request->shipping_amount,
            'status' => $request->status,
        ];

        $update = Shipping::find($id)->update($updateArr);
        
        if($update){
            return redirect()->route('shipping.edit', $id)->with('message', 'Shipping Cost details updated successfully');
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
        $shipping = Shipping::findOrFail($id);
        $shipping->delete();
        return redirect()->back()->with('message', 'Shipping deleted successfully!');
    }
}

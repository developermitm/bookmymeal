<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Role;
use App\Models\Permission;
use App\Services\NotificationService;
use App\Models\Products;
class CouponController extends Controller
{   
    public $notification = null; 
    public function __construct(NotificationService $notification ){
        $this->notification = $notification;
        $this->middleware(['auth']); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        $coupons = Coupon::orderBy('id', 'desc')->paginate(10);
        return view('admin.coupon.list',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Products::select('id', 'title')->orderBy('title', 'asc')->get();
        return view('admin.coupon.add', compact('products'));
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
            'offer_title' => 'required|max:255',
            'validity' => 'required',
            'offer_code' => 'required',
        ]);
        $userId = auth()->user()->id;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);

        $insert = Coupon::Create([
            'title' => $request->offer_title,
            'spec' => $request->description,
            'added_by' => $addedby,
            // 'product_id' => $request->product,
            'till' => date('Y-m-d', strtotime($request->validity)),
            'code' => $request->offer_code,
            'status' => $request->status,
            'amount' => $request->amount

        ]);
      
        if($insert){
            return redirect('coupon-list')->with('message', 'Coupon details added successfully!');
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
        $getDetails = Coupon::find($id);
        $products = Products::select('id', 'title')->orderBy('title', 'asc')->get();
        return view('admin.coupon.edit', compact('getDetails', 'products'));
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
            'offer_title' => 'required|max:255',
            'validity' => 'required',
            'offer_code' => 'required',
        ]);
        $userId = auth()->user()->id;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);

        $updateArr = [
            'title' => $request->offer_title,
            'spec' => $request->description,
            'added_by' => $addedby,
            // 'product_id' => $request->product,
            'till' => date('Y-m-d', strtotime($request->validity)),
            'code' => $request->offer_code,
            'status' => $request->status,
            'amount' => $request->amount

        ];

        $update = Coupon::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Coupon details updated successfully !');
            return redirect()->route('coupon.edit', $id);
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
        $offer = Coupon::findOrFail($id);
        $offer->delete();
        return redirect()->back()->with('message', 'Coupon deleted successfully!');
    }
}

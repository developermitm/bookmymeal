<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Schedule;
use Session;
class OrderScheduleController extends Controller
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
        $orderSchedule = Schedule::orderBy('id','desc')->paginate(10);
        return view('admin.setting.schedule.list',compact('orderSchedule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.schedule.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $latestData = Schedule::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    

        $input = request()->validate([
            'order_from_time' => 'required',
            'order_to_time' => 'required',
        ]);
       
        $insert = Schedule::Create([
            'from_time' => $request->order_from_time,
            'to_time' => $request->order_to_time,
            'status' => $request->status,
        ]);
        
        if($insert){
            return redirect('order-schedule-list')->with('message', 'Schedule details added successfully!');
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
        $getDetails = Schedule::find($id);
        return view('admin.setting.schedule.edit', compact('getDetails'));
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
            'order_from_time' => 'required',
            'order_to_time' => 'required',
        ]);
        
        $updateArr = [
            'from_time' => $request->order_from_time,
            'to_time' => $request->order_to_time,
            'status' => $request->status,
        ];

        $update = Schedule::find($id)->update($updateArr);
        
        if($update){
            return redirect()->route('order-schedule.edit', $id)->with('message', 'Schedule details updated successfully');
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
        $shipping = Schedule::findOrFail($id);
        $shipping->delete();
        return redirect()->back()->with('message', 'Schedule deleted successfully!');
    }
}

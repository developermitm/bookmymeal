<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceLocation;

use Session;
class ServiceLocationController extends Controller
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
        $location = ServiceLocation::orderBy('id','desc')->paginate(10);
        return view('admin.setting.service-location.list',compact('location'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.service-location.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = ServiceLocation::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    
      
        $input = request()->validate([
            'address' => 'required',
        ]);
       
        $insert = ServiceLocation::Create([
            'location' => $request->address,
            'lat' => $request->lat,
            'lang'=>$request->lang,
            'status' => $request->status,
        ]);
        
        if($insert){
            return redirect('service-location-list')->with('message', 'Service Location details added successfully!');
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
        $getDetails = ServiceLocation::find($id);
        return view('admin.setting.service-location.edit', compact('getDetails'));
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
            'address' => 'required',
        ]);
        
        $updateArr = [
            'location' => $request->address,
            'lat' => $request->lat,
            'lang'=>$request->lang,
            'status' => $request->status,
        ];

        $update = ServiceLocation::find($id)->update($updateArr);
        
        if($update){
            return redirect()->route('service-location.edit', $id)->with('message', 'Service Location details updated successfully');
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
        $appuser = ServiceLocation::findOrFail($id);
        $appuser->delete();
        return redirect()->back()->with('message', 'Service Location deleted successfully!');
    }
}

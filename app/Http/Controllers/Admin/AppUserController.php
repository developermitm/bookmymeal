<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Permission;
use Session;
class AppUserController extends Controller
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
        $sectionPer = Permission::where('name', 'LIKE', 'user')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list()
    {
       $users = Customer:: orderBy('id', 'desc')->paginate(10);
        return view('admin.appuser.list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $result = Customer::find($id);
        return view('admin.appuser.edit', compact('result'));
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
    
        $getDetails = Customer::find($id);
        $input = request()->validate([
            'username' => 'required',
            'mobile_no' => 'required|min:10|max:10|unique:user,mobile_no,'.$getDetails->id,
        ]);

        $updateArr = [
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'status' => $request->status,
        ];
        

        $update = Customer::find($id)->update($updateArr);
        if($update){
            return redirect()->route('appuser.edit', $id)->with('message', 'App User details updated successfully');
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
        $appuser = Customer::findOrFail($id);
        $appuser->delete();
        return redirect()->back()->with('message', 'User deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offers;
use App\Models\Role;
use App\Models\Permission;
use App\Services\NotificationService;
use App\Models\Products;
class OffersController extends Controller
{   
    public $notification = null; 
    public function __construct(NotificationService $notification ){
        $this->notification = $notification;
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
        $sectionPer = Permission::where('name', 'LIKE', 'coupon')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list()
    {
        $offers = Offers::paginate(10);
        return view('admin.offers.list',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Products::select('id', 'title')->orderBy('title', 'asc')->get();
        return view('admin.offers.add', compact('products'));
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

        $insert = Offers::Create([
            'title' => $request->offer_title,
            'spec' => $request->description,
            'added_by' => $addedby,
            // 'product_id' => $request->product,
            'till' => date('Y-m-d', strtotime($request->validity)),
            'code' => $request->offer_code,
            'status' => $request->status,

        ]);
        $heading = '<strong>New Product Offer On. <br></strong>';
        $title = '<a>'.$heading.$request->offer_title.'</a>';
        $desc = '<strong>Offer Code : </strong>'.$request->offer_code.' and <strong>OfferValid till </strong>'.$request->validity.'Offer description : '.$request->description;
        $getDetails = Products::select('main_image')->find($request->product);
        $imgUrl = '';
        $this->notification->sendPushNotification($title, $request->description, $imgUrl);
        
        if($insert){
            return redirect('offer-list')->with('message', 'Offers details added successfully!');
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
        $getDetails = Offers::find($id);
        $products = Products::select('id', 'title')->orderBy('title', 'asc')->get();
        return view('admin.offers.edit', compact('getDetails', 'products'));
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

        ];

        $update = Offers::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Offers details updated successfully !');
            return redirect()->route('offer.edit', $id);
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
        $offer = Offers::findOrFail($id);
        $offer->delete();
        return redirect()->back()->with('message', 'Offers deleted successfully!');
    }
}

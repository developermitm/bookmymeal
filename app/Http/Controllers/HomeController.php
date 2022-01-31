<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'email_available','forgotPassword','demo','submit_password']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userRole = auth()->user()->role;
        if($userRole == 1){
             return redirect('admin/dashboard');
        }elseif ($userRole == 2) {
            return redirect('user/dashboard');
        }
    }


}

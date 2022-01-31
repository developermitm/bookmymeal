<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Products;
use App\Models\Order;
use App\Models\Books;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Session;
use Mail;

class UserController extends Controller
{
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $productCount = Products::count();
        $usersCount = User::where(['role' => 2])->count();
        $categoryCount = Category::count();
        $orderCount = Order::where('delivary_datetime', '!=', NULL)->count();
        $pendingorderCount = Order::where('delivary_datetime', '=', NULL)->count();
        $currentYear = date('Y');
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : $currentYear ;
        
        $saleArr = [];
        for($i = 1; $i <= 12; $i++) {
            $from = strtotime($year.'-'.$i.'-01');
            $to =  date('Y-m-t', $from);
            $to = strtotime($to);
            $sql = "SELECT sum(grand_total) as totalSale From sale where sale_datetime BETWEEN $from and $to ";
            $resCount = DB::select($sql);
            $saleArr[] = (isset($resCount[0]->totalSale) && !empty($resCount[0]->totalSale)) ? number_format( str_replace(',',' ', $resCount[0]->totalSale), 2,'.', '')  : '0';
        }
        $totalSale = !empty($saleArr) ? array_sum($saleArr) : 0; 
        $saleArr = implode(',', $saleArr);
        return view('user.dashboard', compact('saleArr','productCount', 'usersCount', 'categoryCount', 'orderCount', 'totalSale', 'pendingorderCount'));
    }


}

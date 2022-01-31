<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Offers;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Wishlist;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\Advertisement;
use App\Models\AdsCategory;
use DB;
use Session;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class ProductController extends Controller
{
    public $successStatus = 200;
    
    public function createOrder(Request $request){
        $api_key = env('RAZORPAY_API_KEY');
        $api_secret = env('RAZORPAY_API_SECRET');
        $api = new Api($api_key, $api_secret);

        $receipt = rand();
        $amount = $request->amount;
        $date = date('Y-m-d');
        $offers = Offers::select('title', 'spec', 'till as valid_date','code as offer_id', )->where('status', '=', 1)->where('till', '>=', $date)->get();
        $offersArr = [];
        if(isset($offers) && !empty($offers)){
            foreach($offers as $row){
                $offersArr[] = $row->offer_id;
            }
            $array = array('receipt' => $receipt, 'amount' => $amount,'currency' => 'INR', 'offers' => $offersArr);
            $order  = $api->order->create($array);
            
        }else{
             $order  = $api->order->create(array('receipt' => $receipt, 'amount' => $amount, 'currency' => 'INR'));   
        }
     

        $orderId = $order['id'];
        $data['orderId'] = $order['id']; // Get the created Order ID
        return response()->json(['success' => $data], $this->successStatus);
    }

    public function verifyOrder(Request $request){
        $jsonData = $request->json()->all();
        $orderData = !empty($jsonData['order_details']) ? $jsonData['order_details'] : array();
        $api_key = env('RAZORPAY_API_KEY');
        $api_secret = env('RAZORPAY_API_SECRET');
        $signature = $jsonData['razorpay_signature'];
        $paymentId = $jsonData['razorpay_payment_id'];
        $orderId = $jsonData['razorpay_order_id'];
        $addressId = $jsonData['address_id'];
        $api = new Api($api_key, $api_secret);
     
        $success = false;
            try{
                $attributes = array(
                    'razorpay_order_id' => $orderId,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature
                );

                $api->utility->verifyPaymentSignature($attributes);
                $success = true;
            }catch(SignatureVerificationError $e){
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }

            if ($success === true){
                
                $paymentDetails = $api->payment->fetch($paymentId);
                $detailsArr = ['id'=> $paymentDetails->id, 'entity' => $paymentDetails->entity,'amount' => $paymentDetails->amount,'currency' => $paymentDetails->currency,'status' => $paymentDetails->status,'order_id' => $paymentDetails->order_id,'invoice_id' => $paymentDetails->invoice_id,'international' => $paymentDetails->international,'method' => $paymentDetails->method,'amount_refunded' => $paymentDetails->amount_refunded,'refund_status' => $paymentDetails->refund_status,'captured' => $paymentDetails->captured, 'description'=> $paymentDetails->description,'card_id'=> $paymentDetails->card_id,'bank'=> $paymentDetails->bank,'wallet'=> $paymentDetails->wallet,'vpa'=> $paymentDetails->vpa,'email'=> $paymentDetails->email,'contact'=> $paymentDetails->contact,'fee' => $paymentDetails->fee,'tax' => $paymentDetails->tax,'created_at' => $paymentDetails->created_at ];

                if(isset($orderData) && !empty($orderData)){
                    $userId = Auth::user()->id;
                    $delete = CartItem::where('user_id', $userId)->delete();
                    $address = Address::where(['user_id' => $userId, 'id' =>$addressId])->orderBy('id', 'asc')->first();
                    $name = !empty($address->name) ? $address->name : ''; 
                    $last_name = !empty(Auth::user()->surname) ? Auth::user()->surname : '' ;
                    $email = !empty(Auth::user()->email) ? Auth::user()->email :'';     
                    $address1 = !empty($address->address1) ? $address->address1 : '' ;
                    $address2 = !empty($address->address2) ? $address->address2 : '' ;
                    $zip =  !empty($address->zip) ? $address->zip : '';
                    $phone = !empty($address->mobile) ? $address->mobile : '' ;
                    $addressArr = ['firstname' => $first_name, 'lastname' => $last_name, 'address1' => $address1, 'address2' => $address2, 'zip' => $zip, 'email' => $email, 'phone' => $phone];
                    $latestData = Order::latest('id', 'desc')->select('id')->first();
                    $i = 0;
                    foreach($orderData as $row){
                    
                        $i++;
                        $lastId = ($latestData->id + $i); 
                        $saleId = date('Y').date('m').$lastId;
                        $productId = $row['product_id'];
                        $res = Products::find($productId);
                        $paymentStatusArr = ['admin' => '','status' => 'placed'];
                        $qty = !empty($row['qty']) ? $row['qty'] : '';
                       
                        $stock = ($res->current_stock - $qty);
                        $updateArr = ['current_stock' => $stock];
                        $update = Products::where('id',$productId)->update($updateArr);
                       
                        $color = !empty($row['color']) ? $row['color'] : '' ;
                        $size = !empty($row['size']) ? $row['size'] : '' ;
                        $url = env('APP_URL').'/public/products/thumbnail/';
                        $totalAmount = !empty($row['total_amount']) ? $row['total_amount'] : '00';
                        $colorArr = ['title' => 'Color', 'value' => $color];
                        $sizeArr = ['title' => 'size', 'value' => $size];
                        $option['color'] = $colorArr;
                        $option['size'] = $sizeArr;
                        $image = $url.$res->main_image;
                        $optionArr = !empty(json_encode($option)) ? json_encode($option) : '' ;
                        $productDetails[$paymentId] = ['id' => $res->id, 'option' => $optionArr,'qty' => $qty, 'price' => $res->sale_price, 'name' => $res->title, 'shipping' => $res->shipping_cost, 'tax' => $res->tax, 'image' => $image, 'coupon' => '', 'subtotal' => $totalAmount];
                        $paymentStatus = json_encode(array($paymentStatusArr));
                        $insertArr = [
                            'sale_code' => $saleId,
                            'buyer' => $userId,
                            'vat' =>'',
                            'vat_percent' => '',
                            'payment_status' => $paymentStatus,
                            'payment_type' => 'online_payment',
                            'product_details' => json_encode($productDetails),
                            'shipping_address' => !empty($addressArr) ? json_encode($addressArr) : '',
                            'shipping' => $res->shipping_cost,
                            'payment_timestamp' => time(),
                            'grand_total'=> !empty($row['total_amount']) ? $row['total_amount'] : '00',
                            'sale_datetime' => time(),
                            'orderId' => $orderId,
                            'paymentId' => $paymentId,
                            'payment_details' => json_encode($detailsArr)
                        ];

                        $insert = Order::Create($insertArr);

                        if($insert){
                            $data['msg'] = "Payment success/ Signature Verified";
                        }
                    }
                }
            }
            else{ $data['msg'] = "<p>Your payment failed</p><p>{$error}</p>"; }
        return response()->json(['success' => $data], $this->successStatus);
    }
  
    public function index()
    {   
       
        $orderBy = 'desc';
      
        $offset = !empty($_GET['offset']) ? $_GET['offset'] : 0 ;
        $limit = !empty($_GET['limit']) ? $_GET['limit'] : 20 ;

        $where = [];

        $where[] = ['product.category', '!=', ''];

        $categoryId = !empty($_GET['categoryId']) ? $_GET['categoryId'] : '' ;
        $subcat_id = !empty($_GET['subcat_id']) ? $_GET['subcat_id'] : '' ;

        $brand = !empty($_GET['brand']) ? $_GET['brand'] : '' ;

        if(isset($categoryId) && !empty($categoryId)){
            $where[] = ['product.category', '=', $categoryId];            
        }

        if(isset($subcat_id) && !empty($subcat_id)){
            $where[] = ['product.sub_category', '=', $subcat_id];            
        }

        if(isset($brand) && !empty($brand)){
            $where[] = ['product.brand', '=', $brand];            
        }
      
        $products = Products::select('product.id','product.title','product.sale_price','product.current_stock','product.purchase_price','product.main_image as thumbnail')->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where($where)->
        groupBy('product.id')->
        orderBy('product.id', $orderBy)->skip(($offset - 0) * $limit)->take($limit)->get();
        $categories = Category::select('id', 'category_name', 'banner as thumbnail')->get();

        $success['products'] = $products; 
        $success['categories'] =  $categories;
        return response()->json(['success' => $success], $this->successStatus);
    }

        public function getProductDetails($id, $guest){
        $userId = $guest;
        $date = date('Y-m-d');
        $offers = Offers::select('title', 'spec', 'till as valid_date','code as offer_id', )->where('status', '=', 1)->where('till', '>=', $date)->get();
        
        $products = Products::select('product.id','stock.size','stock.quantity','stock.color as productColor','stock.size','stock.quantity','product.title','product.sale_price','product.current_stock','product.discount','product.discount_type','product.color','product.additional_fields','product.options','product.purchase_price','product.shipping_cost',DB::raw('group_concat(product_Image.image) as thumbnail'))->
            leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
            leftJoin('stock', 'product.id', '=', 'stock.product_id')->
            where('product.id', '=', $id)->first();
            
            $Key = $id;
            $valu = \Session::get('ID');
           
            if ($Key != $valu){
              $insert = \DB::table('product')
               ->where('id', $id)
               ->increment('number_of_view', 1);
               Session::put('ID',$id);
           }

        $where = [];
        $where2 = [];
    
        if($userId != 'guest'){
            $where[] = [['cart.product_id' => $id, 'cart.user_id' => $userId]]; 
            $where2[] = [['wishlist.product_id' => $id, 'wishlist.user_id' => $userId]];
        }
        $colorvar =  !empty($products->productColor) ? $products->productColor : '';
        $sizevar = !empty($products->size) ? $products->size : '' ;

        $subtitle = substr($products->title, 0, 8);
        $size = [];
        $colorArr = [];
        $quantityArr = [];
        $price = [];
        $discountArr = [];
        $salePriceArr = [];
        $sizeVariants = Products::select('product.id','product.title','product.current_stock','product.discount','product.sale_price','stock.color','stock.size','stock.quantity')->
            leftJoin('stock', 'product.id', '=', 'stock.product_id')->
            where(['stock.color'=>$colorvar])->
            where('product.id', '!=', $products->id)->
            orwhere('product.title', 'LIKE', '%'.$subtitle.'%')->
            get();
  

        $colorVariants = Products::select('product.id','product.title','product.current_stock','product.discount','product.sale_price','stock.color','stock.size','stock.quantity')->leftJoin('stock', 'product.id', '=', 'stock.product_id')->
           /* where(['size'=>$sizevar])->*/
            orwhere('product.title', 'LIKE', '%'.$subtitle.'%')->
            where('product.id', '!=', $products->id)->
            get();

            if(isset($sizeVariants) && count($sizeVariants) > 0){
                foreach($sizeVariants as $variant){   
                     
                        if($variant->id != $products->id){
                            $stock = ($variant->current_stock > 0) ? $variant->current_stock : 0;
                            $size[] = array('id' => $variant->id, 'size' => $variant->size, 'title' =>$variant->title,'sale_price'=>$variant->sale_price, 'discount'=>$variant->discount, 'color'=>$variant->color ,'stock'=>$stock);
                        }
                }
            }

        
        $getCartItems = CartItem::where($where)->count();
        $getWishItems = Wishlist::where($where2)->count();
        $additional =  !empty($products->additional_fields) ? json_decode($products->additional_fields) : array();
        $addName = !empty($additional) ? $additional->name : '';
        $addValue = !empty($additional) ? $additional->value[0] : array();
        $additionalArr = array(['name' => $addName, 'value' => $addValue]);
        $additionalArr = !empty($additionalArr) ? ($additionalArr) : [];
      

        $productArr = [
                'id' => $products->id, 
                'title' => $products->title,
                'sale_price' => $products->sale_price,
                'current_stock' => $products->current_stock,
                'discount' => $products->discount,
                'discount_type' => $products->discount_type,
                'color' => !empty($products->productColor) ? ($products->productColor) : '',
                'size' => !empty($products->size) ? $products->size : '',
               'purchase_price' => $products->purchase_price,
               'shipping_cost' => $products->shipping_cost,
               'thumbnail' => $products->thumbnail,
               /* 'additional_fields' => json_decode($products->additional_fields) ,*/
               'additional_fields' => $additionalArr ,
               'hasInCart' => ($getCartItems != 0) ? true : false,
               'hasInWishlist' => ($getWishItems != 0) ? true : false,
               // 'feature' => !empty($products->getProductFeature) ? ($products->getProductFeature) : [] ,
               'extrafeature' => !empty($products->extraFeatures) ? ($products->extraFeatures) : [] ,
               'relatedProduct' => $size,
               'offers' => $offers
            ];

        $success['products'] = $productArr; 
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function categoryListing(){
        $categories = Category::select('id', 'category_name','banner as thumbnail')->get();

        $categoriesArr = [];
        foreach ($categories as $row) {
            $categoriesArr[] = $row;
            if(!empty($row->getSubCategory->get_sub_category)){
                $categoriesArr[] = $row->getSubCategory->get_sub_category ;
            }
           
        }
           
        $categories =  $categoriesArr;
        return response()->json(['categories' => $categories], $this->successStatus);
    }

    public function addToCart(Request $request){
        $userId = Auth::user()->id;
       
        $insert = CartItem::Create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        if($insert){
          return response()->json(['success'=>' Item added successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 

    }

    public function removeCartItem($id){
        
        $delete = CartItem::find($id)->delete();
        
        if($delete){
          return response()->json(['success'=>' Item removed successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
    }

    public function cartListing(){
        $userId = Auth::user()->id;
        $getCartItems['cartItems'] = CartItem::select('cart.id','product.id as productId','product.title','product.sale_price','product.current_stock','product.purchase_price','cart.qty','product.shipping_cost','product.main_image as thumbnail')->
        leftJoin('product_Image', 'cart.product_id', '=', 'product_Image.product_id')->
        leftJoin('product', 'cart.product_id', '=', 'product.id')->
        where('cart.user_id', $userId)->
        groupBy('cart.product_id')->get();
        return response()->json(['success' => $getCartItems], $this->successStatus);
       
    }

    public function wishListing(){
        $userId = Auth::user()->id;
        $getCartItems['wishListItems'] = Wishlist::select('wishlist.id','product.id as productId','product.title','product.sale_price','product.current_stock','product.purchase_price','product.main_image as thumbnail')->
        leftJoin('product_Image', 'wishlist.product_id', '=', 'product_Image.product_id')->
        leftJoin('product', 'wishlist.product_id', '=', 'product.id')->
        where('wishlist.user_id', $userId)->
        groupBy('wishlist.product_id')->get();
        return response()->json(['success' => $getCartItems], $this->successStatus);
    }

    public function addToWishlist(Request $request){
        $userId = Auth::user()->id;
       
        $insert = Wishlist::Create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
        ]);

        if($insert){
          return response()->json(['success'=>' Item added in wishlist successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
    }

    public function removeWishItem($id){
        
        $delete = Wishlist::find($id)->delete();
        
        if($delete){
          return response()->json(['success'=>' Item removed successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
    }  

    public function advertisementListing(){
        $advtListing['advtListing'] = Advertisement::select('advertisement.product_id','product.title' ,'advertisement.image', 'advertisement.status', 'advertisement.price')
        ->leftJoin('product', 'advertisement.product_id', '=', 'product.id')->
        orderBy('advertisement.id', 'desc')->get();
        return response()->json(['success' => $advtListing], $this->successStatus);
    }
    public function offerslisting(){
        $date = date('d-m-Y');
        $offers['offers'] = Offers::where('till', '>=', $date)->orderBy('id', 'desc')->get();
        return response()->json(['success' => $offers], $this->successStatus);
    }

    public function popularProducts(){
        $products['popularProducts'] = Products::select('product.id','product.title','brand.name as brand' , 'category.category_name', 'sub_category.sub_category_name','product.sale_price','product.current_stock','product.discount','product.purchase_price','product.shipping_cost','product.main_image as thumbnail', 'product.number_of_view')->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where('product.number_of_view', '>', 20)->
        groupBy('product.id')->
        orderBy('product.number_of_view', 'desc')->
        get();
        return response()->json(['success' => $products], $this->successStatus);
    } 

    public function brandsListing(){
        $brands['brands'] = Brand::all();
        return response()->json(['success' => $brands], $this->successStatus);
    }  

    public function latestProduct(){
        $products['latestProducts'] = Products::select('product.id','product.title','brand.name as brand' , 'category.category_name', 'sub_category.sub_category_name','product.sale_price','product.current_stock','product.discount','product.purchase_price','product.shipping_cost','product.main_image as thumbnail')->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        groupBy('product.id')->
        orderBy('product.id', 'desc')->take(10)->get();
        return response()->json(['success' => $products], $this->successStatus);
    
    } 

   public function bannerList(){
        $where = [];
        $fromTime = date('d-m-Y') ;
        $fromTimestamp = strtotime($fromTime);
        $toTime = strtotime($fromTime);
        $products['bannerList'] = Banner::select('banner.page', 'banner.place', 'banner.num', 'banner.image_ext', 'product.title')->
        leftJoin('product', 'banner.product_id', '=', 'product.id')->
        whereBetween('from_time', [$fromTimestamp, $toTime])->orderBy('product.id', 'desc')->get();
        // orderBy('product.id', 'desc')->take(4)->get();
        return response()->json(['success' => $products], $this->successStatus);
    }

    public function orderDetails($orderId){
        $dataArr = [];
        $userId = Auth::user()->id;
        $getOrder = Order::where(['id' => $orderId, 'buyer' => $userId ])->first();
        if(isset($getOrder) && !empty($getOrder)){
            $productData = !empty($getOrder->product_details) ? json_decode($getOrder->product_details) : array();
            foreach($productData as $row){
                $dataArr['product'] = $row;
                $dataArr['option']  = !empty($row->option) ? json_decode($row->option) : array();
            }
            $dataArr['address'] = !empty($getOrder->shipping_address) ? json_decode($getOrder->shipping_address) : array();
            $dataArr['payment_status'] = !empty($getOrder->payment_status) ? json_decode($getOrder->payment_status) : array() ;
            $dataArr['delivery_status'] = !empty($getOrder->delivery_status) ? json_decode($getOrder->delivery_status) : array();
            return response()->json(['success' => $dataArr], $this->successStatus);
        }else{
            return response()->json(['success' => 'No records found !'], $this->successStatus);
        }
    }

    public function orderList(){
        $dataArr = [];
        $userId = Auth::user()->id;
        $getOrder = Order::where(['buyer' => $userId ])->orderBy('id', 'desc')->get();

        if(!empty($getOrder)){
            $productArr = [];
            foreach ($getOrder as $key => $row) {
                $address = !empty($row->shipping_address) ? json_decode($row->shipping_address) : array();
                $payment_status = !empty($row->payment_status) ? json_decode($row->payment_status) : array() ;
                $delivery_status = !empty($row->delivery_status) ? json_decode($row->delivery_status) : array();
                $payment_details = !empty($row->payment_details) ? json_decode($row->payment_details) : array();
                $shipping_address = !empty($row->shipping_address) ? json_decode($row->shipping_address) : array();

                $product_details = !empty($row->product_details) ? json_decode($row->product_details) : array();
                $dataArr = '';
                foreach($product_details as $row2){
                    $dataArr = $row2; 
                }
              $productArr['orderID'][$row->orderId][] = ['product_details' => $dataArr,'payment_details' => $payment_details,'delivery_status' => $delivery_status,'payment_status' => $payment_status,'address' => $address,'sale_code' => $row->sale_code, 'id' => $row->id, 'shipping_address' => $shipping_address];
            }
        }
        return response()->json(['success' => $productArr], $this->successStatus);
    }

    public function findProduct(){
        $search = $_GET['search'];
        $getCat = Category::select(DB::raw('group_concat(category.id) as ids'))->where('category.category_name', 'LIKE', "%$search%")->first();

        $getCatArr = !empty($getCat->ids) ? explode(',', $getCat->ids) : array() ;
      
        $getProductArr = [];
        $getProductIdArr = [];
        $getSubCateArr = [];
        $getSubProductArr = [];
        $getBrandsArr = [];
        $getBrandProductArr = [];
        
        if(isset($getCat) && !empty($getCat)){
            $getProductArrId = Products::select(DB::raw('group_concat(product.id) as productId'))->whereIn('product.category',$getCatArr)->first();
            $getProductArr = !empty($getProductArrId->productId) ? explode(',', $getProductArrId->productId) : array();
        }

        $getProduct = Products::select(DB::raw('group_concat(product.id) as productId'))->where('product.title', 'LIKE', "%$search%")->first();
        if(isset($getProduct) && !empty($getProduct)){
            $getProductIdArr = !empty($getProduct->productId) ? explode(',', $getProduct->productId) : array(); 
        }
        
        $getSubCategory = SubCategory::select(DB::raw('group_concat(sub_category.id) as subCatIds'))->where('sub_category.sub_category_name', 'LIKE', "%$search%")->first();
        $getSubCateArr = !empty($getSubCategory->subCatIds) ? explode(',', $getSubCategory->subCatIds) : array(); 
        if(isset($getSubCateArr) && !empty($getSubCateArr)){
            $getProductArrId = Products::select(DB::raw('group_concat(product.id) as productId'))->whereIn('product.sub_category',$getSubCateArr)->first();
            $getSubProductArr = !empty($getProductArrId->productId) ? explode(',', $getProductArrId->productId) : array();   
        } 

        $getBrand = Brand::select(DB::raw('group_concat(brand.id) as brandId'))->where('brand.name', 'LIKE', "%$search%")->first();
        $getBrandsArr = !empty($getBrand->brandId) ? explode(',', $getBrand->brandId) : array(); 
        
        if(isset($getBrandsArr) && !empty($getBrandsArr)){
            $getProductArrId = Products::select(DB::raw('group_concat(product.id) as productId'))->whereIn('product.brand',$getBrandsArr)->first();
            $getBrandProductArr = !empty($getProductArrId->productId) ? explode(',', $getProductArrId->productId) : array();   
        }
        
        $allProductArr = array_unique (array_merge ($getProductArr, $getProductIdArr,$getSubProductArr,$getBrandProductArr));

        $products['latestProducts'] = Products::select('product.id','product.title','brand.name as brand' , 'category.category_name', 'sub_category.sub_category_name','product.sale_price','product.current_stock','product.discount','product.purchase_price','product.shipping_cost','product.main_image as thumbnail')->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        whereIn('product.id', $allProductArr)->
        groupBy('product.id')->
        orderBy('product.id', 'desc')->take(10)->get();
        return response()->json(['success' => $products], $this->successStatus);
    }

    public function getMethods(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/methods');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, env('RAZORPAY_API_KEY'));
        $result = curl_exec($ch);
        curl_close($ch);
        return response()->json(['success' => json_decode($result) ], $this->successStatus);   
    }

}

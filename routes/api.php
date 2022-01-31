<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

  
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('fb-login', [UserController::class, 'facebookLogin']);

     
Route::middleware('auth:customerapi')->group( function () {

   Route::get('/userdetails',[UserController::class,'userdetails']);
   Route::get('/logout',[UserController::class,'logout']);
   Route::post('/change-password',[UserController::class,'restPassword']);
   Route::post('/firebase-token',[UserController::class,'firebaseToken']);
   Route::post('/update-profile',[UserController::class,'updateProfile']);
   Route::post('/update-address',[UserController::class,'updateAddress']);
   Route::get('/edit-user-details',[UserController::class,'edituserDetails']);

   Route::get('/cart-items',[ProductController::class,'cartListing']);
   Route::post('/add-to-cart',[ProductController::class,'addToCart']);
   Route::get('/remove-cart-item/{cartId}',[ProductController::class,'removeCartItem']);

   Route::get('/wish-list',[ProductController::class,'wishListing']);
   Route::post('/add-to-wish-list',[ProductController::class,'addToWishlist']);
   Route::get('/remove-wishlist/{id}',[ProductController::class,'removeWishItem']);
   Route::get('/order-detail/{orderId}',[ProductController::class,'orderDetails']);
   Route::get('/order-list/',[ProductController::class,'orderList']);

   Route::post('/add-address',[UserController::class,'addUserAddress']);
   Route::get('/delete-address/{addressId}',[UserController::class,'deleteAddress']);
   Route::get('address-list',[UserController::class,'userAddress']);
   Route::post('/create-order',[ProductController::class,'createOrder']);
   Route::post('/verify-order',[ProductController::class,'verifyOrder']);

});

   Route::post('/forgot-password',[UserController::class,'forgotPassword']);
   Route::post('/anonymous-token',[UserController::class,'anonymousToken']);
   Route::post('/verify-otp',[UserController::class,'verifyOTP']);
   Route::post('/update-password',[UserController::class,'updatePassword']);
   Route::get('/product-details/{productId}/{guest}',[ProductController::class,'getProductDetails']);
   Route::get('/product-listing',[ProductController::class,'index']);
   Route::get('/latest-product',[ProductController::class,'latestProduct']);
   Route::get('/category-listing',[ProductController::class,'categoryListing']);
  
   Route::post('/contact-us',[UserController::class,'contactMessage']);
   Route::get('/advertisement',[ProductController::class,'advertisementListing']);
   Route::get('/offers',[ProductController::class,'offerslisting']);
   Route::get('/popular-products',[ProductController::class,'popularProducts']);
   Route::get('/brands',[ProductController::class,'brandsListing']);
   Route::get('/banners',[ProductController::class,'bannerList']);
   Route::get('/product-search',[ProductController::class,'findProduct']);
   Route::get('/get-methods',[ProductController::class,'getMethods']);

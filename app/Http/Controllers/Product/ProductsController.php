<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductFeature;
use App\Models\ExtraFeature;
use App\Models\ProductAddon;
use App\Services\NotificationService;
use DB;
class ProductsController extends Controller
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

        $count = Products::count();
        $products = Products::select('id', 'title', 'category', 'status','main_image','current_stock', 'sale_price', 'purchase_price')->orderBy('id', 'desc')->paginate($count);
        return view('admin.products.list', compact('products'));
    } 

   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $addonListing = ProductAddon::select('id', 'name', 'qty', 'price')->where('status', 1)->get();
        $categories = Category::select('id', 'category_name')->orderBy('category_name', 'asc')->get(); 
        return view('admin.products.add', compact('categories', 'addonListing'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        private function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
            $imgsize = getimagesize($source_file);
            $width = $imgsize[0];
            $height = $imgsize[1];
            $mime = $imgsize['mime'];

            switch($mime){
                case 'image/gif':
                    $image_create = "imagecreatefromgif";
                    $image = "imagegif";
                    break;

                case 'image/png':
                    $image_create = "imagecreatefrompng";
                    $image = "imagepng";
                    $quality = 7;
                    break;

                case 'image/jpeg':
                    $image_create = "imagecreatefromjpeg";
                    $image = "imagejpeg";
                    $quality = 80;
                    break;

                default:
                    return false;
                    break;
            }

            $dst_img = imagecreatetruecolor($max_width, $max_height);
            $src_img = $image_create($source_file);

            $width_new = $height * $max_width / $max_height;
            $height_new = $width * $max_height / $max_width;
            if($width_new > $width){
                $h_point = (($height - $height_new) / 2);
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
            }else{
                $w_point = (($width - $width_new) / 2);
                imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
            }

            $image($dst_img, $dst_dir, $quality);

            if($dst_img)imagedestroy($dst_img);
            if($src_img)imagedestroy($src_img);
    }
  
    public function store(Request $request){
        $latestData = Products::latest('id', 'desc')->select('id')->first();
        $lastId = !empty($latestData->id) ? ($latestData->id + 1) : 1;    
        $userId = auth()->user()->id;
        $role = auth()->user()->role;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);
        $imageArr = [];
        $input = request()->validate([
            'title' => 'required|unique:product|max:255',
            'description' => 'required',
            'category' => 'required',
            'sale_price' => 'required',
            'purchase_price'=> 'required|lt:sale_price',
            'image' =>'required',
            'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
          $image = $request->file('image');
          $i = 0;
          foreach ($image as $files) {
              $i++;  
              $destinationPath = public_path('/products');
              $file_name = $lastId.'_'.$i.'.'.$files->getClientOriginalExtension();
              $files->move($destinationPath, $file_name);
              $imageArr[] = $file_name;
          }
        }

        $totalImage = !empty($imageArr) ? count($imageArr) : 0 ; 
        $sourcepath = public_path('/products/').$imageArr[0]; 
        $destpath = public_path('products/thumbnail/').$imageArr[0]; 
        $this->resize_crop_image(1024, 750, $sourcepath, $destpath);
        $insert = Products::Create([

            'title' => $request->title ,
            'description' => $request->description,
            'category' => $request->category,
            'num_of_imgs' => $totalImage,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            // 'shipping_cost' => $request->shipping_cost,
            'tag' => !empty($request->tags) ? implode(', ', $request->tags) : '',
            'featured' => !empty($request->producttags) ? implode(', ', $request->producttags) : '',
            'current_stock' => $request->current_stock,
            // 'discount' => $request->discount,
            // 'discount_type' => $request->discount_type,
            'added_by' => $addedby,
            'main_image' => $imageArr[0],
            'status' => !empty($request->status) ? $request->status : 0,
            'additional_fields' => $request->specification,
        ]);

        $insertId = $insert->id;
      
        if(isset($request->product_addon) &&  count($request->product_addon) > 0){
            $getlength = count($request->product_addon);
            for($i=0; $i < $getlength; $i++){
                $insertArr = array(
                    'product_id'=> $insertId,
                    'addon_id'   => !empty($request->product_addon[$i]) ? $request->product_addon[$i] : null,
                );
                $insert = isset($request->product_addon) && !empty($request->product_addon) ? ProductFeature::Create($insertArr) : '';
            }
        }

        if(isset($imageArr) && !empty($imageArr)){
            foreach ($imageArr as $row) {
                $insert = ProductImage::Create([
                    'product_id' => $insertId,
                    'image' => $row
                ]);
            }
        }

        if($insert){
            return redirect('products-list')->with('message', 'Product details added successfully !');
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
        $getDetails = Products::where('id', $id)->first();
        return view('admin.products.show', compact('getDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::select('id', 'category_name')->orderBy('category_name', 'asc')->get(); 
        $addonListing = ProductAddon::select('id', 'name', 'qty', 'price')->where('status', 1)->get(); 
        $getDetails = Products::where('id', $id)->first();
        $addons =  ProductFeature::select(DB::raw('group_concat(addon_id) as ids'))->where('product_id', $id)->first();
        $addonsArr = explode(',',$addons->ids); 
        return view('admin.products.edit', compact('categories', 'addonListing', 'getDetails', 'addonsArr'));
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

        $userId = auth()->user()->id;
        $role = auth()->user()->role;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);
        $imageArr = [];
        $totalImage = $request->totalImage;
        
        $optionArr = [];

        $input = request()->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'sale_price' => 'required',
            'purchase_price'=> 'required|lt:sale_price',
        ]);

        if(isset($request->product_addon) &&  count($request->product_addon) > 0){
            $getlength = count($request->product_addon);
            for($i=0; $i < $getlength; $i++){
                $insertArr = array(
                    'product_id'=> $id,
                    'addon_id'   => !empty($request->product_addon[$i]) ? $request->product_addon[$i] : null,
                );
                $insert = isset($request->id[$i]) && !empty($request->id[$i]) ? ProductFeature::where(['id' => $request->id[$i]])->update($insertArr)  : ProductFeature::Create($insertArr);
            }
        }

        if ($request->hasFile('image')) {
          $image = $request->file('image');
          $i = $totalImage;
          foreach ($image as $files) {
              $i++;  
              $destinationPath = public_path('/products');
              $file_name = $id.'_'.$i.'.'.$files->getClientOriginalExtension();
              $files->move($destinationPath, $file_name);
              $imageArr[] = $file_name;
          }
        }

        $totalImage = !empty($imageArr) ? count($imageArr)+$totalImage : 0 ; 
        $size = !empty($request->size) ? json_encode($request->size) : '';
        $color = !empty($request->color) ? json_encode($request->color) : '';
        
        $updateArr = [

            'title' => $request->title ,
            'description' => $request->description,
            'category' => $request->category,
            'num_of_imgs' => $totalImage,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            // 'shipping_cost' => $request->shipping_cost,
            'tag' => !empty($request->tags) ? implode(', ', $request->tags) : '',
            'featured' => !empty($request->producttags) ? implode(', ', $request->producttags) : '',
            'current_stock' => $request->current_stock,
            // 'discount' => $request->discount,
            // 'discount_type' => $request->discount_type,
            'added_by' => $addedby,
            'status' => !empty($request->status) ? $request->status : 0,
            'additional_fields' => $request->specification,
        ];

        $update = Products::find($id)->update($updateArr);
        
        if(isset($imageArr) && !empty($imageArr)){
            foreach ($imageArr as $row) {
                $insert = ProductImage::Create([
                    'product_id' => $id,
                    'image' => $row
                ]);
            }
        }

        if($update){
            return redirect()->route('products.edit', $id)->with('message', 'Product details updated successfully !');
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
        $product = Products::findOrFail($id);
        $product->delete();
        $deleteImage = ProductImage::where('product_id', $id)->get();
        if(!empty($deleteImage)){
            foreach ($deleteImage as $image) {
            $path = public_path('products/'.$image);
              if(file_exists($path)){
                unlink($path);   
              }
            }
        }

        $deleteImageData = ProductImage::where('product_id', $id)->delete();
        return redirect()->back()->with('message', 'Product deleted successfully!');
    }

    public function getSubCategory(Request $request){
        $categoryId = $request->categoryId;
        $subcategories = Category::find($categoryId)->getSubCategory;
        return json_encode($subcategories);
    }

    public function setMainImage( Request $request){

        $id = $request->productId;
        $sourceImage = $request->productImage;
        $destImage = $request->dest;
        
        $sourcepath = public_path('/products/').$sourceImage; 
        $destTmpPath = public_path('products/thumbnail/').$destImage; 
        $destpath = public_path('products/thumbnail/').$sourceImage; 
        
        if(file_exists($destTmpPath)){
            unlink($destTmpPath);
        }
        $this->resize_crop_image(1024, 750, $sourcepath, $destpath);

        $updateArr = ['main_image' => $sourceImage];
        $update = Products::find($id)->update($updateArr);
        if($update){
            $data = ['status' => 'success', 'msg' => 'Thumbnail set successfully !'];
            echo json_encode($data);
            exit();
        }
    }

        public function uploadCsv(){
        return view('admin.products.csv');
    }

    public function importCsvData(Request $request){
        $destinationPath = public_path('products/csv/');
        $files = glob($destinationPath.'/*'); 
            foreach($files as $file){ 
              if(is_file($file)) {
                unlink($file); 
              }
            }

        $file = $request->file('csv_file');
        $fileName = $file->getClientOriginalName();  

        $destinationPath = public_path('products/csv/');
        $import = 1;
        
        $import = $file->move($destinationPath,$file->getClientOriginalName());
        
        if($import){
            $fileUrl = $destinationPath.$fileName;    

            $filepath = $fileUrl;

            $file = fopen($filepath,"r");

            $importData_arr = array();
            $i = 0;

              while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                 $num = count($filedata );
                 
                if($i == 0){
                    $i++;
                    continue; 
                }
               for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                 }
                 $i++;
              }
              fclose($file);
           
            $userId = auth()->user()->id;
            $addedby = json_encode(['type' => 'admin', 'id' => $userId]);
        
              foreach($importData_arr as $key => $importData){
                $additionalData = !empty($importData[12]) ? $importData[12] : '';
                $additional = ['name' => 'information', 'value' => $additionalData];
                $additionalInfo = !empty($importData[12]) ? json_encode($additional) : array();
                $labelArr = !empty($importData[13]) ? explode('|', $importData[13]) : array();
                $valueArr = !empty($importData[14]) ? explode('|', $importData[14]) : array();
                $featuresArr = [];
                $labelCount = count(array($labelArr));
                $valueCount = count(array($valueArr));
                
                if(($labelCount) == ($valueCount)){
                    $featuresArr = array_combine($labelArr , $valueArr);
                }

                $getCatId = Category::where('category_name', '=', $importData[2] )->select('id')->first();
                $getSubCatId = SubCategory::where('sub_category_name', '=', $importData[3] )->select('id')->first();
                $getBrandId = Brand::where('name', '=', $importData[4] )->select('id')->first();
                $catId = !empty($getCatId) ? $getCatId->id : '';
                $subCatId = !empty($getSubCatId) ? $getSubCatId->id : '';
                $brandId = !empty($getBrandId) ? $getBrandId->id : '';
                
                $insertArr = [
                    'title' => !empty($importData[0]) ? $importData[0] : '' ,
                    'description' => !empty($importData[1]) ? $importData[1] : '',
                    'category' => !empty($catId) ? $catId : '',
                    'sub_category' => !empty($subCatId) ? $subCatId : '',
                    'brand' => !empty($brandId) ? $brandId : '',
                    'sale_price' => !empty($importData[5]) ? $importData[5] : '',
                    'purchase_price' => !empty($importData[6]) ? $importData[6] : '',
                    'shipping_cost' => !empty($importData[7]) ? $importData[7] : 0,
                    'current_stock' => !empty($importData[8]) ? $importData[8] : 0,
                    'added_by' => $addedby,
                    'additional_fields'   => !empty($additionalInfo) ? $additionalInfo : '',
                ];
              
                $insert = Products::Create($insertArr);
                $productId = $insert->id;
               

                $insertArr1 = [
                    'type' => 'add',
                    'category' => $catId,
                    'sub_category' => $subCatId,
                    'product_id' => $productId,
                    'size' => !empty($importData[9]) ? $importData[9] : '',
                    'color' => !empty($importData[10]) ? $importData[10] : '',
                    'quantity' => !empty($importData[11]) ? $importData[11] : '',
                    'datetime' => time(),
                    'added_by' => $addedby
                ];

                $insert2 = ProductFeature::Create($insertArr1);

                if(isset($featuresArr) && !empty($featuresArr)){
                    foreach ($featuresArr as $key => $value) {
                        $insertArr2 = [
                            'product_id' => $productId ,
                            'feature_label' => $key ,
                            'feature_value' => $value,
                        ];
                        $insert3 = ExtraFeature::Create($insertArr2);
                    }
                }

            }
   
            return redirect('upload-csv')->with('message', 'Product import successfully !');
        }
    }

    public function categoryAddon( Request $request){
        $catId = $request->categoryId;
        $productAdd = ProductAddon::where(['category_id' => $catId])->get();
        return $productAdd;
    }
}

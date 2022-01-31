<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Products extends Authenticatable
{
    use  Notifiable, LogsActivity ,SoftDeletes;
    protected $table = 'product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rating_num','rating_total','rating_user','title','added_by','category','description','sub_category','num_of_imgs','sale_price','purchase_price','shipping_cost','add_timestamp','featured','tag','seo_title','seo_description','status','front_image','brand','current_stock','unit','additional_fields','number_of_view','background','discount','discount_type','tax','tax_type','color','options','main_image','download','download_name','deal','num_of_downloads','update_time','requirements','logo','video','last_viewed','products','is_bundle','vendor_featured' ];


      	public function hasCategory(){
		      return $this->belongsTo(Category::class, 'category', 'id');
		    }

    		public function hasSubCategory(){
    		    return $this->belongsTo(SubCategory::class, 'sub_category', 'id');
    		}

    		public function hasBrand(){
    		    return $this->belongsTo(Brand::class, 'brand', 'id');
    		}

        public function getProductImages(){
          return $this->hasMany(ProductImage::class, 'product_id', 'id');   
        }  

        public function getProductFeature(){
          return $this->hasMany(ProductFeature::class, 'product_id', 'id');   
        }
        
        public function extraFeatures(){
          return $this->hasMany(ExtraFeature::class, 'product_id', 'id');   
        }

    protected static $logAttributes = ['rating_num','rating_total','rating_user','title','added_by','category','description','sub_category','num_of_imgs','sale_price','purchase_price','shipping_cost','add_timestamp','featured','tag','seo_title','seo_description','status','front_image','brand','current_stock','unit','additional_fields','number_of_view','background','discount','discount_type','tax','tax_type','color','options','main_image','download','download_name','deal','num_of_downloads','update_time','requirements','logo','video','last_viewed','products','is_bundle','vendor_featured'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Products';

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Authenticatable
{
    use  Notifiable , LogsActivity ,SoftDeletes;

    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id';
    
    protected $fillable = ['category_name', 'description', 'status', 'category_order', 'category_image'];

    protected static $logAttributes = ['category_name', 'status', 'description', 'category_order', 'category_image'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Category';

	public function getSubCategory(){
      return $this->hasMany(SubCategory::class, 'category', 'id');   
    }

}

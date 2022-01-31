<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductAddon extends Model
{
    use HasFactory, Notifiable, LogsActivity ,SoftDeletes;

    protected $table = 'addon_product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'name', 'qty', 'price', 'status', 'addon_desc', 'addon_image'];

    protected static $logAttributes = ['category_id', 'name', 'qty', 'price', 'status', 'addon_desc', 'addon_image'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'addon_product';

    public function getCategory(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}

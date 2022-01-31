<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductFeature extends Authenticatable
{
    use  Notifiable ,SoftDeletes;
    protected $table = 'product_feature';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'addon_id',
    ];
    public function getProductAddon(){
        return $this->hasMany(ProductAddon::class, 'addon_id', 'id');   
    }

}

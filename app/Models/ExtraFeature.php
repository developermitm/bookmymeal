<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExtraFeature extends Authenticatable
{
    use  Notifiable ,SoftDeletes;
    protected $table = 'product_extra_feature';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'feature_label',
        'feature_value',
    ];


}

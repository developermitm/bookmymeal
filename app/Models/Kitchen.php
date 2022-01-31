<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Kitchen extends Authenticatable
{
    use  Notifiable,SoftDeletes;
    protected $table = 'kitchen';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_name',
        'kitchen_name',
        'image',
        'address',
        'lat',
        'lang',
        'mobile_num',
        'status',
    ];


}

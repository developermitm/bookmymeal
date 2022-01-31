<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryUserDoc extends Authenticatable
{
    use  Notifiable,SoftDeletes;
    protected $table = 'delivery_user_doc';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'delivery_user_id',
        'document',
    ];


}

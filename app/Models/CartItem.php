<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class CartItem extends Authenticatable
{
    use  Notifiable , LogsActivity ,SoftDeletes;
    
    protected $table = 'cart';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'price',
    ];

    protected static $logAttributes = [ 
        'user_id',
        'product_id',
        'qty',
        'price'
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'AppUser';


}

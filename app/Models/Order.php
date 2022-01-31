<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Authenticatable
{
    use  Notifiable, LogsActivity ,SoftDeletes;

    protected $table = 'sale';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sale_code', 'buyer', 'guest_id', 'product_details', 'shipping_address', 'vat', 'vat_percent', 'shipping', 'payment_type', 'payment_status', 'payment_details', 'payment_timestamp', 'grand_total', 'sale_datetime', 'delivary_datetime', 'delivery_status', 'viewed', 'orderId','paymentId' ];

    protected static $logAttributes = ['sale_code', 'buyer', 'guest_id', 'product_details', 'shipping_address', 'vat', 'vat_percent', 'shipping', 'payment_type', 'payment_status', 'payment_details', 'payment_timestamp', 'grand_total', 'sale_datetime', 'delivary_datetime', 'delivery_status', 'viewed' , 'orderId', 'paymentId'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Order';


}

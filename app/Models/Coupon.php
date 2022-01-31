<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Coupon extends Authenticatable
{
    use  Notifiable, LogsActivity ,SoftDeletes;

    protected $table = 'coupon';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'spec',
        'added_by',
        'till',
        'code',
        'status',
        'amount'
    ];

    protected static $logAttributes = [
        'title',
        'spec',
        'added_by',
        'till',
        'code',
        'status'
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Coupon';


}

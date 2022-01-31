<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banner extends Authenticatable
{
    use  Notifiable, LogsActivity, SoftDeletes;

    protected $table = 'banner';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page',
        'place',
        'num',
        'status',
        'link',
        'image_ext',
        'product_id',
        'from_time',
        'addedBy'

    ];

    protected static $logAttributes = [
        'page',
        'place',
        'num',
        'status',
        'link',
        'image_ext',
        'product_id',
        'from_time',
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'Banner';

    public function getProduct(){
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }


}

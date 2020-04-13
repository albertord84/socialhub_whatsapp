<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Tracking
 * @package App\Models
 * @version April 9, 2020, 6:00 pm -03
 *
 * @property string post_card
 * @property string|\Carbon\Carbon post_date
 * @property string service_code
 * @property integer items
 * @property string object_code
 * @property string json_csv_data
 * @property integer status_id
 * @property string tracking_list
 */
class Tracking extends Model
{

    public $table = 'tracking';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.tracking";

    public $fillable = [
        'post_card',
        'post_date',
        'service_code',
        'items',
        'object_code',
        'json_csv_data',
        'status_id',
        'tracking_list'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'post_card' => 'string',
        'post_date' => 'datetime',
        'service_code' => 'string',
        'items' => 'integer',
        'object_code' => 'string',
        'json_csv_data' => 'string',
        'status_id' => 'integer',
        'tracking_list' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'object_code' => 'required'
    ];

    
}

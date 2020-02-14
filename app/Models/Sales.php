<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Sales
 * @package App\Models
 * @version February 14, 2020, 10:30 am -03
 *
 * @property integer contact_id
 * @property integer source
 * @property integer sended
 * @property string json_data
 */
class Sales extends Model
{

    public $table = 'sales';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.sales";

    public $fillable = [
        'contact_id',
        'source',
        'sended',
        'json_data'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contact_id' => 'integer',
        'source' => 'integer',
        'sended' => 'integer',
        'json_data' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

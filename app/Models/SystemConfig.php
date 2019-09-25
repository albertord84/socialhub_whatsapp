<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class SystemConfig
 * @package App\Models
 * @version September 13, 2019, 9:29 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string name
 * @property string value
 * @property string description
 */
class SystemConfig extends Model
{

    public $table = 'system_config';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'value',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'value' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'name' => 'required'
    ];

    
}

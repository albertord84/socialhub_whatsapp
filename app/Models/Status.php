<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Status
 * @package App\Models
 * @version September 13, 2019, 9:09 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string name
 * @property string description
 */
class Status extends Model
{

    public $table = 'status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
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
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required'
    ];

    
}

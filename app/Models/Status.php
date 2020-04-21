<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Status
 * @package App\Models
 * @version April 9, 2020, 6:33 pm -03
 *
 * @property string name
 * @property string model
 * @property string description
 */
class Status extends Model
{

    public $table = 'status';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'model',
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
        'model' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

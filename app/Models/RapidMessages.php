<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class RapidMessages
 * @package App\Models
 * @version May 28, 2020, 2:57 pm -03
 *
 * @property integer user_id
 * @property string message
 */
class RapidMessages extends Model
{

    public $table = 'rapid_messages';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'message' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'message' => 'required'
    ];

    
}

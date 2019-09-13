<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class MessageType
 * @package App\Models
 * @version September 13, 2019, 2:53 pm UTC
 *
 */
class MessageType extends Model
{

    public $table = 'message_types';
    


    public $fillable = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class MessagesType
 * @package App\Models
 * @version November 7, 2019, 8:04 pm UTC
 *
 * @property string name
 * @property string description
 */
class MessagesType extends Model
{

    public $table = 'messages_types';
    
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
        
    ];

    
}

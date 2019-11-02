<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Chat
 * @package App\Models
 * @version October 31, 2019, 4:12 pm UTC
 *
 * @property integer contact_id
 * @property integer attendant_id
 * @property string message
 * @property integer type_id
 * @property string data
 * @property integer status_id
 * @property integer socialnetwork_id
 */
class ExtendedChat extends Chat
{

    public $table = 'chats';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.chats";

    public $fillable = [
        'contact_id',
        'attendant_id',
        'message',
        'type_id',
        'data',
        'status_id',
        'socialnetwork_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contact_id' => 'integer',
        'attendant_id' => 'integer',
        'message' => 'string',
        'type_id' => 'integer',
        'data' => 'string',
        'status_id' => 'integer',
        'socialnetwork_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'contact_id' => 'required',
        'attendant_id' => 'required'
    ];

    
}

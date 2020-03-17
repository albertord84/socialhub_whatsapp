<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Queue
 * @package App\Models
 * @version March 17, 2020, 5:34 pm -03
 *
 * @property integer contact_id
 * @property integer attendant_id
 * @property integer company_id
 * @property integer source
 * @property integer response_to
 * @property string message
 * @property integer type_id
 * @property string data
 * @property integer status_id
 * @property integer socialnetwork_id
 */
class Queue extends Model
{

    public $table = 'queue';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.chats";

    public $fillable = [
        'contact_id',
        'attendant_id',
        'company_id',
        'source',
        'response_to',
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
        'company_id' => 'integer',
        'source' => 'integer',
        'response_to' => 'integer',
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
        
    ];

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chat
 * @package App\Models
 * @version October 31, 2019, 4:12 pm UTC
 *
 * @property integer contact_id
 * @property integer attendant_id
 * @property integer source
 * @property string message
 * @property integer type_id
 * @property string data
 * @property integer status_id
 * @property integer socialnetwork_id
 */
class Chat extends Model
{

    public $table = 'chats';

    public $connection = "socialhub_mvp.chats";
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'contact_id',
        'attendant_id',
        'company_id',
        'source',
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

    /**
     * Class constructor.
     */
    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);

    //     $this->connection = isset($_SESSION['TESTING']) && $_SESSION['TESTING'] ? "socialhub_mvp.chats.test" : "socialhub_mvp.chats";
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id');
    }
}

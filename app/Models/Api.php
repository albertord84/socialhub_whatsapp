<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Api
 * @package App\Models
 * @version April 14, 2020, 4:09 pm -03
 *
 * @property integer contact_id
 * @property integer sended
 * @property string message
 * @property integer type_id
 * @property string data
 */
class Api extends Model
{

    public $table = 'api';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.api";

    public $fillable = [
        'contact_id',
        'sended',
        'message',
        'type_id',
        'data',
        'status_id',
        'file_name',
        'file_type'
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contact_id' => 'integer',
        'sended' => 'integer',
        'message' => 'string',
        'type_id' => 'integer',
        'data' => 'string',
        'status_id' => 'integer',
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function status()
    {
        return $this->hasOne(\App\Models\Status::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     **/
    public function statuses()
    {
        return $this->morphMany(\App\Models\Status::class, 'statusable');
    }

    
}

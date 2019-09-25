<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class UsersManager
 * @package App\Models
 * @version September 13, 2019, 10:14 pm UTC
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string CNPJ
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 */
class UsersManager extends Model
{

    public $table = 'users_managers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'CNPJ',
        'whatsapp_id',
        'facebook_id',
        'instagram_id',
        'linkedin_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'CNPJ' => 'string',
        'whatsapp_id' => 'string',
        'facebook_id' => 'string',
        'instagram_id' => 'string',
        'linkedin_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}

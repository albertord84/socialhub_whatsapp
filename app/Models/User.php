<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class User
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 *
 * @property \App\Models\Company company
 * @property \App\Models\Role role
 * @property \App\Models\UsersStatus status
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property \Illuminate\Database\Eloquent\Collection 2s
 * @property \App\Models\UsersManager usersManager
 * @property integer id
 * @property integer company_id
 * @property string name
 * @property string email
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 * @property string login
 * @property string CPF
 * @property string phone
 * @property string image_path
 * @property integer role_id
 * @property integer status_id
 */
class User extends Model
{

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'company_id',
        'name',
        'email',
        'whatsapp_id',
        'facebook_id',
        'instagram_id',
        'linkedin_id',
        'email_verified_at',
        'password',
        'remember_token',
        'login',
        'CPF',
        'phone',
        'image_path',
        'role_id',
        'status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'whatsapp_id' => 'string',
        'facebook_id' => 'string',
        'instagram_id' => 'string',
        'linkedin_id' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'login' => 'string',
        'CPF' => 'string',
        'phone' => 'string',
        'image_path' => 'string',
        'role_id' => 'integer',
        'status_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'image_path' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function status()
    {
        return $this->belongsTo(\App\Models\UsersStatus::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function usersManager()
    {
        return $this->hasOne(\App\Models\UsersManager::class);
    }
}

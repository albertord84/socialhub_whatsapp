<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class User
 * @package App\Models
 * @version September 13, 2019, 9:09 pm UTC
 *
 * @property \App\Models\Role role
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \App\Models\UsersAttendant usersAttendant
 * @property \App\Models\UsersManager usersManager
 * @property string name
 * @property string email
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 * @property string login
 * @property string CPF
 * @property string phone
 * @property string image_path
 * @property integer role_id
 */
class User extends Model
{

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'login',
        'CPF',
        'phone',
        'image_path',
        'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'login' => 'string',
        'CPF' => 'string',
        'phone' => 'string',
        'image_path' => 'string',
        'role_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'image_path' => 'required',
        'role_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function usersAttendant()
    {
        return $this->hasOne(\App\Models\UsersAttendant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function usersManager()
    {
        return $this->hasOne(\App\Models\UsersManager::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class UsersAttendant
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 *
 * @property \App\Models\User user
 * @property \App\Models\User userManager
 * @property \Illuminate\Database\Eloquent\Collection attendantsContacts
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer user_manager_id
 * @property integer code
 */
class UsersAttendant extends Model
{

    public $table = 'users_attendants';

    protected $primaryKey = 'user_id';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'user_id',
        'user_manager_id',
        'code',
        'selected_contact_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'user_manager_id' => 'integer',
        'code' => 'integer',
        'selected_contact_id' => 'integer'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function userManager()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendantsContacts()
    {
        return $this->hasMany(\App\Models\AttendantsContact::class, 'attendant_id');
    }
}

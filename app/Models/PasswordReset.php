<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class PasswordReset
 * @package App\Models
 * @version September 13, 2019, 9:13 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string email
 * @property string token
 */
class PasswordReset extends Model
{

    public $table = 'password_resets';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'email',
        'token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'token' => 'required'
    ];

    
}

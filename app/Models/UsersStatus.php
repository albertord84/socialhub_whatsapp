<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class UsersStatus
 * @package App\Models
 * @version September 26, 2019, 1:31 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string name
 * @property string description
 */
class UsersStatus extends Model
{

    public $table = 'users_status';
    
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
        'id' => 'required'
    ];

    
}

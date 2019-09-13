<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class AttendentsContact
 * @package App\Models
 * @version September 13, 2019, 3:04 pm UTC
 *
 */
class AttendentsContact extends Model
{

    public $table = 'attendents_contacts';
    


    public $fillable = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}

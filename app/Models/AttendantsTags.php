<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class AttendantsTags
 * @package App\Models
 * @version April 2, 2020, 8:00 am -03
 *
 * @property integer attendant_id
 * @property string name
 * @property string color
 */
class AttendantsTags extends Model
{

    public $table = 'attendants_tags';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'attendant_id',
        'name',
        'color'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'attendant_id' => 'integer',
        'name' => 'string',
        'color' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'color' => 'required'
    ];

    
}

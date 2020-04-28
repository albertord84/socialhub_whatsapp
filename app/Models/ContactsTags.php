<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class ContactsTags
 * @package App\Models
 * @version April 2, 2020, 9:47 pm -03
 *
 * @property integer contact_id
 * @property integer attendant_id
 * @property integer attendant_tag_id
 */
class ContactsTags extends Model
{

    public $table = 'contacts_tags';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'contact_id',
        'attendant_id',
        'attendant_tag_id'
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
        'attendant_tag_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'contact_id' => 'required',
        'attendant_id' => 'required',
        'attendant_tag_id' => 'required'
    ];

    
}

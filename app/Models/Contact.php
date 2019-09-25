<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Contact
 * @package App\Models
 * @version September 13, 2019, 9:12 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection attendantsContacts
 * @property string first_name
 * @property string last_name
 * @property string phone
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 */
class Contact extends Model
{

    public $table = 'contacts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'first_name',
        'last_name',
        'phone',
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
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
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
        'id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendantsContacts()
    {
        return $this->hasMany(\App\Models\AttendantsContact::class, 'contact_id');
    }
}

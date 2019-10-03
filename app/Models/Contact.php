<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Contact
 * @package App\Models
 * @version September 27, 2019, 5:25 pm UTC
 *
 * @property \App\Models\Company company
 * @property \App\Models\ContactsStatus status
 * @property \Illuminate\Database\Eloquent\Collection attendantsContacts
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer company_id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string description
 * @property string remember
 * @property string summary
 * @property string phone
 * @property string whatsapp_id
 * @property string facebook_id
 * @property string instagram_id
 * @property string linkedin_id
 * @property integer status_id
 */
class Contact extends Model
{

    public $table = 'contacts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'description',
        'remember',
        'summary',
        'phone',
        'whatsapp_id',
        'facebook_id',
        'instagram_id',
        'linkedin_id',
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
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'description' => 'string',
        'remember' => 'string',
        'summary' => 'string',
        'phone' => 'string',
        'whatsapp_id' => 'string',
        'facebook_id' => 'string',
        'instagram_id' => 'string',
        'linkedin_id' => 'string',
        'status_id' => 'integer'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function status()
    {
        return $this->belongsTo(\App\Models\ContactsStatus::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendantsContacts()
    {
        return $this->hasMany(\App\Models\AttendantsContact::class, 'contact_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function latestAttendantContact()
    {
        return $this->hasOne(\App\Models\AttendantsContact::class, 'contact_id', 'id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function latestAttendant()
    {
        return $this->hasOne(\App\Models\AttendantsContact::class, 'contact_id', 'id')->latest();

        // $AttendantContact = $this->hasOne(\App\Models\AttendantsContact::class, 'contact_id', 'id')->latest();
        // dd("OK");   
        // $Attendant = $AttendantContact->get();
        // dd($Attendant);
        // dd($AttendantContact->all()->last());
        // return UsersAttendant::with('User')->find($AttendantContact->attendant_id);
    }
}

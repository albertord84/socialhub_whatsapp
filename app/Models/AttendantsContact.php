<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class AttendantsContact
 * @package App\Models
 * @version September 27, 2019, 3:37 pm UTC
 *
 * @property \App\Models\UsersAttendant attendant
 * @property \App\Models\Contact contact
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer attendant_id
 * @property integer contact_id
 */
class AttendantsContact extends Model
{

    public $table = 'attendants_contacts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'attendant_id',
        'contact_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'attendant_id' => 'integer',
        'contact_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function attendant()
    {
        return $this->belongsTo(\App\Models\UsersAttendant::class, 'attendant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id');
    }
}

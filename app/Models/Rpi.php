<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Rpi
 * @package App\Models
 * @version November 30, 2019, 5:50 pm -03
 *
 * @property integer company_id
 * @property string mac
 * @property string tunnel
 * @property string ip
 * @property string password
 * @property string data
 * @property string soft_version
 * @property string soft_version_date
 */
class Rpi extends Model
{

    public $table = 'rpis';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'company_id',
        'mac',
        'tunnel',
        'ip',
        'password',
        'data',
        'soft_version',
        'soft_version_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'mac' => 'string',
        'tunnel' => 'string',
        'ip' => 'string',
        'password' => 'string',
        'data' => 'string',
        'soft_version' => 'string',
        'soft_version_date' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }    
}

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
        'id',
        'ip',
        'data',
        'api_user',
        'api_password',
        'root_user',
        'root_password',
        'tcp_tunnel',
        'tcp_port',
        'mac',
        'api_tunnel',
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
        'ip' => 'string',
        'data' => 'string',
        'api_user' => 'string',
        'api_password' => 'string',
        'root_user' => 'string',
        'root_password' => 'string',
        'tcp_tunnel' => 'string',
        'tcp_port' => 'string',
        'mac' => 'string',
        'api_tunnel' => 'string',
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

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  **/
    // public function company()
    // {
    //     return $this->belongsTo(\App\Models\Company::class, 'company_id');
    // }    
}

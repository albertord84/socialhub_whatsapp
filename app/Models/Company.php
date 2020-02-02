<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Company
 * @package App\Models
 * @version September 27, 2019, 5:24 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection contacts
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection 1s
 * @property string CNPJ
 * @property string name
 * @property string phone
 * @property string email
 * @property string rpi_id
 * @property string description
 */
class Company extends Model
{

    public $table = 'companies';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'rpi_id',
        'CNPJ',
        'name',
        'phone',
        'email',
        'whatsapp',
        'description',
        'user_seller_id',

        'CEP',
        'cidade',
        'estado',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'amount_attendants',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'rpi_id' => 'integer',
        'CNPJ' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'whatsapp'=> 'string',
        'description' => 'string',
        'user_seller_id' => 'integer',

        'CEP'=> 'string',
        'estado'=> 'string',
        'cidade'=> 'string',
        'rua'=> 'string',
        'numero'=> 'string',
        'complemento'=> 'string',
        'bairro'=> 'string',
        
        'amount_attendants'=> 'string',
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
    public function contacts()
    {
        return $this->hasMany(\App\Models\Contact::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function rpi()
    {
        return $this->hasOne(\App\Models\Rpi::class, 'id', 'rpi_id');
        // return $this->hasOne(\App\Models\Rpi::class, 'rpi_id');
    } 

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function manager()
    {
        $this->manager = User::where([
            'company_id' => $this->id, 
            'role_id' => 3, 
            'status_id' => 1
        ])->first();

        return $this;
        // return $this->hasOne(\App\Models\User::class, 'company_id', 'id');
        // return $this->hasOne(\App\Models\Rpi::class, 'rpi_id');
    } 

}

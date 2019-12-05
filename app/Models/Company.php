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
 * @property string description
 */
class Company extends Model
{

    public $table = 'companies';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'CNPJ',
        'name',
        'phone',
        'email',
        'whatsapp',
        'ngrok_url',
        'description',
        // 'user_seller_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'CNPJ' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'email' => 'string',
        //'whatsapp'=> 'string',
        //'ngrok_url' => 'string',
        'description' => 'string',
        ///'user_seller_id'
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
}

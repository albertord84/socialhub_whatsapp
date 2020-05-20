<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class CompaniesBlings
 * @package App\Models
 * @version May 20, 2020, 8:29 am -03
 *
 * @property \App\Models\Company company
 * @property integer company_id
 * @property string bling_apikey
 * @property string bling_token
 * @property string bling_message
 * @property integer bling_contrated
 */
class CompaniesBlings extends Model
{

    public $table = 'companies_blings';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'company_id',
        'bling_apikey',
        'bling_token',
        'bling_message',
        'bling_contrated'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'bling_apikey' => 'string',
        'bling_token' => 'string',
        'bling_message' => 'string',
        'bling_contrated' => 'integer'
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

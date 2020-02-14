<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use stdClass;

/**
 * Class Sales
 * @package App\Models
 * @version February 14, 2020, 10:30 am -03
 *
 * @property integer contact_id
 * @property integer source
 * @property integer sended
 * @property string json_data
 */
class Sales extends Model
{

    public $table = 'sales';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.sales";

    public $fillable = [
        'contact_id',
        'source', // Defaul 1 -> Bling
        'sended',
        'json_data'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contact_id' => 'integer',
        'source' => 'integer',
        'sended' => 'integer',
        'json_data' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Class constructor.
     */
    public static function blingConstruct(stdClass $saleBling) : Sales
    {
        $Sale = new Sales;
        $Sale->contact_id = $saleBling->contact_id;
        $Sale->source = 1;
        $Sale->json_data = json_encode($saleBling);

        return $Sale;
    }
}

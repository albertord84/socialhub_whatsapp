<?php

namespace App\Models;

use App\Business\MyException;
use Illuminate\Database\Eloquent\Model as Model;
use stdClass;

/**
 * Class Sales
 * @package App\Models
 * @version February 14, 2020, 10:30 am -03
 *
 * @property string id
 * @property integer contact_id
 * @property integer source
 * @property integer sended
 * @property string json_data
 */
class Sales extends Model
{

    public $table = 'sales';

    public $company_id = null;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.sales";

    public $fillable = [
        'id',
        'contact_id',
        'source', // Defaul 1 -> Bling
        'sended',
        'message',
        'json_data'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'id' => 'string',
        'contact_id' => 'integer',
        'source' => 'integer',
        'sended' => 'integer',
        'message' => 'string',
        // 'json_data' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'contact_id' => 'required',
    ];

    /**
     * Class constructor.
     */
    public static function blingConstruct(stdClass $saleBling, int $contact_id, int $company_id) : Sales
    {
        $Sale = new Sales();
        $Sale->table = "$company_id";
        if (isset($saleBling->pedido->numero)) {
            $Sale->id =  $saleBling->pedido->numero;
        }
        else {
            throw new MyException("Invalid Bling Sale Id", 1);
        }
        $Sale->contact_id = $contact_id;
        $Sale->source = 0;
        $Sale->json_data = json_encode($saleBling);

        return $Sale;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function contact()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id');
    }    
}

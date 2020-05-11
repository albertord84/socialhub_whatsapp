<?php

namespace App\Models;

use App\Business\MyException;
use App\Business\SalesBusiness;
use App\Http\Controllers\MessagesStatusController;
use App\Http\Controllers\MessagesTypeController;
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
        'json_data',
        'has_attendant',
        'attendant_id',
        'chat_id',
        'status_id'
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
    public static function blingConstruct(stdClass $saleBling, Contact $Contact, Company $Company, bool $hasAttendant) : Sales
    {
        $Sale = new Sales();
        $Sale->table = "$Company->id";
        if (isset($saleBling->pedido->numero)) {
            $Sale->id =  $saleBling->pedido->numero;
        }
        else {
            throw new MyException("Invalid Bling Sale Id", 1);
        }
        $Sale->contact_id = $Contact->id;
        $Sale->source = 0;
        $Sale->json_data = json_encode($saleBling);

        $Sale->status_id = MessagesStatusController::ROUTED;

        $Sale->message = SalesBusiness::builSaleMessage($saleBling, $Company);
        
        if ($hasAttendant) { // Save sale chat to attendant
            $Chat = new ExtendedChat();
            $Chat->contact_id = $Contact->id;
            $Chat->company_id = $Company->id;
            $Chat->type_id = MessagesTypeController::Text;
            $Chat->status_id = MessagesStatusController::ROUTED;
            $Chat->message = $Sale->message;
            $Chat->attendant_id = $Contact->latestAttendantContact->attendant_id;
            $Chat->source = 0;
            $Chat->table = "$Chat->attendant_id";
            $Chat->save();
            
            $Sale->has_attendant = true;
            $Sale->attendant_id = $Chat->attendant_id;
            $Sale->chat_id = $Chat->id;
            $Sale->status_id = $Chat->status_id;
            
        }

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

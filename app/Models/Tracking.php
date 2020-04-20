<?php

namespace App\Models;

use App\Http\Controllers\MessagesStatusController;
use App\Http\Controllers\StatusController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Model;
use stdClass;

/**
 * Class Tracking
 * @package App\Models
 * @version April 9, 2020, 6:00 pm -03
 *
 * @property string post_card
 * @property string|\Carbon\Carbon post_date
 * @property string service_code
 * @property integer items
 * @property string tracking_code
 * @property string json_csv_data
 * @property integer status_id
 * @property string tracking_list
 */
class Tracking extends Model
{

    public $table = 'tracking';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $connection = "socialhub_mvp.tracking";

    public $fillable = [
        'id',
        'contact_id',
        'post_card',
        'post_date',
        'service_code',
        'items',
        'tracking_code',
        'json_csv_data',
        'status_id',
        'tracking_list'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'contact_id' => 'string',
        'post_card' => 'string',
        'post_date' => 'datetime',
        'service_code' => 'string',
        'items' => 'integer',
        'tracking_code' => 'string',
        'json_csv_data' => 'string',
        'status_id' => 'integer',
        'tracking_list' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tracking_code' => 'required'
    ];


    /**
     * Class constructor.
     */
    public static function trackingConstruct(stdClass $objTracking, int $contact_id, int $company_id) : Tracking
    {
        $Tracking = new Tracking();
        $Tracking->table = "$company_id";
        
        $Tracking->id =  $objTracking->pedidoID;
        $Tracking->contact_id = $contact_id;
        $Tracking->post_date = Carbon::createFromFormat('d/m/Y H:i', $objTracking->pedidoData)->toDateTimeString();
        // $Tracking->post_date =  Carbon::createFromFormat('d/m/Y H:i', $objTracking->pedidoData)->toFormattedDateString('Y-m-d H:i:s');
        // $Tracking->post_date =  (new Carbon($objTracking->envioData))->toFormattedDateString('Y-m-d H:i:s');
        $Tracking->tracking_code =  $objTracking->envioRastreamento;
        $Tracking->json_csv_data = json_encode($objTracking);
        $Tracking->status_id = StatusController::POSTED;

        return $Tracking;
    }

}

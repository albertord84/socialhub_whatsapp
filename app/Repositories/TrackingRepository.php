<?php

namespace App\Repositories;

use App\Models\Tracking;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TrackingRepository
 * @package App\Repositories
 * @version April 9, 2020, 6:00 pm -03
 *
 * @method Tracking findWithoutFail($id, $columns = ['*'])
 * @method Tracking find($id, $columns = ['*'])
 * @method Tracking first($columns = ['*'])
*/
class TrackingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_card',
        'post_date',
        'service_code',
        'items',
        'tracking_code',
        'json_csv_data',
        'status_id',
        'tracking_list'
    ];

    public function trackingByCompany($company_id, int $page = null, string $searchInput = '', $filterStatus=0, $betweenDates=null )
    {
        $Tracking = new Tracking();
        $Tracking->table = "$company_id";

        $page_length = env('APP_TRACKING_PAGE_LENGTH_FOR_MANAGER', 100);
        $start = $page_length * $page;

        /* FEITO já -:)
        TODO: los filtros por status y por fecha van a llegar asi hasta aqui
            filterStatus --> puede ser un numero del 1 al 7 (excepto 6 que no existe en la BD), o 0 si no se especifico status
            betweenDates --> puede ser un array (ex: betweenDates[0]='2020-04-29' y betweenDates[1]='2020-05-01']), o null
        */
        $Trackings = $Tracking
            ->where(function($query) use ($searchInput){
                if ($searchInput != '') {
                    $query
                        ->where('json_csv_data', 'LIKE', '%'. $searchInput.'%')
                        ->orWhere('tracking_code', 'LIKE', '%'. $searchInput.'%')
                        ->orWhere('tracking_list', 'LIKE', '%'. $searchInput.'%');
                }})
            ->where(function($query) use ($filterStatus){
                if ($filterStatus != 0) {
                    $query->where('status_id', '=', $filterStatus);
                }})
            ->where(function($query) use ($betweenDates){
                if ($betweenDates) {
                    $query
                        ->where('updated_at', '>=', $betweenDates[0].' 00:00:00')
                        ->where('updated_at', '<=', $betweenDates[1].' 00:00:00');
                }})
            ->orderBy('updated_at','desc')
            ->get()
            ->slice($start, $page_length)
            ->each(function(Tracking $tracking) {
                    $tracking->Contact = $tracking->contact()->first();
                    $tracking->last_tracking = $tracking->last_tracking();
                    $tracking->Status = $tracking->status()->first();
                });

        return $Trackings;
    }

    public function deleteTracking($tracking_id, $company_id = null){
        $trackingModel = new $this->model();
        $trackingModel->table = (string)$company_id;
        $sale = $trackingModel->findOrFail($tracking_id);
        return $sale->delete();
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tracking::class;
    }
}

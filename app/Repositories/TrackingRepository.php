<?php

namespace App\Repositories;

use App\Models\Tracking;
use Illuminate\Database\Eloquent\Collection;
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

    public function trackingByCompany($company_id, int $page = null): Collection
    {
        $Tracking = new Tracking();
        $Tracking->table = "$company_id";

        $page_length = env('APP_TRACKING_PAGE_LENGTH_FOR_MANAGER', 100);
        $start = $page_length * $page;
        
        return $Tracking->with(['contact', 'status'])->slice($start, $page_length)->all();
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tracking::class;
    }
}

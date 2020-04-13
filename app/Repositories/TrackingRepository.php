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
        'object_code',
        'json_csv_data',
        'status_id',
        'tracking_list'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tracking::class;
    }
}

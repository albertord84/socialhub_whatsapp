<?php

namespace App\Repositories;

use App\Models\Queue;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QueueRepository
 * @package App\Repositories
 * @version March 17, 2020, 5:34 pm -03
 *
 * @method Queue findWithoutFail($id, $columns = ['*'])
 * @method Queue find($id, $columns = ['*'])
 * @method Queue first($columns = ['*'])
*/
class QueueRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'contact_id',
        'attendant_id',
        'company_id',
        'source',
        'response_to',
        'message',
        'type_id',
        'data',
        'status_id',
        'socialnetwork_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Queue::class;
    }
}

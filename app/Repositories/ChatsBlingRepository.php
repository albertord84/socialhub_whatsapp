<?php

namespace App\Repositories;

use App\Models\ChatsBling;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ChatsBlingRepository
 * @package App\Repositories
 * @version February 14, 2020, 10:50 am -03
 *
 * @method ChatsBling findWithoutFail($id, $columns = ['*'])
 * @method ChatsBling find($id, $columns = ['*'])
 * @method ChatsBling first($columns = ['*'])
*/
class ChatsBlingRepository extends BaseRepository
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
        return ChatsBling::class;
    }
}

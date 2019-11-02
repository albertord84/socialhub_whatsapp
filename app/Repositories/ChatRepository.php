<?php

namespace App\Repositories;

use App\Models\Chat;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ChatRepository
 * @package App\Repositories
 * @version October 31, 2019, 4:12 pm UTC
 *
 * @method Chat findWithoutFail($id, $columns = ['*'])
 * @method Chat find($id, $columns = ['*'])
 * @method Chat first($columns = ['*'])
*/
class ChatRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'contact_id',
        'attendant_id',
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
        return Chat::class;
    }
}

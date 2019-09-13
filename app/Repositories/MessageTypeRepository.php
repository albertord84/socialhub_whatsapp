<?php

namespace App\Repositories;

use App\Models\MessageType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MessageTypeRepository
 * @package App\Repositories
 * @version September 13, 2019, 9:10 pm UTC
 *
 * @method MessageType findWithoutFail($id, $columns = ['*'])
 * @method MessageType find($id, $columns = ['*'])
 * @method MessageType first($columns = ['*'])
*/
class MessageTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MessageType::class;
    }
}

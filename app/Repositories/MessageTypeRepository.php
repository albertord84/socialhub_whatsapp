<?php

namespace App\Repositories;

use App\Models\MessageType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MessageTypeRepository
 * @package App\Repositories
 * @version September 13, 2019, 2:53 pm UTC
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
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MessageType::class;
    }
}

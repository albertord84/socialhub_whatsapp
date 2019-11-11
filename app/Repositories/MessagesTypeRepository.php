<?php

namespace App\Repositories;

use App\Models\MessagesType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MessagesTypeRepository
 * @package App\Repositories
 * @version November 7, 2019, 8:04 pm UTC
 *
 * @method MessagesType findWithoutFail($id, $columns = ['*'])
 * @method MessagesType find($id, $columns = ['*'])
 * @method MessagesType first($columns = ['*'])
*/
class MessagesTypeRepository extends BaseRepository
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
        return MessagesType::class;
    }
}

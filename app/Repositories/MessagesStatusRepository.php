<?php

namespace App\Repositories;

use App\Models\MessagesStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MessagesStatusRepository
 * @package App\Repositories
 * @version September 26, 2019, 1:32 am UTC
 *
 * @method MessagesStatus findWithoutFail($id, $columns = ['*'])
 * @method MessagesStatus find($id, $columns = ['*'])
 * @method MessagesStatus first($columns = ['*'])
*/
class MessagesStatusRepository extends BaseRepository
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
        return MessagesStatus::class;
    }
}

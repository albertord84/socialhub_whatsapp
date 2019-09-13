<?php

namespace App\Repositories;

use App\Models\Status;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StatusRepository
 * @package App\Repositories
 * @version September 13, 2019, 9:09 pm UTC
 *
 * @method Status findWithoutFail($id, $columns = ['*'])
 * @method Status find($id, $columns = ['*'])
 * @method Status first($columns = ['*'])
*/
class StatusRepository extends BaseRepository
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
        return Status::class;
    }
}

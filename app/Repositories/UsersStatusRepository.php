<?php

namespace App\Repositories;

use App\Models\UsersStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersStatusRepository
 * @package App\Repositories
 * @version September 26, 2019, 1:31 am UTC
 *
 * @method UsersStatus findWithoutFail($id, $columns = ['*'])
 * @method UsersStatus find($id, $columns = ['*'])
 * @method UsersStatus first($columns = ['*'])
*/
class UsersStatusRepository extends BaseRepository
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
        return UsersStatus::class;
    }
}

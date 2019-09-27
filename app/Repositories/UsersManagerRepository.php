<?php

namespace App\Repositories;

use App\Models\UsersManager;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersManagerRepository
 * @package App\Repositories
 * @version September 27, 2019, 5:07 pm UTC
 *
 * @method UsersManager findWithoutFail($id, $columns = ['*'])
 * @method UsersManager find($id, $columns = ['*'])
 * @method UsersManager first($columns = ['*'])
*/
class UsersManagerRepository extends BaseRepository
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
        return UsersManager::class;
    }
}

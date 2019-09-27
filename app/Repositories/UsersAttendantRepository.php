<?php

namespace App\Repositories;

use App\Models\UsersAttendant;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersAttendantRepository
 * @package App\Repositories
 * @version September 27, 2019, 5:06 pm UTC
 *
 * @method UsersAttendant findWithoutFail($id, $columns = ['*'])
 * @method UsersAttendant find($id, $columns = ['*'])
 * @method UsersAttendant first($columns = ['*'])
*/
class UsersAttendantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_manager_id',
        'code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UsersAttendant::class;
    }
}

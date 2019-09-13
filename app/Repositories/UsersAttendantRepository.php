<?php

namespace App\Repositories;

use App\Models\UsersAttendant;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersAttendantRepository
 * @package App\Repositories
 * @version September 13, 2019, 9:43 pm UTC
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

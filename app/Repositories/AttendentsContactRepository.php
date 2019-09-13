<?php

namespace App\Repositories;

use App\Models\AttendentsContact;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttendentsContactRepository
 * @package App\Repositories
 * @version September 13, 2019, 3:04 pm UTC
 *
 * @method AttendentsContact findWithoutFail($id, $columns = ['*'])
 * @method AttendentsContact find($id, $columns = ['*'])
 * @method AttendentsContact first($columns = ['*'])
*/
class AttendentsContactRepository extends BaseRepository
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
        return AttendentsContact::class;
    }
}

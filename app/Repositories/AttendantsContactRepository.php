<?php

namespace App\Repositories;

use App\Models\AttendantsContact;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttendantsContactRepository
 * @package App\Repositories
 * @version September 27, 2019, 3:37 pm UTC
 *
 * @method AttendantsContact findWithoutFail($id, $columns = ['*'])
 * @method AttendantsContact find($id, $columns = ['*'])
 * @method AttendantsContact first($columns = ['*'])
*/
class AttendantsContactRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'attendant_id',
        'contact_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttendantsContact::class;
    }
}

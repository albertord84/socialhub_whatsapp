<?php

namespace App\Repositories;

use App\Models\ContactsStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactsStatusRepository
 * @package App\Repositories
 * @version September 26, 2019, 1:32 am UTC
 *
 * @method ContactsStatus findWithoutFail($id, $columns = ['*'])
 * @method ContactsStatus find($id, $columns = ['*'])
 * @method ContactsStatus first($columns = ['*'])
*/
class ContactsStatusRepository extends BaseRepository
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
        return ContactsStatus::class;
    }
}

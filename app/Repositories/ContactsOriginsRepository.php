<?php

namespace App\Repositories;

use App\Models\ContactsOrigins;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactsOriginsRepository
 * @package App\Repositories
 * @version February 14, 2020, 12:59 am -03
 *
 * @method ContactsOrigins findWithoutFail($id, $columns = ['*'])
 * @method ContactsOrigins find($id, $columns = ['*'])
 * @method ContactsOrigins first($columns = ['*'])
*/
class ContactsOriginsRepository extends BaseRepository
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
        return ContactsOrigins::class;
    }
}

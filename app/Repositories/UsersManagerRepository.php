<?php

namespace App\Repositories;

use App\Models\UsersManager;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersManagerRepository
 * @package App\Repositories
 * @version September 13, 2019, 10:14 pm UTC
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
        'CNPJ',
        'whatsapp_id',
        'facebook_id',
        'instagram_id',
        'linkedin_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UsersManager::class;
    }
}

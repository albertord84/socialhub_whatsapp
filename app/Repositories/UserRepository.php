<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 3, 2020, 2:02 am -03
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'email',
        'whatsapp_id',
        'facebook_id',
        'instagram_id',
        'linkedin_id',
        'email_verified_at',
        'password',
        'remember_token',
        'login',
        'CPF',
        'phone',
        'image_path',
        'role_id',
        'status_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\PasswordReset;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PasswordResetRepository
 * @package App\Repositories
 * @version September 13, 2019, 9:13 pm UTC
 *
 * @method PasswordReset findWithoutFail($id, $columns = ['*'])
 * @method PasswordReset find($id, $columns = ['*'])
 * @method PasswordReset first($columns = ['*'])
*/
class PasswordResetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PasswordReset::class;
    }
}

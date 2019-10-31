<?php

namespace App\Repositories;

use App\Models\UsersSeller;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersSellerRepository
 * @package App\Repositories
 * @version October 30, 2019, 8:28 pm UTC
 *
 * @method UsersSeller findWithoutFail($id, $columns = ['*'])
 * @method UsersSeller find($id, $columns = ['*'])
 * @method UsersSeller first($columns = ['*'])
*/
class UsersSellerRepository extends BaseRepository
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
        return UsersSeller::class;
    }
}

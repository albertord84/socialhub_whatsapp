<?php

namespace App\Repositories;

use App\Models\Socialnetwork;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SocialnetworkRepository
 * @package App\Repositories
 * @version November 5, 2019, 12:50 am UTC
 *
 * @method Socialnetwork findWithoutFail($id, $columns = ['*'])
 * @method Socialnetwork find($id, $columns = ['*'])
 * @method Socialnetwork first($columns = ['*'])
*/
class SocialnetworkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Socialnetwork::class;
    }
}

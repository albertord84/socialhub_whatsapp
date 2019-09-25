<?php

namespace App\Repositories;

use App\Models\SystemConfig;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SystemConfigRepository
 * @package App\Repositories
 * @version September 13, 2019, 9:29 pm UTC
 *
 * @method SystemConfig findWithoutFail($id, $columns = ['*'])
 * @method SystemConfig find($id, $columns = ['*'])
 * @method SystemConfig first($columns = ['*'])
*/
class SystemConfigRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'value',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SystemConfig::class;
    }
}

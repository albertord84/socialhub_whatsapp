<?php

namespace App\Repositories;

use App\Models\Rpi;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RpiRepository
 * @package App\Repositories
 * @version November 30, 2019, 5:50 pm -03
 *
 * @method Rpi findWithoutFail($id, $columns = ['*'])
 * @method Rpi find($id, $columns = ['*'])
 * @method Rpi first($columns = ['*'])
*/
class RpiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'ip',
        'data',

        'api_user',
        'api_password',
        'root_user',
        'root_password',
        'tcp_tunnel',
        'tcp_port',
        'mac',
        'api_tunnel',
        'soft_version',
        'soft_version_date'

    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Rpi::class;
    }
}

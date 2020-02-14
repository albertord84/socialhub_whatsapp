<?php

namespace App\Repositories;

use App\Models\Bling;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BlingRepository
 * @package App\Repositories
 * @version February 14, 2020, 9:30 am -03
 *
 * @method Bling findWithoutFail($id, $columns = ['*'])
 * @method Bling find($id, $columns = ['*'])
 * @method Bling first($columns = ['*'])
*/
class BlingRepository extends BaseRepository
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
        return Bling::class;
    }
}

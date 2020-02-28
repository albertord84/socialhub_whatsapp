<?php

namespace App\Repositories;

use App\Models\Sales;
use Illuminate\Database\Eloquent\Collection;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SalesRepository
 * @package App\Repositories
 * @version February 14, 2020, 10:30 am -03
 *
 * @method Sales findWithoutFail($id, $columns = ['*'])
 * @method Sales find($id, $columns = ['*'])
 * @method Sales first($columns = ['*'])
*/
class SalesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'contact_id',
        'source',
        'sended',
        'json_data'
    ];


    public function salesByCompany($company_id)
    {
        $Sales = new Sales();
        $Sales->table = "$company_id";

        return $Sales->where('id', '!=', null)->get();
    }
    



    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sales::class;
    }
}

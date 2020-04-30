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


    public function salesByCompany($company_id, $page, $stringFilter)
    {
        $Sales = new Sales();
        $Sales->table = "$company_id";

        // $this->table = "$company_id";
        // return $this->get();
        // return $this->with(['contact'])->get();

        return $Sales->get();
        // return $Sales->with(['contact'])->get();
        // return $Sales->with('contact')->where('id', '!=', null)->get();
    }

    public function findSale($company_id, $sales_id){
        $saleModel = new $this->model();
        $saleModel->table = (string)$company_id;
        $saleModel->findOrFail($sales_id);
        return $saleModel;
    }

    public function updateSale($datas, $company_id, $sales_id){
        $saleModel = new $this->model();
        $saleModel->table = (string)$company_id;
        $sale = $saleModel->findOrFail($sales_id);
        // dd($datas);
        // dd($sale->json_data);
        $json_data = $datas["json_data"];
        $sale->json_data = $json_data;
        return $sale->save();
    }


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sales::class;
    }
}

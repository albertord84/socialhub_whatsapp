<?php

namespace App\Repositories;
use CreateSalesTable;
use App\Models\Bling;
use App\Models\Company;
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



    public function updateCompanyBlingIntegrationField(int $company_id, string $bling_apikey, string $bling_message)
    {
        $Company = Company::find($company_id);
        $Company->bling_apikey = $bling_apikey;
        $Company->bling_message = $bling_message;
        $Company->save();
        return $Company;
    }

    public function createCompanySalesTable(int $company_id)
    {
        try {
            $salesMigrationsDir = __DIR__.'/../../database/migrations/2020_02_14_104111_create_sales_table.php';
            require_once($salesMigrationsDir);
            $salesTable = new CreateSalesTable();
            $salesTable->up((string)$company_id);
        } catch (\Throwable $th) {
            var_dump($th);
            // print("Erro creating Attendant Chat Table...! " + $th);
            throw $th;
        }
    }


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bling::class;
    }
}

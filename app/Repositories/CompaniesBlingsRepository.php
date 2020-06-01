<?php

namespace App\Repositories;

use App\Models\CompaniesBlings;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CompaniesBlingsRepository
 * @package App\Repositories
 * @version May 20, 2020, 10:56 am -03
 *
 * @method CompaniesBlings findWithoutFail($id, $columns = ['*'])
 * @method CompaniesBlings find($id, $columns = ['*'])
 * @method CompaniesBlings first($columns = ['*'])
*/
class CompaniesBlingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'bling_username',
        'bling_apikey',
        'bling_message',
        'bling_contrated'
    ];

    public function saveCompanyBling($input)
    {
        $companiesBlings = $this->model->where('company_id', $input['company_id'])->where('bling_username',  $input['bling_username'])->get()->first();
        if(!$companiesBlings){
            $companiesBlings = $this->create($input);
        } else{
            $companiesBlings = $this->update($input, $companiesBlings->id);
        }

        return $companiesBlings;
    }



    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompaniesBlings::class;
    }
}

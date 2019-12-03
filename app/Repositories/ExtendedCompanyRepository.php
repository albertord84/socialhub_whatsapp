<?php

namespace App\Repositories;

use App\Models\Company;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CompanyRepository
 * @package App\Repositories
 * @version September 27, 2019, 5:24 pm UTC
 *
 * @method Company findWithoutFail($id, $columns = ['*'])
 * @method Company find($id, $columns = ['*'])
 * @method Company first($columns = ['*'])
*/
class ExtendedCompanyRepository extends CompanyRepository
{
    
    protected $fieldSearchable = [
        'CNPJ',
        'name',
        'phone',
        'email',
        'description',
        'user_seller_id'
    ];

    
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }
}

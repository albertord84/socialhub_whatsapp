<?php

namespace App\Repositories;

use App\Models\Company;

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
    
    public function allBySeller(int $seller_id = null)
    {
        $Attentands = $this->findWhere(['user_seller_id' => $seller_id]);
    
        return $Attentands;
    }

    
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }
}

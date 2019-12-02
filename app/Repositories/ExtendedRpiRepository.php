<?php

namespace App\Repositories;

use App\Models\Rpi;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RpiRepository
 * @package App\Repositories
 * @version November 30, 2019, 4:31 pm -03
 *
 * @method Rpi findWithoutFail($id, $columns = ['*'])
 * @method Rpi find($id, $columns = ['*'])
 * @method Rpi first($columns = ['*'])
*/
class ExtendedRpiRepository extends RpiRepository
{
    
    public function rpiOfCompany(int $company_id): Collection
    {
        $pri = $this->findWhere(['company_id' => $company_id]);

        return $pri;
    }


    public function model()
    {
        return Rpi::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Rpi;
use Illuminate\Database\Eloquent\Collection;

use function React\Promise\Stream\first;

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
    
    public function rpiOfCompany(int $company_id): ?Rpi
    {
        $pri = $this->findWhere(['company_id' => $company_id])->first();

        return $pri;
    }


    public function model()
    {
        return Rpi::class;
    }
}

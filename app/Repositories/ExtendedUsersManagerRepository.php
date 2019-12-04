<?php

namespace App\Repositories;

use App\Models\ExtendedUsersManager;
use App\Models\UsersManager;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Database\Eloquent\Collection;



/**
 * Class UsersManagerRepository
 * @package App\Repositories
 * @version September 27, 2019, 5:26 pm UTC
 *
 * @method UsersManager findWithoutFail($id, $columns = ['*'])
 * @method UsersManager find($id, $columns = ['*'])
 * @method UsersManager first($columns = ['*'])
*/
class ExtendedUsersManagerRepository extends UsersManagerRepository
{
    
    public function Managers_User(int $company_id)
    {
        
        $role_id = 3;

        $Manager = $this->with('user')->whereHas('user', function($q) use ($company_id, $role_id) {
            $q->where(['company_id' => $company_id, 'role_id' => $role_id]);
        })->get();  

        return $Manager;
    }

    public function model()
    {
        // return UsersManager::class;
        return ExtendedUsersManager::class;
    }

}

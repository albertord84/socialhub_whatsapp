<?php

namespace App\Repositories;

use CreateChatsTable;
use App\Models\UsersSeller;
use App\Models\UsersStatus;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UsersSellerRepository
 * @package App\Repositories
 * @version October 30, 2019, 8:28 pm UTC
 *
 * @method UsersSeller findWithoutFail($id, $columns = ['*'])
 * @method UsersSeller find($id, $columns = ['*'])
 * @method UsersSeller first($columns = ['*'])
*/

/**
 * Class ExtendedUsersSellerRepository
*/
class ExtendedUsersSellerRepository extends UsersSellerRepository
{

    public function Sellers_User(): Collection
    {
        $Sellers = $this->with(['User'])->get();

        return $Sellers;
    }

    public function createSellerChatTable(int $SellerId)
    {
        try {
            $chatsMigrationsDir = __DIR__.'/../../database/migrations/2019_09_13_003_create_chats_table.php';
            require_once($chatsMigrationsDir);

            $chatsTable = new CreateChatsTable();
            $chatsTable->up((string)$SellerId);
        } catch (\Throwable $th) {
            print("Erro creating Seller Chat Table...! " + $th);
            throw $th;
        }
    }

}

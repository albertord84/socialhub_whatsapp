<?php

namespace App\Repositories;

use CreateChatsTable;
use Illuminate\Database\Eloquent\Collection;
/**
 * Class ExtendedUsersAttendantRepository
 */
class ExtendedUsersAttendantRepository extends UsersAttendantRepository
{
    public function Attendants_User(int $manager_id): Collection
    {
        $Attentands = $this->with('User')->findWhere(['user_manager_id' => $manager_id]);

        return $Attentands;
    }

    public function Attendants_User_By_Attendant(int $company_id, int $role_id): Collection
    {
        $Attentands = $this->with('User')->findWhere(['company_id' => $company_id, 'role_id'=>$role_id]);

        return $Attentands;
    }

    public function createAttendantChatTable(int $attendantId)
    {
        try {
            $chatsMigrationsDir = __DIR__.'/../../database/migrations/2019_09_13_003_create_chats_table.php';
            require_once($chatsMigrationsDir);

            $chatsTable = new CreateChatsTable();
            $chatsTable->up((string)$attendantId);
        } catch (\Throwable $th) {
            print("Erro creating Attendant Chat Table...! " + $th);
            throw $th;
        }
    }

}

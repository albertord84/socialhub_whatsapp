<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Http\Controllers\ExtendedUsersManagerController;
use App\Models\UsersManager;
use App\Repositories\ExtendedUsersManagerRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExtendedUsersManagerControllerTest extends MyTestCase
{

    public function testRouteUsersManagersReturns1ManagersForCompany1()
    {
        $manager_id = 3;

        $Manager = User::find($manager_id);

        Auth::login($Manager);

        $response = $this->get('/usersManagers');
        $responseContent = $response->getContent();
        $Managers = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(1, count($Managers));
    }
    
    public function testRoutePostUsersManagerReturnsCreatedUser()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        if ($UsersManager = UsersManager::find(4)) {
            $UsersManager->delete();
        }
        $UsersManager = new UsersManager();
        $UsersManager->user_id = 4;
        // Delete Mocked
        $UsersManager->delete();
        
        $response = $this->be($Manager)->post('/usersManagers', $UsersManager->toArray());
        if ($UsersManager = UsersManager::find(4)) { // Delete created user
            $UsersManager->delete();
        }
        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertEquals($UsersManager->user_id, $responseUser->id); // Expected to be the next to be inserted  
    }    

    public function testRoutePutUsersManagerReturnsUpdatedUser()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        if ($UsersManager = UsersManager::find(4)) {
            $UsersManager->delete();
        }
        $UsersManager = new UsersManager();
        $UsersManager->user_id = 4;
        $UsersManager->save();
        $UsersManager->user_id = 4;  // User Id get lost after save()
        
        $UsersManagerArray = $UsersManager->toArray();
        $UsersManagerArray['user_id'] = 5;

        $response = $this->be($Manager)->put("/usersManagers/$UsersManager->user_id", $UsersManagerArray);
        $response->assertSuccessful();
        UsersManager::find($UsersManagerArray['user_id'])->delete();
        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);

        $this->assertJson($responseContent);
        $this->assertEquals($UsersManagerArray['user_id'], $responseUser->user_id); // Expected to be the next to be inserted  
    }

    public function testRouteDestroyUsersManagerReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        if ($UsersManager = UsersManager::find(4)) {
            $UsersManager->delete();
        }
        $UsersManager = new UsersManager();
        $UsersManager->user_id = 4;  // carefulll, its taking 0 after save()
        $UsersManager->save();

        $response = $this->be($Manager)->delete("/usersManagers/4");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(UsersManager::find(4));
    }

}

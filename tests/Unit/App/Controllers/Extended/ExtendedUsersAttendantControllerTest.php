<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Http\Controllers\ExtendedUsersAttendantController;
use App\Models\UsersAttendant;
use App\Repositories\ExtendedUsersAttendantRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExtendedUsersAttendantControllerTest extends MyTestCase
{

    public function testRouteUsersAttendantsReturns2AttendantsForCompany1()
    {
        $manager_id = 3;

        $Manager = User::find($manager_id);

        Auth::login($Manager);

        $response = $this->get('/usersAttendants');
        $responseContent = $response->getContent();
        $attendants = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(2, count($attendants));
    }
    
    public function testModelUsersAttendantsReturns2AttendantsForCompany1()
    {
        $company_id = 1;

        $attendants = UsersAttendant::with('user')->whereHas('user', function ($query) use ($company_id) {
            $query->where(['company_id' => $company_id]);
        })->get();

        $this->assertGreaterThanOrEqual(2, count($attendants));
    }

    public function testControllerUsersAttendantsReturns2AttendantsForCompany1()
    {
        $manager_id = 3;

        $Manager = User::find($manager_id);

        Auth::login($Manager);

        $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
        $ExtendedUsersAttendantController = new ExtendedUsersAttendantController($ExtendedUsersAttendantRepository);
        $Request = new Request();
        $response = $ExtendedUsersAttendantController->index($Request);
        $attendants = json_decode($response);

        $this->assertJson($response);
        $this->assertGreaterThanOrEqual(2, count($attendants));
    }
    
    public function testRoutePostUsersAttendantReturnsCreatedUser()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        if ($UsersAttendant = UsersAttendant::find($manager_id)) {
            $UsersAttendant->delete();
        }
        $UsersAttendant = new UsersAttendant();
        $UsersAttendant->user_id = $manager_id;
        $UsersAttendant->user_manager_id = $manager_id;
        $UsersAttendant->selected_contact_id = 1;
        // Delete Mocked
        $UsersAttendant->delete();
        
        $response = $this->be($Manager)->post('/usersAttendants', $UsersAttendant->toArray());
        if ($UsersAttendant = UsersAttendant::find($manager_id)) { // Delete created user
            $UsersAttendant->delete();
        }
        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertEquals($UsersAttendant->user_id, $responseUser->id); // Expected to be the next to be inserted  
        $this->assertEquals($UsersAttendant->user_manager_id, $UsersAttendant->refresh()->user_manager_id);
        $this->assertEquals($UsersAttendant->selected_contact_id, $UsersAttendant->refresh()->selected_contact_id);

    }    

    public function testRoutePutUsersAttendantReturnsUpdatedUser()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        if ($UsersAttendant = UsersAttendant::find($manager_id)) {
            $UsersAttendant->delete();
        }
        $UsersAttendant = new UsersAttendant();
        $UsersAttendant->user_id = $manager_id;
        $UsersAttendant->user_manager_id = $manager_id;
        $UsersAttendant->selected_contact_id = 1;
        $UsersAttendant->save();
        $UsersAttendant->user_id = $manager_id;  // User Id get lost after save()
        
        $UsersAttendantArray = $UsersAttendant->toArray();
        $UsersAttendantArray['user_id'] = 1;
        $UsersAttendantArray['user_manager_id'] = 1;
        $UsersAttendantArray['selected_contact_id'] = 2;

        $response = $this->be($Manager)->put("/usersAttendants/$UsersAttendant->user_id", $UsersAttendantArray);
        $response->assertSuccessful();
        UsersAttendant::find($UsersAttendantArray['user_id'])->delete();
        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);

        $this->assertJson($responseContent);
        $this->assertEquals($UsersAttendantArray['user_id'], $responseUser->user_id); // Expected to be the next to be inserted  
        $this->assertEquals($UsersAttendantArray['user_manager_id'], $responseUser->user_manager_id);
        $this->assertEquals($UsersAttendantArray['selected_contact_id'], $responseUser->selected_contact_id);
    }

    public function testRouteDestroyUsersAttendantReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        // Create Mock User Into DB Test
        if ($UsersAttendant = UsersAttendant::find($manager_id)) {
            $UsersAttendant->delete();
        }
        $UsersAttendant = new UsersAttendant();
        $UsersAttendant->user_id = $manager_id;  // carefulll, its taking 0 after save()
        $UsersAttendant->user_manager_id = $manager_id;
        $UsersAttendant->selected_contact_id = 1;
        $UsersAttendant->save();

        $response = $this->be($Manager)->delete("/usersAttendants/$manager_id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(UsersAttendant::find($manager_id));
    }

}

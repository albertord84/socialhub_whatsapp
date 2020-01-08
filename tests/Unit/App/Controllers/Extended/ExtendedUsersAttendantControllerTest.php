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
        $this->assertCount(2, $attendants);
    }
    
    public function testModelUsersAttendantsReturns2AttendantsForCompany1()
    {
        $company_id = 1;

        $attendants = UsersAttendant::with('user')->whereHas('user', function ($query) use ($company_id) {
            $query->where(['company_id' => $company_id]);
        })->get();

        $this->assertCount(2, $attendants);
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
        $this->assertCount(2, $attendants);
    }

    public function testRoutePostUsersAttendantReturnsCreatedUser()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        $User = new UsersAttendant();
        // Delete Mocked
        $User->delete();

        // Insert Mocked throw /users Post
        $response = $this->be($Manager)->post('/users', $User->toArray());

        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertEquals($User->id+1, $responseUser->id); // Expected to be the next to be inserted  
        $this->assertEquals($User->email, $responseUser->email);
        $this->assertEquals($User->password, $responseUser->password);
        $this->assertEquals($User->company_id, $responseUser->company_id);

    }    
}

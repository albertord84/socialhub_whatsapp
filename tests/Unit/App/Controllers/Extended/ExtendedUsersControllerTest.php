<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExtendedUsersControllerTest extends MyTestCase
{

    public function testRouteUsersReturnsSixOrMoreUsers()
    {
        $manager_id = 3;

        $Manager = User::find($manager_id);

        Auth::login($Manager);

        $response = $this->be($Manager)->get('/users');
        $responseContent = $response->getContent();
        $users = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(6, count($users));
    }

}

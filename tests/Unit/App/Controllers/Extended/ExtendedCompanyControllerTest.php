<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExtendedCompanyControllerTest extends MyTestCase
{

    public function testRouteCompaniesReturnsOneOrMoreCompaniesForSeller()
    {
        $Admin_id = 1;

        $Admin = User::find($Admin_id);

        Auth::login($Admin);

        $response = $this->be($Admin)->get('/companies');
        $responseContent = $response->getContent();
        $companies = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(1, count($companies));
    }

    public function testRouteCompaniesGetNullForNormalUser()
    {
        $User_id = 4;

        $User = User::find($User_id);

        Auth::login($User);

        $response = $this->be($User)->get('/companies');
        $responseContent = $response->getContent();
        $companies = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
    }

}

<?php

namespace Tests\Apis\Rpi;

use App\Http\Controllers\ExternalRPIController;
use App\Models\Rpi;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExternalRpiControllerTest extends MyTestCase
{

    // public function testRouteRpisReturnsOneOrMoreRpisForSeller()
    // {
    //     $Manager_id = 3;

    //     $Manager = User::find($Manager_id);

    //     Auth::login($Manager);

    //     $response = $this->be($Manager)->get('/rpis');
    //     $responseContent = $response->getContent();
    //     $Rpi = json_decode($responseContent);

    //     $response->assertSuccessful();
    //     $this->assertJson($responseContent);
    //     $this->assertEquals(1, $Rpi->id);
    // }

    public function testRouteLogoutRpi()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = Rpi::find(1);
        // $Rpi->api_tunnel = url('/') . '/RPI/tests';

        $response = ExternalRPIController::logout($Rpi);
        $this->assertJson($response);
        $responseJson = json_decode($response);

        $this->assertEquals('Logout feito', $responseJson->Message);
    }

}

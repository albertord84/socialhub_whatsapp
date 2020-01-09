<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Models\Rpi;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExtendedRpiControllerTest extends MyTestCase
{

    public function newMockObject()
    {
        // Create Mock Into DB Test
        $Rpi = new Rpi();
        $Rpi->id = 100;
        $Rpi->mac = '77:77:77:77';
        $Rpi->api_tunnel = 'http://shrpialberto.sa.ngrok.io.ngrok.io';
        $Rpi->soft_version = '7.7';

        return $Rpi;
    }

    public function testRouteRpisReturnsOneOrMoreRpisForSeller()
    {
        $Admin_id = 1;

        $Admin = User::find($Admin_id);

        Auth::login($Admin);

        $response = $this->be($Admin)->get('/rpis');
        $responseContent = $response->getContent();
        $Rpi = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertEquals(1, $Rpi->id);
    }

    // public function testRouteRpisGetNullForNormalUser()
    // {
    //     $User_id = 4;

    //     $User = User::find($User_id);

    //     Auth::login($User);

    //     $response = $this->be($User)->get('/rpis');

    //     $response->assertSeeText('Method not allowed to user');
    // }

    public function testRoutePostRpiReturnsCreatedRpi()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = $this->newMockObject();

        $response = $this->be($Manager)->post('/rpis', $Rpi->toArray());
        $response->assertSuccessful();
        $responseContent = $response->getContent();

        $responseRpi = json_decode($responseContent);
        if ($Rpi = Rpi::find($responseRpi->id)) { // Delete created user
            $Rpi->delete();
        }
        $this->assertJson($responseContent);
        $this->assertEquals($Rpi->mac, $responseRpi->mac); // Expected to be the next to be inserted
        $this->assertEquals($Rpi->api_tunnel, $responseRpi->api_tunnel);
        $this->assertEquals($Rpi->soft_version, $responseRpi->soft_version);

    }

    public function testRoutePutRpiReturnsUpdatedRpi()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Rpi = Rpi::find(100)) { // Delete created user
            $Rpi->delete();
        }
        $Rpi = $this->newMockObject();
        $Rpi->save();

        $RpiArray = $Rpi->toArray();
        $RpiArray['id'] = 100;
        $RpiArray['mac'] = '77:77:77:77';
        $RpiArray['api_tunel'] = 'new api tunel';
        $RpiArray['soft_version'] = '7.7';

        $response = $this->be($Manager)->put("/rpis/" . $RpiArray['id'], $RpiArray);
        $response->assertSuccessful();
        $responseContent = $response->getContent();
        $responseRpi = json_decode($responseContent);
        $Rpi->delete();

        $this->assertJson($responseContent);
        $this->assertEquals($RpiArray['id'], $responseRpi->id); // Expected to be the next to be inserted
        $this->assertEquals($RpiArray['mac'], $responseRpi->mac);
        $this->assertEquals($RpiArray['api_tunnel'], $responseRpi->api_tunnel);
        $this->assertEquals($RpiArray['soft_version'], $responseRpi->soft_version);
    }

    public function testRouteDestroyRpiReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Rpi = Rpi::find(100)) { // Delete created user
            $Rpi->delete();
        }
        $Rpi = $this->newMockObject();
        $Rpi->save();

        $response = $this->be($Manager)->delete("/rpis/$Rpi->id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(Rpi::find($Rpi->id));
    }

}

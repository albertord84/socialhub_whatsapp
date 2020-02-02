<?php

namespace Tests\Apis\Rpi;

use App\Http\Controllers\ExternalRPIController;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Rpi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\MyTestCase;

/**
 * The RPi NGrok has the altered his URL (ended with /tests) to call 
 * the ExternalRPIController@tests and return the RPi simulated answer!
 * Ex: calling /tests/logout returns '{"message": "Logout feito"}';
 */
class ExternalRpiControllerTest extends MyTestCase
{

    public function testRouteUpdateRpiRegisterNewRPI()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Request = new Request();
        $Request->MAC = '77:77:77:77';
        $Request->user = 'user';
        $Request->password = 'password';

        $ExternalRPIController = new ExternalRPIController();
        $response = $ExternalRPIController->update($Request);
        $this->assertEquals('null', $response);

        $Rpi = Rpi::whereMac($Request->MAC)->first();
        !$Rpi?: $Rpi->delete();

        $this->assertEquals('user', $Rpi->api_user);
        $this->assertEquals('password', $Rpi->api_password);
    }

    public function testRouteUpdateRpiUpdateExisting()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = Rpi::find(1);

        $Request = new Request();
        $Request->MAC = $Rpi->mac;
        $Request->user = 'new user';
        $Request->password = 'new password';

        $ExternalRPIController = new ExternalRPIController();
        $response = $ExternalRPIController->update($Request);
        $this->assertJson($response);
        $responseJson = json_decode($response);
        
        $RpiUpdated = Rpi::find($responseJson->rpi_id)->first();
        $RpiUpdated->api_user = $Rpi->api_user;
        $RpiUpdated->api_password = $Rpi->api_password;
        $RpiUpdated->save();

        $this->assertEquals($Request->MAC, $responseJson->rpi->mac);
        $this->assertEquals('new user', $Request->user);
        $this->assertEquals('new password', $Request->password);
    }

    public function testRouteLogoutRpi()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = Rpi::find(1);

        $response = ExternalRPIController::logout($Rpi);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertEquals('Logout feito', $response->message);
    }

    public function testRouteUpdateRpi()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = Rpi::find(1);

        $response = ExternalRPIController::sai_rpi_to_update($Rpi);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertEquals('Atualizado', $response->message);
    }

    public function testRouteLoggedInRpi()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Request = new Request();
        $Request->CompanyPhone = '5521965536174@c.us';

        $ExternalRPIController = new ExternalRPIController();
        $response = $ExternalRPIController->loggedin($Request);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('LoggedUser', $response);
        $this->assertEquals($manager_id, $response->LoggedUser->id);
    }

    public function testRouteQrCodeRpi()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Request = new Request();
        $Request->CompanyPhone = '5521965536174@c.us';

        $Rpi = Rpi::find(1);

        $response = ExternalRPIController::getQRCode($Rpi);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertEquals('Ja logado', $response->message);
    }

    public function testRouteGetContactInfo()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = Rpi::find(1);

        $CompanyPhone = '5521965536174@c.us';

        $ExternalRPIController = new ExternalRPIController();
        $response = $ExternalRPIController->getContactInfo($CompanyPhone, $Rpi);
        $this->assertJson($response);
        $response = json_decode($response);

        $this->assertObjectHasAttribute('name', $response);
        $this->assertObjectHasAttribute('picurl', $response);
    }

    public function testRouteSendTextMessage()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Rpi = Rpi::find(1);

        $Contact = Contact::find(1);

        $ExternalRPIController = new ExternalRPIController();
        $response = $ExternalRPIController->sendTextMessage("Test Message", $Contact);
        $this->assertJson($response);
        $response = json_decode($response);

        $this->assertObjectHasAttribute('MsgID', $response);
        $this->assertEquals('MsgID', $response->MsgID);
    }

    public function testRouteReciveTextMessage()
    {
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        $Request = new Request();
        $Request['Jid'] = '5521965536174@s.whatsapp.net';
        $Request['CompanyPhone'] = '5521965536174@c.us';
        $Request['Type'] = 'text';
        $Request['Msg'] = 'test message';
        $Request['Testing'] = true;

        $ExternalRPIController = new ExternalRPIController();
        $response = $ExternalRPIController->reciveTextMessage($Request);
        $this->assertJson($response);
        $response = json_decode($response);

        $Chat = Chat::find($response->id);
        !$Chat?: $Chat->delete();

        $this->assertObjectHasAttribute('id', $response);
        $this->assertObjectHasAttribute('message', $response);
        $this->assertEquals('test message', $response->message);
    }

}

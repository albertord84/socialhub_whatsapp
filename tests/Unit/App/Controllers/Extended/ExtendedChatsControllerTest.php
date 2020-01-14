<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Http\Controllers\ExtendedChatController;
use App\Http\Controllers\ExtendedRpiController;
use App\Http\Controllers\ExternalRPIController;
use App\Models\Chat;
use App\Models\Contact;
use App\Repositories\ExtendedChatRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\MyTestCase;

class ExtendedChatControllerTest extends MyTestCase
{
    private $ChatModel;

    public function newMockObject(bool $save = false)
    {
        $this->ChatModel = new Chat();
        $this->ChatModel->connection = 'socialhub_mvp.chats.test';
        $this->ChatModel->table = 'chats';

        // Create Mock Into DB Test
        if ($save && $Chat = $this->ChatModel->find(100)) $Chat->delete();
        $Chat = $this->ChatModel;
        $Chat->id = 100;
        $Chat->attendant_id = 4;
        $Chat->contact_id = 1;
        $Chat->company_id = 1;
        $Chat->message = 'Message Test';

        if ($save) $Chat->save();

        return $Chat;
    }

    public function testRouteChatReturnsOneOrMoreChatForSeller()
    {
        $Attenndant_id = 4;
        $Attenndant = User::find($Attenndant_id);
        Auth::login($Attenndant);

        $response = $this->be($Attenndant)->get('/chats?contact_id=1');
        $responseContent = $response->getContent();
        $Chats = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(5, count($Chats));
    }

    public function testRoutePostChatReturnsCreatedChat()
    {
        $Attenndant_id = 4;
        $Attenndant = User::find($Attenndant_id);
        Auth::login($Attenndant);

        // Create Mock Into DB Test
        $Chat = $this->newMockObject();

        $mockExternalRPIController = Mockery::mock(ExternalRPIController::class);
        $mockExternalRPIController->shouldReceive('sendTextMessage')
                                ->with(Mockery::any(), Mockery::any())
                                ->once()
                                ->andReturn('{"MsgID": "msgIdTest"}');

        $ExtendedChatRepository = new ExtendedChatRepository(app());
        $ExtendedChatController = new ExtendedChatController($ExtendedChatRepository, $mockExternalRPIController);
        $this->app->instance(ExtendedChatController::class, $ExtendedChatController);
        $response = $this->be($Attenndant)->post('/chats', $Chat->toArray());
        $response->assertSuccessful();
        
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseChat = json_decode($responseContent);
        
        $this->ChatModel->table = 4;
        if ($Chat = $this->ChatModel->find($responseChat->id)) { // Delete created chat
            $Chat->delete();
        }
        $this->assertEquals($Chat->attendant_id, $responseChat->attendant_id); // Expected to be the next to be inserted  
        $this->assertEquals($Chat->contact_id, $responseChat->contact_id);

    }    

    public function testRoutePutChatReturnsUpdatedChat()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Chat = Chat::find(100)) { // Delete created chat
            $Chat->delete();
        }
        $Chat = $this->newMockObject(true);
        
        $ChatArray = $Chat->toArray();
        $ChatArray['id'] = 100;
        $ChatArray['attendant_id'] = 5;
        $ChatArray['contact_id'] = 2;
        
        $response = $this->be($Manager)->put("/chats/".$ChatArray['id'], $ChatArray);
        $response->assertSuccessful();
        $Chat->delete();
        $responseContent = $response->getContent();
        $responseChat = json_decode($responseContent);

        $this->assertJson($responseContent);
        $this->assertEquals($ChatArray['id'], $responseChat->id); // Expected to be the next to be inserted  
        $this->assertEquals($ChatArray['attendant_id'], $responseChat->attendant_id); // Expected to be the next to be inserted  
        $this->assertEquals($ChatArray['contact_id'], $responseChat->contact_id);
    }

    public function testRouteDestroyChatReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        $Chat = $this->newMockObject(true);

        $response = $this->be($Manager)->delete("/chats/$Chat->id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(Chat::find($Chat->id));
    }

}

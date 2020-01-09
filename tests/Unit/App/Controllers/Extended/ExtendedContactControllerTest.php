<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Models\Contact;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\MyTestCase;

class ExtendedContactControllerTest extends MyTestCase
{

    public function newMockObject()
    {
        // Create Mock Into DB Test
        $Contact = new Contact();
        $Contact->id = 100;
        $Contact->first_name = 'Alberto teste';
        $Contact->company_id = 1;
        $Contact->whatsapp_id = 'whatsapp_id test';

        return $Contact;
    }

    public function testRouteContactReturnsOneOrMoreContactForSeller()
    {
        $Admin_id = 1;

        $Admin = User::find($Admin_id);

        Auth::login($Admin);

        $response = $this->be($Admin)->get('/contacts');
        $responseContent = $response->getContent();
        $Contacts = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(10, count($Contacts));
    }

    public function testRoutePostContactReturnsCreatedContact()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        $Contact = $this->newMockObject();

        $response = $this->be($Manager)->post('/contacts', $Contact->toArray());
        $response->assertSuccessful();
        $responseContent = $response->getContent();
        
        $responseContact = json_decode($responseContent);
        if ($Contact = Contact::find($responseContact->id)) { // Delete created user
            $Contact->delete();
        }
        $this->assertJson($responseContent);
        $this->assertEquals($Contact->first_name, $responseContact->first_name); // Expected to be the next to be inserted  
        $this->assertEquals($Contact->company_id, $responseContact->company_id);
        $this->assertEquals($Contact->whatsapp_id, $responseContact->whatsapp_id);

    }    

    public function testRoutePutContactReturnsUpdatedContact()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Contact = Contact::find(100)) { // Delete created user
            $Contact->delete();
        }
        $Contact = $this->newMockObject();
        $Contact->save();
        
        $ContactArray = $Contact->toArray();
        $ContactArray['id'] = 100;
        $ContactArray['first_name'] = 'Test Contact new';
        $ContactArray['company_id'] = 1;
        $ContactArray['whatsapp_id'] = 'new whatsapp_id';
        
        $response = $this->be($Manager)->put("/contacts/".$ContactArray['id'], $ContactArray);
        $response->assertSuccessful();
        $Contact->delete();
        $responseContent = $response->getContent();
        $responseContact = json_decode($responseContent);

        $this->assertJson($responseContent);
        $this->assertEquals($ContactArray['id'], $responseContact->id); // Expected to be the next to be inserted  
        $this->assertEquals($ContactArray['first_name'], $responseContact->first_name); // Expected to be the next to be inserted  
        $this->assertEquals($ContactArray['company_id'], $responseContact->company_id);
        $this->assertEquals($ContactArray['whatsapp_id'], $responseContact->whatsapp_id);
    }

    public function testRouteDestroyContactReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($Contact = Contact::find(100)) { // Delete created user
            $Contact->delete();
        }
        $Contact = $this->newMockObject();
        $Contact->save();

        $response = $this->be($Manager)->delete("/contacts/$Contact->id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(Contact::find($Contact->id));
    }

}

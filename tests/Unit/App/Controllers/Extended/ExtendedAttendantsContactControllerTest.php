<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\Models\AttendantsContact;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class ExtendedAttendantsContactControllerTest extends MyTestCase
{

    public function newMockObject()
    {
        // Create Mock Into DB Test
        $AttendantsContact = new AttendantsContact();
        $AttendantsContact->id = 100;
        $AttendantsContact->attendant_id = 4;
        $AttendantsContact->contact_id = 1;

        return $AttendantsContact;
    }

    public function testRouteAttendantsContactReturnsOneOrMoreAttendantsContactForSeller()
    {
        $Admin_id = 1;

        $Admin = User::find($Admin_id);

        Auth::login($Admin);

        $response = $this->be($Admin)->get('/attendantsContacts');
        $responseContent = $response->getContent();
        $AttendantsContacts = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertGreaterThanOrEqual(10, count($AttendantsContacts));
    }

    public function testRoutePostAttendantsContactReturnsCreatedAttendantsContact()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        $AttendantsContact = $this->newMockObject();

        $response = $this->be($Manager)->post('/attendantsContacts', $AttendantsContact->toArray());
        $response->assertSuccessful();
        $responseContent = $response->getContent();
        
        $responseAttendantsContact = json_decode($responseContent);
        if ($AttendantsContact = AttendantsContact::find($responseAttendantsContact->id)) { // Delete created user
            $AttendantsContact->delete();
        }
        $this->assertJson($responseContent);
        $this->assertEquals($AttendantsContact->attendant_id, $responseAttendantsContact->attendant_id); // Expected to be the next to be inserted  
        $this->assertEquals($AttendantsContact->contact_id, $responseAttendantsContact->contact_id);

    }    

    public function testRoutePutAttendantsContactReturnsUpdatedAttendantsContact()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($AttendantsContact = AttendantsContact::find(100)) { // Delete created user
            $AttendantsContact->delete();
        }
        $AttendantsContact = $this->newMockObject();
        $AttendantsContact->save();
        
        $AttendantsContactArray = $AttendantsContact->toArray();
        $AttendantsContactArray['id'] = 100;
        $AttendantsContactArray['attendant_id'] = 5;
        $AttendantsContactArray['contact_id'] = 2;
        
        $response = $this->be($Manager)->put("/attendantsContacts/".$AttendantsContactArray['id'], $AttendantsContactArray);
        $response->assertSuccessful();
        $AttendantsContact->delete();
        $responseContent = $response->getContent();
        $responseAttendantsContact = json_decode($responseContent);

        $this->assertJson($responseContent);
        $this->assertEquals($AttendantsContactArray['id'], $responseAttendantsContact->id); // Expected to be the next to be inserted  
        $this->assertEquals($AttendantsContactArray['attendant_id'], $responseAttendantsContact->attendant_id); // Expected to be the next to be inserted  
        $this->assertEquals($AttendantsContactArray['contact_id'], $responseAttendantsContact->contact_id);
    }

    public function testRouteDestroyAttendantsContactReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock Into DB Test
        if ($AttendantsContact = AttendantsContact::find(100)) { // Delete created user
            $AttendantsContact->delete();
        }
        $AttendantsContact = $this->newMockObject();
        $AttendantsContact->save();

        $response = $this->be($Manager)->delete("/attendantsContacts/$AttendantsContact->id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(AttendantsContact::find($AttendantsContact->id));
    }

}

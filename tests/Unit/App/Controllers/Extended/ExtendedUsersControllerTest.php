<?php

namespace Tests\Unit\App\Controllers\Extended;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\MyTestCase;

class ExtendedUsersControllerTest extends MyTestCase
{

    public function testRouteGetUsersReturnsSixOrMoreUsers()
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

    public function testRoutePostUsersReturnsCreatedUser()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        $User = factory(User::class)->create([
            'company_id' => 1,
            'password' => 'i-love-laravel',
        ]);
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

    public function testRoutePutUsersReturnsUpdatedUser_WhitoutPasswordUpdate()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        $User = factory(User::class)->create([
            'company_id' => 1,
            'password' => 'i-love-laravel',
        ]);
        // Delete Mocked
        // Create user 101 and Update User
        if ($user = User::find(100)) {
            $user->delete();
        }
        $User->id = 101;
        $User->save();
        $User->company = 1;
        $User->email = 'alberto@test.ok';
        $User->password = 'albertotestpass';

        $UserArray = $User->toArray();
        unset($UserArray['password']);
        // Insert Mocked throw /users Post
        $response = $this->be($Manager)->put("/users/$User->id", $UserArray);

        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertEquals($User->id, $responseUser->id); // Expected to be the next to be inserted  
        $this->assertEquals($User->email, $responseUser->email);
        $this->assertEquals('i-love-laravel', $responseUser->password);
        $this->assertEquals($User->company_id, $responseUser->company_id);

    }

    public function testRoutePutUsersReturnsUpdatedUser_WhitPasswordUpdate()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        $User = factory(User::class)->create([
            'company_id' => 1,
            'password' => 'i-love-laravel',
        ]);
        // Delete Mocked
        $User->delete();

        // Create user 101 and Update User
        if ($user = User::find(101)) {
            $user->delete();
        }
        $User->id = 101;
        $User->save();
        $User->company = 1;
        $User->name = 'alberto test';
        $User->email = 'alberto@test.ok';
        $User->password = 'passchanged';

        $response = $this->be($Manager)->put("/users/$User->id", $User->toArray());
        $responseContent = $response->getContent();
        $responseUser = json_decode($responseContent);
        $User->delete();

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertEquals($User->id, $responseUser->id); // Expected to be the next to be inserted  
        $this->assertEquals($User->name, $responseUser->name);
        $this->assertEquals($User->email, $responseUser->email);
        $this->assertNotEquals('i-love-laravel', $responseUser->password);
        $this->assertEquals($User->company_id, $responseUser->company_id);

    }

    public function testRouteDestroyUsersReturnsEmptyAfterDelete()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create Mock User Into DB Test
        $User = factory(User::class)->create([
            'company_id' => 1,
            'password' => 'i-love-laravel',
        ]);
        // Delete Mocked
        // $User->delete();

        // Insert Mocked throw /users Post
        $response = $this->be($Manager)->delete("/users/$User->id");

        $responseContent = $response->getContent();

        $response->assertSuccessful();
        $this->assertEmpty($responseContent);
        $this->assertNull(User::find($User->id));
    }

    public function testRouteUsersUpdateAvatarImageReturnsImageRoute()
    {
        // Login Manager
        $manager_id = 3;
        $Manager = User::find($manager_id);
        Auth::login($Manager);

        // Create and upload fake image
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->be($Manager)->post("/users/$Manager->id/update_image", [
            'file' => $file
        ]);
        $responseContent = $response->getContent();

        $response->assertSuccessful();
        var_dump($responseContent);
        $responseContent = str_replace('external_files/', '', $responseContent);
        Storage::disk('chats_files')->assertExists("$responseContent");
    }



}

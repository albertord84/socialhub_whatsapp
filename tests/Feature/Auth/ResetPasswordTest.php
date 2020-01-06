<?php

namespace Tests\Feature\Auth;

use App\Events\PasswordResetEvent;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Tests\MyTestCase;

class ResetPasswordTest extends MyTestCase
{

    protected function getValidToken($user)
    {
        return Password::broker()->createToken($user);
    }

    protected function getInvalidToken()
    {
        return 'invalid-token';
    }

    public function testUserCanResetPasswordWithValidToken()
    {
        Event::fake();
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => bcrypt('i-love-laravel'),
        ]);

        $response = $this->post('/auth/password_reset', [
            'token' => $this->getValidToken($user),
            'email' => $user->email,
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ]);
        
        $user = User::find(100);
        
        $response->assertSuccessful();
        $this->assertEquals($user->email, $user->email);
        $this->assertEquals($user->password, $user->password);
        // $this->assertTrue(Hash::check('new-awesome-password', $user->password));
        // $this->assertAuthenticatedAs($user);
        Event::assertDispatched(PasswordResetEvent::class, function ($e) use ($user) {
            // return $e->user->id === $user->id;
            return $e->data['email'] === $user->email;
        });
        
    }

    public function testUserCannotResetPasswordWithInvalidToken()
    {
        if ($user = User::find(100)) $user->delete();
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => bcrypt('old-password'),
        ]);

        $response = $this->post('/auth/password_reset', [
            'token' => $this->getInvalidToken(),
            'email' => $user->email,
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ]);

        $user = User::find(100);
        $user->delete();
        
        $response->assertSuccessful();
        $this->assertEquals($user->email, $user->email);
        $this->assertEquals($user->password, $user->password);
        // $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    public function testUserCannotResetPasswordWithoutProvidingANewPassword()
    {
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => 'old-password',
        ]);

        $token = $this->getValidToken($user);
        $response = $this->post('/auth/password_reset', [
            'token' => $token,
            'email' => '',
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ]);

        $user = User::find(100);

        $response->assertStatus(401);
        // $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->email);
        $this->assertEquals('old-password', $user->password);
        $this->assertGuest();
    }

    public function testUserCannotResetPasswordWithoutProvingAnEmail()
    {
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => 'old-password',
        ]);

        $token = $this->getValidToken($user);
        $response = $this->post('/auth/password_reset', [
            'token' => $token,
            'email' => '',
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ]);

        $user = User::find(100);
        
        $response->assertStatus(401);
        // $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->email);
        $this->assertEquals('old-password', $user->password);
        $this->assertGuest();
    }

}

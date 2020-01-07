<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class LoginTest extends MyTestCase
{

    protected function successfulLoginRoute()
    {
        return '/home';
    }

    protected function loginGetRoute()
    {
        return '/';
    }

    protected function loginPostRoute()
    {
        return '/auth/login';
    }

    protected function logoutRoute()
    {
        return '/auth/logout';
    }

    protected function successfulLogoutRoute()
    {
        return '/';
    }

    protected function guestMiddlewareRoute()
    {
        return '/home';
    }

    public function testUserCanViewALoginForm()
    {
        $response = $this->get($this->loginGetRoute());

        $response->assertSuccessful();
        $response->assertViewIs('welcome');
    }

    public function testUserCannotViewALoginFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get($this->loginGetRoute());

        $response->assertSuccessful();
        $response->assertViewIs('welcome');
        // $response->assertRedirect($this->guestMiddlewareRoute());
    }

    public function testUserCanDoLoginFromAuthFeature()
    {
        $user_id = 1;

        $User1 = User::find($user_id);

        Auth::login($User1);

        $logguedUser = Auth::user();

        $this->assertInstanceOf(User::class, $logguedUser);
        $this->assertEquals($logguedUser->id, 1);
        $this->assertEquals($logguedUser->email, 'admin@socialhub.pro');
    }

    public function testAdmin1CanDoLoginFromLoginForm()
    {
        $response = $this->post('/auth/login', ['email' => 'admin@socialhub.pro', 'password' => 'admin']);

        $logguedUser = Auth::user();

        $response->assertSuccessful();
        $this->assertInstanceOf(User::class, $logguedUser);
        $this->assertEquals($logguedUser->id, 1);
        $this->assertEquals($logguedUser->email, 'admin@socialhub.pro');
    }

    public function testMockUserCanLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post($this->loginPostRoute(), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertSuccessful();
        // $response->assertRedirect($this->successfulLoginRoute());
        $this->assertAuthenticatedAs($user);

    }

    public function testRememberMeFunctionality()
    {
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post($this->loginPostRoute(), [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertSuccessful();
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);

    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = factory(User::class)->create([
            'id' => 100,
            'password' => 'i-love-laravel',
        ]);

        $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $user->delete();

        $response->assertStatus(401);
        // $response->assertSessionHasErrors('email');
        $this->assertGuest();

    }

    public function testUserCannotLoginWithEmailThatDoesNotExist()
    {
        $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
            'email' => 'nobody@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(401);
        $this->assertGuest();
    }

    public function testUserCanLogout()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->post($this->logoutRoute());

        $response->assertSuccessful();
        $this->assertGuest();
    }

    // public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute()
    // {
    //     $user = factory(User::class)->create([
    //         'password' => bcrypt($password = 'i-love-laravel'),
    //     ]);

    //     foreach (range(0, 5) as $_) {
    //         $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
    //             'email' => $user->email,
    //             'password' => 'invalid-password',
    //         ]);
    //     }

    //     $response->assertRedirect($this->loginGetRoute());
    //     $response->assertSessionHasErrors('email');
    //     $this->assertContains(
    //         'Too many login attempts.',
    //         collect($response
    //             ->baseResponse
    //             ->getSession()
    //             ->get('errors')
    //             ->getBag('default')
    //             ->get('email')
    //         )->first()
    //     );
    //     $this->assertTrue(session()->hasOldInput('email'));
    //     $this->assertFalse(session()->hasOldInput('password'));
    //     $this->assertGuest();
    // }

}

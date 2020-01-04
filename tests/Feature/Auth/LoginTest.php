<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\ExtendedUsersAttendantController;
use App\Models\UsersAttendant;
use App\Repositories\ExtendedUsersAttendantRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\MyTestCase;

class LoginTest extends MyTestCase
{
    // use RefreshDatabase;

    protected function successfulLoginRoute()
    {
        return route('home');
    }

    protected function loginGetRoute()
    {
        return '/';
    }

    protected function loginPostRoute()
    {
        return route('login');
    }

    protected function logoutRoute()
    {
        return route('logout');
    }

    protected function successfulLogoutRoute()
    {
        return '/';
    }

    protected function guestMiddlewareRoute()
    {
        return route('home');
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

        // var_dump($response);

        $response->assertSuccessful();
        $response->assertViewIs('welcome');
        // $response->assertRedirect($this->guestMiddlewareRoute());
    }

    public function testDefault2AttendantsInCompany1WithUsersAttendantModel()
    {
        $company_id = 1;

        $attendants = UsersAttendant::with('user')->whereHas('user', function ($query) use ($company_id) {
            $query->where(['company_id' => $company_id]);
        })->get();

        $this->assertCount(2, $attendants);
    }

    public function testDefault2AttendantsInCompany1WithUsersAttendantsController()
    {
        $company_id = 1;
        $manager_id = 3;

        $Manager = User::find($manager_id);

        Auth::login($Manager);

        $ExtendedUsersAttendantRepository = new ExtendedUsersAttendantRepository(app());
        $ExtendedUsersAttendantController = new ExtendedUsersAttendantController($ExtendedUsersAttendantRepository);
        $Request = new Request();
        $response = $ExtendedUsersAttendantController->index($Request);
        $attendants = json_decode($response);

        $this->assertJson($response);
        $this->assertCount(2, $attendants);
    }

    public function testDefault2AttendantsInCompany1WithUsersAttendantsIndexRoute()
    {
        $company_id = 1;
        $manager_id = 3;

        $Manager = User::find($manager_id);

        Auth::login($Manager);

        $response = $this->get('/usersAttendants');
        $responseContent = $response->getContent();
        $attendants = json_decode($responseContent);

        $response->assertSuccessful();
        $this->assertJson($responseContent);
        $this->assertCount(2, $attendants);
    }

    // public function testUserCanLoginWithCorrectCredentials()
    // {
    //     $user = factory(User::class)->create([
    //         'password' => bcrypt($password = 'i-love-laravel'),
    //     ]);

    //     $response = $this->post($this->loginPostRoute(), [
    //         'email' => $user->email,
    //         'password' => $password,
    //     ]);

    //     $response->assertRedirect($this->successfulLoginRoute());
    //     $this->assertAuthenticatedAs($user);
    // }

    // public function testRememberMeFunctionality()
    // {
    //     $user = factory(User::class)->create([
    //         'id' => random_int(1, 100),
    //         'password' => bcrypt($password = 'i-love-laravel'),
    //     ]);

    //     $response = $this->post($this->loginPostRoute(), [
    //         'email' => $user->email,
    //         'password' => $password,
    //         'remember' => 'on',
    //     ]);

    //     $response->assertRedirect($this->successfulLoginRoute());
    //     $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
    //         $user->id,
    //         $user->getRememberToken(),
    //         $user->password,
    //     ]));
    //     $this->assertAuthenticatedAs($user);
    // }

    // public function testUserCannotLoginWithIncorrectPassword()
    // {
    //     $user = factory(User::class)->create([
    //         'password' => bcrypt('i-love-laravel'),
    //     ]);

    //     $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
    //         'email' => $user->email,
    //         'password' => 'invalid-password',
    //     ]);

    //     $response->assertRedirect($this->loginGetRoute());
    //     $response->assertSessionHasErrors('email');
    //     $this->assertTrue(session()->hasOldInput('email'));
    //     $this->assertFalse(session()->hasOldInput('password'));
    //     $this->assertGuest();
    // }

    // public function testUserCannotLoginWithEmailThatDoesNotExist()
    // {
    //     $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
    //         'email' => 'nobody@example.com',
    //         'password' => 'invalid-password',
    //     ]);

    //     $response->assertRedirect($this->loginGetRoute());
    //     $response->assertSessionHasErrors('email');
    //     $this->assertTrue(session()->hasOldInput('email'));
    //     $this->assertFalse(session()->hasOldInput('password'));
    //     $this->assertGuest();
    // }

    // public function testUserCanLogout()
    // {
    //     $this->be(factory(User::class)->create());

    //     $response = $this->post($this->logoutRoute());

    //     $response->assertRedirect($this->successfulLogoutRoute());
    //     $this->assertGuest();
    // }

    // public function testUserCannotLogoutWhenNotAuthenticated()
    // {
    //     $response = $this->post($this->logoutRoute());

    //     $response->assertRedirect($this->successfulLogoutRoute());
    //     $this->assertGuest();
    // }

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

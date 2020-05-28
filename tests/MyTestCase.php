<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class MyTestCase extends BaseTestCase
{
    use CreatesApplication;

    public $faker;
    
    protected function setUp()
    {
        parent::setUp();
        // Do something

        $_SESSION['TESTING'] = true;

        if ($user = User::find(100)) {
            $user->delete();
        }
    }

    protected function tearDown(): void
    {
        // Do something

        $_SESSION['TESTING'] = false;
        
        Mockery::close();

        parent::tearDown();
    }    
}

<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class MyTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
        // Do something

        if ($user = User::find(100)) {
            $user->delete();
        }
    }

    protected function tearDown(): void
    {
        // Do something
        parent::tearDown();
    }    
}

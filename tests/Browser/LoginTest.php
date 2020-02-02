<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * @group login
     * @return void
     */
    public function testingLoginPage(){
        echo "\n--------------------------------------------------------------\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Email')
                ->assertSee('Senha');
            echo "OK -- Tested Login Page\n ";
        });
    }
    
    /**
     * @group login
     * @return void
     */
    public function testingLoginInputsFields(){   
        echo "\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Email')
                ->assertSee('Senha')
                ->assertSee('Esqueceu sua senha?')
                ->assertSee('Entrar');
            echo "OK -- Tested Login HTML elements\n ";
        });
    }

    /**
     * @group login
     * @return void
     */
    public function testingLoginInputsValues(){
        echo "\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', '') //empty email
                ->type('password', '') //empty password
                ->press('Entrar')
                ->assertSee('Email inválido');
            echo "OK -- Tested empty email and empty password\n ";

            $browser->visit('/')
                ->type('email', 'invalidEmail') //invalid email
                ->type('password', '') //empty password
                ->press('Entrar')
                ->assertSee('Email inválido');
            echo "OK -- Tested invalid email and empty password\n ";

            $browser->visit('/')
                ->type('email', 'anyemail@gmail.com') //valid email
                ->type('password', '')  //empty password
                ->press('Entrar')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo "OK -- Tested valid email and empty password\n";

            $browser->visit('/')
                ->type('email', '') //empty email
                ->type('password', 'anypassword')  //any password
                ->press('Entrar')
                ->assertSee('Email inválido');
            echo " OK -- Tested empty email and any password\n";
            
            $browser->visit('/')
                ->type('email', 'anyemail@gmail.com') ////non-user valid email
                ->type('password', 'anypassword')  //non-user password
                ->press('Entrar')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo " OK -- Tested login of non-system user\n";

            $browser->visit('/')
                ->click('a[href="#/forgotpassword"]')
                ->waitForText('Recuperar senha')
                ->assertSee('Recuperar senha');
            echo " OK -- Tested link to forgotpassword page\n";
        });
    }

    
}

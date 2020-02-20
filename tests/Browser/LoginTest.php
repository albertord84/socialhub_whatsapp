<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * @group page_login
     * @return void
     */
    public function testingLoginInputsFields(){   
        echo "\n--------------------------------------------------------------\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Email')
                ->assertSee('Senha')
                ->assertSee('Esqueceu sua senha?')
                ->assertSee('Entrar')
                ->assertPresent('#email')
                ->assertPresent('#password');
            echo "OK -- Tested Login HTML elements\n ";
        });
    }

    /**
     * @group page_login
     * @return void
     */
    public function testingLoginInputsValues(){
        echo "\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', '') //empty email
                ->type('password', '') //empty password
                ->press('#btnEnter')
                ->assertSee('Email inválido');
            echo "OK -- Tested empty email and empty password\n ";

            $browser//->visit('/')
                ->type('email', 'invalidEmail') //invalid email
                ->type('password', '') //empty password
                ->press('#btnEnter')
                ->assertSee('Email inválido');
            echo "OK -- Tested invalid email and empty password\n ";

            $browser//->visit('/')
                ->type('email', 'anyemail@gmail.com') //valid email
                ->type('password', '')  //empty password
                ->press('#btnEnter')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo "OK -- Tested valid email and empty password\n";

            $browser//->visit('/')
                ->type('email', '') //empty email
                ->type('password', 'anypassword')  //any password
                ->press('#btnEnter')
                ->assertSee('Email inválido');
            echo " OK -- Tested empty email and any password\n";
            
            $browser//->visit('/')
                ->type('email', 'anyemail@gmail.com') ////non-user valid email
                ->type('password', 'anypassword')  //non-user password
                ->press('#btnEnter')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo " OK -- Tested login of non-system user\n";

            $browser//->visit('/')
                ->click('a[href="#/forgotpassword"]')
                ->waitForText('Recuperar senha')
                ->assertSee('Recuperar senha');
            echo " OK -- Tested link to forgotpassword page\n";
        });
    }

    
}

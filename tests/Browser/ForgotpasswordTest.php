<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ForgotpasswordTest extends DuskTestCase
{
    /**
     * @group page_forgot_password
     * @return void
     */
    public function testingForgotPasswordInputsFields(){   
        echo "\n--------------------------------------------------------------\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('#/forgotpassword')
            ->assertSee('Recuperar senha')
            ->assertSee('Digite o e-mail com o qual')
            ->assertSee('Enviar Email')
            ->assertPresent('#email');
            echo "OK -- Tested Forgotpassword HTML elements\n ";
        });
    }

    /**
     * @group page_forgot_password
     * @return void
     */
    public function testingForgotPasswordInputsValues(){
        echo "\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('#/forgotpassword')
                ->type('email', '') //empty email
                ->press('Enviar Email')
                ->assertSee('Email é obrigatório');
            echo "OK -- Tested empty email\n ";

            $browser//->visit('#/forgotpassword')
                ->type('email', 'invalidEmail') //invalid email
                ->press('Enviar Email')
                ->assertSee('Email é inválido');
            echo "OK -- Tested invalid email\n ";

            $browser//->visit('#/forgotpassword')
                ->type('email', 'anyemail@gmail.com') //valid email
                ->press('Enviar Email')
                ->waitForText('Email não existe')
                ->assertSee('Email não existe');
            echo "OK -- Tested forgotpassword of non-system user\n";
            
            $browser//->visit('#/forgotpassword')
                ->type('email', 'attendant2@socialhub.pro') //valid email
                ->press('Enviar Email')
                ->waitForText('O email de redefinição de senha foi enviado.')
                ->assertSee('O email de redefinição de senha foi enviado.');
            echo " OK -- Tested 'O email de redefinição de senha foi enviado': \n";
            
        });
    }
}

<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ResetpasswordTest extends DuskTestCase
{
    /**
     * @group page_reset_password
     * @return void
     */
    public function testingResetPasswordInputsFields(){   
        echo "\n--------------------------------------------------------------\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('#/reset_password/PJ3JIKv6fGaXpwYX')
                ->assertSee('Redefinir Senha')
                ->assertSee('A senha é sensível a maiúsculas.')
                ->assertPresent('#password')
                ->assertPresent('#repeatpassword');
            echo "OK -- Tested Reset Password HTML fields\n ";
        });
    }

    /**
     * @group page_reset_password
     * @return void
     */
    public function testingResetPasswordInputsValues(){
        echo "\n ";
        $this->browse(function (Browser $browser) {
            $browser->visit('#/reset_password/PJ3JIKv6fGaXpwYX')
                ->type('password', '') //empty password
                ->type('repeatpassword', '') //empty repeatpassword
                ->press('Redefinir senha')
                ->waitForText('A senha é obrigatória')
                ->assertSee('A senha é obrigatória')
                ->assertSee('Confirmação de senha é obrigatória');
            echo "OK -- Tested empty password and empty repeatpassword fields\n ";

            $browser->visit('#/reset_password/PJ3JIKv6fGaXpwYX')
                ->type('password', 'anypassword') //anypassword password
                ->type('repeatpassword', '') //empty repeatpassword
                ->press('Redefinir senha')
                ->waitForText('Confirmação de senha é obrigatória')
                ->assertSee('Confirmação de senha é obrigatória');
            echo "OK -- Tested any password and empty repeatpassword fields\n ";

            $browser->visit('#/reset_password/PJ3JIKv6fGaXpwYX')
                ->type('password', '') //empty password
                ->type('repeatpassword', 'anypassword') //any repeatpassword
                ->press('Redefinir senha')
                ->waitForText('A senha é obrigatória')
                ->assertSee('A senha é obrigatória');
            echo "OK -- Tested empty password and any repeatpassword fields\n ";

            $browser->visit('#/reset_password/PJ3JIKv6fGaXpwYX')
                ->type('password', 'anypassword1') //any password
                ->type('repeatpassword', 'anypassword2') //any repeatpassword
                ->press('Redefinir senha')
                ->waitForText('As senhas não coincidem')
                ->assertSee('As senhas não coincidem');
            echo "OK -- Tested different password and repeatpassword fields\n ";
            
            // $browser->visit('#/reset_password/PJ3JIKv6fGaXpwYX')
            //     ->type('password', '1213456') //any password
            //     ->type('repeatpassword', '1213456') //any repeatpassword
            //     ->press('Redefinir senha')
            //     ->waitForText('As senhas não coincidem')
            //     ->assertSee('As senhas não coincidem');
            // echo "OK -- Tested different password and repeatpassword fields\n ";
            
        });
    }
}

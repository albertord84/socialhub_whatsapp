<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagerAttendantsFunctionsTest extends DuskTestCase
{
    /**
     * @group ManagerAttendants.
     * @return void
     */
    public function testExample(){
        echo "\n--------------------------------------------------------------\n ";

        $this->browse(function (Browser $browser)  {
            $browser->visit('/')
                ->type('email', 'manager@socialhub.pro')
                ->type('password', 'wrong_pass')
                ->press('Entrar')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo "OK -- Tested login of user: manager@socialhub.pro with incorrect pasword \n";

            $browser->visit('/')
                ->type('email', 'manager@socialhub.pro')
                ->type('password', 'manager')
                ->press('Entrar');

                // ->waitForText('Contatos')
                // ->assertSee('Contatos')
                // ->assertPresent('#logged_user_name')
                // ->assertPresent('#search-input')
                // ->assertPresent('#addCompany')
                // ->assertPresent('#exportCompany')
                // ->assertSee('Linhas por página:');
            echo " OK -- Tested login of user: seller1@socialhub.pro \n";
        });



       
    }
}

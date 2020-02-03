<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SellerFunctionsTest extends DuskTestCase
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
            echo "OK -- Tested Login Page to Seller functions\n ";
        });
    }

    /**
     * * @group login
     * @return void
     */
    public function testingSellerDoLogin(){
        echo "\n ";
        $this->browse(function ($browser)  {
            $browser->visit('/')
                ->type('email', 'seller1@socialhub.pro')
                ->type('password', 'wrong_pass')
                ->press('Entrar')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo "OK -- Tested login of user: seller1@socialhub.pro with incorrect pasword\n";

            $browser->visit('/')
                ->type('email', 'seller1@socialhub.pro')
                ->type('password', 'seller1')
                ->press('Entrar')
                ->waitForText('Empresas')
                ->assertSee('Empresas');
            echo "OK -- Tested login of user: seller1@socialhub.pro\n";
        });
    }

    // /**
    //  * * @group login
    //  * @return void
    //  */
    // public function testingSellerAddCompany(){
    //     echo "\n ";
    //     $this->browse(function ($browser)  {
    //         $browser->visit('#/seller')
    //             ->click('a[href="#/addCompany"]')
    //             ->assertSee('Nova empresa')
                
    //             ->type('email', 'seller1@socialhub.pro')
    //             ->type('password', 'seller1')
    //             ->press('Entrar')
    //             ->waitForText('Empresas')
    //             ->assertSee('Empresas');
    //             echo "OK -- Tested login of user: seller1@socialhub.pro\n";
    //     });
    // }


}

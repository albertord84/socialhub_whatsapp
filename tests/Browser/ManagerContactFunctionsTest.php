<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagerContactFunctionsTest extends DuskTestCase
{
    
    /**
     * @group manager
     * @return void
     */
    public function testingLoginPage(){
        echo "\n--------------------------------------------------------------\n ";
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->assertSee('Email')
                ->assertSee('Senha')
                ->assertSee('Esqueceu sua senha?')
                ->assertSee('Entrar')
                ->assertPresent('#email')
                ->assertPresent('#password');
            echo "OK -- Tested Login Page to manager functions \n ";
        });
    }
    
    
    
    /**
     * @group manager
     * @return void
     */
    public function testingManagerDoLogin(){
        echo "\n--------------------------------------------------------------\n ";

        $this->browse(function (Browser $browser)  {
            $browser->visit('/')
                ->type('email', 'manager@socialhub.pro')
                ->type('password', 'wrong_pass')
                ->press('Entrar')
                ->waitForText('Email ou senha inválido')
                ->assertSee('Email ou senha inválido');
            echo "OK -- Tested login of user: manager@socialhub.pro with incorrect pasword\n";

            $browser->visit('/')
                ->type('email', 'manager@socialhub.pro')
                ->type('password', 'manager')
                ->press('Entrar')
                ->waitForText('Contatos')
                ->assertSee('Contatos')
                ->assertSee('Linhas por página:')

                ->assertPresent('#search-input')
                ->assertPresent('#fileInputCSV')
                ->assertPresent('#exportExcel')
                ->assertPresent('#AddContact')
                ->assertPresent('#tableContacts')
                ->assertPresent('#search-input')
                ->screenshot('1')	
                ->assertPresent('#dropdown_btn');
                

                // ->assertPresent('#logged_user_name')
                // ->assertPresent('#lnk_editUser')
                // ->assertPresent('#lnk_lockscreen')
                // ->assertPresent('#lnk_editUser');

                

            echo " OK -- Tested login of user: manager@socialhub.pro \n";
        });
    }




    /**
     * * @group manager
     * @return void
     */
    public function testingManagerHeaderSide(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
           
            $browser
                ->screenshot('2')	

                ->assertPresent('#dropdown_btn')
                ->press('#dropdown_btn')
                ->waitForText('Perfil')
                ->assertSee('Perfil')
                ->assertPresent('#perfil_lnk')
                ->assertPresent('#lockscreen_lnk')
                ->assertPresent('#logout_lnk');
            echo "OK -- Tested manager check Header Side\n";

            $browser
                ->press('#perfil_lnk')
                ->whenAvailable('#userCRUDDatasModal1', function ($modal) {
                    $modal
                        ->assertSee('INFORMAÇÃO PESSOAL')
                        ->assertSee('CPF')
                        ->assertSee('Telefone')
                        ->assertSee('Whatsapp')
                        ->assertSee('Facebook')
                        ->assertSee('Instagram')
                        ->assertSee('Linkedin');
                    });
            $browser
                ->script('location.reload();');
            echo " OK -- Tested manager check link to edit manager from Header Side\n";

            $browser
                ->assertPresent('#dropdown_btn')
                ->press('#dropdown_btn')
                ->waitForText('Bloquear')
                ->assertPresent('#lockscreen_lnk')
                ->press('#lockscreen_lnk')
                    ->assertPresent('#password')
                    ->assertPresent('#desbloquear')
                    ->type('password', 'manager')
                    ->press('#desbloquear')
                ->waitForText('Contatos')
                ->assertSee('Contatos'); 
            echo " OK -- Tested manager check link to lockscreen manager from Header Side\n";

            $browser
                ->assertPresent('#dropdown_btn')
                ->press('#dropdown_btn')
                ->waitForText('Sair')
                ->assertPresent('#logout_lnk')
                ->press('#logout_lnk')
                    ->assertSee('Email')
                    ->assertSee('Senha')
                    ->assertSee('Esqueceu sua senha?')
                    ->assertSee('Entrar')
                    ->assertPresent('#email')
                    ->assertPresent('#password')
                    ->assertPathIs('/')
                    ->type('email', 'manager@socialhub.pro')
                    ->type('password', 'manager')
                    ->press('Entrar')
                ->waitForText('Contatos')
                ->assertSee('Contatos');
            echo " OK -- Tested manager check link to logout manager from Header Side\n";
        });
    }



    // /**
    //  * * @group manager
    //  * @return void
    //  */
    // public function testingManagerDoLogout(){
    //     echo "\n ";
    //     $this->browse(function (Browser $browser)  {
           
    //         $browser
    //             ->assertPresent('#lnk_logout')
    //             ->click('#lnk_logout')
    //             ->assertSee('Email')
    //             ->assertSee('Senha')
    //             ->assertSee('Esqueceu sua senha?')
    //             ->assertSee('Entrar')
    //             ->assertPresent('#email')
    //             ->assertPresent('#password')
    //             ->assertPathIs('/');
    //         echo "OK -- Tested logout of user: manager@socialhub.pro\n";

    //         $browser
    //             ->type('email', 'manager@socialhub.pro')
    //             ->type('password', 'manager')
    //             ->press('Entrar')
    //             ->waitForText('Contatos')
    //             ->assertSee('Contatos');
    //         echo " OK -- Tested login after logout of user: manager@socialhub.pro\n";
    //     });
    // }



    // /**
    //  * * @group manager
    //  * @return void
    //  */
    // public function testingManagerDoLockScreen(){
    //     echo "\n ";
    //     $this->browse(function (Browser $browser)  {
           
    //         $browser
    //             ->assertPresent('#lnk_lockscreen')
    //             ->click('#lnk_lockscreen')
    //             ->assertPresent('#password')
    //             ->assertPresent('#desbloquear');
    //         echo "OK -- Tested lockscreen of user: manager@socialhub.pro\n";
            
    //         $browser
    //             ->type('password', '')
    //             ->press('#desbloquear')
    //             ->waitForText('A senha é obrigatória')
    //             ->assertSee('A senha é obrigatória');
    //         echo " OK -- Tested login after lockscreen of user: manager@socialhub.pro without pasword\n";
            
    //         // ECR => descomentar depois de concertado. ERRO: manager ou seller podem entrar com cualquer senha
    //         // $browser
    //         //     ->type('password', 'wrong_pass')
    //         //     ->press('#desbloquear');
    //         //     // ->waitForText('Senha inválida')
    //         //     // ->assertSee('Senha inválida');
    //         // echo " OK -- Tested login after lockscreen of user: manager@socialhub.pro with incorrect pasword\n";

    //         $browser
    //             ->type('password', 'manager')
    //             ->press('#desbloquear')
    //             ->waitForText('Contatos')
    //             ->assertSee('Contatos');
    //         echo " OK -- Tested login after lockscreen of user: manager@socialhub.pro\n";
    //     });
    // }








}
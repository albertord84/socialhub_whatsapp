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
            echo "OK -- Tested Login Page to manager functions\n ";
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
                ->assertPresent('#dropdown_btn')
                ->assertPresent('#logged_user_name')
                ->assertPresent('#lnk_editUser')
                ->assertPresent('#lnk_lockscreen')
                ->assertPresent('#lnk_editUser');
            echo " OK -- Tested login of user: manager@socialhub.pro\n";
        });
    }



    /**
     * * @group manager
     * @return void
     */
    public function testingManagerDoLogout(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {

            $browser
                ->assertPresent('#lnk_logout')
                ->click('#lnk_logout')
                ->assertSee('Email')
                ->assertSee('Senha')
                ->assertSee('Esqueceu sua senha?')
                ->assertSee('Entrar')
                ->assertPresent('#email')
                ->assertPresent('#password')
                ->assertPathIs('/');
            echo "OK -- Tested logout of user: manager@socialhub.pro\n";

            $browser
                ->type('email', 'manager@socialhub.pro')
                ->type('password', 'manager')
                ->press('Entrar')
                ->waitForText('Contatos')
                ->assertSee('Contatos');
            echo " OK -- Tested login after logout of user: manager@socialhub.pro\n";
        });
    }



    /**
     * * @group manager
     * @return void
     */
    public function testingManagerDoLockScreen(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
           
            $browser
                ->assertPresent('#lnk_lockscreen')
                ->click('#lnk_lockscreen')
                ->assertPresent('#password')
                ->assertPresent('#desbloquear');
            echo "OK -- Tested lockscreen of user: manager@socialhub.pro\n";
            
            $browser
                ->type('password', '')
                ->press('#desbloquear')
                ->waitForText('A senha é obrigatória')
                ->assertSee('A senha é obrigatória');
            echo " OK -- Tested login after lockscreen of user: manager@socialhub.pro without pasword\n";
            
            // ECR => descomentar depois de concertado. ERRO: manager ou seller podem entrar com cualquer senha
            // $browser
            //     ->type('password', 'wrong_pass')
            //     ->press('#desbloquear');
            //     // ->waitForText('Senha inválida')
            //     // ->assertSee('Senha inválida');
            // echo " OK -- Tested login after lockscreen of user: manager@socialhub.pro with incorrect pasword\n";

            $browser
                ->type('password', 'manager')
                ->press('#desbloquear')
                ->waitForText('Contatos')
                ->assertSee('Contatos');
            echo " OK -- Tested login after lockscreen of user: manager@socialhub.pro\n";
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



    /**
     *  @group manager
     * @return void
     */
    public function testingManagerAddContact(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->click('#AddContact')
                ->waitForText('Novo contato')
                ->assertSee('Novo contato')
                ->assertSee('Adicionar')
                ->assertSee('Cancelar')
                ->assertPresent('#nameContact')
                    ->type('nameContact', '')->press('#btnInsertContact')->waitForText('O nome do contato é obrigatório')->assertSee('O nome do contato é obrigatório')
                    ->pause(3000)
                    ->type('nameContact', 'AAA_nameContact')->press('#btnInsertContact')->waitForText('Por favor, confira')->assertDontSee('O nome do contato é obrigatório')
                ->assertPresent('#contact_atendant_id')
                ->assertPresent('#emailContact')
                    ->type('emailContact', 'emailInvalid')->press('#btnInsertContact')->waitForText('Email inválido')->assertSee('Email inválido')
                    ->pause(3000)
                    ->type('emailContact', 'emailvalid@gmail.com')->press('#btnInsertContact')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                ->assertPresent('#phoneContact')
                    ->type('phoneContact', '11111111')->press('#btnInsertContact')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                    ->pause(3000)
                    ->type('phoneContact', '2188888888')->press('#btnInsertContact')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                ->assertPresent('#whatsapp_id')
                    ->type('whatsapp_id', '')->press('#btnInsertContact')->waitForText('O whatsapp do contato é obrigatório')->assertSee('O whatsapp do contato é obrigatório')
                    ->type('whatsapp_id', '11111111')->press('#btnInsertContact')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                    ->type('whatsapp_id', '2188888888')
                ->assertPresent('#facebook_id')
                    ->type('facebook_id', 'facebook_id')
                ->assertPresent('#instagram_id')
                    ->type('instagram_id', 'instagram_id')
                ->assertPresent('#linkedin_id')
                    ->type('linkedin_id', 'linkedin_id')
                ->assertPresent('#summary')
                    ->type('summary', 'summary')
                ->assertPresent('#remember')
                    ->type('remember', 'remember')
                ->press('#btnInsertContact')->waitForText('Contato adicionado com sucesso') ->assertSee('Contato adicionado com sucesso');
            $browser->script('location.reload();');
            echo "OK -- Tested Manager add a new Contact\n";
        });
    }


    /**
     *  @group manager
     * @return void
     */
    public function testingManagerAddContactWhatsappDuplicate(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->click('#AddContact')
                ->waitForText('Novo contato')
                ->assertSee('Novo contato')

                ->type('nameContact', 'BBB_nameContact')
                ->type('whatsapp_id', '2188888888')
                ->press('#btnInsertContact')
                
                ->waitForText('Atenção')
                ->assertSee('O número de Whatsapp informado já está cadastrado');
            $browser->script('location.reload();');
            echo "OK -- Tested Manager add a Contact with whatsapp duplicate\n";
        });
    }


    // /**
    //  *  @group manager
    //  * @return void
    //  */
    // public function testingManagerEditContact(){
    //     echo "\n ";
    //     $this->browse(function (Browser $browser) {

    //         $browser
    //             ->with('#tableContacts', function ($table) {
    //                 $table->assertSee('AAA_nameContact')
    //                 ->click('#editContacts');
    //             })
    //             ->whenAvailable('#editContactModal', function ($modal) {
    //                 $modal
    //                     ->assertSee('Editar contato')
    //                     ->assertSee('Atualizar')
    //                     ->assertSee('Cancelar')
    //                     ->assertPresent('#nameContact')
    //                     ->assertPresent('#contact_atendant_id')
    //                     ->assertPresent('#emailContact')
    //                     ->assertPresent('#phoneContact')
    //                     ->assertPresent('#whatsapp_id')
    //                     ->assertPresent('#facebook_id')
    //                     ->assertPresent('#instagram_id')
    //                     ->assertPresent('#linkedin_id')
    //                     ->assertPresent('#summary')
    //                     ->assertPresent('#remember')
    //                     ->press('#btnCancelContact1');
    //             });
    //         $browser
    //             ->waitUntilMissing('#btnCancelContact1')
    //             ->assertDontSee('Atualizar');
    //         $browser->script('location.reload();');
    //         echo "OK -- Tested manager check cancel botton of editContactModal\n";

    //         $browser
    //             ->with('#tableContacts', function ($table) {
    //                 $table->assertSee('AAA_nameContact')
    //                 ->click('#editContacts');
    //             })
    //             ->whenAvailable('#editContactModal', function ($modal) {
    //                 $modal
    //                     ->type('nameContact', ' ') 
    //                     ->type('whatsapp_id', ' ')
    //                     ->press('#btnEditContact');
    //             });
    //         $browser
    //             ->waitForText('Por favor, confira')
    //             ->assertSee('O nome do contato é obrigatório')
    //             ->assertSee('O whatsapp do contato é obrigatório');
    //         $browser->script('location.reload();');
    //         echo " OK -- Tested manager edit a contact without mandatory data\n";
            
    //         $browser
    //             ->with('#tableContacts', function ($table) {
    //                 $table->assertSee('AAA_nameContact')
    //                 ->click('#editContacts');
    //             })
    //             ->whenAvailable('#editContactModal', function ($modal) {
    //                 $modal
    //                     ->type('nameContact', 'nameContactEdited') 
    //                     ->type('emailContact', 'emailvalidedited@gmail.com')
    //                     ->press('#btnEditContact');
    //             });
    //         $browser
    //             ->waitForText('Contato atualizado com sucesso')
    //             ->assertSee('Contato atualizado com sucesso');
    //         $browser->script('location.reload();');
    //         echo " OK -- Tested manager edit a new contact\n";
    //     });
    // }


    // /**
    //  *  @group manager
    //  * @return void
    //  */
    // public function testingManagerDeleteContact(){
    //     echo "\n ";
    //     $this->browse(function (Browser $browser)  {
    //         $browser
    //             ->with('#tableContacts', function ($table) {
    //                 $table->assertSee('AAA_nameContact')
    //                 ->click('#deleteContacts');
    //             })
    //             ->whenAvailable('#deleteContactModal', function ($modal) {
    //                 $modal
    //                     ->assertSee('Verificação de exclusão')
    //                     ->assertSee('Tem certeza que deseja remover esse Contato?')
    //                     ->assertSee('Eliminar')
    //                     ->assertSee('Cancelar')
    //                     ->assertPresent('#btnDeleteContact')
    //                     ->assertPresent('#btnCancelContact3')
    //                     ->screenshot('1')	
    //                         ->press('btnCancelContact3');
    //             });
    //         $browser
    //             ->waitUntilMissing('#btnCancelContact3')
    //             ->assertDontSee('Eliminar');
    //         echo "OK -- Tested manager check cancel botton of deleteCompaniesModal\n";

    //         $browser
    //             ->with('#tableContacts', function ($table) {
    //                 $table->assertSee('AAA_nameContact')
    //                 ->click('#deleteContacts');
    //             })
    //             ->whenAvailable('#deleteContactModal', function ($modal) {
    //                 $modal
    //                     ->assertPresent('#btnDeleteContact')
    //                         ->press('#btnDeleteContact');
    //             });
    //         $browser
    //             ->waitForText('Contato eliminado com sucesso')
    //             ->assertSee('Contato eliminado com sucesso');
    //         echo " OK -- Tested manager delete a contact\n";
    //     });
    // }














}
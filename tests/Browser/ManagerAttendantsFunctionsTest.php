<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagerAttendantsFunctionsTest extends DuskTestCase
{
    
    /**
     * @group managerAttendants
     * @return void
     */
    public function testingManagerDoLogin(){
        echo "\n--------------------------------------------------------------\n ";
        $this->browse(function (Browser $browser)  {

            $browser->visit('/')
                ->assertSee('Email')
                ->assertSee('Senha')
                ->assertSee('Esqueceu sua senha?')
                ->assertSee('Entrar')
                ->assertPresent('#email')
                ->assertPresent('#password')
                ->type('email', 'manager@socialhub.pro')
                ->type('password', 'manager')
                ->press('Entrar')
                ->waitForText('Contatos')
                ->assertSee('Contatos')
                ->assertSee('Linhas por página:')
                ->assertPresent('#fileInputCSV')
                ->assertPresent('#exportContacts')
                ->assertPresent('#addContact')
                ->assertPresent('#tableContacts')
                ->assertPresent('#search-input-contact')
                ->assertPresent('#dropdown_btn')
                ->assertPresent('#logged_user_name')
                ->assertPresent('#lnk_lockscreen')
                ->assertPresent('#lnk_editUser');
            echo "OK -- Tested login of user: manager@socialhub.pro\n";
        });
    }

    
    
    /**
     * @group managerAttendants
     * @return void
     */
    public function testingManagerDashboard(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {

            $browser->visit('#/manager/attendant')
                ->waitForText('Atendentes')
                ->assertSee('Atendentes')
                ->assertPresent('#search-input-attendant')
                ->assertPresent('#addAttendant')
                ->assertPresent('#exportAttendant')
                ->assertPresent('#tableAttendants')
                ->assertSee('Linhas por página:');
            echo "OK -- Tested managerAttendants Dashboard \n";
        });
    }


    /**
     *  @group managerAttendants
     * @return void
     */
    public function testingManagerAddAttendantsEmailDuplicate(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->click('#addAttendant')
                ->waitForText('Novo atendente')
                ->assertSee('Novo atendente')

                ->type('nameAttendant', 'AAA_nameAttendant')
                ->type('emailAttendant', 'attendant1@socialhub.pro')
                ->type('whatsappAttendant', '2188888888')
                ->type('CPF-Attendant', '08266391190')
                ->press('#btnInsertAttendant')
                ->waitForText('Atenção')
                ->assertSee('O e-mail do usuário informado já está cadastrado');
            $browser->script('location.reload();');
            echo "OK -- Tested Manager add a Attendant with email duplicate \n";
        });
    }


    /**
     *  @group managerAttendants
     * @return void
     */
    public function testingManagerAddAttendants(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->click('#addAttendant')
                ->waitForText('Novo atendente')
                ->assertSee('Novo atendente')
                ->assertSee('Adicionar')
                ->assertSee('Cancelar')
                ->assertPresent('#nameAttendant')
                    ->type('nameAttendant', '')->press('#btnInsertAttendant')->waitForText('O nome do atendente é obrigatório')->assertSee('O nome do atendente é obrigatório')
                    ->pause(3000)
                    ->type('nameAttendant', 'AAA_nameAttendant')->press('#btnInsertAttendant')->waitForText('Por favor, confira')->assertDontSee('O nome do atendente é obrigatório')
                ->assertPresent('#loginAttendant')
                    ->type('loginAttendant', 'loginAttendant')
                ->assertPresent('#emailAttendant')
                    ->type('emailAttendant', '')->press('#btnInsertAttendant')->waitForText('O e-mail do atendente é obrigatório')->assertSee('O e-mail do atendente é obrigatório')
                    ->type('emailAttendant', 'emailInvalid')->press('#btnInsertAttendant')->waitForText('Email inválido')->assertSee('Email inválido')
                    ->pause(3000)
                    ->type('emailAttendant', 'emailvalid@gmail.com')->press('#btnInsertAttendant')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                ->assertPresent('#CPF-Attendant')
                    ->type('CPF-Attendant', '')->press('#btnInsertAttendant')->waitForText('O CPF do atendente é obrigatório')->assertSee('O CPF do atendente é obrigatório')
                    ->type('CPF-Attendant', '12345678910')->press('#btnInsertAttendant')->waitForText('CPF inválido')->assertSee('CPF inválido')
                    ->pause(3000)
                    ->type('CPF-Attendant', '08266391190')->press('#btnInsertAttendant')->waitForText('Por favor, confira')->assertDontSee('CPF inválido')
                ->assertPresent('#phoneAttendant')
                    ->type('phoneAttendant', '11111111')->press('#btnInsertAttendant')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                    ->pause(3000)
                    ->type('phoneAttendant', '2188888888')->press('#btnInsertAttendant')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                ->assertPresent('#whatsappAttendant')
                    ->type('whatsappAttendant', '')->press('#btnInsertAttendant')->waitForText('O whatsapp do atendente é obrigatório')->assertSee('O whatsapp do atendente é obrigatório')
                    ->type('whatsappAttendant', '11111111')->press('#btnInsertAttendant')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                    ->type('whatsappAttendant', '2188888888')
                ->assertPresent('#facebookAttendant')
                    ->type('facebookAttendant', 'facebookAttendant')
                ->assertPresent('#instagramAttendant')
                    ->type('instagramAttendant', 'instagramAttendant')
                ->assertPresent('#linkedinAttendant')
                    ->type('linkedinAttendant', 'linkedinAttendant')
                ->press('#btnInsertAttendant')->waitForText('Atendente adicionado com sucesso', 10) ->assertSee('Atendente adicionado com sucesso');
            $browser->script('location.reload();');
            echo "OK -- Tested Manager add a new Attendant \n";
        });
    }


    /**
     *  @group managerAttendants
     * @return void
     */
    public function testingManagerAddAttendantsWhitoutMoreAllowed(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->click('#addAttendant')
                ->waitForText('Atenção')
                ->assertSee('Para inserir mais atentendente você deve contatar nossa equipe');
            $browser->script('location.reload();');
            echo "OK -- Tested Manager Trying to add a Attendant when reached the maximum number allowed \n";
        });
    }



    /**
     *  @group managerAttendants
     * @return void
     */
    public function testingManagerEditAttendant(){
        echo "\n ";
        $this->browse(function (Browser $browser) {

            $browser
                ->with('#tableAttendants', function ($table) {
                    $table->assertSee('AAA_nameAttendant')
                    ->click('#editAttendant');
                })
                ->whenAvailable('#editAttendantModal', function ($modal) {
                    $modal

                        ->assertSee('Editar atendente')
                        ->assertSee('Atualizar')
                        ->assertSee('Cancelar')
                        ->assertPresent('#nameAttendant')
                        ->assertPresent('#loginAttendant')
                        ->assertPresent('#emailAttendant')
                        ->assertPresent('#CPF-Attendant')
                        ->assertPresent('#phoneAttendant')
                        ->assertPresent('#whatsappAttendant')
                        ->assertPresent('#facebookAttendant')
                        ->assertPresent('#instagramAttendant')
                        ->assertPresent('#linkedinAttendant')

                        ->assertPresent('#btnCancelContact1')
                        ->press('#btnCancelContact1');
                });
            $browser
                ->waitUntilMissing('#btnCancelContact1')
                ->assertDontSee('Atualizar');
            $browser->script('location.reload();');
            echo "OK -- Tested manager check cancel botton of editAttendantModal \n";

            $browser
                ->with('#tableAttendants', function ($table) {
                    $table->assertSee('AAA_nameAttendant')
                    ->click('#editAttendant');
                })
                ->whenAvailable('#editAttendantModal', function ($modal) {
                    $modal
                        ->type('nameAttendant', ' ') 
                        ->type('emailAttendant', ' ')
                        ->type('CPF-Attendant', ' ')
                        ->type('whatsappAttendant', ' ')

                        ->press('#btnEditAttendant');
                });
            $browser
                ->waitForText('Por favor, confira')
                ->assertSee('O nome do atendente é obrigatório')
                ->assertSee('O e-mail do atendente é obrigatório')
                ->assertSee('O CPF do atendente é obrigatório')
                ->assertSee('O whatsapp do atendente é obrigatório');

            $browser->script('location.reload();');
            echo " OK -- Tested manager edit an Attendant without mandatory data \n";
            
            $browser
                ->with('#tableAttendants', function ($table) {
                    $table->assertSee('AAA_nameAttendant')
                    ->click('#editAttendant');
                })
                ->whenAvailable('#editAttendantModal', function ($modal) {
                    $modal
                        ->type('nameAttendant', 'AAA_nameAttendantEdited') 
                        ->type('emailAttendant', 'emailvalidedited@gmail.com')
                        ->type('CPF-Attendant', '08266391190')
                        ->press('#btnEditAttendant');
                });
            $browser
                ->waitForText('Atendente atualizado com sucesso', 10)
                ->assertSee('Atendente atualizado com sucesso');
            $browser->script('location.reload();');
            echo " OK -- Tested manager edit a new Attendant \n";
        });
    }



    /**
     *  @group managerAttendants
     * @return void
     */
    public function testingManagerDeleteAttendant(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->with('#tableAttendants', function ($table) {
                    $table->assertSee('AAA_nameAttendantEdited')
                    ->click('#deleAttendant');
                })
                ->whenAvailable('#deleteAttendantModal', function ($modal) {
                    $modal
                        ->assertSee('Verificação de exclusão')
                        ->assertSee('Tem certeza que deseja remover esse Atendente?')
                        ->assertSee('Eliminar')
                        ->assertSee('Cancelar')

                        ->assertPresent('#btnDeleteAttendant')
                        ->assertPresent('#btnCancelContact2')
                            ->press('#btnCancelContact2');
                });
            $browser
                ->waitUntilMissing('#btnCancelContact2')
                ->assertDontSee('Eliminar');
            echo "OK -- Tested manager check cancel botton of deleteAttendantModal \n";

            $browser
                ->with('#tableAttendants', function ($table) {
                    $table->assertSee('AAA_nameAttendantEdited')
                    ->click('#deleAttendant');
                })
                ->whenAvailable('#deleteAttendantModal', function ($modal) {
                    $modal
                        ->assertPresent('#btnDeleteAttendant')
                            ->press('#btnDeleteAttendant');
                });
            $browser
                ->waitForText('Atendente eliminado com sucesso')
                ->assertSee('Atendente eliminado com sucesso');
            echo " OK -- Tested manager delete Attendant \n";
        });
    }




}

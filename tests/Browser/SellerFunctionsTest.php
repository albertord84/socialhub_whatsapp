<?php

namespace Tests\Browser;

use Barryvdh\LaravelIdeHelper\Macro;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// use App\Providers\DuskServiceProvider;

class SellerFunctionsTest extends DuskTestCase
{
    /**
     * @group seller
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
            echo "OK -- Tested Login Page to Seller functions\n ";
        });
    }



    /**
     * * @group seller
     * @return void
     */
    public function testingSellerDoLogin(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
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
                ->assertSee('Empresas')
                ->assertPresent('#logged_user_name')
                ->assertPresent('#search-input')
                ->assertPresent('#addCompany')
                ->assertPresent('#exportCompany')
                ->assertSee('Linhas por página:');
            echo " OK -- Tested login of user: seller1@socialhub.pro\n";
        });
    }



    /**
     * * @group seller
     * @return void
     */
    public function testingSellerDoLogout(){
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
            echo "OK -- Tested logout of user: seller1@socialhub.pro\n";

            $browser
                ->type('email', 'seller1@socialhub.pro')
                ->type('password', 'seller1')
                ->press('Entrar')
                ->waitForText('Empresas')
                ->assertSee('Empresas');
            echo " OK -- Tested login after logout of user: seller1@socialhub.pro\n";
        });
    }



    /**
     * * @group seller
     * @return void
     */
    public function testingSellerDoLockScreen(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
           
            $browser
                ->assertPresent('#lnk_lockscreen')
                ->click('#lnk_lockscreen')
                ->assertPresent('#password')
                ->assertPresent('#desbloquear');
            echo "OK -- Tested lockscreen of user: seller1@socialhub.pro\n";
            
            $browser
                ->type('password', '')
                ->press('#desbloquear')
                ->waitForText('A senha é obrigatória')
                ->assertSee('A senha é obrigatória');
            echo " OK -- Tested login after lockscreen of user: seller1@socialhub.pro without pasword\n";
            
            // ECR => descomentar depois de concertado. ERRO: manager ou seller podem entrar com cualquer senha
            // $browser
            //     ->type('password', 'wrong_pass')
            //     ->press('#desbloquear');
            //     // ->waitForText('Senha inválida')
            //     // ->assertSee('Senha inválida');
            // echo " OK -- Tested login after lockscreen of user: seller1@socialhub.pro with incorrect pasword\n";

            $browser
                ->type('password', 'seller1')
                ->press('#desbloquear')
                ->waitForText('Empresas')
                ->assertSee('Empresas');
            echo " OK -- Tested login after lockscreen of user: seller1@socialhub.pro\n";
        });
    }



    /**
     * * @group seller
     * @return void
     */
    public function testingSellerEditUser(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            
            $browser
                ->assertPresent('#lnk_editUser1')
                ->click('#lnk_editUser1')
                ->whenAvailable('#userCRUDDatasModal', function ($modal) {
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
            echo "OK -- Tested seller1 check link to edit seller1 from photo user\n";
            
            $browser
                ->assertPresent('#lnk_editUser')
                ->click('#lnk_editUser')
                ->whenAvailable('#userCRUDDatasModal', function ($modal) {
                    $modal
                        ->assertSee('INFORMAÇÃO PESSOAL')
                        ->assertSee('CPF')
                        ->assertSee('Telefone')
                        ->assertSee('Whatsapp')
                        ->assertSee('Facebook')
                        ->assertSee('Instagram')
                        ->assertSee('Linkedin')
                        ->assertPresent('#updateUser')
                        ->assertPresent('#fileUserPhoto')
                        ->assertPresent('#editPerfil')
                        ->press('#editPerfil')
                        ->waitForText('Senha')
                            ->assertSee('Senha')
                            ->assertSee('Repetir senha')
                        ->type('#userCPF', '08266391190')
                        ->type('#userPhone', '2198745632')
                        ->type('#userWhatsapp', '2198745632')
                        ->type('#userFacebook', 'userFacebook')
                        ->type('#userInstagram', 'userInstagram')
                        ->type('#userLinkedin', 'userLinkedin')
                        ->press('#updateUser');
                });
            $browser
                ->waitForText('Sucesso')
                ->assertSee('Perfil atualizado com sucesso')
                ->script('location.reload();');
            echo " OK -- Tested seller1 edit seller1\n";
        });
    }

    

    /**
     * * @group seller
     * @return void
     */
    public function testingSellerHeaderSide(){
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
            echo "OK -- Tested Seller1 check Header Side\n";

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
            echo " OK -- Tested seller1 check link to edit seller1 from Header Side\n";

            $browser
                ->assertPresent('#dropdown_btn')
                ->press('#dropdown_btn')
                ->waitForText('Bloquear')
                ->assertPresent('#lockscreen_lnk')
                ->press('#lockscreen_lnk')
                    ->assertPresent('#password')
                    ->assertPresent('#desbloquear')
                    ->type('password', 'seller1')
                    ->press('#desbloquear')
                ->waitForText('Empresas')
                ->assertSee('Empresas'); 
            echo " OK -- Tested seller1 check link to lockscreen seller1 from Header Side\n";

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
                    ->type('email', 'seller1@socialhub.pro')
                    ->type('password', 'seller1')
                    ->press('Entrar')
                ->waitForText('Empresas')
                ->assertSee('Empresas');
            echo " OK -- Tested seller1 check link to logout seller1 from Header Side\n";
        });
    }



    /**
     *  @group seller
     * @return void
     */
    public function testingSellerAddCompany(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->click('#addCompany')
                ->waitForText('Nova empresa')
                ->assertSee('Nova empresa')

                ->assertSee('Endereço postal')
                ->assertSee('Descrição da empresa')
                ->assertSee('Dados do manager da empresa')
                ->assertSee('Adicionar')
                ->assertSee('Cancelar')

                ->assertPresent('#nameManager')
                    ->type('nameManager', '')->press('#btnInsert')->waitForText('O nome do manager da empresa é obrigatório')->assertSee('O nome do manager da empresa é obrigatório')
                    ->type('nameManager', 'correct name')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O nome do manager da empresa é obrigatório')
                ->assertPresent('#emailManager')
                    ->type('emailManager', '')->press('#btnInsert')->waitForText('O e-mail do manager da empresa é obrigatório')->assertSee('O e-mail do manager da empresa é obrigatório')
                    ->type('emailManager', 'emailInvalid')->press('#btnInsert')->waitForText('Email inválido')->assertSee('Email inválido')
                    ->pause(3000)
                    ->type('emailManager', 'emailvalid@gmail.com')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                ->assertPresent('#CPF')
                    ->type('CPF', '')->press('#btnInsert')->waitForText('O CPF do manager da empresa é obrigatório')->assertSee('O CPF do manager da empresa é obrigatório')
                    ->type('CPF', '12345678910')->press('#btnInsert')->waitForText('CPF inválido')->assertSee('CPF inválido')
                    ->pause(3000)
                    ->type('CPF', '08266391190')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('CPF inválido')
                ->assertPresent('#phoneManager')
                    ->type('phoneManager', '11111111')->press('#btnInsert')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                    ->pause(3000)
                    ->type('phoneManager', '2188888888')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                ->assertPresent('#whatsappManager')
                    ->type('whatsappManager', '')->press('#btnInsert')->waitForText('O whatsapp do manager da empresa é obrigatório')->assertSee('O whatsapp do manager da empresa é obrigatório')
                    ->type('whatsappManager', '11111111')->press('#btnInsert')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                    ->pause(3000)
                    ->type('whatsappManager', '2188888888')->press('#btnInsert')->waitForText('Por favor, confira') ->assertDontSee('Número de whatsapp inválido')
                
                ->assertPresent('#btnGroupAddon')
                ->assertPresent('#CEP')
                    ->type('CEP', '')->press('#btnGroupAddon')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
                    ->type('CEP', '111111')->press('#btnGroupAddon')->waitForText('CEP inválido')->assertSee('CEP inválido')
                    // ->type('CEP', '12345678')->press('#btnGroupAddon')->waitForText('O CEP inserido não existe')->assertSee('O CEP inserido não existe')
                    ->type('CEP', '')->press('#btnInsert')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
                    ->type('CEP', '111111')->press('#btnInsert')->waitForText('CEP inválido')->assertSee('CEP inválido')
                    ->pause(3000)
                    ->type('CEP', '24210050')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('CEP inválido')
                ->assertPresent('#cidade')
                    ->type('cidade', '')->press('#btnInsert')->waitForText('A cidade no endereço da empresa é obrigatório')->assertSee('A cidade no endereço da empresa é obrigatório')
                    ->pause(3000)
                    ->type('cidade', 'cidade')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('A cidade no endereço da empresa é obrigatório')
                ->assertPresent('#estado')
                    ->type('estado', '')->press('#btnInsert')->waitForText('O estado no endereço da empresa é obrigatório')->assertSee('O estado no endereço da empresa é obrigatório')
                    ->pause(3000)
                    ->type('estado', 'RJ')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O estado no endereço da empresa é obrigatório')
                ->assertPresent('#rua')
                    ->type('rua', '')->press('#btnInsert')->waitForText('A rua no endereço da empresa é obrigatório')->assertSee('A rua no endereço da empresa é obrigatório')
                    ->pause(3000)
                    ->type('rua', 'rua')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('A rua no endereço da empresa é obrigatório')
                ->assertPresent('#numero')
                    ->type('numero', '')->press('#btnInsert')->waitForText('O número no endereço da empresa é obrigatório')->assertSee('O número no endereço da empresa é obrigatório')
                    ->pause(3000)
                    ->type('numero', '100')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O número no endereço da empresa é obrigatório')
                ->assertPresent('#complemento')
                ->assertPresent('#bairro')
                    ->type('bairro', '')->press('#btnInsert')->waitForText('O bairro no endereço da empresa é obrigatório')->assertSee('O bairro no endereço da empresa é obrigatório')
                    ->pause(3000)
                    ->type('bairro', 'bairro')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O bairro no endereço da empresa é obrigatório')
                ->assertPresent('#description')

                ->assertPresent('#CNPJ')
                    ->type('CNPJ', '')->press('#btnInsert')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
                    ->type('CNPJ', '111111111')->press('#btnInsert')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    ->pause(3000)
                    ->type('CNPJ', '88495263000161')->press('#btnInsert')->waitForText('Por favor, confira', 10)->assertDontSee('CNPJ inválido')
                ->assertPresent('#nameCompany')
                    ->type('nameCompany', '')->press('#btnInsert')->waitForText('O nome da empresa é obrigatório')->assertSee('O nome da empresa é obrigatório')
                    ->pause(3000)
                    ->type('nameCompany', 'AAA_Company')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O nome da empresa é obrigatório')
                ->assertPresent('#phoneCompany')
                    ->type('phoneCompany', '11111111')->press('#btnInsert')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                    ->pause(3000)
                    ->type('phoneCompany', '2188888888')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                ->assertPresent('#emailCompany')
                    ->type('emailCompany', '')->press('#btnInsert')->waitForText('O e-mail da empresa é obrigatório')->assertSee('O e-mail da empresa é obrigatório')
                    ->type('emailCompany', 'emailInvalid')->press('#btnInsert')->waitForText('Email inválido')->assertSee('Email inválido')
                    ->pause(3000)
                    ->type('emailCompany', 'emailvalid@gmail.com')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                ->assertPresent('#amount_attendants')
                ->assertPresent('#whatsappCompany')
                    ->type('whatsappCompany', '')->press('#btnInsert')->waitForText('O whatsapp da empresa é obrigatório')->assertSee('O whatsapp da empresa é obrigatório')
                    ->type('whatsappCompany', '11111111')->press('#btnInsert')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                    ->type('whatsappCompany', '2188888888')->press('#btnInsert')->waitForText('Empresa adicionada com sucesso', 10)->assertSee('Empresa adicionada com sucesso');
                $browser->script('location.reload();');
            echo "OK -- Tested seller1 add a new company\n";
        });
    }

    
    /**
     *  @group seller
     * @return void
     */
    public function testingSellerEditCompany(){
        echo "\n ";
        $this->browse(function (Browser $browser) {

            $browser
                // ->maximize()

                ->with('#tableCompanies', function ($table) {
                    $table->assertSee('AAA_Company')
                    ->click('#editCompany');
                })
                ->whenAvailable('#editCompaniesModal', function ($modal) {
                    $modal
                        ->assertSee('Editar empresa')
                        ->assertSee('Dados da empresa')
                        ->assertSee('Endereço postal')
                        ->assertSee('Descrição da empresa')
                        ->assertSee('Dados do manager da empresa')
                        ->assertSee('Dados do canal de comunicação')
                        ->assertSee('Atualizar')
                        ->assertSee('Cancelar')

                        ->assertPresent('#nameManager')
                        ->assertPresent('#emailManager')
                        ->assertPresent('#CPF')
                        ->assertPresent('#phoneManager')
                        ->assertPresent('#whatsappManager')

                        ->assertPresent('#btnGroupAddon')
                        ->assertPresent('#CEP')
                        ->assertPresent('#cidade')
                        ->assertPresent('#estado')
                        ->assertPresent('#rua')
                        ->assertPresent('#numero')
                        ->assertPresent('#complemento')
                        ->assertPresent('#bairro')
                        ->assertPresent('#description')
                        ->assertPresent('#CNPJ')
                        ->assertPresent('#nameCompany')
                        ->assertPresent('#phoneCompany')
                        ->assertPresent('#emailCompany')
                        ->assertPresent('#amount_attendants')
                        ->assertPresent('#whatsappCompany')

                        ->assertPresent('#api_user')
                        ->assertPresent('#api_password')
                        ->assertPresent('#root_user')
                        ->assertPresent('#root_password')
                        ->assertPresent('#tcp_tunnel')
                        ->assertPresent('#tcp_port')
                        ->assertPresent('#mac')
                        ->assertPresent('#api_tunnel')
                        ->assertPresent('#soft_version')
                        ->assertPresent('#soft_version_date')
                        ->assertPresent('#btnEdit')
                        ->assertPresent('#btnCancel2')
                            ->press('#btnCancel2');
                });
            $browser
                ->waitUntilMissing('#btnCancel2')
                ->assertDontSee('Atualizar');
            $browser->script('location.reload();');
            echo "OK -- Tested seller1 check cancel botton of editCompaniesModal\n";

            $browser
                ->with('#tableCompanies', function ($table) {
                    $table->assertSee('AAA_Company')
                    ->click('#editCompany');
                })
                ->whenAvailable('#editCompaniesModal', function ($modal) {
                    $modal
                        ->type('nameManager', ' ') 
                        ->type('nameCompany', ' ')
                        ->press('#btnEdit');
                });
            $browser
                ->waitForText('Por favor, confira')
                ->assertSee('O nome da empresa é obrigatório')
                ->assertSee('O nome do manager da empresa é obrigatório');
            $browser->script('location.reload();');
            echo " OK -- Tested seller1 edit a company without mandatory data\n";
            
            $browser
                ->with('#tableCompanies', function ($table) {
                    $table->assertSee('AAA_Company')
                    ->click('#editCompany');
                })
                ->whenAvailable('#editCompaniesModal', function ($modal) {
                    $modal
                        ->type('nameManager', 'managerNameEdited')
                        ->type('nameCompany', 'AAA_CompanyEdited')
                        ->press('#btnEdit');
                });
            $browser
                ->waitForText('Dados atualizados corretamente', 10)
                ->assertSee('Dados atualizados corretamente');
            $browser->script('location.reload();');
            echo " OK -- Tested seller1 edit a company\n";
        });
    }



    /**
     *  @group seller
     * @return void
     */
    public function testingSellerDeleteCompany(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->with('#tableCompanies', function ($table) {
                    $table->assertSee('AAA_Company')
                    ->click('#deleteCompany');
                })
                ->whenAvailable('#deleteCompaniesModal', function ($modal) {
                    $modal
                        ->assertSee('Verificação de cancelamento')
                        ->assertSee('Tem certeza que deseja cancelar o contrato dessa Empresa')
                        ->assertSee('Eliminar')
                        ->assertSee('Cancelar')
                        ->assertPresent('#btnDelete')
                        ->assertPresent('#btnCancel1')
                            ->press('btnCancel1');
                });
            $browser
                ->waitUntilMissing('#btnCancel1')
                ->assertDontSee('Eliminar');
            echo "OK -- Tested seller1 check cancel botton of deleteCompaniesModal\n";

            $browser
                ->with('#tableCompanies', function ($table) {
                    $table->assertSee('AAA_Company')
                    ->click('#deleteCompany');
                })
                ->whenAvailable('#deleteCompaniesModal', function ($modal) {
                    $modal
                        ->assertPresent('#btnDelete')
                            ->press('#btnDelete');

                });
            $browser
                ->waitForText('Empresa eliminada com sucesso')
                ->assertSee('Empresa eliminada com sucesso');
            echo " OK -- Tested seller1 delete a company\n";
        });
    }

}

<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
                ->assertPresent('#addCompany')
                ->assertSee('Linhas por página:');

            echo " OK -- Tested login of user: seller1@socialhub.pro\n";
        });
    }

    // /**
    //  *  @group seller
    //  * @return void
    //  */
    // public function testingSellerAddCompany(){
    //     echo "\n ";
    //     $this->browse(function (Browser $browser)  {
    //         $browser
    //             ->click('#addCompany')
    //             ->waitForText('Nova empresa')
    //             ->assertSee('Nova empresa')

    //             ->assertSee('Endereço postal')
    //             ->assertSee('Descrição da empresa')
    //             ->assertSee('Dados do manager da empresa')
    //             ->assertSee('Adicionar')
    //             ->assertSee('Cancelar')

    //             ->assertPresent('#nameManager')
    //                 ->type('nameManager', '')->press('#btnInsert')->waitForText('O nome do manager da empresa é obrigatório')->assertSee('O nome do manager da empresa é obrigatório')
    //                 ->type('nameManager', 'correct name')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O nome do manager da empresa é obrigatório')
    //             ->assertPresent('#emailManager')
    //                 ->type('emailManager', '')->press('#btnInsert')->waitForText('O e-mail do manager da empresa é obrigatório')->assertSee('O e-mail do manager da empresa é obrigatório')
    //                 ->type('emailManager', 'emailInvalid')->press('#btnInsert')->waitForText('Email inválido')->assertSee('Email inválido')
    //                 ->type('emailManager', 'emailvalid2@gmail.com')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
    //             ->assertPresent('#CPF')
    //                 ->type('CPF', '')->press('#btnInsert')->waitForText('O CPF do manager da empresa é obrigatório')->assertSee('O CPF do manager da empresa é obrigatório')
    //                 ->type('CPF', '12345678910')->press('#btnInsert')->waitForText('CPF inválido')->assertSee('CPF inválido')
    //                 ->type('CPF', '08266391190')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('CPF inválido')
    //             ->assertPresent('#phoneManager')
    //                 ->type('phoneManager', '11111111')->press('#btnInsert')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
    //                 ->type('phoneManager', '2188888888')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
    //             ->assertPresent('#whatsappManager')
    //                 ->type('whatsappManager', '')->press('#btnInsert')->waitForText('O whatsapp do manager da empresa é obrigatório')->assertSee('O whatsapp do manager da empresa é obrigatório')
    //                 ->type('whatsappManager', '11111111')->press('#btnInsert')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
    //                 ->type('whatsappManager', '2188888888')->press('#btnInsert')->waitForText('Por favor, confira') ->assertSee('Número de whatsapp inválido')
                
    //             ->assertPresent('#btnGroupAddon')
    //             ->assertPresent('#CEP')
    //                 ->type('CEP', '')->press('#btnGroupAddon')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
    //                 ->type('CEP', '111111')->press('#btnGroupAddon')->waitForText('CEP inválido')->assertSee('CEP inválido')
    //                 // ->type('CEP', '12345678')->press('#btnGroupAddon')->waitForText('O CEP inserido não existe')->assertSee('O CEP inserido não existe')
    //                 ->type('CEP', '')->press('#btnInsert')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
    //                 ->type('CEP', '111111')->press('#btnInsert')->waitForText('CEP inválido')->assertSee('CEP inválido')
    //                 ->type('CEP', '24210050')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('CEP inválido')
    //             ->assertPresent('#cidade')
    //                 ->type('cidade', '')->press('#btnInsert')->waitForText('A cidade no endereço da empresa é obrigatório')->assertSee('A cidade no endereço da empresa é obrigatório')
    //                 ->pause(3000)
    //                 ->type('cidade', 'cidade')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('A cidade no endereço da empresa é obrigatório')
    //             ->assertPresent('#estado')
    //                 ->type('estado', '')->press('#btnInsert')->waitForText('O estado no endereço da empresa é obrigatório')->assertSee('O estado no endereço da empresa é obrigatório')
    //                 ->pause(3000)
    //                 ->type('estado', 'RJ')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O estado no endereço da empresa é obrigatório')
    //             ->assertPresent('#rua')
    //                 ->type('rua', '')->press('#btnInsert')->waitForText('A rua no endereço da empresa é obrigatório')->assertSee('A rua no endereço da empresa é obrigatório')
    //                 ->pause(3000)
    //                 ->type('rua', 'rua')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('A rua no endereço da empresa é obrigatório')
    //             ->assertPresent('#numero')
    //                 ->type('numero', '')->press('#btnInsert')->waitForText('O número no endereço da empresa é obrigatório')->assertSee('O número no endereço da empresa é obrigatório')
    //                 ->pause(3000)
    //                 ->type('numero', '100')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O número no endereço da empresa é obrigatório')
    //             ->assertPresent('#complemento')
    //             ->assertPresent('#bairro')
    //                 ->type('bairro', '')->press('#btnInsert')->waitForText('O bairro no endereço da empresa é obrigatório')->assertSee('O bairro no endereço da empresa é obrigatório')
    //                 ->pause(3000)
    //                 ->type('bairro', 'bairro')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O bairro no endereço da empresa é obrigatório')
    //             ->assertPresent('#description')

    //             ->assertPresent('#CNPJ')
    //                 ->type('CNPJ', '')->press('#btnInsert')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
    //                 ->type('CNPJ', '111111111')->press('#btnInsert')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
    //                 ->pause(3000)
    //                 ->type('CNPJ', '88495263000161')->press('#btnInsert')->waitForText('Por favor, confira', 10)->assertDontSee('CNPJ inválido')
    //             ->assertPresent('#nameCompany')
    //                 ->type('nameCompany', '')->press('#btnInsert')->waitForText('O nome da empresa é obrigatório')->assertSee('O nome da empresa é obrigatório')
    //                 ->pause(3000)
    //                 ->type('nameCompany', 'AAA_Company')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('O nome da empresa é obrigatório')
    //             ->assertPresent('#phoneCompany')
    //                 ->type('phoneCompany', '11111111')->press('#btnInsert')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
    //                 ->pause(3000)
    //                 ->type('phoneCompany', '2188888888')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
    //             ->assertPresent('#emailCompany')
    //                 ->type('emailCompany', '')->press('#btnInsert')->waitForText('O e-mail da empresa é obrigatório')->assertSee('O e-mail da empresa é obrigatório')
    //                 ->type('emailCompany', 'emailInvalid')->press('#btnInsert')->waitForText('Email inválido')->assertSee('Email inválido')
    //                 ->pause(3000)
    //                 ->type('emailCompany', 'emailvalid@gmail.com')->press('#btnInsert')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
    //             ->assertPresent('#amount_attendants')
    //             ->assertPresent('#whatsappCompany')
    //                 ->type('whatsappCompany', '')->press('#btnInsert')->waitForText('O whatsapp da empresa é obrigatório')->assertSee('O whatsapp da empresa é obrigatório')
    //                 ->type('whatsappCompany', '11111111')->press('#btnInsert')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
    //                 ->type('whatsappCompany', '2188888888')->press('#btnInsert')->waitForText('Empresa adicionada com sucesso', 10)->assertSee('Empresa adicionada com sucesso');

    //         echo "OK -- Tested seller1 add a new company\n";
    //     });
    // }

    
    /**
     *  @group seller
     * @return void
     */
    public function testingSellerEditCompany(){
        echo "\n ";
        $this->browse(function (Browser $browser)  {
            $browser
                ->with('#tableCompanies', function ($table) {
                    $table->assertSee('AAA_Company')
                    ->click('#editCompany');
                })
                ->waitForText('Editar empresa')
                ->assertSee('Dados da empresa')
                ->assertSee('Endereço postal')
                ->assertSee('Descrição da empresa')
                ->assertSee('Dados do manager da empresa')
                ->assertSee('Dados do canal de comunicação')
                ->assertSee('Atualizar')
                ->assertSee('Cancelar')
                
                ->assertPresent('#nameManager')
                    ->type('nameManager', '')->press('#btnEdit')->waitForText('O nome do manager da empresa é obrigatório')->assertSee('O nome do manager da empresa é obrigatório')
                    ->type('nameManager', 'managerNameEdited')
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
                    ->type('nameCompany', '')->press('#btnEdit')->waitForText('O nome da empresa é obrigatório')->assertSee('O nome da empresa é obrigatório')
                    ->pause(3000)
                    ->type('nameCompany', 'AAA_CompanyEdited')
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

                    
                ->press('#btnEdit')->waitForText('Dados atualizados corretamente', 10)->assertSee('Dados atualizados corretamente');

            echo "OK -- Tested seller1 edit a company\n";
        });
    }


    
    // /**
    //  *  @group seller
    //  * @return void
    //  */
    // public function testingSellerDeleteCompany(){
    //     echo "\n ";
    //     $this->browse(function (Browser $browser)  {
    //         $browser
    //             ->with('#tableCompanies', function ($table) {
    //                 $table->assertSee('AAA_Company')
    //                 ->click('#deleteCompany');
    //             })
    //             ->waitForText('Verificação de cancelamento')
    //             ->assertSee('Tem certeza que deseja cancelar o contrato dessa Empresa')
    //             ->assertSee('Eliminar')
    //             ->assertSee('Cancelar')

    //             ->press('#btnDelete')
    //                 ->waitForText('Empresa eliminada com sucesso')
    //                 ->assertSee('Empresa eliminada com sucesso');

    //             // ->press('#btnCancel');

    //             echo "OK -- Tested seller1 delete a company\n";
    //     });
    // }





}

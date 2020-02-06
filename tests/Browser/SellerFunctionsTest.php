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

                // ->click('#addCompany')
                // ->waitForText('Nova empresa')
                // ->assertSee('Nova empresa');
            echo " OK -- Tested login of user: seller1@socialhub.pro\n";
        });
    }

    // /**
    //  *  @group seller
    //  * @return void
    //  */
    // public function testingSellerAddCompanySuccessful(){
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

    //             ->assertPresent('#CNPJ')
    //                 ->type('CNPJ', '88495263000161')
    //             ->assertPresent('#nameCompany')
    //                 ->type('nameCompany', 'correct name')
    //             ->assertPresent('#phoneCompany')
    //                 ->type('phoneCompany', '2188888888')
    //             ->assertPresent('#emailCompany')
    //                 ->type('emailCompany', 'emailvalid@gmail.com')
    //             ->assertPresent('#whatsappCompany')
    //                 ->type('whatsappCompany', '2188888888')
    //             ->assertPresent('#amount_attendants')
    //             ->assertPresent('#btnGroupAddon')
    //             ->assertPresent('#CEP')
    //                 ->type('CEP', '24210050')
    //             ->assertPresent('#cidade')
    //                 ->type('cidade', 'cidade')
    //             ->assertPresent('#estado')
    //                 ->type('estado', 'estado')
    //             ->assertPresent('#rua')
    //                 ->type('rua', 'rua')
    //             ->assertPresent('#numero')
    //                 ->type('numero', '100')
    //             ->assertPresent('#complemento')
    //             ->assertPresent('#bairro')
    //                 ->type('bairro', 'bairro')
    //             ->assertPresent('#description')

    //             ->assertPresent('#nameManager')
    //                 ->type('nameManager', 'correct name')
    //             ->assertPresent('#emailManager')
    //                 ->type('emailManager', 'emailvalid@gmail.com')
    //             ->assertPresent('#CPF')
    //                 ->type('CPF', '2188888888')
    //             ->assertPresent('#phoneManager')
    //                 ->type('phoneManager', '2188888888')
    //             ->assertPresent('#whatsappManager')
    //                 ->type('whatsappManager', '2188888888')
    //                 ->press('Adicionar')->waitForText('Empresa adicionada com sucesso') ->assertSee('Empresa adicionada com sucesso');
                   
    //         echo "OK -- Tested seller1 add a new company\n";    
    //     });
    // }
        
    /**
     *  @group seller
     * @return void
     */
    public function testingSellerAddCompanyCNPJ(){
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

                ->assertPresent('#CNPJ')
                    
                    ->type('CNPJ', '')->press('Adicionar')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
                    // ->type('CNPJ', '111111111')->press('Adicionar')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    ->type('CNPJ', '88495263000161')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CNPJ inválido');
                
        });
        
    }
    /**
     *  @group seller
     * @return void
     */
    public function testingSellerAddCompanyCNPJ(){
        echo "\n ";

        $this->browse(function (Browser $browser)  {
            $browser
                               
                ->assertPresent('#CNPJ')
                    
                    ->type('CNPJ', '')->press('Adicionar')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
                    // ->type('CNPJ', '111111111')->press('Adicionar')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    ->type('CNPJ', '88495263000161')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CNPJ inválido');
                
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

                ->assertPresent('#CNPJ')

                    ->type('CNPJ', '')->press('Adicionar')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
                    // ->type('CNPJ', '111111111')->press('Adicionar')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    ->type('CNPJ', '88495263000161')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CNPJ inválido');
                
                // ->type('nameCompany', 'correct name') ->type('emailCompany', 'emailvalid@gmail.com') ->type('whatsappCompany', '2188888888') ->type('CEP', '24210050')
                // ->type('cidade', 'cidade') ->type('estado', 'estado') ->type('rua', 'rua') ->type('numero', '100') ->type('bairro', 'bairro')
                

                // ->assertPresent('#nameCompany')
                //     // ->type('nameCompany', '')->press('Adicionar')->waitForText('O nome da empresa é obrigatório')->assertSee('O nome da empresa é obrigatório')
                //     // ->type('nameCompany', 'correct name')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('O nome da empresa é obrigatório')
                // ->assertPresent('#phoneCompany')
                //     // ->type('phoneCompany', '11111111')->press('Adicionar')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                //     // ->type('phoneCompany', '2188888888')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                // ->assertPresent('#emailCompany')
                //     // ->type('emailCompany', '')->press('Adicionar')->waitForText('O e-mail da empresa é obrigatório')->assertSee('O e-mail da empresa é obrigatório')
                //     // ->type('emailCompany', 'emailInvalid')->press('Adicionar')->waitForText('Email inválido')->assertSee('Email inválido')
                //     // ->type('emailCompany', 'emailvalid@gmail.com')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                // ->assertPresent('#whatsappCompany')
                //     // ->type('whatsappCompany', '')->press('Adicionar')->waitForText('O whatsapp da empresa é obrigatório')->assertSee('O whatsapp da empresa é obrigatório')
                //     // ->type('whatsappCompany', '11111111')->press('Adicionar')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                //     // ->type('whatsappCompany', '2188888888')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Número de whatsapp inválido')
                // ->assertPresent('#amount_attendants')
                // ->assertPresent('#btnGroupAddon')
                // ->assertPresent('#CEP')
                //     // ->type('CEP', '')->press('#btnGroupAddon')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
                //     // ->type('CEP', '111111')->press('#btnGroupAddon')->waitForText('CEP inválido')->assertSee('CEP inválido')
                //     // ->type('CEP', '12345678')->press('#btnGroupAddon')->waitForText('O CEP inserido não existe')->assertDontSee('O CEP inserido não existe')
                //     // ->type('CEP', '24210050')->press('#btnGroupAddon')->waitForText('Niterói')->assertDontSee('Niterói')
                //     // ->type('CEP', '')->press('Adicionar')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
                //     // ->type('CEP', '111111')->press('Adicionar')->waitForText('CEP inválido')->assertSee('CEP inválido')
                //     // ->type('CEP', '24210050')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CEP inválido')
                // ->assertPresent('#cidade')
                //     // ->type('cidade', '')->press('Adicionar')->waitForText('A cidade no endereço da empresa é obrigatório')->assertSee('A cidade no endereço da empresa é obrigatório')
                //     // ->type('cidade', 'cidade')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('A cidade no endereço da empresa é obrigatório')
                // ->assertPresent('#estado')
                //     // ->type('estado', '')->press('Adicionar')->waitForText('O estado no endereço da empresa é obrigatório')->assertSee('O estado no endereço da empresa é obrigatório')
                //     // ->type('estado', 'estado')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('O estado no endereço da empresa é obrigatório')
                // ->assertPresent('#rua')
                //     // ->type('rua', '')->press('Adicionar')->waitForText('A rua no endereço da empresa é obrigatório')->assertSee('A rua no endereço da empresa é obrigatório')
                //     // ->type('rua', 'rua')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('A rua no endereço da empresa é obrigatório')
                // ->assertPresent('#numero')
                //     // ->type('numero', '')->press('Adicionar')->waitForText('O número no endereço da empresa é obrigatório')->assertSee('O número no endereço da empresa é obrigatório')
                //     // ->type('numero', '100')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('O número no endereço da empresa é obrigatório')
                // ->assertPresent('#complemento')
                // ->assertPresent('#bairro')
                //     // ->type('bairro', '')->press('Adicionar')->waitForText('O bairro no endereço da empresa é obrigatório')->assertSee('O bairro no endereço da empresa é obrigatório')
                //     // ->type('bairro', 'bairro')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('O bairro no endereço da empresa é obrigatório')
                // ->assertPresent('#description')

                // ->assertPresent('#nameManager')
                //     ->type('nameManager', '')->press('Adicionar')->waitForText('O nome do manager da empresa é obrigatório')->assertSee('O nome do manager da empresa é obrigatório')
                //     // ->type('nameManager', 'correct name')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('O nome do manager da empresa é obrigatório')
                //     ->type('nameManager', 'correct name')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Ooooo nome do manager da empresa é obrigatório')
                // ->assertPresent('#emailManager')
                //     ->type('emailManager', '')->press('Adicionar')->waitForText('O e-mail do manager da empresa é obrigatório')->assertSee('O e-mail do manager da empresa é obrigatório')
                //     ->type('emailManager', 'emailInvalid')->press('Adicionar')->waitForText('Email inválido')->assertSee('Email inválido')
                //     ->type('emailManager', 'emailvalid@gmail.com')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                // ->assertPresent('#CPF')
                //     ->type('CPF', '')->press('Adicionar')->waitForText('O CPF do manager da empresa é obrigatório')->assertSee('O CPF do manager da empresa é obrigatório')
                //     ->type('CPF', '12345678910')->press('Adicionar')->waitForText('CPF inválido')->assertSee('CPF inválido')
                //     ->type('CPF', '2188888888')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CPF inválido')
                // ->assertPresent('#phoneManager')
                //     ->type('phoneManager', '11111111')->press('Adicionar')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                //     ->type('phoneManager', '2188888888')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                // ->assertPresent('#whatsappManager')
                //     ->type('whatsappManager', '')->press('Adicionar')->waitForText('O whatsapp do manager da empresa é obrigatório')->assertSee('O whatsapp do manager da empresa é obrigatório')
                //     ->type('whatsappManager', '11111111')->press('Adicionar')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                //     ->type('whatsappManager', '2188888888')->press('Adicionar')->waitForText('Empresa adicionada com sucesso') ->assertSee('Empresa adicionada com sucesso');
                   
            echo "OK -- Tested seller1 add a new company\n";
        });
    }

    


}

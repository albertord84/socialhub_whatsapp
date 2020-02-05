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

    /**
     *  @group seller
     * @return void
     */
    public function testingSellerAddCompany(){
        echo "\n ";
        $this->browse(function ($browser)  {
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
                    ->type('CNPJ', '111111111')->press('Adicionar')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    ->type('CNPJ', '88495263000161')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CNPJ inválido')
                ->assertPresent('#nameCompany')
                    ->type('nameCompany', '')->press('Adicionar')->waitForText('O nome da empresa é obrigatório')->assertSee('O nome da empresa é obrigatório')
                    ->type('nameCompany', 'correct name')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('O nome da empresa é obrigatório')
                ->assertPresent('#phoneCompany')
                    ->type('phoneCompany', '11111111')->press('Adicionar')->waitForText('Número de telefone inválido')->assertSee('Número de telefone inválido')
                    ->type('phoneCompany', '2188888888')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Número de telefone inválido')
                ->assertPresent('#emailCompany')
                    ->type('emailCompany', '')->press('Adicionar')->waitForText('O e-mail da empresa é obrigatório')->assertSee('O e-mail da empresa é obrigatório')
                    ->type('emailCompany', 'emailInvalid')->press('Adicionar')->waitForText('Email inválido')->assertSee('Email inválido')
                    ->type('emailCompany', 'emailvalid@gmail.com')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Email inválido')
                ->assertPresent('#whatsappCompany')
                    ->type('whatsappCompany', '')->press('Adicionar')->waitForText('O whatsapp da empresa é obrigatório')->assertSee('O whatsapp da empresa é obrigatório')
                    ->type('whatsappCompany', '11111111')->press('Adicionar')->waitForText('Número de whatsapp inválido')->assertSee('Número de whatsapp inválido')
                    ->type('whatsappCompany', '2188888888')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('Número de whatsapp inválido')
                ->assertPresent('#amount_attendants')
                ->assertPresent('#btnGroupAddon')
                ->assertPresent('#CEP')
                    ->type('CEP', '')->press('#btnGroupAddon')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
                    ->type('CEP', '111111')->press('#btnGroupAddon')->waitForText('CEP inválido')->assertSee('CEP inválido')
                    ->type('CEP', '12345678')->press('#btnGroupAddon')->waitForText('O CEP inserido não existe')->assertDontSee('O CEP inserido não existe')
                    ->type('CEP', '24210050')->press('#btnGroupAddon')->waitForText('Niterói')->assertDontSee('Niterói')
                    ->type('CEP', '')->press('Adicionar')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')
                    ->type('CEP', '111111')->press('Adicionar')->waitForText('CEP inválido')->assertSee('CEP inválido')
                    ->type('CEP', '24210050')->press('Adicionar')->waitForText('Por favor, confira')->assertDontSee('CEP inválido')

                ->assertPresent('#cidade')
                ->type('cidade', '')->press('Adicionar')->waitForText('O CEP da empresa é obrigatório')->assertSee('O CEP da empresa é obrigatório')



                ->assertPresent('#estado')

                ->assertPresent('#rua')

                ->assertPresent('#numero')

                ->assertPresent('#complemento')
                ->assertPresent('#bairro')
                ->assertPresent('#description')

                ->assertPresent('#nameManager')
                ->assertPresent('#emailManager')
                ->assertPresent('#CPF')
                ->assertPresent('#phoneManager')

                ->assertPresent('#whatsappManager');
                    // ->type('whatsapp_id', '')->press('Adicionar')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
                    // ->type('whatsapp_id', '111111111')->press('Adicionar')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    // ->type('whatsapp_id', '88495263000161')->press('Adicionar')->waitForText('Empresas adicionada com seucesddo')->assertSee('Empresas adicionada com seucesddo');
        


                
                

                
            echo "OK -- Tested seller1 add a new company\n";
        });
    }

    


}

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
                ->assertPresent('#name')
                    ->type('CNPJ', 'correct name')
                ->assertPresent('#phoneCompany')
                ->assertPresent('#email')
                ->assertPresent('#whatsapp')
                ->assertPresent('#amount_attendants')
                ->assertPresent('#CEP')
                ->assertPresent('#cidade')
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

                ->assertPresent('#whatsapp_id');
                    // ->type('whatsapp_id', '')->press('Adicionar')->waitForText('O CNPJ é obrigatório')->assertSee('O CNPJ é obrigatório')
                    // ->type('whatsapp_id', '111111111')->press('Adicionar')->waitForText('CNPJ inválido')->assertSee('CNPJ inválido')
                    // ->type('whatsapp_id', '88495263000161')->press('Adicionar')->waitForText('Empresas adicionada com seucesddo')->assertSee('Empresas adicionada com seucesddo');
        


                
                

                
            echo "OK -- Tested seller1 add a new company\n";
        });
    }

    


}

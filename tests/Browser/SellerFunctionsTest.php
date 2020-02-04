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
                ->assertSee('Senha');
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
                ->assertSee('Linhas por página:')

                ->click('#addCompany')
                ->waitForText('Nova empresa')
                ->assertSee('Nova empresa');
            echo " OK -- Tested login of user: seller1@socialhub.pro\n";
        });
    }

    /**
     * * @group seller
     * @return void
     */
    public function testingSellerAddCompany(){
        echo "\n ";
        $this->browse(function ($browser)  {
            $browser->visit('/')
            ->type('email', 'seller1@socialhub.pro')
            ->type('password', 'seller1')
            ->press('Entrar')
            ->waitForText('Empresas')
            ->assertSee('Empresas')
            ->assertPresent('#logged_user_name')
            ->assertPresent('#addCompany')
            ->assertSee('Linhas por página:')

            ->click('#addCompany')
            ->waitForText('Nova empresa')
            ->assertSee('Nova empresa')

            ->assertSee('Endereço postal')
            ->assertSee('Descrição da empresa')
            ->assertSee('Dados do manager da empresa')
            ->assertSee('Adicionar')
            ->assertSee('Cancelar')

            ->assertPresent('#CNPJ')
                ->type('CNPJ', '111111111')->press('Adicionar')->waitForText('Por favor, confira')->assertSee('Por favor, confira')->type('CNPJ', '88495263000161')
            ->assertPresent('#name')
                ->type('name', 'Company#$%DuskTest')->press('Adicionar')->waitForText('Por favor, confira')->assertSee('Por favor, confira')->type('name', 'CompanyDuskTest')
            ->assertPresent('#phoneCompany')
                ->type('phoneCompany', '123456')->press('Adicionar')->waitForText('Por favor, confira')->assertSee('Por favor, confira')->type('phoneCompany', '5521965913089')
            ->assertPresent('#email')
                ->type('email', '123456')->press('Adicionar')->waitForText('Por favor, confira')->assertSee('Por favor, confira')->type('phoneCompany', 'jgonzalez@ic.uff.br')
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


            // ->type('email', 'seller1@socialhub.pro')
            // ->type('password', 'seller1')
            // ->press('Entrar')
            // ->waitForText('Empresas')
            // ->assertSee('Empresas')
            // ->assertPresent('#logged_user_name')
            // ->assertPresent('#addCompany')
            // ->assertSee('Linhas por página:')

                
            echo "OK -- Tested seller1 add a new company\n";
        });
    }

    


}

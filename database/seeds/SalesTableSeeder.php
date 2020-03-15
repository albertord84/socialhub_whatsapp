<?php

use Illuminate\Database\Seeder;
use App\Models\Sales;

class SalesTableSeeder extends Seeder
{
    public $sales;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->sales = new Sales();
        $this->command->info('Truncate Sales Table...');
        // DB::table('socialhub_mvp.sales.1')->truncate();
        $this->command->info('Creating Sales:');
        $this->createSales();
    }
    
    public function createSales(){
        $this->sales->table = "1";
        $this->sales->create([
            'id' => 1,
            'contact_id' => 1,
            'source' => '1',
            'sended' => '0',
            'json_data' => '{"pedido":{"desconto":"0,00","observacoes":"","observacaointerna":"","data":"2020-02-19","numero":"9","numeroOrdemCompra":"","vendedor":"","valorfrete":"0.00","totalprodutos":"6.00","totalvenda":"6.00","situacao":"Em aberto","dataSaida":"2020-02-19","loja":"203390210","numeroPedidoLoja":"2331330936","tipoIntegracao":"MercadoLivre","cliente":{"id":"7559868364","nome":"Frederico Flores","cnpj":"","ie":"","rg":"","endereco":"","numero":"","complemento":"","cidade":"","bairro":"N\u00e3o Informado","cep":null,"uf":"","email":"fflores.95rywk+2-ogiztgmjtgmydsobu@mail.mercadolivre.com","celular":"","fone":"11999360066"},"itens":[{"item":{"codigo":null,"descricao":"Caneta Bic Azul","quantidade":"1.0000","valorunidade":"6.0000000000","precocusto":null,"descontoItem":"0.00","un":"UN","pesoBruto":null,"largura":null,"altura":null,"profundidade":null,"descricaoDetalhada":"","unidadeMedida":"m","gtin":null}}],"parcelas":[{"parcela":{"idLancamento":0,"valor":"6.00","dataVencimento":"2020-03-20 00:00:00","obs":"M\u00e9todo de pagamento: account_money","destino":1,"forma_pagamento":{"id":897799,"descricao":"Conta a receber\/pagar","codigoFiscal":15}}}],"transporte":{"enderecoEntrega":{"nome":"Frederico Flores","endereco":"","numero":"","complemento":"","cidade":"","bairro":"N\u00e3o Informado","cep":".-","uf":""}}}}'            
        ]);
        $this->sales->create([
            'id' => 2,
            'contact_id' => 1,
            'source' => '1',
            'sended' => '1',
            'json_data' => '{"pedido":{"desconto":"0,00","observacoes":"","observacaointerna":"","data":"2020-02-19","numero":"9","numeroOrdemCompra":"","vendedor":"","valorfrete":"0.00","totalprodutos":"6.00","totalvenda":"6.00","situacao":"Em aberto","dataSaida":"2020-02-19","loja":"203390210","numeroPedidoLoja":"2331330936","tipoIntegracao":"MercadoLivre","cliente":{"id":"7559868364","nome":"Frederico Flores","cnpj":"","ie":"","rg":"","endereco":"","numero":"","complemento":"","cidade":"","bairro":"N\u00e3o Informado","cep":null,"uf":"","email":"fflores.95rywk+2-ogiztgmjtgmydsobu@mail.mercadolivre.com","celular":"","fone":"11999360066"},"itens":[{"item":{"codigo":null,"descricao":"Caneta Bic Azul","quantidade":"1.0000","valorunidade":"6.0000000000","precocusto":null,"descontoItem":"0.00","un":"UN","pesoBruto":null,"largura":null,"altura":null,"profundidade":null,"descricaoDetalhada":"","unidadeMedida":"m","gtin":null}}],"parcelas":[{"parcela":{"idLancamento":0,"valor":"6.00","dataVencimento":"2020-03-20 00:00:00","obs":"M\u00e9todo de pagamento: account_money","destino":1,"forma_pagamento":{"id":897799,"descricao":"Conta a receber\/pagar","codigoFiscal":15}}}],"transporte":{"enderecoEntrega":{"nome":"Frederico Flores","endereco":"","numero":"","complemento":"","cidade":"","bairro":"N\u00e3o Informado","cep":".-","uf":""}}}}',            
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');
    }


}

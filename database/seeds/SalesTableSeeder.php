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
            'json_data' => '{"pedido":{"desconto":"0,00","observacoes":"N\u00ba Pedidos na Loja: 2334946725\nGILGO\n\n","observacaointerna":"","data":"2020-02-24","numero":"15407","numeroOrdemCompra":"","vendedor":"","valorfrete":"0.00","totalprodutos":"148.00","totalvenda":"148.00","situacao":"Atendido","dataSaida":"2020-02-27","loja":"203238853","numeroPedidoLoja":"2334946725","tipoIntegracao":"MercadoLivre","cliente":{"id":"6477965563","nome":"Ismael Alexandrino J\u00fanior (gilgo)","cnpj":"702.251.501-82","ie":"","rg":"","endereco":"Alameda Das Espat\u00f3dias","numero":"12","complemento":"Quadra 44, Lote 12","cidade":"Goi\u00e2nia","bairro":"Residencial Aldeia do Vale","cep":"74680160","uf":"GO","email":"gmartin.8gzhch+2-ogiztgnbzgq3donru@mail.mercadolivre.com","celular":"61983294846","fone":"6461983294846"},"itens":[{"item":{"codigo":"SPA.TMU.CP.01.55","descricao":"MAGAZINE DE MUNICIAMENTO PR900W, CP1-M, LR700W, CP2, SR900S, CR600W 5.5MM","quantidade":"1.0000","valorunidade":"148.0000000000","precocusto":"118.8000000000","descontoItem":"0.00","un":"UN","pesoBruto":"0.100","largura":"18","altura":"3","profundidade":"20","descricaoDetalhada":"","unidadeMedida":"cm","gtin":"8650000000146"}}],"parcelas":[{"parcela":{"idLancamento":7595540087,"valor":"148.00","dataVencimento":"2020-02-25 00:00:00","obs":"M\u00e9todo de pagamento: bolbradesco | Pedidos Vinculados: 2334946725","destino":1,"forma_pagamento":{"id":375043,"descricao":"Conta a receber\/pagar","codigoFiscal":15}}}],"nota":{"serie":"1","numero":"006702","dataEmissao":"2020-02-27 10:58:25","situacao":7,"valorNota":"116.27","chaveAcesso":"41200231488248000177550010000067021955400220"},"transporte":{"enderecoEntrega":{"nome":"Ismael Alexandrino J\u00fanior (GILGO)","endereco":"Alameda Das Espat\u00f3dias","numero":"12","complemento":"Quadra 44, Lote 12","cidade":"Goi\u00e2nia","bairro":"Residencial Aldeia do Vale","cep":"74.680-160","uf":"GO"},"volumes":[{"volume":{"idServico":"7094732937","servico":"Normal (100009)","codigoRastreamento":"PW322864001BR","valorFretePrevisto":"0.00","remessa":null,"dataSaida":"2020-02-27","prazoEntregaPrevisto":null,"valorDeclarado":"148.00","avisoRecebimento":true,"maoPropria":false,"dimensoes":{"peso":"0.100","altura":"0","largura":"0","comprimento":"0","diametro":"0"}}},{"volume":{"idServico":"7094732937","servico":"Normal (100009)","codigoRastreamento":"PW322864001BR","valorFretePrevisto":"0.00","remessa":null,"dataSaida":"2020-02-27","prazoEntregaPrevisto":null,"valorDeclarado":"148.00","avisoRecebimento":true,"maoPropria":false,"dimensoes":{"peso":"0.100","altura":"0","largura":"0","comprimento":"0","diametro":"0"}}}],"servico_correios":"Normal (100009)"},"codigosRastreamento":{"codigoRastreamento":"PW322864001BR"}}}',            
        ]);
        $this->sales->create([
            'id' => 2,
            'contact_id' => 1,
            'source' => '1',
            'sended' => '1',
            'json_data' => '{"pedido":{"desconto":"0,00","observacoes":"N\u00ba Pedidos na Loja: 2334946725\nGILGO\n\n","observacaointerna":"","data":"2020-02-24","numero":"15407","numeroOrdemCompra":"","vendedor":"","valorfrete":"0.00","totalprodutos":"148.00","totalvenda":"148.00","situacao":"Atendido","dataSaida":"2020-02-27","loja":"203238853","numeroPedidoLoja":"2334946725","tipoIntegracao":"MercadoLivre","cliente":{"id":"6477965563","nome":"Ismael Alexandrino J\u00fanior (gilgo)","cnpj":"702.251.501-82","ie":"","rg":"","endereco":"Alameda Das Espat\u00f3dias","numero":"12","complemento":"Quadra 44, Lote 12","cidade":"Goi\u00e2nia","bairro":"Residencial Aldeia do Vale","cep":"74680160","uf":"GO","email":"gmartin.8gzhch+2-ogiztgnbzgq3donru@mail.mercadolivre.com","celular":"61983294846","fone":"6461983294846"},"itens":[{"item":{"codigo":"SPA.TMU.CP.01.55","descricao":"MAGAZINE DE MUNICIAMENTO PR900W, CP1-M, LR700W, CP2, SR900S, CR600W 5.5MM","quantidade":"1.0000","valorunidade":"148.0000000000","precocusto":"118.8000000000","descontoItem":"0.00","un":"UN","pesoBruto":"0.100","largura":"18","altura":"3","profundidade":"20","descricaoDetalhada":"","unidadeMedida":"cm","gtin":"8650000000146"}}],"parcelas":[{"parcela":{"idLancamento":7595540087,"valor":"148.00","dataVencimento":"2020-02-25 00:00:00","obs":"M\u00e9todo de pagamento: bolbradesco | Pedidos Vinculados: 2334946725","destino":1,"forma_pagamento":{"id":375043,"descricao":"Conta a receber\/pagar","codigoFiscal":15}}}],"nota":{"serie":"1","numero":"006702","dataEmissao":"2020-02-27 10:58:25","situacao":7,"valorNota":"116.27","chaveAcesso":"41200231488248000177550010000067021955400220"},"transporte":{"enderecoEntrega":{"nome":"Ismael Alexandrino J\u00fanior (GILGO)","endereco":"Alameda Das Espat\u00f3dias","numero":"12","complemento":"Quadra 44, Lote 12","cidade":"Goi\u00e2nia","bairro":"Residencial Aldeia do Vale","cep":"74.680-160","uf":"GO"},"volumes":[{"volume":{"idServico":"7094732937","servico":"Normal (100009)","codigoRastreamento":"PW322864001BR","valorFretePrevisto":"0.00","remessa":null,"dataSaida":"2020-02-27","prazoEntregaPrevisto":null,"valorDeclarado":"148.00","avisoRecebimento":true,"maoPropria":false,"dimensoes":{"peso":"0.100","altura":"0","largura":"0","comprimento":"0","diametro":"0"}}},{"volume":{"idServico":"7094732937","servico":"Normal (100009)","codigoRastreamento":"PW322864001BR","valorFretePrevisto":"0.00","remessa":null,"dataSaida":"2020-02-27","prazoEntregaPrevisto":null,"valorDeclarado":"148.00","avisoRecebimento":true,"maoPropria":false,"dimensoes":{"peso":"0.100","altura":"0","largura":"0","comprimento":"0","diametro":"0"}}}],"servico_correios":"Normal (100009)"},"codigosRastreamento":{"codigoRastreamento":"PW322864001BR"}}}',            
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');
    }


}

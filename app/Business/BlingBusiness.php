<?php

namespace App\Business;

use App\Models\Company;
use App\Repositories\BlingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class BlingBusiness extends Business
{

    public function __construct()
    {
        parent::__construct();

        $this->repo = new BlingRepository(app());
    }

    public function getBlingSales(): Collection
    {
        $Sales = new Collection();
        try {
            $Companies = Company::with('rpi')->where(['bling_contrated' => true])->get();

            $SalesBussines = new SalesBusiness();
            foreach ($Companies as $key => $Company) {
                $Sales = $this->getBlingCompanySales($Company);

                foreach ($Sales as $key => $Sale) {
                    $SalesBussines->createSale($Sale, $Company);
                }
            }
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Sales;
    }

    public function getBlingCompanySales(Company $Company): Collection
    {
        $Sales = new Collection();
        try {
            $client = new \GuzzleHttp\Client();

            $url = env('URL_BLING_SALES', 'https://bling.com.br/Api/v2/pedidos/json/');

            // $yesterday = Carbon::yesterday()->subDays(3)->format('d/m/Y');
            $yesterday = Carbon::yesterday()->format('d/m/Y');
            $today = Carbon::now()->format('d/m/Y');

            $response = $client->request('GET', $url, [
                'query' => [
                    'apikey' => $Company->bling_apikey,
                    'filters' => "dataEmissao[$today TO $today]",
                ],
            ]);

            $Content = $response->getBody()->getContents();
            $Content = json_decode($Content);

            if ($Content && isset($Content->retorno->pedidos)) {
                $Sales = new Collection($Content->retorno->pedidos);
            }
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }

        return $Sales;
    }

    public function testBlingAPIKey(string $bling_apikey = null) //: MyResponse
    {
        try {
            $client = new \GuzzleHttp\Client();

            $url = env('URL_BLING_SALES', 'https://bling.com.br/Api/v2/pedidos/json/');

            //$yesterday = Carbon::yesterday()->format('dc/m/Y');
            $today = Carbon::now()->format('d/m/Y');

            $response = $client->request('GET', $url, [
                'query' => [
                    'apikey' => $bling_apikey,
                    'filters' => "dataEmissao[$today TO $today]",
                ],
            ]);

            $Content = $response->getBody()->getContents();

            $Content = json_decode($Content);

            if ($Content && isset($Content->retorno->pedidos)) {
                return true;
            }
        } catch (\Throwable $th) {
            return json_decode(MyResponse::makeExceptionJson($th));
        }

        return json_decode(MyResponse::makeResponseJson("Unexpected error with bling connection", $Content, -1, false));;
    }
}

// {"pedido":{"desconto":"0,00","observacoes":"","observacaointerna":"","data":"2020-02-13","numero":"2","numeroOrdemCompra":"","vendedor":"","valorfrete":"0.00","totalprodutos":"6.00","totalvenda":"6.00","situacao":"Em aberto","loja":"203395636","numeroPedidoLoja":"2324665257","tipoIntegracao":"MercadoLivre","cliente":{"id":"7519258851","nome":"J\u00e9ssica Mello (mej4290244)","cnpj":"","ie":"","rg":"","endereco":"","numero":"","complemento":"","cidade":"","bairro":"N\u00e3o Informado","cep":null,"uf":"","email":"jmello.sdm2b52+2-ogiztenbwgy2teobx@mail.mercadolivre.com","celular":"","fone":" 21969791284"},"itens":[{"item":{"codigo":null,"descricao":"Caneta Bic Azul","quantidade":"1.0000","valorunidade":"6.0000000000","precocusto":null,"descontoItem":"0.00","un":"UN","pesoBruto":null,"largura":null,"altura":null,"profundidade":null,"descricaoDetalhada":"","unidadeMedida":"m","gtin":null}}],"parcelas":[{"parcela":{"idLancamento":0,"valor":"6.00","dataVencimento":"2020-03-14 00:00:00","obs":"M\u00e9todo de pagamento: master","destino":1,"forma_pagamento":{"id":897799,"descricao":"Conta a receber\/pagar","codigoFiscal":15}}}],"transporte":{"enderecoEntrega":{"nome":"J\u00e9ssica Mello (MEJ4290244)","endereco":"","numero":"","complemento":"","cidade":"","bairro":"N\u00e3o Informado","cep":".-","uf":""}}}}

/*
{#912 ▼
+"pedido": {#929 ▼
+"desconto": "0,00"
+"observacoes": ""
+"observacaointerna": ""
+"data": "2020-02-13"
+"numero": "2"
+"numeroOrdemCompra": ""
+"vendedor": ""
+"valorfrete": "0.00"
+"totalprodutos": "6.00"
+"totalvenda": "6.00"
+"situacao": "Em aberto"
+"loja": "203395636"
+"numeroPedidoLoja": "2324665257"
+"tipoIntegracao": "MercadoLivre"
+"cliente": {#927 ▼
+"id": "7519258851"
+"nome": "Jéssica Mello (mej4290244)"
+"cnpj": ""
+"ie": ""
+"rg": ""
+"endereco": ""
+"numero": ""
+"complemento": ""
+"cidade": ""
+"bairro": "Não Informado"
+"cep": null
+"uf": ""
+"email": "jmello.sdm2b52+2-ogiztenbwgy2teobx@mail.mercadolivre.com"
+"celular": ""
+"fone": " 21969791284"
}
+"itens": array:1 [▼
0 => {#923 ▼
+"item": {#913 ▼
+"codigo": null
+"descricao": "Caneta Bic Azul"
+"quantidade": "1.0000"
+"valorunidade": "6.0000000000"
+"precocusto": null
+"descontoItem": "0.00"
+"un": "UN"
+"pesoBruto": null
+"largura": null
+"altura": null
+"profundidade": null
+"descricaoDetalhada": ""
+"unidadeMedida": "m"
+"gtin": null
}
}
]
+"parcelas": array:1 [▼
0 => {#914 ▼
+"parcela": {#917 ▼
+"idLancamento": 0
+"valor": "6.00"
+"dataVencimento": "2020-03-14 00:00:00"
+"obs": "Método de pagamento: master"
+"destino": 1
+"forma_pagamento": {#916 ▼
+"id": 897799
+"descricao": "Conta a receber/pagar"
+"codigoFiscal": 15
}
}
}
]
+"transporte": {#921 ▼
+"enderecoEntrega": {#928 ▼
+"nome": "Jéssica Mello (MEJ4290244)"
+"endereco": ""
+"numero": ""
+"complemento": ""
+"cidade": ""
+"bairro": "Não Informado"
+"cep": ".-"
+"uf": ""
}
}
}
}
 */

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
            'json_data' => ' {
                "desconto": "0,00",
                "observacoes": "",
                "observacaointerna": "",
                "data": "2020-02-13",
                "numero": "2",
                "numeroOrdemCompra": "",
                "vendedor": "",
                "valorfrete": "0.00",
                "totalprodutos": "6.00",
                "totalvenda": "6.00",
                "situacao": "Em aberto",
                "loja": "203395636",
                "numeroPedidoLoja": "2324665257",
                "tipoIntegracao": "MercadoLivre",
                "cliente": {
                    "id": "7519258851",
                    "nome": "Jéssica Mello (mej4290244)",
                    "cnpj": "",
                    "ie": "",
                    "rg": "",
                    "endereco": "",
                    "numero": "",
                    "complemento": "",
                    "cidade": "",
                    "bairro": "Não Informado",
                    "cep": null,
                    "uf": "",
                    "email": "jmello.sdm2b52+2-ogiztenbwgy2teobx@mail.mercadolivre.com",
                    "celular": "",
                    "fone": " 21969791284"
                },
                "itens": [
                    {
                        "item": {
                            "codigo": null,
                            "descricao": "Caneta Bic Azul",
                            "quantidade": "1.0000",
                            "valorunidade": "6.0000000000",
                            "precocusto": null,
                            "descontoItem": "0.00",
                            "un": "UN",
                            "pesoBruto": null,
                            "largura": null,
                            "altura": null,
                            "profundidade": null,
                            "descricaoDetalhada": "",
                            "unidadeMedida": "m",
                            "gtin": null
                        }
                    },{
                        "item": {
                            "codigo": null,
                            "descricao": "Pan con pastsa",
                            "quantidade": "12.0000",
                            "valorunidade": "6.0000000000",
                            "precocusto": null,
                            "descontoItem": "0.00",
                            "un": "UN",
                            "pesoBruto": null,
                            "largura": null,
                            "altura": null,
                            "profundidade": null,
                            "descricaoDetalhada": "",
                            "unidadeMedida": "m",
                            "gtin": null
                        }
                    }
                ],
                "parcelas": [
                    {
                        "parcela": {
                            "idLancamento": 0,
                            "valor": "6.00",
                            "dataVencimento": "2020-03-14 00:00:00",
                            "obs": "Método de pagamento: master",
                            "destino": 1,
                            "forma_pagamento": {
                                "id": 897799,
                                "descricao": "Conta a receber/pagar",
                                "codigoFiscal": 15
                            }
                        }
                    }
                ],
                "transporte": {
                    "enderecoEntrega": {
                        "nome": "Jéssica Mello (MEJ4290244)",
                        "endereco": "",
                        "numero": "",
                        "complemento": "",
                        "cidade": "",
                        "bairro": "Não Informado",
                        "cep": ".-",
                        "uf": ""
                    }
                }
            }',            
        ]);
        $this->sales->create([
            'id' => 2,
            'contact_id' => 1,
            'source' => '1',
            'sended' => '1',
            'json_data' => ' {
                "desconto": "0,00",
                "observacoes": "",
                "observacaointerna": "",
                "data": "2020-02-13",
                "numero": "2",
                "numeroOrdemCompra": "",
                "vendedor": "",
                "valorfrete": "0.00",
                "totalprodutos": "6.00",
                "totalvenda": "6.00",
                "situacao": "Em aberto",
                "loja": "203395636",
                "numeroPedidoLoja": "2324665257",
                "tipoIntegracao": "MercadoLivre",
                "cliente": {
                    "id": "7519258851",
                    "nome": "Jéssica Mello (mej4290244)",
                    "cnpj": "",
                    "ie": "",
                    "rg": "",
                    "endereco": "",
                    "numero": "",
                    "complemento": "",
                    "cidade": "",
                    "bairro": "Não Informado",
                    "cep": null,
                    "uf": "",
                    "email": "jmello.sdm2b52+2-ogiztenbwgy2teobx@mail.mercadolivre.com",
                    "celular": "",
                    "fone": " 21969791284"
                },
                "itens": [
                    {
                        "item": {
                            "codigo": null,
                            "descricao": "Caneta Bic Azul",
                            "quantidade": "1.0000",
                            "valorunidade": "6.0000000000",
                            "precocusto": null,
                            "descontoItem": "0.00",
                            "un": "UN",
                            "pesoBruto": null,
                            "largura": null,
                            "altura": null,
                            "profundidade": null,
                            "descricaoDetalhada": "",
                            "unidadeMedida": "m",
                            "gtin": null
                        }
                    }
                ],
                "parcelas": [
                    {
                        "parcela": {
                            "idLancamento": 0,
                            "valor": "6.00",
                            "dataVencimento": "2020-03-14 00:00:00",
                            "obs": "Método de pagamento: master",
                            "destino": 1,
                            "forma_pagamento": {
                                "id": 897799,
                                "descricao": "Conta a receber/pagar",
                                "codigoFiscal": 15
                            }
                        }
                    }
                ],
                "transporte": {
                    "enderecoEntrega": {
                        "nome": "Jéssica Mello (MEJ4290244)",
                        "endereco": "",
                        "numero": "",
                        "complemento": "",
                        "cidade": "",
                        "bairro": "Não Informado",
                        "cep": ".-",
                        "uf": ""
                    }
                }
            }',            
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');
    }


}

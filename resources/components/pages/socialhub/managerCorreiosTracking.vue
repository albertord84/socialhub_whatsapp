<template>
    <div class="card p-3 no-shadows">
        <!-- Dispatch DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        
        <div style="border: 1px solid #dee2e6" class="mb-3">
            <div style="display:flex; align-items: center; justify-content: space-between">
                <label>
                    <div class="form-group mt-3">
                        <div class="col-lg-12 input-group">
                            
                            <input type="search" id="search-input" style="width:220px" class="form-control" placeholder="Digite sua busca ..." v-model="searchInput">
                            
                            <div class="input-group-append ml-3">
                                <select id="example-select" name="example-select" v-model="tackingStatus" class="form-control" size="1" style="width:180px">
                                    <option value="0">
                                        Status dos envios
                                    </option>
                                    <option v-for="(status,index) in trackingStatusOptions" :key="index" :value="status.code">{{status.name}}</option>
                                </select>
                            </div>
                            
                            <div class="input-group-append ml-3" title="Data início">
                                <input type="date" v-model="dateInit" class="form-control" value="yyyy-mm-dd" style="width:160px" aria-selected="true">
                            </div>
                            <div class="input-group-append ml-3" title="Data fim">
                                <input type="date" v-model="dateEnd" class="form-control" value="yyyy-mm-dd" style="width:160px" aria-selected="true">
                            </div>

                            <div class="input-group-append ml-3" title="Filtrar pedidos">
                                <button class="btn btn-info input-group-text text-muted border-right-0 pt-2 px-5" @click.prevent="findSearchInput">
                                    <span v-if="!isFilteringBySearchInput" class="fa fa fa-search"></span>
                                    <span v-if="isFilteringBySearchInput" class="fa fa-spinner fa-spin "></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </label>

                <label style="">
                    <div class="actisons pr-4">
                        <input id="fileInputCSV" ref="fileInputCSV" style="display:none" type="file" @change.prevent="getSelectedFile" accept=".csv"/>
                        <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalUploadDispatchList" title="Subir lista de códigos de rastreio">
                            <i class="mdi mdi-upload fa-lg"  ></i>
                        </a>
                        <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar envios mostrados">
                            <i class="mdi mdi-download fa-lg"></i>
                        </a>
                        <!-- <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalAddDispatch" title="Adicionar um envio">
                            <i class="mdi mdi-plus-box"></i>
                        </a> -->
                    </div>
                </label>
            </div>  
            <div style="display:flex; align-items: center; justify-content: center;">
                <label>
                    <div style="">
                        <button type="button" class="btn btn-flat btn-lg  p-0" :disabled="actualPage===0" @click.prevent="getTrackings(0)">
                            <i class="mdi mdi-chevron-double-left fa-2x" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-flat btn-lg p-0" :disabled="actualPage===0" @click.prevent="getTrackings(actualPage-1)">
                            <i class="mdi mdi-chevron-left fa-2x" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-flat btn-lg  p-3 pl-3 pr-3">
                            <b class="">{{actualPage+1}}</b>
                        </button>
                        <button type="button" class="btn btn-flat btn-lg  p-0" @click.prevent="getTrackings(actualPage+1)">
                            <i class="mdi mdi-chevron-right fa-2x" aria-hidden="true"></i>
                        </button>
                    </div>
                </label>
            </div>  
        </div>

        <div class="table-responsive">
            <table ref="table" id="salesTable" class="table">
                <thead>
                    <tr> <th class="text-left" v-for="(column, i) in columns" :style="{width: column.width ? column.width : 'auto'}" :key="i"> {{column.label}}  </th> <slot name="thead-tr"></slot> </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rows" @click="click(row, index)" :key="index" :class="row.sended ? 'sended' : 'notSended'">
                        <template v-for="(column,index) in columns" >
                            <td v-if="!column.html && !column.json && column.label !='Nome' && column.label !='Status'" >{{ collect(row,column.field) }}</td>
                            <td v-if="column.label =='Nome'" :title="collect(row, column.field).trim()"> 
                                {{(collect(row, column.field).trim() != '')? collect(row, column.field).trim().substr(0, 20) : '' }}
                            </td>                            
                            <td v-if="column.label =='Status'">
                                <span v-if="collect(row, column.field)=='PROBLEM'" style="background-color:#ec6d65">{{ collect(row, column.field) }}</span>
                                <span v-else-if="collect(row, column.field)=='RECEIVED' || collect(row, column.field)=='ARRIVED'" style="background-color:#80ffaa">{{ collect(row, column.field) }}</span>
                                <span v-else style="background-color:silver">{{ collect(row, column.field) }}</span>
                            </td>   
                            <td v-if="column.sended" v-html="collect(row, column.field)" ></td>
                            <td v-if="column.html"  v-html="collect(row, column.field)"  ></td>
                            <td v-if="column.actions" >
                                <div style="position:relative; margin-left:-130px;">
                                    <a class="text-18 mr-1" href="javascript:void(0)" title="Ver comprador" @click.prevent="actionSeeClient(row)"><i class='fa fa-user-circle-o text-primary mr-1' ></i> </a>
                                    <a class="text-18 mr-1" href="javascript:void(0)" title="Ver tracking" @click.prevent="actionSeeTacking(row)"><i class='fa fa-clock-o text-warning mr-1'  ></i> </a>
                                    <a class="text-18 mr-1" href="javascript:void(0)" title="Editar registro" @click.prevent="actionEditRecord(row)"><i class='fa fa-pencil text-success mr-1' ></i> </a>
                                    <a class="text-18" href="javascript:void(0)" title="Eliminar registro" @click.prevent="actionDeleteRecord(row)"><i class='fa fa-trash text-danger'  ></i> </a>
                                </div>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer text-center" v-if="paginate">
            <div  style="border: 1px solid #dee2e6">
                <label class="mt-2">
                    <div style="">
                        <button type="button" class="btn btn-flat btn-lg  p-0" :disabled="actualPage===0" @click.prevent="getTrackings(0)">
                            <i class="mdi mdi-chevron-double-left fa-2x" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-flat btn-lg p-0" :disabled="actualPage===0" @click.prevent="getTrackings(actualPage-1)">
                            <i class="mdi mdi-chevron-left fa-2x" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-flat btn-lg  p-3 pl-3 pr-3">
                            <b class="">{{actualPage+1}}</b>
                        </button>
                        <button type="button" class="btn btn-flat btn-lg  p-0" @click.prevent="getTrackings(actualPage+1)">
                            <i class="mdi mdi-chevron-right fa-2x" aria-hidden="true"></i>
                        </button>
                    </div>
                </label>
            </div>
        </div>
        
        <!-- Add Dispatch Modal -->
        <b-modal v-model="modalAddDispatch" size="lg" :hide-footer="true" title="Adicionar envio">
            <managerCRUDBlingSales :url='url' :action='"edit"' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDBlingSales>            
        </b-modal>

        <!-- Edit Dispatch Modal -->
        <b-modal v-model="modalEdtitDispatch" size="lg" :hide-footer="true" title="Editar envio">
            <managerCRUDBlingSales :url='url' :action='"edit"' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDBlingSales>            
        </b-modal>

        <!-- Delete Dispatch Modal -->
        <b-modal ref="modal-delete-matter" v-model="modalDeleteDispatch" :hide-footer="true" title="Verificação de exclusão">
            <managerCRUDBlingSales :url='url' :action='"delete"' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDBlingSales>            
        </b-modal>

        <!-- Modal to upload codes -->
        <b-modal size="md" v-model="showModalFileUploadCSV" :no-close-on-backdrop="true" :hide-footer="true" title="Importação de códigos de rastreios">
            <div v-if="steepFileUploadCSV === 2">
                <div class="form-group p-2">
                    Confirma que deseja enviar esse arquivo de código de rastreios?
                </div>
                <div class="col-lg-12 mt-2 text-center" >
                    <button class="btn btn-primary pl-5 pr-5 text-white"  @click.prevent="uploadCSVFile">Enviar</button>
                    <button class="btn btn-primary  pl-5 pr-5 text-white" @click.prevent="showModalFileUploadCSV = false" >Cancelar</button>
                </div>
            </div>
            <div v-if="steepFileUploadCSV === 3">
                <div class="form-group p-2">
                    Essa tarefa pode demorar alguns minutos, por favor, espere.
                </div>
                <div class="form-group p-2 text-center">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            </div>
            <div v-if="steepFileUploadCSV === 4">
                <div class="form-group p-2">
                    <table style="width:100%">
                        <tr class="my-bg-success"><td><p class="pt-2 pl-2"> {{csvImportResponse.criated}} trackings novos adicionados.</p></td></tr>
                        <tr class="my-bg-warning"><td><p class="pt-2 pl-2"> {{csvImportResponse.already_exist}} trackings já existiam.</p></td></tr>
                        <tr class="my-bg-danger"><td><p class="pt-2 pl-2"> {{csvImportResponse.exception}} trackings produzeram erros.</p></td></tr>
                    </table>
                </div>
                <div class="form-group p-2 text-center">
                    <button class="btn btn-primary cl-white pl-5 pr-5" @click.prevent="showModalFileUploadCSV = false">Aceitar</button>
                </div>
            </div>
        </b-modal>

        <!-- Modal to see  client -->
        <b-modal size="xl" v-model="showModalSeeClient" :hide-footer="true" title="Informação da venda">
            <div class="card user-profile no-shadows">
                <article class="media">
                    <a class="float-left m-2">
                        <span class="fa fa-info-circle fa-2x text-primary" title="Geral"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0 ml-1"><b>Dados gerais</b></p>
                        <table class="table borderless" >
                            <tbody>
                                <tr >
                                    <td><b>Origem:</b></td>
                                    <td><b>Id origem:</b></td>
                                    <td><b>Conta:</b></td>
                                    <td><b>Sku:</b></td>
                                    <td><b>Id do Marketplace:</b></td>
                                </tr>
                                <tr >
                                    <td>{{modelClient.origem}}</td>
                                    <td>{{modelClient.origemId}}</td>
                                    <td>{{modelClient.conta}}</td>
                                    <td>{{modelClient.sku}}</td>
                                    <td>{{modelClient.idMarketplace}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>
                <hr>
                <article class="media">
                    <a class="float-left m-2">
                        <span class="fa fa-user-circle-o fa-2x text-primary" title="Dados do comprador"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0 ml-1"><b>Dados do comprador</b></p>
                        <p class="mt-2 mb-0 ml-1"><b>Nome:</b> {{modelClient.compradorNome}}</p>
                        <p class="mt-1 mb-0 ml-1"><b>Email:</b> {{modelClient.compradorEmail}}</p>
                        
                        <table class="table borderless" >
                            <tbody>
                                <tr>
                                    <td><b>Apelido:</b></td>
                                    <td><b>Telfone:</b></td>
                                    <td><b>CPF:</b></td>
                                    <td><b>RG:</b></td>
                                    <td><b>Tipo:</b></td>
                                </tr>
                                <tr>
                                    <td>{{modelClient.compradorApelido}}</td>
                                    <td>{{modelClient.compradorFone}}</td>
                                    <td>{{modelClient.compradorCPF}}</td>
                                    <td>{{modelClient.compradorRG}}</td>
                                    <td>{{modelClient.compradorTipo}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>
                <hr>
                <article class="media">
                    <a class="float-left m-3">
                        <span class="fa fa-map-marker fa-2x text-primary" title="Endereço de entrega"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0"><b>Endereço de entrega</b></p>
                        <p class="mt-1 mb-0">
                            <span v-if="modelClient.enderecoRua!='ND'" class="mt-1 mb-0"> {{modelClient.enderecoRua}}, </span>
                            <span v-if="modelClient.enderecoNumero!='ND'" class="mt-1 mb-0"> n.<sup>o</sup> {{modelClient.enderecoNumero}}, </span>
                            <span v-if="modelClient.enderecoComplemento!='ND'" class="mt-1 mb-0">  compl. {{modelClient.enderecoComplemento}}, </span>
                            <span v-if="modelClient.enderecoBairro!='ND'" class="mt-1 mb-0"> {{modelClient.enderecoBairro}}, </span>
                            <span v-if="modelClient.enderecoCidade!='ND'" class="mt-1 mb-0"> {{modelClient.enderecoCidade}}, </span>
                            <span v-if="modelClient.enderecoEstado!='ND'" class="mt-1 mb-0"> {{modelClient.enderecoEstado}}, </span>
                            <span v-if="modelClient.enderecoCep!='ND'" class="mt-1 mb-0">CEP: {{modelClient.enderecoCep}}</span>
                            
                        </p>
                    </div>
                </article>
                <hr>
                <article class="media">
                    <a class="float-left m-2">
                        <span class="fa fa-shopping-cart fa-2x text-primary" title="Sobre o pedido"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-1"><b>Sobre o pedido</b></p>
                        <table class="table borderless" >
                            <tbody>
                                <tr>
                                    <td><b style="background-color:silver">Status:</b></td>
                                    <td><b>ID do status:</b></td>
                                    <td><b>ID pedido:</b></td>
                                    <td><b>TotalProd:</b></td>
                                    <td><b>TotalFrete:</b></td>
                                    <td><b>Data:</b></td>
                                </tr>
                                <tr>
                                    <td>{{modelClient.pedidoStatus}}</td>
                                    <td>{{modelClient.pedidoStatusId}}</td>
                                    <td>{{modelClient.pedidoID}}</td>
                                    <td>{{modelClient.pedidoTotalProd}}</td>
                                    <td>{{modelClient.pedidoTotalFrete}}</td>
                                    <td>{{modelClient.pedidoData}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p  class="mt-1 ml-2"><b>Observações:</b> {{modelClient.pedidoObservacoes}}</p>


                        <div v-if="modelClient.pedidoProduto && modelClient.pedidoProduto.produtos">
                            <p class="mt-2 ml-2"><b>Produtos neste pedido:</b></p>
                            <div v-for="(produto, index) in modelClient.pedidoProduto.produtos" v-bind:key="index" class="ml-4">
                                <p class="mt-2 mb-0"> <b>{{index+1}}. Produto: </b>{{produto.titulo}}</p>
                                
                                <table class="table borderless" >
                                    <tbody>
                                        <tr>
                                            <td><b>Id produto:</b></td>
                                            <td><b>Quantidade:</b></td>
                                            <td><b>Preço:</b></td>
                                            <td><b>Variação:</b></td>
                                            <td><b>Id variação:</b></td>
                                            <td><b>Sku:</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{produto.id}}</td>
                                            <td>{{produto.qtd}}</td>
                                            <td>{{produto.preco}}</td>
                                            <td>{{produto.variacao}}</td>
                                            <td>{{produto.variacao_id}}</td>
                                            <td>{{produto.sku}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-else>
                            <p class="mt-2 mb-0"><b>Produtos não especificados</b></p>
                        </div>
                    </div>
                </article>
                <hr>
                <article class="media">
                    <a class="float-left m-2">
                        <span class="fa fa-money fa-2x text-primary" title="Pagamento"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0"><b>Sobre o pagamento</b></p>

                        <table class="table borderless" >
                            <tbody>
                                <tr>
                                    <td><b style="background-color:silver">Status:</b></td>
                                    <td><b>Forma:</b></td>
                                    <td><b>IdMP:</b></td>
                                    <td><b>StatusMP:</b></td>
                                    <td><b>PagoProd:</b></td>
                                    <td><b>PagoFrete:</b></td>
                                    <td><b>DifTotal:</b></td>
                                </tr>
                                <tr>
                                    <td>{{modelClient.pagamentoStatus}}</td>
                                    <td>{{modelClient.pagamentoForma}}</td>
                                    <td>{{modelClient.pagamentoIdMP}}</td>
                                    <td>{{modelClient.pagamentoStatusMP}}</td>
                                    <td>{{modelClient.pagamentoPagoProd}}</td>
                                    <td>{{modelClient.pagamentoPagoFrete}}</td>
                                    <td>{{modelClient.pagamentoDifTotal}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>
                <hr>
                <article class="media">
                    <a class="float-left m-2">
                        <span class="mdi mdi-truck fa-2x text-primary" title="Sobre o envio"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0"><b>Sobre o envio</b></p>
                        <table class="table borderless" >
                            <tbody>
                                <tr>
                                    <td><b style="background-color:silver">Status:</b></td>
                                    <td><b>Transportadora:</b></td>
                                    <td><b>CNPJ da transp:</b></td>
                                    <td><b>Frete:</b></td>
                                    <td><b>Rastreamento:</b></td>
                                    <td><b>Data de envio:</b></td>
                                    <td><b>Data de entrega:</b></td>
                                    <td><b>Origem (id):</b></td>
                                </tr>
                                <tr>
                                    <td>{{modelClient.envioStatus}}</td>
                                    <td>{{modelClient.envioTransportadora}}</td>
                                    <td>{{modelClient.envioTransportadoraCNPJ}}</td>
                                    <td>{{modelClient.envioFrete}}</td>
                                    <td>{{modelClient.envioRastreamento}}</td>
                                    <td>{{modelClient.envioData}}</td>
                                    <td>{{modelClient.entregaData}}</td>
                                    <td>{{modelClient.origem}} ({{modelClient.origemId}})</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </article>
            </div>
        </b-modal>

        <!-- Modal to see  tracking -->
        <b-modal size="xl" v-model="showModalSeeTracking" :hide-footer="true" title="Tracking da venda">
            <div class="card user-profile no-shadows">
                <article class="media">
                    <div class="media-body ml-2">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><b style="background-color:silver">Status:</b></td>
                                    <td><b>Tipo:</b></td>
                                    <td><b>Data/hora:</b></td>
                                    <td><b>Recebedor:</b></td>
                                    <td><b>Detalhe:</b></td>
                                    <td><b>Local:</b></td>
                                    <td><b>Código:</b></td>
                                    <td><b>Cidade:</b></td>
                                    <td><b>UF:</b></td>
                                    <td><b>Descrição:</b></td>
                                </tr>
                                <tr  v-for="(track,index) in modelTracking" :key="index">
                                    <td>{{track.status}}</td>
                                    <td>{{track.tipo}}</td>
                                    <td>{{track.dataHora}}</td>
                                    <td>{{track.recebedor}}</td>
                                    <td>{{track.detalhe}}</td>
                                    <td>{{track.local}}</td>
                                    <td>{{track.codigo}}</td>
                                    <td>{{track.cidade}}</td>
                                    <td>{{track.uf}}</td>
                                    <td>{{track.descricao}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>
            </div>
        </b-modal>
    </div>

</template>
<script>
    import Vue from 'vue';
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import managerCRUDBlingSales from "./popups/managerCRUDBlingSales";
    import Multiselect from 'vue-multiselect';
    Vue.component(Multiselect);

    export default {
        name:"managerPMailSales",
        
        props: {
            title: {
                default: ""
            },
            perPage: {
                default: 10
            },
            sortable: {
                default: true
            },
            paginate: {
                default: true
            },
            exportable: {
                default: true
            },
            pagelen: {
                type: Array,
                default () {
                    return [5, 10, 20, 50]
                }
            }
        },

        components:{
            managerCRUDBlingSales,
            Multiselect
        },

        data() {
            return {
                userLogged:{},
                url:'trackings',
                sales_id: "",
                model:{},
                modelClient:{},
                modelTracking:{},
                message_sended: false,
                
                showModalFileUploadCSV: false,
                showModalSeeClient: false,
                showModalSeeTracking: false,

                modalAddDispatch: false,
                modalEdtitDispatch: false,
                modalDeleteDispatch: false,
                fileInputCSV: null,
                
                steepFileUploadCSV:2,

                searchInput: '',                
                actualPage: 0,
                saveActualPage: 0,
                isFilteringBySearchInput: false,
                isFindingNextPage: false,
                hasMoreTrackingPage: true,
                
                tackingStatus: 0,
                dateInit: '',
                dateEnd: '',

                rows:[],
                columns: [
                    {
                        label: 'Id',
                        field: 'id',
                        numeric: true,
                        html: false,                   
                    }, {
                        label: 'Status',
                        field: 'Status.name',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Nome',
                        field: 'Contact.first_name',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Código rasterio',
                        field: 'tracking_code',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Postado',
                        field: 'post_date',
                        numeric: false,
                        html: false,                    
                    }, {
                        label: 'Atualizado',
                        field: 'updated_at',
                        numeric: false,
                        html: false,                    
                    },  {
                        label: 'Ações',
                        field: 'button',
                        numeric: false,
                        html: false,
                        actions: true,
                    }
                ],

                tag_value:null,
                trackingStatusOptions: [
                    // {name: 'Vue.js', code: 'vu'}, 
                    // {name: 'Javascript',code: 'js'}, 
                    // {name: 'Monterail',code: 'pl'},
                    // {name: 'Open Source',code: 'os'}
                ],

                currentPage: 1,
                currentPerPage: this.perPage,
                sortColumn: -1,
                sortType: 'asc',
            }
        },

        methods: {
            getTrackings: function(page) { //R
                if(this.isFindingNextPage){
                    if(this.isFilteringBySearchInput)
                        this.isFilteringBySearchInput = false;
                    return;
                } 
                this.actualPage = page;
                this.isFindingNextPage = true;
                ApiService.get(this.url,{
                    'page': this.actualPage,
                    'searchInput': this.searchInput,
                    'filterStatus': this.tackingStatus,
                    'betweenDates': JSON.stringify(Array(this.dateInit,this.dateEnd))
                })
                .then(response => {   
                    this.rows = response.data;
                })
                .catch(error => {
                    // this.processMessageError(error, this.url, "get");
                })
                .finally(()=>{
                    this.isFindingNextPage = false;
                    this.isFilteringBySearchInput = false;
                });
            },

            getTrackingsStatus: function() {
                ApiService.get('status')
                .then(response => {  
                    this.trackingStatusOptions = Array();
                    response.data.some((item,i)=>{
                        this.trackingStatusOptions.push(  {
                            'name': item.name,
                            'code': item.id
                        });
                    });
                    this.trackingStatusOptions = Object.values(this.trackingStatusOptions); 
                })
                .catch(error => {
                })
                .finally(()=>{
                });
            },

            findSearchInput() {
                if(this.searchInput.trim()){
                    this.isFilteringBySearchInput = true;
                    this.saveActualPage = this.actualPage;
                    this.getTrackings(0);
                }else{
                    this.isFilteringBySearchInput = true;
                    this.getTrackings(this.saveActualPage);
                }
            },

            actionSeeClient: function(value){
                value.json_csv_data = JSON.parse(value.json_csv_data);
                value.json_csv_data.pedidoProduto = JSON.parse(value.json_csv_data.pedidoProduto);
                this.modelClient = value.json_csv_data;
                this.showModalSeeClient = true;
            }, 

            actionSeeTacking: function(value){
                this.modelTracking = (value.tracking_list) ? JSON.parse(value.tracking_list): [];
                if(this.modelTracking.length>0)
                    this.showModalSeeTracking = true;
                else
                miniToastr.warn('Não existem atualizações para essa venda ainda','Atenção');
            },

            actionEditRecord: function(value){
                this.model = value;
                this.sales_id = value.id;
                this.modalEditSales = !this.modalEditSales;
            },

            actionDeleteRecord: function(value){
                this.model = value;
                this.sales_id = value.id;
                this.modalDeleteSales = !this.modalDeleteSales;
            },

            uploadCSVFile: function(){
                if(!this.fileInputCSV.files[0].name.includes('.csv')){
                    miniToastr.error("O arquivo selecionado deve estar em formato .CSV", "Erro"); 
                    return;
                }
                if(this.fileInputCSV.files[0].size < 10*1024*1024) {
                    this.file = this.fileInputCSV.files[0];
                    if(this.file){
                        let formData = new FormData();
                        formData.append("file",this.file);
                        this.steepFileUploadCSV = 3;
                        ApiService.post('trackings_import_csv',formData, {headers: { "Content-Type": "multipart/form-data" }})
                            .then(response => {
                                this.csvImportResponse = response.data;
                                miniToastr.success("Arquivo enviado com sucesso", "Sucesso");
                                this.steepFileUploadCSV = 4;
                                this.reloadDatas();
                            })
                            .catch(error => {
                                // this.processMessageError(error, this.url, "get");
                            })
                            .finally(()=>{ });
                    }
                } else{
                    miniToastr.error("O arquivo deve ter tamanho inferior a 5MB", "Erro"); 
                }
            },

            reloadDatas(){
                this.getTrackings(this.actualPage);
            },

            showModalAddDispatch() {
                this.modalAddDispatch =true;
            },            

            showModalEdtitDispatch() {
                this.modalEdtitDispatch =true;
            },
            
            showModalDeleteDispatch() {
                this.modalDeleteDispatch =true;
            },            

            showModalFilterDispatchs() {
            },
            
            showModalUploadDispatchList() {
                this.fileInputCSV = null;
                this.$refs.fileInputCSV.click();
            },

            getSelectedFile: function(e){
                this.fileInputCSV=e.target;
                this.showModalFileUploadCSV = true;
                this.steepFileUploadCSV = 2;
            },
            
            closeModals(){
                this.modalAddDispatch = false;
                this.modalEdtitDispatch =  false;
                this.modalDeleteDispatch =  false;
            },

            //------ Specific DataTable methods------------
            nextPage() {
                if (this.processedRows.length > this.currentPerPage * this.currentPage && this.currentPerPage != -1)
                    ++this.currentPage;
            },

            previousPage() {
                if (this.currentPage > 1)
                    --this.currentPage;
            },

            sort(index) {
                if (!this.sortable) {
                    return;
                }
                if (this.sortColumn === index) {
                    this.sortType = this.sortType === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortType = 'asc';
                    this.sortColumn = index;
                }
            },

            click(row, index) {
                this.$emit("rowClick", row, index);
            },

            exportExcel() {
                const mimeType = 'data:application/vnd.ms-excel';
                const html = this.renderTable().replace(/ /g, '%20');

                const d = new Date();

                var dummy = document.createElement('a');
                dummy.href = mimeType + ', ' + html;
                dummy.download = this.title.toLowerCase().replace(/ /g, '-') + '-' + d.getFullYear() + '-' + (d.getMonth() +
                        1) + '-' + d.getDate() + '-' + d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds() +
                    '.xls';
                dummy.click();
            },

            renderTable() {
                var table = '<table><thead>';

                table += '<tr>';
                for (var i = 0; i < this.columns.length; i++) {
                    const column = this.columns[i];
                    table += '<th>';
                    table += column.label;
                    table += '</th>';
                }
                table += '</tr>';

                table += '</thead><tbody>';

                for (var i = 0; i < this.rows.length; i++) {
                    const row = this.rows[i];
                    table += '<tr>';
                    for (var j = 0; j < this.columns.length; j++) {
                        const column = this.columns[j];
                        table += '<td>';
                        table += this.collect(row, column.field);
                        table += '</td>';
                    }
                    table += '</tr>';
                }

                table += '</tbody></table>';

                return table;
            },

            dig(obj, selector) {
                var result = obj;
                const splitter = selector.split('.');
                for (let i = 0; i < splitter.length; i++)
                    if (typeof (result) === 'undefined')
                        return undefined;
                    else
                        result = result[splitter[i]];
                return result;
            },

            collect(obj, field) {
                if (typeof (field) === 'function')
                    return field(obj);
                else if (typeof (field) === 'string')
                    return this.dig(obj, field);
                else
                    return undefined;
            },

            mycheck(){
                alert("hi");
            },

            addTag(newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.object_options.push(tag)
                this.tag_value.push(tag)
            },

            //------ Specific exceptions methods------------
            processMessageError: function(error, url, action) {
                var info = ApiService.process_request_error(error, url, action);
                if(info.typeException == "expiredSection"){
                    miniToastr.warn(info.message,"Atenção");
                    this.$router.push({name:'login'});
                    window.location.reload(false);
                }else if(info.typeMessage == "warn"){
                    miniToastr.warn(info.message,"Atenção");
                }else{
                    miniToastr.error(info.erro, info.message); 
                }
            }
        },

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
            this.getTrackings(0);
            this.getTrackingsStatus();
        },

        mounted() {
            if(this.userLogged.role_id > 3){
                this.$router.push({name: "login"});
            }
            
            this.sort(0);
        },        

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        computed: {
            processedRows: function () {
                var computedRows = this.rows;
                return computedRows;
            },

            paginated: function () {
                
                return this.rows;
            }
        },

        watch: {

            dateInit(value){
                if(this.dateEnd.trim()!=''){
                    if(value.trim() > this.dateEnd.trim()){
                        this.dateInit = "";
                        this.dateEnd = "";
                    }
                }
            },

            dateEnd(value){
                if(this.dateInit.trim()!=''){
                    if(value.trim() < this.dateInit.trim()){
                        this.dateInit = "";
                        this.dateEnd = "";
                    }
                }
            }
            
        },
        
    }


</script>

<style scoped>
    .pagination {
        margin-top: 12px;
    }

    .sortable {
        cursor: pointer;
    }

    .has-search .form-control {
        padding-left: 2.375rem;
    }
    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }  
    .has-search-color{
        color: #aaa;
    }
    .btn_width{
        width: 100px
    }
    .text-18{
        font-size: 18px
    }
    .sended{
        /* background-color: rgb(212, 241, 212);         */
    }
    .notSended{
        /* background-color:  rgb(247, 212, 212); */
    }
    .no-shadows{
        box-shadow: none !important;
    }
    .borderless table {
        border-top-style: none;
        border-left-style: none;
        border-right-style: none;
        border-bottom-style: none;
        margin-top: 0px;
        padding-bottom: 0px;
        margin-top: 0px;
        padding-bottom: 0px;
    }
    .borderless tr {
        border-top-style: none;
        border-left-style: none;
        border-right-style: none;
        border-bottom-style: none;
        margin-top: 0px;
        padding-bottom: 0px;
        margin-top: 0px;
        padding-bottom: 0px;
    }
    .borderless td {
        border-top-style: none;
        border-left-style: none;
        border-right-style: none;
        border-bottom-style: none;
        margin-top: 0px;
        padding-bottom: 0px;
        margin-top: 0px;
        padding-bottom: 0px;
    }
    .my-bg-success{
        border: 1px solid #ececf6;
        padding: 10px;
        background-color: #c3e6cb;
    }
    .my-bg-warning{
        border: 1px solid #ececf6;
        padding: 10px;
        background-color: #eed487;
    }
    .my-bg-danger{
        border: 1px solid #ececf6;
        padding: 10px;
        background-color: #f1b0b7;
    }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<template>
    <div class="card p-3 no-shadows">
        <!-- Dispatch DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        <div class="text-left">
            <div id="search-input-container">
                <!-- Buscar envio -->
                <label>
                    <div style="" class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="search" id="search-input" style="width:35rem" class="form-control" placeholder="Buscar envio por e-mail, CEP, CPF/CNPJ ou código de rastreio" v-model="searchInput">
                    </div>
                </label>

                <!-- Exportar envios -->
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar envios mostrados">
                        <i class="mdi mdi-download fa-lg"></i>
                    </a>
                </div>

                <!-- Subir lista de códigos de rastreio -->
                <div class="actions float-right pr-4 mb-3">
                    <input id="fileInputCSV" ref="fileInputCSV" style="display:none" type="file" @change.prevent="getSelectedFile" accept=".csv"/>
                    <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalUploadDispatchList" title="Subir lista de códigos de rastreio">
                        <i class="mdi mdi-upload fa-lg"  ></i>
                    </a>
                </div>
                                
                <!-- Flitrar envios -->
                <!-- <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalFilterDispatchs" title="Flitrar envios">
                        <i class="mdi mdi-filter-plus"></i>
                    </a>
                </div> -->
                <!-- Adicionar um envio -->
                <!-- <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalAddDispatch" title="Adicionar um envio">
                        <i class="mdi mdi-plus-box"></i>
                    </a>
                </div> -->
            </div>
        </div>        
        <div class="table-responsive">
            <table ref="table" id="salesTable" class="table">
                <thead>
                    <tr> <th class="text-left" v-for="(column, index) in columns"  @click="sort(index)" :class="(sortable ? 'sortable' : '') + (sortColumn === index ? (sortType === 'desc' ? ' sorting-desc' : ' sorting-asc') : '')" :style="{width: column.width ? column.width : 'auto'}" :key="index"> {{column.label}} <i class="fa float-right" :class="(sortColumn === index ? (sortType === 'desc' ? ' fa fa-angle-down' : ' fa fa-angle-up') : '')"> </i> </th> <slot name="thead-tr"></slot> </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in paginated" @click="click(row, index)" :key="index" :class="row.sended ? 'sended' : 'notSended'">
                        <template v-for="(column,index2) in columns">
                            <td v-if="!column.html && !column.json" :key="index2">{{ collect(row,column.field) }}</td>
                            <td v-if="column.sended" :key="index2" v-html="collect(row, column.field)"></td>
                            <td v-if="column.html" :key="index2" v-html="collect(row, column.field)" ></td>
                            <td v-if="column.actions" :key="index2">
                                <div style="position:relative; margin-left:-130px;">
                                    <a class="text-18 mr-1" href="javascript:void(0)" title="Ver comprador" @click.prevent="actionSeeClient(row)"><i class='fa fa-user-circle-o text-primary mr-1' ></i> </a>
                                    <a class="text-18 mr-1" href="javascript:void(0)" title="Ver tracking" @click.prevent="actionSeeTacking(row)"><i class='fa fa-clock-o text-warning mr-1'  ></i> </a>
                                    <a class="text-18 mr-1" href="javascript:void(0)" title="Editar registro" @click.prevent="actionEditRecord(row)"><i class='fa fa-pencil text-success mr-1' ></i> </a>
                                    <a class="text-18" href="javascript:void(0)" title="Eliminar registro" @click.prevent="actionDeleteRecord(row)"><i class='fa fa-trash text-danger'  ></i> </a>
                                </div>
                            </td>
                        </template>
                        <!-- <slot name="tbody-tr" :row="row"></slot> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-footer" v-if="paginate">
            <div class="datatable-length float-left pl-3">
                <span>Linhas por página:</span>
                <select class="custom-select" v-model="currentPerPage">
                    <option v-for="len in pagelen" :value="len" :key="len">{{len}}</option>
                    <option value="-1">Todos</option>
                </select>
                <div class="datatable-info  pb-2 mt-3">
                    <span>Mostrando </span> {{(currentPage - 1) * currentPerPage ? (currentPage - 1) * currentPerPage : 1}} -{{currentPerPage==-1?processedRows.length:Math.min(processedRows.length,
                    currentPerPage * currentPage)}} of {{processedRows.length}}
                    <span>linhas</span>
                </div>
            </div>
            <div class="float-right">
                <ul class="pagination">
                    <li>
                        <a href="javascript:undefined" class="btn link" @click.prevent="previousPage" tabindex="0">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:undefined" class="btn link" @click.prevent="nextPage" tabindex="0">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
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

        <!-- Filter Dispatchs Modal -->
        <b-modal v-model="modalFilterDispatchs" size="md" :hide-footer="true" title="Filtrar envios">
            <form class="p-3">
                <div class="row pl-2 pr-2">
                    <div class="col-12 mb-4">
                        <label for="period">Periodo</label>
                        <multiselect v-model="tag_value" tag-placeholder="Add this as new tag" placeholder="Search tag" label="name" track-by="code" :options="object_options" :multiple="false" :taggable="true" @tag="addTag"></multiselect>
                    </div>
                    <div class="col-12 mb-4">
                        <label for="period">Situação</label>
                        <multiselect v-model="tag_value" tag-placeholder="Add this as new tag" placeholder="Search tag" label="name" track-by="code" :options="object_options" :multiple="false" :taggable="true" @tag="addTag"></multiselect>
                    </div>
                    <div class="col-12 mb-4">
                        <label for="period">Ocorrências</label>
                        <multiselect v-model="tag_value" tag-placeholder="Add this as new tag" placeholder="Search tag" label="name" track-by="code" :options="object_options" :multiple="false" :taggable="true" @tag="addTag"></multiselect>
                    </div>
                    <div class="col-12 mb-4">
                        <label for="period"> Dados do contato</label>
                        <multiselect v-model="tag_value" tag-placeholder="Add this as new tag" placeholder="Search tag" label="name" track-by="code" :options="object_options" :multiple="false" :taggable="true" @tag="addTag"></multiselect>
                    </div>
                </div>
            </form>            
        </b-modal>

        <!-- Modal to upload codes -->
        <b-modal size="md" v-model="showModalFileUploadCSV" :hide-footer="true" title="Verificação">
            <div>
                <div class="form-group p-2">
                    Confirma que deseja enviar esse arquivo de código de rastreios?
                </div>
                <div class="col-lg-12 mt-2 text-center" >
                    <button class="btn btn-primary pl-5 pr-5 text-white"  @click.prevent="uploadCSVFile">Enviar</button>
                    <button class="btn btn-primary  pl-5 pr-5 text-white" @click.prevent="showModalFileUploadCSV = false" >Cancelar</button>
                </div>
            </div>
        </b-modal>

        <!-- Modal to see  client -->
        <b-modal size="lg" v-model="showModalSeeClient" :hide-footer="true" title="Informação">
            <div class="card user-profile no-shadows">
                <article class="media">
                    <a class="float-left m-2">
                        <span class="fa fa-info-circle fa-2x text-primary" title="Geral"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0"><b>Dados gerais</b></p>
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
                                    <td v-if="modelClient.origem!='ND'">{{modelClient.origem}}</td>
                                    <td v-if="modelClient.origemId!='ND'">{{modelClient.origemId}}</td>
                                    <td v-if="modelClient.conta!='ND'">{{modelClient.conta}}</td>
                                    <td v-if="modelClient.sku!='ND'">{{modelClient.sku}}</td>
                                    <td v-if="modelClient.idMarketplace!='ND'">{{modelClient.idMarketplace}}</td>
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
                        <p class="mt-1 mb-0"><b>Dados do comprador</b></p>
                        <p v-if="modelClient.compradorNome!='ND'" class="mt-1 mb-0">Nome: {{modelClient.compradorNome}}</p>
                        <p v-if="modelClient.compradorEmail!='ND'" class="mt-1 mb-0" >Email: {{modelClient.compradorEmail}}</p>
                        <p v-if="modelClient.compradorApelido!='ND'" class="mt-1 mb-0">Apelido: {{modelClient.compradorApelido}}</p>
                        <p v-if="modelClient.compradorFone!='ND'" class="mt-1 mb-0">Telfone: {{modelClient.compradorFone}}</p>
                        <p v-if="modelClient.compradorCPF!='ND'" class="mt-1 mb-0">CPF: {{modelClient.compradorCPF}}</p>
                        <p v-if="modelClient.compradorRG!='ND'" class="mt-1 mb-0">RG: {{modelClient.compradorRG}}</p>
                        <p v-if="modelClient.compradorTipo!='ND'" class="mt-1 mb-0">Tipo: {{modelClient.compradorTipo}}</p>
                    </div>
                </article>


                <hr>
                <article class="media">
                    <a class="float-left m-2">
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
                        <p class="mt-1 mb-0"><b>Sobre o pedido</b></p>
                        <p v-if="modelClient.pedidoID!='ND'" class="mt-1 mb-0">ID do pedido: {{modelClient.pedidoID}}</p>
                        <p v-if="modelClient.pedidoStatus!='ND'" class="mt-1 mb-0">Status: {{modelClient.pedidoStatus}} ({{modelClient.pedidoStatusId}})</p>
                        <p v-if="modelClient.pedidoTotalProd!='ND'" class="mt-1 mb-0">TotalProd: {{modelClient.pedidoTotalProd}}</p>
                        <p v-if="modelClient.pedidoTotalFrete!='ND'" class="mt-1 mb-0">TotalFrete: {{modelClient.pedidoTotalFrete}}</p>
                        <p v-if="modelClient.pedidoData!='ND'" class="mt-1 mb-0">Data: {{modelClient.pedidoData}}</p>
                        <p v-if="modelClient.pedidoObservacoes!='ND'" class="mt-1 mb-0">Observações: {{modelClient.pedidoObservacoes}}</p>
                        
                        <div v-if="modelClient.pedidoProduto && modelClient.pedidoProduto.produtos">
                            <p class="mt-2 mb-0"><b>Produtos neste pedido:</b></p>
                            <div v-for="(produto, index) in modelClient.pedidoProduto.produtos" v-bind:key="index" class="ml-4">
                                <p class="mt-2 mb-0"> <b>Produto {{index+1}}</b></p>
                                <p v-if="produto.id!='ND'" class="mt-1 mb-0">Id do produto: {{produto.id}}</p>
                                <p v-if="produto.titulo!='ND'" class="mt-1 mb-0">Título: {{produto.titulo}}</p>
                                <p v-if="produto.qtd!='ND'" class="mt-1 mb-0">Quantidade: {{produto.qtd}}</p>
                                <p v-if="produto.preco!='ND'" class="mt-1 mb-0">Preço: {{produto.preco}}</p>
                                <p v-if="produto.variacao!='ND'" class="mt-1 mb-0">Variação: {{produto.variacao}}</p>
                                <p v-if="produto.variacao_id!='ND'" class="mt-1 mb-0">Id variação: {{produto.variacao_id}}</p>
                                <p v-if="produto.sku!='ND'" class="mt-1 mb-0">Sku: {{produto.sku}}</p>
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
                        <p v-if="modelClient.pagamentoStatus!='ND'" class="mt-1 mb-0">Status: {{modelClient.pagamentoStatus}}</p>
                        <p v-if="modelClient.pagamentoForma!='ND'" class="mt-1 mb-0">Forma: {{modelClient.pagamentoForma}}</p>
                        <p v-if="modelClient.pagamentoIdMP!='ND'" class="mt-1 mb-0">IdMP: {{modelClient.pagamentoIdMP}}</p>
                        <p v-if="modelClient.pagamentoStatusMP!='ND'" class="mt-1 mb-0">StatusMP: {{modelClient.pagamentoStatusMP}}</p>
                        <p v-if="modelClient.pagamentoPagoProd!='ND'" class="mt-1 mb-0">PagoProd: {{modelClient.pagamentoPagoProd}}</p>
                        <p v-if="modelClient.pagamentoPagoFrete!='ND'" class="mt-1 mb-0">PagoFrete: {{modelClient.pagamentoPagoFrete}}</p>
                        <p v-if="modelClient.pagamentoDifTotal!='ND'" class="mt-1 mb-0">DifTotal: {{modelClient.pagamentoDifTotal}}</p>
                    </div>
                </article>

                <hr>
                <article class="media">
                    <a class="float-left m-2">
                        <span class="fa fa-money fa-2x text-primary" title="Sobre o envio"></span>
                    </a>
                    <div class="media-body ml-2">
                        <p class="mt-1 mb-0"><b>Sobre o envio</b></p>
                        <p v-if="modelClient.envioStatus!='ND'" class="mt-1 mb-0">Status do envio: {{modelClient.envioStatus}}</p>
                        <p v-if="modelClient.envioTransportadora!='ND'" class="mt-1 mb-0">Transportadora: {{modelClient.envioTransportadora}}</p>
                        <p v-if="modelClient.envioTransportadoraCNPJ!='ND'" class="mt-1 mb-0">CNPJ da transportadora: {{modelClient.envioTransportadoraCNPJ}}</p>
                        <p v-if="modelClient.envioFrete!='ND'" class="mt-1 mb-0">Frete: {{modelClient.envioFrete}}</p>
                        <p v-if="modelClient.envioRastreamento!='ND'" class="mt-1 mb-0">Rastreamento: {{modelClient.envioRastreamento}}</p>
                        <p v-if="modelClient.envioData!='ND'" class="mt-1 mb-0">Data de envio: {{modelClient.envioData}}</p>
                        <p v-if="modelClient.entregaData!='ND'" class="mt-1 mb-0">Data de entrega: {{modelClient.entregaData}}</p>
                        <p v-if="modelClient.origem!='ND'" class="mt-1 mb-0">Origem: {{modelClient.origem}} ({{modelClient.origemId}})</p>
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
                message_sended: false,
                
                showModalFileUploadCSV: false,
                showModalSeeClient: false,

                modalAddDispatch: false,
                modalEdtitDispatch: false,
                modalDeleteDispatch: false,
                modalFilterDispatchs: false,
                fileInputCSV: null,

                rows:[],
                columns: [
                    {
                        label: 'Id',
                        field: 'id',
                        numeric: true,
                        html: false,                   
                    }, {
                        label: 'Status',
                        field: 'status_id',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'tracking_code',
                        field: 'tracking_code',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'post_date',
                        field: 'post_date',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'end_date',
                        field: 'end_date',
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
                object_options: [
                    {name: 'Vue.js', code: 'vu'}, 
                    {name: 'Javascript',code: 'js'}, 
                    {name: 'Monterail',code: 'pl'},
                    {name: 'Open Source',code: 'os'}
                ],

                currentPage: 1,
                currentPerPage: this.perPage,
                sortColumn: -1,
                sortType: 'asc',
                searchInput: '',
            }
        },

        methods: {
            getTrackings: function() { //R
                ApiService.get(this.url)
                    .then(response => {                        
                        this.rows = response.data;
                    })
                    .catch(error => {
                        // this.processMessageError(error, this.url, "get");
                    });
            }, 

            actionSeeClient: function(value){
                value.json_csv_data = JSON.parse(value.json_csv_data);
                value.json_csv_data.pedidoProduto = JSON.parse(value.json_csv_data.pedidoProduto);
                console.log(value.json_csv_data.pedidoProduto.produtos);
                this.modelClient = value.json_csv_data;
                this.showModalSeeClient = true;
            },

            actionSeeTacking: function(value){

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
                        ApiService.post('trackings_import_csv',formData, {headers: { "Content-Type": "multipart/form-data" }})
                            .then(response => {
                                this.showModalFileUploadCSV = false;
                                miniToastr.success("Arquivo enviado com sucesso", "Sucesso");
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
                this.getTrackings();
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
                this.modalFilterDispatchs =true;
            },
            
            showModalUploadDispatchList() {
                this.fileInputCSV = null;
                this.$refs.fileInputCSV.click();
            },

            getSelectedFile: function(e){
                this.fileInputCSV=e.target;
                this.showModalFileUploadCSV = true;
            },
            
            closeModals(){
                this.modalAddDispatch = false;
                this.modalEdtitDispatch =  false;
                this.modalDeleteDispatch =  false;
                this.modalFilterDispatchs =  false;
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
            this.getTrackings();
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
                if (this.sortable !== false) {
                    computedRows = computedRows.sort((x, y) => {
                        if (!this.columns[this.sortColumn]) {
                            return 0;
                        }
                        const cook = (x) => {
                            x = this.collect(x, this.columns[this.sortColumn].field);
                            if (typeof (x) === 'string') {
                                x = x.toLowerCase();
                                if (this.columns[this.sortColumn].numeric)
                                    x = x.indexOf('.') >= 0 ? parseFloat(x) : parseInt(x);
                            }
                            return x;
                        }
                        x = cook(x);
                        y = cook(y);
                        return (x < y ? -1 : (x > y ? 1 : 0)) * (this.sortType === 'desc' ? -1 : 1);
                    })
                }

                if (this.searchInput) {
                    computedRows = (new Fuse(computedRows, {
                        keys: this.columns.map(c => c.field)
                    })).search(this.searchInput);
                }
                return computedRows;
            },

            paginated: function () {
                var paginatedRows = this.processedRows;
                if (this.paginate && this.currentPerPage != -1) {
                    paginatedRows = paginatedRows.slice((this.currentPage - 1) * this.currentPerPage, this.currentPage *
                        this.currentPerPage);
                }
                return paginatedRows;
            }
        },

        watch: {
            currentPerPage() {
                this.currentPage = 1;
                this.paginated;
            },

            searchInput() {
                this.currentPage = 1;
                this.paginated;
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
    /* .borderless table {
        border-top-style: none;
        border-left-style: none;
        border-right-style: none;
        border-bottom-style: none;
    }
    .borderless tr {
        border-top-style: none;
        border-left-style: none;
        border-right-style: none;
        border-bottom-style: none;
    } */
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
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
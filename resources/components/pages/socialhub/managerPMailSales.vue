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
                    <input id="fileInputCSV" ref="fileInputCSV" style="display:none" type="file" @change.prevent="showModalFileUploadCSV=!showModalFileUploadCSV" accept=".csv"/>
                    <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalUploadDispatchList" title="Subir lista de códigos de rastreio">
                        <i class="mdi mdi-upload fa-lg"  ></i>
                    </a>
                </div>
                                
                <!-- Flitrar envios -->
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalFilterDispatchs" title="Flitrar envios">
                        <i class="mdi mdi-filter-plus"></i>
                    </a>
                </div>
                <!-- Adicionar um envio -->
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click="showModalAddDispatch" title="Adicionar um envio">
                        <i class="mdi mdi-plus-box"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table ref="table" id="salesTable" class="table">
                <thead>
                    <tr> <th class="text-left" v-for="(column, index) in columns"  @click="sort(index)" :class="(sortable ? 'sortable' : '') + (sortColumn === index ? (sortType === 'desc' ? ' sorting-desc' : ' sorting-asc') : '')" :style="{width: column.width ? column.width : 'auto'}" :key="index"> {{column.label}} <i class="fa float-right" :class="(sortColumn === index ? (sortType === 'desc' ? ' fa fa-angle-down' : ' fa fa-angle-up') : '')"> </i> </th> <slot name="thead-tr"></slot> </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in paginated" @click="click(row, index)" :key="index" :class="row.sended ? 'sended' : 'notSended'">
                        <template v-for="(column,index) in columns">
                            <td v-if="!column.html && !column.json" :key="index">{{ collect(row,column.field) }}</td>
                            <td v-if="column.sended" :key="index" v-html="collect(row, column.field)"></td>
                            <td v-if="column.html" :key="index" v-html="collect(row, column.field)" ></td>
                            <td v-if="column.actions" :key="index">
                                <div style="position:relative; margin-left:-80px;">
                                    <a v-if="!row.sended" class="text-18" href="javascript:void(0)" title="Reenviar mensagem" @click.prevent="actionResendMessageSales(row)"><i class="fa fa-share text-primary mr-1" aria-hidden="true"></i></a>
                                    <a class="text-18" href="javascript:void(0)" title="Editar venda" @click.prevent="actionEditSales(row)"><i class='fa fa-pencil text-success mr-1' ></i> </a>
                                    <a class="text-18" href="javascript:void(0)" title="Eliminar venda" @click.prevent="actionDeleteSales(row)"><i class='fa fa-trash text-danger'  ></i> </a>
                                </div>
                            </td>
                        </template>
                        <slot name="tbody-tr" :row="row"></slot>
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
                url:'sales',
                sales_id: "",
                model:{},
                message_sended: false,                
                
                modalAddDispatch: false,
                modalEdtitDispatch: false,
                modalDeleteDispatch: false,
                modalFilterDispatchs: false,

                rows:[],
                columns: [
                    {
                        label: 'Envio',
                        field: 'id',
                        numeric: true, 
                        // width: "90px",
                        html: false,                   
                    }, {
                        label: 'Data',
                        field: 'json_data.pedido.data',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Cliente',
                        field: 'json_data.pedido.cliente.nome',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Telefone',
                        field: 'json_data.pedido.cliente.fone',
                        numeric: false,
                        html: false,
                    },{
                        label: 'Situação',
                        field: 'json_data.pedido.situacao',
                        numeric: false,
                        html: false,
                    },{
                        label: 'Produto',
                        field: 'json_data.itensInHTML',
                        numeric: false,
                        html: true,
                    }, {
                        label: 'Mensagem',
                        field: 'messageSended',
                        numeric: false,
                        html: true,
                    }, {
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
            getSales: function() { //R
                ApiService.get(this.url)
                    .then(response => {
                        response.data.forEach((sale, i)=>{
                            sale.messageSended = (sale.sended) ? "<span class='text-success'><i class='fa fa-check'></i> Enviada<span>" : "<span class='text-danger'><i class='fa fa-times'></i> Não enviada<span>";
                            sale.json_data = JSON.parse(sale.json_data);
                            var str = "";
                            try{
                                sale.json_data.pedido.itens.forEach((itemData, j)=>{
                                    str += "<div title='"+itemData.item.descricao+"'>"+Math.round(itemData.item.quantidade)+" "+itemData.item.un+" "+itemData.item.descricao.substring(0,10)+"... </div>";                                
                                });
                                sale.json_data.itensInHTML =str;
                            }catch(error){
                                console.log(error);
                            }
                        });
                        this.rows = response.data;
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url, "get");
                    });
            }, 

            reloadDatas(){
                this.getSales();
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
                this.$refs.fileInputCSV.click();
            },
            
            closeModals(){
                this.modalAddDispatch = false;
                this.modalEdtitDispatch =  false;
                this.modalDeleteDispatch =  false;
                this.modalFilterDispatchs =  false;
            },

            actionResendMessageSales: function(value){
                alert(value.contact_id);
                alert(value.json_data);

                // tryResendMessageSales(); // TODO: ainda por implementar
                this.message_sended = true; // So para teste

                if(this.message_sended){
                    //  console.log("1");
                    //  console.log(this.model);
                    //  console.log(value);
                    //  console.log(value.json_data);
                    //  console.log(value.id);

                    delete value.json_data.itensInHTML;
                    delete value.created_at;
                    delete value.updated_at;
                    delete value.deleted_at;

                    value.sended = 1;

                    value.json_data = JSON.stringify(value.json_data);
                    
                    ApiService.put(this.url+'/'+value.id, value) 
                        .then(response => {

                            miniToastr.success("Mensagem enviada com sucesso","Sucesso");
                                this.reloadDatas();
                        })
                        .catch(error => {
                            this.processMessageError(error, this.url, "update");
                        })

                }else{
                    miniToastr.warn("Não foi possivél enviar a mensagem. Tente mais tarde!","Atenção");
                }   
            },

            tryResendMessageSales: function(){
                // se mensagem enviado
                this.message_sended = true;
            },

            actionEditSales: function(value){
                this.model = value;
                this.sales_id = value.id;
                this.modalEditSales = !this.modalEditSales;
            },

            actionDeleteSales: function(value){
                this.model = value;
                this.sales_id = value.id;
                this.modalDeleteSales = !this.modalDeleteSales;
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
            this.getSales();
        },

        mounted() {
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
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
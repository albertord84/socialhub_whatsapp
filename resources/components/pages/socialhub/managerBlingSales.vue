<template>
    <div class="card p-3">
        <!-- Contact DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        <div class="text-left">
            <div id="search-input-container">
                <label>
                    <div style="" class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="search" id="search-input" class="form-control" placeholder="Buscar venda" v-model="searchInput">
                    </div>
                </label>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar vendas">
                        <i class="mdi mdi-file-export fa-lg"  ></i>
                        <!-- <i class="fa fa-download"></i> -->
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table ref="table" class="table">
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
        
        <!-- Edit Sales Modal -->
        <b-modal v-model="modalEditContact" size="lg" :hide-footer="true" title="Editar venda">
            <managerCRUDContact :url='url' :secondUrl='secondUrl' :action='"edit"' :attendants='attendants' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDContact>            
        </b-modal>

        <!-- Delete Sales Modal -->
        <b-modal ref="modal-delete-matter" v-model="modalDeleteContact" id="modalDeleteMatter" :hide-footer="true" title="Verificação de exclusão">
            <managerCRUDContact :url='url' :secondUrl='secondUrl' :action='"delete"' :attendants='attendants' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDContact>            
        </b-modal>

        <!-- Confirm import cantacts Modal -->
        <b-modal ref="modal-import-contact" v-model="showModalFileUploadCSV" id="showModalFileUploadCSV" :hide-footer="true" title="Confirmação de importação de contatos">
            
            <h6>Você está adicionando novos contatos a partir do arquivo selecionado.</h6>
            <h5>Atenção:</h5>
            <p>   1. Para adicionar os contatos, o nome de usuário e o número de Whatsapp são obrigatórios.</p>
            <p>   2. Os dados dos contatos no arquivo .csv devem ter a ordem e formato corretos.</p>
            <p>      Ex: Nome | Whatsapp | email | facebook | instagram | linkedin </p>
            <p>Os contatos que não cumpram com os itens 1 e 2 não serão adicionados na lista de contatos.</p>

                <div class="col-lg-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary btn_width" @click.prevent="addContactsFromCSV">
                        <i v-if="isSendingContactFromCSV==true" class="fa fa-spinner fa-spin"></i>
                        Enviar
                    </button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="showModalFileUploadCSV=!showModalFileUploadCSV, file=null">Cancelar</button>
                </div>
        </b-modal>

    </div>
</template>
<script>
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import managerCRUDContact from "./popups/managerCRUDContact";

    export default {
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
            managerCRUDContact
        },

        data() {
            return {
                //---------General properties-----------------------------
                url:'sales',  //route to controller
                // secondUrl:'attendantsContacts',
                // url_attendants:'usersAttendants',  //route to controller
                
                //---------Specific properties-----------------------------
                contact_id: "",
                contact_atendant_id: 0,
                model:{},
                
                isSendingContactFromCSV:false,
                file:null,
                //---------New record properties-----------------------------
                
                //---------Edit record properties-----------------------------
                
                //---------Show Modals properties-----------------------------
                modalAddSales: false,
                modalEditContact: false,
                modalDeleteContact: false,
                showModalFileUploadCSV: false,

                //---------Externals properties-----------------------------
                attendants:null,

                //---------DataTable properties-----------------------------
                rows:[],
                columns: [
                    {
                        label: 'Id',
                        field: 'id',
                        numeric: true, 
                        // width: "90px",
                        html: false,                   
                    }, {
                        label: 'Cliente',
                        field: 'json_data.cliente.nome',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Telefone',
                        field: 'json_data.cliente.fone',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Situação',
                        field: 'json_data.situacao',
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
                            sale.json_data.itens.forEach((itemData, j)=>{
                                str += "<div title='"+itemData.item.descricao+"'>"+Math.round(itemData.item.quantidade)+" "+itemData.item.un+" "+itemData.item.descricao.substring(0,10)+"... </div>";                                
                            });
                            sale.json_data.itensInHTML =str;
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
            
            closeModals(){
                this.modalAddSales = false;
                this.modalEditContact = false;
                this.modalDeleteContact = false;
            },

            actionResendMessageSales: function(value){
                alert(value.contact_id);
                alert(value.json_data);
            },

            actionEditSales: function(value){
                this.model = value;
                this.contact_id = value.id;
                // this.contact_atendant_id = value.contact_atendant_id;
                this.modalEditContact = !this.modalEditContact;
            },

            actionDeleteSales: function(value){
                this.model = value;
                this.contact_id = value.id;
                this.modalDeleteContact = !this.modalDeleteContact;
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

            triggerEvent () {
                this.$refs.fileInputCSV.click();
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
</style>

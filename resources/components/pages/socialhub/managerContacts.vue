<template>
    <div class="card p-3 no-shadows">
        <!-- Contact DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        <div class="text-left">
            <div id="search-input-container">
                <label>
                    <div style="" class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="search" id="search-input" class="form-control" placeholder="Buscar contato" v-model="searchInput">
                    </div>
                </label>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar contatos">
                        <i class="mdi mdi-file-export fa-lg"  ></i>
                        <!-- <i class="fa fa-download"></i> -->
                    </a>
                </div>
                <div class="actions float-right pr-4 mb-3">
                    <input id="fileInputCSV" ref="fileInputCSV" style="display:none" type="file" @change.prevent="showModalFileUploadCSV=!showModalFileUploadCSV" accept=".csv"/>
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="triggerEvent()" title="Importar contatos">
                        <i class="mdi mdi-file-import fa-lg"  ></i>
                        <!-- <i class="fa fa-id-card-o"></i> -->
                    </a>

                </div>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click.prevent="modalAddContact = !modalAddContact" title="Novo contato">
                        <i class="fa fa-user-plus"></i>
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
                    <tr v-for="(row, index) in paginated" @click="click(row, index)" :key="index">
                        <template v-for="(column,index) in columns">
                            <td :class="column.numeric ? 'numeric' : ''" v-if="!column.html" :key="index">
                                {{ collect(row,column.field) }}
                            </td>
                            <td :class="column.numeric ? 'numeric' : ''" v-if="column.html" :key="index">
                                <!-- <a class="text-18" href="javascript:void(0)" @click.prevent="actionSeeContact(row)"><i class='fa fa-comments-o text-info mr-3'></i></a> -->
                                <a class="text-18" href="javascript:void(0)" title="Editar dados" @click.prevent="actionEditContact(row)"> <i class='fa fa-pencil text-success mr-3' ></i> </a>
                                <a class="text-18" href="javascript:void(0)" title="Eliminar contato" @click.prevent="actionDeleteContact(row)"><i class='fa fa-trash text-danger'  ></i> </a>
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

        <!-- Add Contact Modal -->
        <b-modal v-model="modalAddContact" size="lg" :hide-footer="true" title="Novo contato">
            <managerCRUDContact :url='url' :secondUrl='secondUrl' :action='"insert"' :attendants='attendants' :item='{}' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDContact>
        </b-modal>

        <!-- Edit Contact Modal -->
        <b-modal v-model="modalEditContact" size="lg" :hide-footer="true" title="Editar contato">
            <managerCRUDContact :url='url' :secondUrl='secondUrl' :action='"edit"' :attendants='attendants' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDContact>            
        </b-modal>

        <!-- Delete Contact Modal -->
        <b-modal ref="modal-delete-matter" v-model="modalDeleteContact" id="modalDeleteMatter" :hide-footer="true" title="Verificação de exclusão">
            <managerCRUDContact :url='url' :secondUrl='secondUrl' :action='"delete"' :attendants='attendants' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </managerCRUDContact>            
        </b-modal>

        <!-- Confirm import cantacts Modal -->
        <b-modal ref="modal-import-contact" v-model="showModalFileUploadCSV" id="showModalFileUploadCSV" :hide-footer="true" title="Confirmação de importação de contatos">
            <!-- Você adicionará novos contatos a partir do arquivo selecionado.
            Atenção: 
               1. Para adicionar os contatos, o nome de usuario e o número de Whatsapp são obrigatorios.
               2. Os dados dos contatos no arquivo .csv devem ter a ordem e formato correto.
                  Ex: João Silva | 55 11 999999999 | joao@gmail.com |
            Os dados que nao cumpram com os itens 1 e 2 nã serão adicionados. -->

            <h6>Você está adicionando novos contatos a partir do arquivo selecionado.</h6>
            <h5>Atenção:</h5>
            <p>   1. Para adicionar os contatos, o nome de usuário e o número de Whatsapp são obrigatórios.</p>
            <p>   2. Os dados dos contatos no arquivo .csv devem ter a ordem e formato corretos.</p>
            <p>      Ex: Nome | Whatsapp | email | facebook | instagram | linkedin | estado | cidade | categoria 1 | categoria 2 </p>
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
                url:'contacts',  //route to controller
                secondUrl:'attendantsContacts',
                url_attendants:'usersAttendants',  //route to controller
                
                //---------Specific properties-----------------------------
                contact_id: "",
                contact_atendant_id: 0,
                model:{},
                
                isSendingContactFromCSV:false,
                file:null,
                //---------New record properties-----------------------------
                
                //---------Edit record properties-----------------------------
                
                //---------Show Modals properties-----------------------------
                modalAddContact: false,
                modalEditContact: false,
                modalDeleteContact: false,
                showModalFileUploadCSV: false,

                //---------Externals properties-----------------------------
                attendants:null,

                //---------DataTable properties-----------------------------
                rows:[],
                columns: [
                    {
                        label: 'Status',
                        field: 'status_name',
                        numeric: true, 
                        width: "90px",
                        html: false,
                    },{
                        label: 'Whatsapp',
                        field: 'whatsapp_id',
                        numeric: false,
                        html: false,
                    },{
                        label: 'Nome', 
                        field: 'first_name', 
                        numeric: false, 
                        html: false, 
                    }, {
                        label: 'Email',
                        field: 'email',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Atendente',
                        field: 'attendant_name',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Ações',
                        field: 'button',
                        numeric: false,
                        html: true,
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
            getContacts: function() { //R
                ApiService.get(this.url)
                    .then(response => {
                        this.rows = response.data;
                        var This=this;
                        response.data.forEach(function(item, i){                            
                            if(item.status)
                                item.status_name = item.status.name;
                            var name = "";
                            item.contact_atendant_id = 0;
                            if(item.latestAttendant){
                                item.attendant_name = item.latestAttendant.name;
                                item.contact_atendant_id = item.latestAttendant.id;
                            }
                        });
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url, "get");
                    });
            }, 

            reloadDatas(){

                this.getContacts();
            },
            
            closeModals(){

                this.modalAddContact = false;
                this.modalEditContact = false;
                this.modalDeleteContact = false;
            },

            actionSeeContact: function(value){
                alert(value);
            },

            actionEditContact: function(value){
                this.model = value;
                this.contact_id = value.id;
                // this.contact_atendant_id = value.contact_atendant_id;
                this.modalEditContact = !this.modalEditContact;
            },

            actionDeleteContact: function(value){
                this.model = value;
                this.contact_id = value.id;
                this.modalDeleteContact = !this.modalDeleteContact;
            },

            addContactsFromCSV:function(){
                this.file = null;
                if(!this.$refs.fileInputCSV.files[0].name.includes('.csv')){
                    miniToastr.error("O arquivo selecionado deve estar em formato .CSV", "Erro"); 
                    return;
                }
                if(this.$refs.fileInputCSV.files[0].size < 5*1024*1024) {
                    this.file = this.$refs.fileInputCSV.files[0];
                    if(this.file){
                        let formData = new FormData();
                        formData.append("id",'0');
                        formData.append("file",this.file);
                        this.isSendingContactFromCSV = true;
                        ApiService.post('contactsFromCSV',formData, {headers: { "Content-Type": "multipart/form-data" }})
                            .then(response => {
                                this.getContacts();
                                miniToastr.success("Os contatos foram adicionados corretamente", "Sucesso"); 
                            })
                            .catch(error => {
                                this.processMessageError(error, this.url, "get");
                            })
                            .finally(()=>{this.isSendingContactFromCSV=false;
                                          this.showModalFileUploadCSV=!this.showModalFileUploadCSV });
                                        //   this.showModalFileUploadCSV=false;});
                    }
                } else{
                    miniToastr.error("O arquivo deve ter tamanho inferior a 5MB", "Erro"); 
                }

            },

            //------ externals methods--------------------
            getAttendantList: function() { //R
                ApiService.get(this.url_attendants)
                    .then(response => {
                        this.attendants = [];
                        var This=this;
                        response.data.forEach(function(item, i){
                            var obj = item.user;
                            obj.created_at = item.created_at;
                            obj.deleted_at = item.deleted_at;
                            obj.updated_at = item.updated_at;
                            This.attendants.push(obj);
                            //TODO-JR: adicionar o nome do status a cada registro
                        });
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url_attendants, "get");
                    });
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
            this.getAttendantList();
            this.getContacts();
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
    .no-shadows{
        box-shadow: none !important;
    }
</style>

<template>
    <div class="card p-3">
        <!-- Companies DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        <div class="text-left">
            <div id="search-input-container">
                <label>
                    <div style="" class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="search" id="search-input" class="form-control" placeholder="Buscar empresa" v-model="searchInput">
                    </div>
                </label>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar empresas">
                        <i class="fa fa-download"></i>
                    </a>
                </div>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click.prevent="modalAddCompanies = !modalAddCompanies" title="Nova empresa">
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
                                {{ collect(row, column.field) }}
                            </td>
                            <td :class="column.numeric ? 'numeric' : ''" v-if="column.html" :key="index">
                                <a class="text-18" href="javascript:void(0)" title="Editar dados" @click.prevent="actionEditCompanies(row)"> <i class='fa fa-pencil text-success mr-3' ></i> </a>
                                <a class="text-18" href="javascript:void(0)" title="Cancelar contrato" @click.prevent="actionDeleteCompanies(row)"><i class='fa fa-trash text-danger'  ></i> </a>
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
                <div class="datatable-info pb-2 mt-3">
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

        <!-- Add Companies Modal -->
        <b-modal v-model="modalAddCompanies" size="lg" :hide-footer="true" title="Nova empresa">
            <sellerCRUDCompanies :rpi_url='rpi_url' :companies_url='companies_url' :users_url='users_url' :usersManager_url='usersManager_url' :action='"insert"' :item='{}' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </sellerCRUDCompanies>
        </b-modal>

        <!-- Edit Companies Modal -->
        <b-modal v-model="modalEditCompanies" size="lg" :hide-footer="true" title="Editar empresa">
            <sellerCRUDCompanies :rpi_url='rpi_url' :companies_url='companies_url' :users_url='users_url' :usersManager_url='usersManager_url' :action='"edit"' :model_rpi='model_rpi' :model_company='model_company' :model_manager='model_manager' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </sellerCRUDCompanies>
        </b-modal>

        <!-- Delete Companies Modal -->
        <b-modal ref="modal-delete-matter" v-model="modalDeleteCompanies" :hide-footer="true" title="Verificação de cancelamento">
            <sellerCRUDCompanies :rpi_url='rpi_url' :companies_url='companies_url' :users_url='users_url' :usersManager_url='usersManager_url' :action='"delete"' :model_rpi='model_rpi' :model_company='model_company' :model_manager='model_manager' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </sellerCRUDCompanies>            
        </b-modal>

    </div>
</template>
<script>
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import sellerCRUDCompanies from "./popups/sellerCRUDCompanies";
    // import sellerCRUDCompanies from "./popups/sellerCRUDCompaniesWizzard";

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
            sellerCRUDCompanies
        },

        data() {
            return {
                //---------General properties-----------------------------
                companies_url:'companies',  //route to controller
                users_url:'users',  //route to controller
                usersManager_url:'usersManagers',  //route to controller
                rpi_url:'rpis',  //route to controller
                
                //---------Specific properties-----------------------------
                companies_id: "",
                rpi_id: "",
                model_company:'',
                model_manager:'',
                model_rpi:'',
                //---------New record properties-----------------------------
                
                //---------Edit record properties-----------------------------

                //---------Show Modals properties-----------------------------
                modalAddCompanies: false,
                modalEditCompanies: false,
                modalDeleteCompanies: false,

                //---------Externals properties-----------------------------

                //---------DataTable properties-----------------------------
                rows:[],
                columns: [
                    {
                        label: 'Nome', 
                        field: 'name', 
                        numeric: false, 
                        html: false, 
                    },{
                        label: 'CNPJ', 
                        field: 'CNPJ', 
                        numeric: false, 
                        html: false,                     
                    }, {
                        label: 'Telefone',
                        field: 'phone',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Email',
                        field: 'email',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'RPI-DB-ID',
                        field: 'rpi_id',
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
            getCompanies: function() { //R
                ApiService.get(this.companies_url)
                    .then(response => {
                        this.rows = response.data;
                        var This = this;
                        response.data.forEach(function(item, i){
                            //TODO-JR: pegar o nome do gerente e adicionar para mostrar na tabela

                            // if(item.status)
                            //     item.status_name = item.status.name;
                            // var name = "";
                            // item.contact_atendant_id = 0;
                            // if(item.latestAttendant){
                            //     item.attendant_name = item.latestAttendant.user.name;
                            //     item.contact_atendant_id = item.latestAttendant.user.id;
                            // }
                        });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando as empresas");   
                    });
            }, 

            reloadDatas(){
                this.getCompanies();
            },
            
            closeModals(){
                this.modalAddCompanies = false;
                this.modalEditCompanies = false;
                this.modalDeleteCompanies = false;
            },

            actionSeeCompanies: function(value){
                this.model_company = value;
            },

            actionEditCompanies: function(value){
                //company datas
                this.model_company = Object.assign({}, value);
                this.companies_id = value.id;
                this.rpi_id = value.rpi_id;
                this.model_rpi={};
                
                //manager data
                ApiService.post(this.usersManager_url+'/'+this.companies_id+'/'+'getManager')
                    .then(response => {
                        try {
                            this.model_manager  = response.data[0];
                            for (var key in this.model_manager.user) { //pasar los campos del usuraio para el manager
                                this.model_manager[key] = this.model_manager.user[key];
                            }
                            delete this.model_manager.user;
                            
                            //rpi datas
                            if(this.rpi_id){
                                ApiService.get(this.rpi_url+'/'+this.rpi_id)
                                .then(response => {
                                    this.model_rpi = response.data;
                                    this.modalEditCompanies = !this.modalEditCompanies;    
                                })
                                .catch(function(error) {
                                    miniToastr.error(error, "Erro obtendo canal de comunicação");   
                                });

                            }else{
                                this.modalEditCompanies = !this.modalEditCompanies;
                            }


                            
                        } catch (error) {
                            console.log(error);
                        }
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Erro obtendo Manager");   
                    });
            },

            actionDeleteCompanies: function(value){
                //company datas
                this.model_company = Object.assign({}, value);
                this.companies_id = value.id;
                this.rpi_id = value.rpi_id;
                this.model_rpi={};
                
                //manager data
                ApiService.post(this.usersManager_url+'/'+this.companies_id+'/'+'getManager')
                    .then(response => {
                        try {
                            this.model_manager  = response.data[0];
                            for (var key in this.model_manager.user) { //pasar los campos del usuraio para el manager
                                this.model_manager[key] = this.model_manager.user[key];
                            }
                            delete this.model_manager.user;
                            
                            //rpi datas
                            if(this.rpi_id){
                                ApiService.get(this.rpi_url+'/'+this.rpi_id)
                                .then(response => {
                                    this.model_rpi = response.data;
                                    this.modalDeleteCompanies = !this.modalDeleteCompanies;    
                                })
                                .catch(function(error) {
                                    miniToastr.error(error, "Erro obtendo canal de comunicação");   
                                });

                            }else{
                                this.modalDeleteCompanies = !this.modalDeleteCompanies;
                            }


                            
                        } catch (error) {
                            console.log(error);
                        }
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Erro obtendo Manager");   
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
        },

        beforeMount(){
            this.getCompanies();
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
</style>

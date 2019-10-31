<template>
    <div class="card p-3">
        <!-- Sellers DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        <div class="text-left">
            <div id="search-input-container">
                <label>
                    <div style="" class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="search" id="search-input" class="form-control" placeholder="Buscar vendedor" v-model="searchInput">
                    </div>
                </label>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar vendedores">
                        <i class="fa fa-download"></i>
                    </a>
                </div>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" @click.prevent="modalAddSellers = !modalAddSellers" title="Novo vendedor">
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
                                <a class="text-18" href="javascript:void(0)" @click.prevent="actionSeeSellers(row)"><i class='fa fa-headphones text-dark mr-3'></i></a>
                                <a class="text-18" href="javascript:void(0)" @click.prevent="actionEditSellers(row)"> <i class='fa fa-pencil text-success mr-3' ></i> </a>
                                <a class="text-18" href="javascript:void(0)" @click.prevent="actionDeleteSellers(row)"><i class='fa fa-trash text-danger'  ></i> </a>
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

        <!-- Add Sellers Modal -->
        <b-modal v-model="modalAddSellers" size="lg" :hide-footer="true" title="Novo vendedor">
            <adminCRUDSellers :url='url' :first_url='first_url' :action='"insert"' :item='{}' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </adminCRUDSellers>
        </b-modal>

        <!-- Edit Sellers Modal -->
        <b-modal v-model="modalEditSellers" size="lg" :hide-footer="true" title="Editar vendedor">
            <adminCRUDSellers :url='url' :first_url='first_url' :action='"edit"' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </adminCRUDSellers>
        </b-modal>

        <!-- Delete Sellers Modal -->
        <b-modal ref="modal-delete-matter" v-model="modalDeleteSellers" id="modalDeleteMatter" :hide-footer="true" title="Verificação de exclusão">
            <adminCRUDSellers :url='url' :first_url='first_url' :action='"delete"' :item='model' @onreloaddatas='reloadDatas' @modalclose='closeModals'> </adminCRUDSellers>            
        </b-modal>

    </div>
</template>
<script>
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import adminCRUDSellers from "./popups/adminCRUDSellers";

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
            adminCRUDSellers
        },

        data() {
            return {
                //---------General properties-----------------------------
                first_url:'users',  //route to controller
                url:'usersSellers',  //route to controller
                
                // model:{},
                //---------Specific properties-----------------------------
                Sellers_id: "",
                model:{},
                //---------New record properties-----------------------------
                
                //---------Edit record properties-----------------------------

                //---------Show Modals properties-----------------------------
                modalAddSellers: false,
                modalEditSellers: false,
                modalDeleteSellers: false,

                //---------Externals properties-----------------------------

                //---------DataTable properties-----------------------------
                rows:[],
                columns: [
                    {
                        label: 'Status',
                        field: 'status_id',
                        // field: 'status_name',
                        numeric: true, 
                        width: "90px",
                        html: false,
                    },{
                        label: 'Login', 
                        field: 'login', 
                        numeric: false, 
                        html: false, 
                    },{
                        label: 'Nome completo', 
                        field: 'name', 
                        numeric: false, 
                        html: false,                     
                    }, {
                        label: 'Email',
                        field: 'email',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Telefone',
                        field: 'phone',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'CPF',
                        field: 'CPF',
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
            getSellers: function() { //R
                ApiService.get(this.url)
                    .then(response => {
                        this.rows = [];
                        var This=this;
                        // response.data.forEach(function(item, i){
                        //     var obj = item.user;
                        //     This.rows.push(obj);
                        // });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os vendedores");   
                    });
            }, 

            reloadDatas(){
                this.getSellers();
            },
            
            closeModals(){
                this.modalAddSellers = false;
                this.modalEditSellers = false;
                this.modalDeleteSellers = false;
            },

            actionSeeSellers: function(value){
                this.model = value;
            },

            actionEditSellers: function(value){
                this.model = value;
                this.Sellers_id = value.id;
                this.modalEditSellers = !this.modalEditSellers;
            },

            actionDeleteSellers: function(value){
                this.model = value;
                this.Sellers_id = value.id;
                this.modalDeleteSellers = !this.modalDeleteSellers;
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
            this.getSellers();
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

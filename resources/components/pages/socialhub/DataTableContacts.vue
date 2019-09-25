<template>
    <div class="card p-3">
        <!-- Contact DataTable -->
        <div class="table-header">
            <h4 class="table-title text-center mt-3">{{title}}</h4>
        </div>        
        <div class="text-left">
            <div id="search-input-container">
                <label>
                    <input style="font-size: 1rem" type="search" id="search-input" class="form-control mb-2" placeholder="Buscar contato ..." v-model="searchInput">
                </label>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Exportar contatos">
                        <i class="fa fa-download"></i>
                    </a>
                </div>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="exportExcel" title="Importar contatos">
                        <i class="fa fa-id-card-o"></i>
                    </a>
                </div>
                <div class="actions float-right pr-4 mb-3">
                    <a href="javascript:undefined" class="btn btn-info text-white" v-if="this.exportable" @click="modalAddContact=!modalAddContact" title="Novo contato">
                        <i class="fa fa-user-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table ref="table" class="table">
                <thead>
                    <tr>
                        <th class="text-left" v-for="(column, index) in columns" 
                            @click="sort(index)" 
                            :class="(sortable ? 'sortable' : '')
                            + (sortColumn === index ?
                                (sortType === 'desc' ? ' sorting-desc' : ' sorting-asc') : '')" :style="{width: column.width ? column.width : 'auto'}" :key="index">
                                {{column.label}}
                                <i class="fa float-right" 
                                    :class="(sortColumn === index ? (sortType === 'desc' ? ' fa fa-angle-down' : ' fa fa-angle-up') : '')">
                                </i>
                        </th>
                        <slot name="thead-tr"></slot>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in paginated" @click="click(row, index)" :key="index">
                        <template v-for="(column,index) in columns">
                            <td :class="column.numeric ? 'numeric' : ''" v-if="!column.html" :key="index">
                                {{ collect(row,column.field) }}
                            </td>
                            <td :class="column.numeric ? 'numeric' : ''" v-html="collect(row, column.field)" v-if="column.html" :key="index">
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
        <b-modal v-model="modalAddContact" id="modalAddContact" :hide-footer="true" title="Novo contato">
            <b-container fluid>
                <!-- <div class="col-lg-12 sect_header">
                    <ul class="menu">
                        <li><a href="javascript:void(0)" @click.prevent="toggle_left"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                        <li><p>Novo contato</p> </li>
                        <ul class="menu float-right">
                            <li ><a href="javascript:void(0)" @click.prevent="toggle_left()"><i class="fa fa-close"></i></a></li>
                        </ul>
                    </ul>
                </div>
                <form>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="padding: 29px 0px 5px" class="form-group has-search">
                                    <span class="fa fa-user form-control-feedback"></span>
                                    <input v-model="new_first_name" id="name" name="username" type="text" autofocus placeholder="Nome ou Apelido" class="form-control"/>
                                </div>
                                <field-messages name="username" show="$invalid && $submitted" class="text-danger"></field-messages>
                            </validate>
                        </div>
                    </div>                
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-envelope form-control-feedback"></span>
                                    <input v-model="new_email" name="email" id="email" type="email" placeholder="E-mail" class="form-control"/>
                                </div>
                                <field-messages name="email" show="$invalid && $submitted" class="text-danger"><div slot="email">Email inválido</div></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-phone form-control-feedback"></span>
                                    <input v-model="new_phone" id="fix_phone" name="fix_phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                                </div>
                                <field-messages name="fix_phone" show="$invalid && $submitted" class="text-danger"></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-whatsapp form-control-feedback"></span>
                                    <input v-model="new_whatsapp_id" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                                </div>
                                <field-messages name="whatsapp" show="$invali   d && $submitted" class="text-danger"><div slot="required">Whatssap é obrigatório</div></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-facebook form-control-feedback"></span>
                                    <input v-model="new_facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                                </div>
                                <field-messages name="facebook" show="$invalid && $submitted" class="text-danger"></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style=" " class="form-group has-search">
                                    <span class="fa fa-instagram form-control-feedback"></span>
                                    <input v-model="new_instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                                </div>
                                <field-messages name="instagram" show="$invalid && $submitted" class="text-danger">
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-linkedin form-control-feedback"></span>
                                    <input v-model="new_linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                                </div>
                                <field-messages name="linkedin" show="$invalid && $submitted" class="text-danger">
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <textarea v-model="model.decription" name="decription" id="decription" placeholder="Adicione descrição ..." class="form-control" cols="30" rows="5"></textarea>
                                <field-messages show="$invalid && $submitted" class="text-danger">
                                </field-messages>
                            </validate>
                        </div>
                    </div>

                    <div class="col-sm-12" v-show="show_error">
                        <ul>
                            <li v-for="error in validationErrors" class="text-danger">{{error[0]}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-12" v-show="show_success">
                        <ul>
                            <li class="text-success">Your user record has been inserted successfully</li>
                        </ul>
                    </div>
                    <div class="col-lg-12 m-t-25 text-center">
                        <button type="submit" class="btn btn-primary btn_width">Adicionar</button>
                        <button type="reset" class="btn btn-effect-ripple btn-secondary btn_width reset_btn1" @click.prevent="form_reset();toggle_left()">Cancelar</button>
                    </div>
                </form> -->
                <!-- <form>
                    new_first_name: "",
                    new_last_name: "",
                    new_phone: "",
                    new_whatsapp_id: "",
                    new_facebook_id: "",
                    new_instagram_id: "",
                    new_linkedin_id: "",

                    <label for="matter_name" class="mt-2">Nome:</label>
                    <input type="text" id="matter_name_in" class="form-control" v-model="newmattername">

                    
                    <label for="matter_desc" class="mt-2">Descrição</label>
                    <textarea name="matter_desc_in" maxlength="500" class="form-control" rows="5" v-model="newmatterdesc"></textarea>
                    
                    <b-btn class="float-right mt-2" variant="primary" @click.prevent="addMatter">Adicionar</b-btn>
                    <span v-for="(error,key) in errors" v-bind:key="key" class="test-danger">{{error}}</span>
                </form> -->
            </b-container>
        </b-modal>

        <!-- Edit Contact Modal -->

        <!-- Delete Contact Modal -->
        <b-modal ref="modal-delete-matter" v-model="modalDeleteContact" id="modalDeleteMatter" :hide-footer="false" title="Verificação de exclusão">
            Tem certeza que deseja remover a matéria?
        </b-modal>

    </div>
</template>
<script>
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();

    export default {
        props: {
            title: {
                default: ""
            },
            columns: {
                required: true
            },
            rows: {
                required: true
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

        data() {
            return {
                new_first_name: "",
                new_last_name: "",
                new_phone: "",
                new_email: "",
                new_whatsapp_id: "",
                new_facebook_id: "",
                new_instagram_id: "",
                new_linkedin_id: "",

                contact_id: "",
                edit_first_name: "",
                edit_last_name: "",
                edit_phone: "",
                edit_email: "",
                edit_whatsapp_id: "",
                edit_facebook_id: "",
                edit_instagram_id: "",
                edit_linkedin_id: "",

                modalAddContact: false,
                modalDeleteContact: false,

                currentPage: 1,
                currentPerPage: this.perPage,
                sortColumn: -1,
                sortType: 'asc',
                searchInput: '',                
            }
        },

        methods: {
            addContact: function() { //C                
                var url = "contacts";
                ApiService.post(url,{
                    'first_name': this.new_first_name,
                    'last_name': this.new_last_name,
                    'phone': this.new_phone,
                    'email': this.new_email,
                    'whatsapp_id': this.new_whatsapp_id,
                    'facebook_id': this.new_facebook_id,
                    'instagram_id': this.new_instagram_id,
                    'linkedin_id': this.new_linkedin_id,
                })
                .then(response => {
                    miniToastr.success("Contato adicionado com sucesso","Sucesso");
                    this.new_first_name = "";
                    this.new_last_name = "";
                    this.new_email = "";
                    this.new_whatsapp_id = "";
                    this.new_facebook_id = "";
                    this.new_instagram_id = "";
                    this.new_linkedin_id = "";
                    this.reloadContacts();
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando contato");  
                });
            },

            reloadContacts: function() { //R
                // disparar evento para que el padre recargue la página
            },   

            editContact: function(content) { //U
                this.contact_id = contact.id;
                this.edit_first_name = contact.first_name;
                this.edit_last_name = contact.last_name;
                this.edit_phone = contact.phone;
                this.edit_email = contact.email;
                this.edit_whatsapp_id = contact.whatsapp_id;                
                this.edit_facebook_id = contact.facebook_id;
                this.edit_instagram_id = contact.instagram_id;
                this.edit_linkedin_id = contact.linkedin_id;
            },

            updateContact: function() { //U                
                var url = "contacts/"+this.contact_id;
                ApiService.post(url,{
                    'first_name': this.edit_first_name,
                    'last_name': this.edit_last_name,
                    'phone': this.edit_phone,
                    'email': this.edit_email,
                    'whatsapp_id': this.edit_whatsapp_id,
                    'facebook_id': this.edit_facebook_id,
                    'instagram_id': this.edit_instagram_id,
                    'linkedin_id': this.edit_linkedin_id,
                })
                .then(response => {                
                    miniToastr.success("Contato atualizado com sucesso","Sucesso");
                    this.new_first_name = "";
                    this.new_last_name = "";
                    this.new_phone = "";
                    this.new_whatsapp_id = "";
                    this.new_facebook_id = "";
                    this.new_instagram_id = "";
                    this.new_linkedin_id = "";
                    this.reloadContacts();
                })
                .catch(function(error) {
                    ApiService.process_request_error(error);  
                    miniToastr.error(error, "Erro atualizando contato"); 
                });
            },

            deleteContact: function(contact) { //D
                var url = "contacts/" + contact.id;
                ApiService.delete(url)
                    .then(response => {
                        this.reloadContacts();
                        miniToastr.success("Contato eliminado com sucesso","Sucesso");
                    })
                    .catch(function(error) {
                            ApiService.process_request_error(error);  
                            miniToastr.error(error, "Erro eliminando o contato"); 
                    });                
            },

            //-------------------------------------------------------

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
</style>

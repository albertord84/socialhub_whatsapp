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
                    <a href="javascript:undefined" class="btn btn-info text-white" @click.prevent="modalAddContact = !modalAddContact" title="Novo contato">
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
        <b-modal v-model="modalAddContact" size="lg" :hide-footer="true" title="Novo contato">
            <b-container fluid>                
                <form>                    
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="new_first_name" id="name" name="username" type="text" autofocus placeholder="Nome ou Apelido" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-headphones form-control-feedback"></span>
                            <select v-model="new_contact_atendant_id" class="form-control has-search-color" size="1">
                                <option value="0">Asignar um Atendente agora?</option>
                                <option value="1">Bootstrap</option>
                                <option value="2">CSS</option>
                                <option value="3">JavaScript</option>
                                <option value="4">HTML</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="new_email" name="email" id="email" type="email" placeholder="E-mail" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="new_phone" id="fix_phone" name="fix_phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="new_whatsapp_id" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-facebook form-control-feedback"></span>
                            <input v-model="new_facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                                <span class="fa fa-instagram form-control-feedback"></span>
                                <input v-model="new_instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                            </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-linkedin form-control-feedback"></span>
                            <input v-model="new_linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <textarea v-model="new_summary" @keyup="count_length_sumary" name="decription" id="decription" placeholder="Adicione um resumo ..." class="form-control" cols="30" rows="4"></textarea>
                            <label class="form-group has-search-color" for="form-group">{{new_summary_length}}/500</label>
                        </div>
                        <div class="col-lg-6 form-group">
                            <textarea v-model="new_remember" @keyup="count_length_remember" name="decription" id="decription" placeholder="Adicione um lembrete ..." class="form-control" cols="30" rows="4"></textarea>
                            <label class="form-group has-search-color" for="form-group">{{new_remember_length}}/500</label>
                        </div>
                    </div>
                    <div class="col-lg-12 m-t-25 text-center">
                        <button type="submit" class="btn btn-primary btn_width" @click.prevent="addContact">Adicionar</button>
                        <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="form_reset">Cancelar</button>
                    </div>
                </form> 
            </b-container>
        </b-modal>

        <!-- Edit Contact Modal -->
        <b-modal v-model="modalEditContact" size="lg" :hide-footer="true" title="Editar contato">
            <b-container fluid>                
                <form>                    
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="edit_first_name" id="name" name="username" type="text" autofocus placeholder="Nome ou Apelido" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-headphones form-control-feedback"></span>
                            <select v-model="edit_contact_atendant_id" class="form-control has-search-color" size="1">
                                <option value="0">Asignar um Atendente agora?</option>
                                <option value="1">Bootstrap</option>
                                <option value="2">CSS</option>
                                <option value="3">JavaScript</option>
                                <option value="4">HTML</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="edit_email" name="email" id="email" type="email" placeholder="E-mail" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="edit_phone" id="fix_phone" name="fix_phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="edit_whatsapp_id" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-facebook form-control-feedback"></span>
                            <input v-model="edit_facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                                <span class="fa fa-instagram form-control-feedback"></span>
                                <input v-model="edit_instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                            </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-linkedin form-control-feedback"></span>
                            <input v-model="edit_linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <textarea v-model="edit_summary" @keyup="count_length_sumary" name="decription" id="decription" placeholder="Adicione um resumo ..." class="form-control" cols="30" rows="4"></textarea>
                            <label class="form-group has-search-color" for="form-group">{{new_summary_length}}/500</label>
                        </div>
                        <div class="col-lg-6 form-group">
                            <textarea v-model="edit_remember" @keyup="count_length_remember" name="decription" id="decription" placeholder="Adicione um lembrete ..." class="form-control" cols="30" rows="4"></textarea>
                            <label class="form-group has-search-color" for="form-group">{{new_remember_length}}/500</label>
                        </div>
                    </div>
                    <div class="col-lg-12 m-t-25 text-center">
                        <button type="submit" class="btn btn-primary btn_width" @click.prevent="updateContact">Atualizar</button>
                        <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="form_reset">Cancelar</button>
                    </div>
                </form> 
            </b-container>
        </b-modal>

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
    // import add_contact from "./popups/add_contact";

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

        components:{
            // add_contact,
        },

        data() {
            return {
                new_first_name: "",
                new_last_name: "",
                new_phone: "",
                new_email: "",
                new_description: "",
                new_remember: "",
                new_summary: "",
                new_whatsapp_id: "",
                new_facebook_id: "",
                new_instagram_id: "",
                new_linkedin_id: "",
                new_contact_atendant_id:"0",
                new_summary_length:0,
                new_remember_length:0,

                contact_id: "",
                edit_first_name: "",
                edit_last_name: "",
                edit_phone: "",
                edit_email: "",                
                edit_description: "",
                edit_remember: "",
                edit_summary: "",
                edit_contact_atendant_id: "",                
                edit_whatsapp_id: "",
                edit_facebook_id: "",
                edit_instagram_id: "",
                edit_linkedin_id: "",

                modalAddContact: false,
                modalEditContact: false,
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
                    'email': this.new_email,
                    'remember': this.new_remember,
                    'summary': this.new_summary,
                    'phone': this.new_phone,
                    'description': this.new_description,
                    'whatsapp_id': this.new_whatsapp_id,
                    'facebook_id': this.new_facebook_id,
                    'instagram_id': this.new_instagram_id,
                    'linkedin_id': this.new_linkedin_id,                    
                    'contact_atendant_id': this.new_contact_atendant_id,
                })
                .then(response => {
                    miniToastr.success("Contato adicionado com sucesso","Sucesso");
                    this.form_reset();
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
                this.edit_description = contact.description;
                this.edit_remember = contact.remember;
                this.edit_summary = contact.summary;
                this.edit_whatsapp_id = contact.whatsapp_id;                
                this.edit_facebook_id = contact.facebook_id;
                this.edit_instagram_id = contact.instagram_id;
                this.edit_linkedin_id = contact.linkedin_id;
                this.edit_contact_atendant_id = contact.contact_atendant_id;
                this.modalEditContact = !this.modalEditContact;
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

            count_length_sumary: function(){
                this.new_summary_length = this.new_summary.length;
            },

            count_length_remember: function(){
                this.new_remember_length = this.new_remember.length;
            },

            form_reset:function(){
                this.new_first_name = "";
                this.new_last_name = "";
                this.new_email = "";
                this.new_description = "";
                this.new_remember = "";
                this.new_summary = "";
                this.new_phone = "";
                this.new_whatsapp_id = "";
                this.new_facebook_id = "";
                this.new_instagram_id = "";
                this.new_linkedin_id = "";
                this.new_contact_atendant_id = 0;
                this.modalAddContact=!this.modalAddContact;
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
</style>

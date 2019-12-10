<template>
    <div>
        <b-container fluid>                
            <form v-show="action!='delete'"> 
                <div>
                    <h3>Dados da empresa</h3>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelCompany.CNPJ" title="Ex: 00.000.000/0001-00" name="CNPJ" id="CNPJ" type="text" required placeholder="CNPJ (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-building-o form-control-feedback"></span>
                            <input v-model="modelCompany.name" title="Ex: Nome da Empresa" id="name" name="name" type="text" required placeholder="Nome da empresa (*)" class="form-control"/>
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelCompany.phone" title="Ex: 55(21)559-6918" name="phone" id="phone" type="text" required placeholder="Telefone (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelCompany.email" title="Ex: company@gmail.com" id="email" name="email" type="email" required placeholder="Email (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="modelCompany.whatsapp" title="Ex: 963525397" name="whatsapp" id="whatsapp" type="text" required placeholder="whatsapp (*)" class="form-control"/>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group has-search">
                            <textarea v-model="modelCompany.description" title="Ex: Describe informaçẽs relevantes da empresa" style="width:100%" name="description" id="description" rows="4" placeholder="Descrição"></textarea>
                        </div>                                                                         
                    </div>
                </div>
                <hr>

                <div>
                    <h3>Dados do canal de comunicação</h3>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.api_user" title="Ex: Nome da Empresa" name="api_user" id="api_user" type="text" required placeholder="Usuario da API (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.api_password" title="Ex: x2+A*fd!" id="api_password" name="api_password" type="password" required placeholder="Senha do usuario da API (*)" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.root_user" title="Ex: Nome da Empresa" name="root_user" id="root_user" type="text" required placeholder="Usuario Root (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.root_password" title="Ex: x2+A*fd!" id="root_password" name="root_password" type="password" required placeholder="Senha do usuario Root (*)" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.tcp_tunnel" title="Ex: 1.tcp.ngrok.io" name="tcp_tunnel" id="tcp_tunnel" type="text" required placeholder="Tunnel TCP (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.tcp_port" title="Ex: 29426" id="tcp_port" name="tcp_port" type="text" required placeholder="Porto TCP (*)" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.mac" title="Ex: b8:27:eb:76:21:41" name="mac" id="mac" type="text" required placeholder="Endereço MAC (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.api_tunnel" title="Ex: http://shrpialberto.sa.ngrok.io.ngrok.io" id="api_tunnel" name="api_tunnel" type="text" required placeholder="Tunnel da API (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-cog form-control-feedback"></span>
                            <input v-model="modelRpi.soft_version" title="Ex: 0.1.0" name="soft_version" id="soft_version" type="text" required placeholder="Versão do Software (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-cog form-control-feedback"></span>
                            <input v-model="modelRpi.soft_version_date" title="Ex: 30/11/2019" id="soft_version_date" name="soft_version_date" type="text" required placeholder="Data da Versão do Software (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>

                </div>
                <hr>

                <div class="pb-5">
                    <h3>Dados do manager da empresa</h3>
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="modelManager.name" title="Ex: Nome do Manager" id="name" name="name" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelManager.email" title="Ex: manager@gmail.com" name="email" id="email" type="text" required placeholder="Email (*)" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelManager.CPF" title="Ex: 000.000.008-00" name="CPF" id="CPF" type="text" required placeholder="CPF (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelManager.phone" title="Ex: 55(21)559-6918" id="phone" name="phone" type="text" required placeholder="Telefone (*)" class="form-control"/>
                        </div>
                    </div>                                   
                </div> 
                                               
                <div class="col-lg-12 m-t-25 text-center">
                    <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingInsert==true" @click.prevent="addCompany">
                        <i v-show="isSendingInsert==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Adicionar
                    </button>

                    <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateCompany">
                        <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                    </button>

                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>
            <form v-show="action=='delete'">
                Tem certeza que deseja cancelar o contrato dessa Empresa?
                <div class="col-lg-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary btn_width" :disabled="isSendingDelete==true" @click.prevent="deleteCompany">
                        <i v-show="isSendingDelete==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Eliminar
                    </button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>                    
            </form>

        </b-container>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../../common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    import VueFormWizard from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    
    export default {
        // name: 'adminCRUDSellers',
        name: 'sellersCRUDCompanies',

        props: {
            companies_url:'',
            users_url:'',
            usersManager_url:'',
            rpi_url:'',
            action: "",
            model_company:{},
            model_manager:{},
            model_rpi:{},
        },

        components:{
        },

        data(){
            return{
                modelCompany:{ //dados da empresa
                    CNPJ: "",
                    name: "",
                    phone: "",
                    email: "",
                    whatsapp: "",
                    description: "",
                },

                modelRpi:{ //dados do canal de comunicação
                    api_user: "",
                    api_password: "",
                    root_user: "",
                    root_password: "",
                    tcp_tunnel: "",
                    tcp_port: "",
                    mac: "",
                    api_tunnel: "",
                    soft_version: "",
                    soft_version_date: "",
                },

                modelManager:{ //manager da empresa
                    name: "",
                    role_id: "",
                    email: "",
                    login: "",
                    CPF: "",
                    phone: "",
                    image_path: "",
                    whatsapp_id: "",
                    facebook_id: "",
                    instagram_id: "",
                    linkedin_id: "",
                },
                logued_user:null,
                isSendingInsert: false,
                isSendingUpdate: false,
                isSendingDelete: false,
            }
        },

        methods:{
            addCompany: function() { //C
                this.modelCompany.id=1;
                this.modelCompany.user_seller_id=this.logued_user.id;
                this.modelManager.id=1;
                this.modelManager.role_id=3;
                this.modelManager.image_path = "images/user.jpg";
                this.isSendingInsert = true;

                //inserindo canal de comunicação.
                ApiService.post(this.rpi_url, this.modelRpi)
                        .then(response => {
                            this.modelCompany.rpi_id = response.data.id;
                            // inserindo company
                                ApiService.post(this.companies_url, this.modelCompany)
                                    .then(response => {
                                        this.modelManager.company_id = response.data.id;
                                        this.modelRpi.company_id = response.data.id;
                                        // inserindo user
                                        ApiService.post(this.users_url, this.modelManager)
                                                .then(response => {
                                                //inserindo userManager
                                                ApiService.post(this.usersManager_url, {'user_id':response.data.id})
                                                        .then(response => {
                                                            miniToastr.success("Empresa adicionada com sucesso","Sucesso");
                                                            this.formReset();
                                                            this.reload();
                                                            this.closeModals();
                                                        })
                                                        .catch(function(error) {
                                                            ApiService.process_request_error(error); 
                                                            miniToastr.error(error, "Erro adicionando Manager");  
                                                        });
                                                
                                                })
                                        .catch(function(error) {
                                            ApiService.process_request_error(error); 
                                            miniToastr.error(error, "Erro adicionando Manager");  
                                        });

                                })
                                .catch(function(error) {
                                    ApiService.process_request_error(error); 
                                    miniToastr.error(error, "Erro adicionando Empresa");  
                                });

                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando canal de comunicação");  
                });
            },
            
            editCompany: function() { //U
                this.modelManager = Object.assign({}, this.model_manager);
                this.modelCompany = Object.assign({}, this.model_company);
                this.modelRpi = Object.assign({}, this.model_rpi);

            },

            updateCompany: function() { 
                delete this.modelCompany.created_at;
                delete this.modelCompany.updated_at;
                delete this.modelManager.created_at;
                delete this.modelManager.updated_at;
                delete this.modelRpi.created_at;
                delete this.modelRpi.updated_at;
                
                this.isSendingUpdate = true;

                ApiService.put(this.rpi_url+'/'+this.modelRpi.id, this.modelRpi)
                        .then(response => {

                            ApiService.put(this.companies_url+'/'+this.modelCompany.id, this.modelCompany)
                                .then(response => {
                                    ApiService.put(this.users_url+'/'+this.modelManager.id, this.modelManager)
                                        .then(response => {
                                            miniToastr.success("Manager atualizado com sucesso","Sucesso");
                                            this.reload();
                                            this.closeModals();
                                        })
                                        .catch(function(error) {
                                            ApiService.process_request_error(error);  
                                            miniToastr.error(error, "Erro atualizando Manager"); 
                                        });
                                })
                                .catch(function(error) {
                                    ApiService.process_request_error(error);  
                                    miniToastr.error(error, "Erro atualizando companhia"); 
                                });

                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro atualizando canal de comunicação");  
                });
            },


            deleteCompany: function(){
                
                this.isSendingDelete = true;

                ApiService.delete(this.rpi_url+'/'+this.modelRpi.id)
                        .then(response => {

                            ApiService.delete(this.usersManager_url+'/'+this.modelManager.user_id )
                                .then(response => {
                                    
                                    ApiService.delete(this.users_url+'/'+this.modelManager.id)
                                        .then(response => {
                                            ApiService.delete(this.companies_url+'/'+this.modelCompany.id)
                                                .then(response => {
                                                    miniToastr.success("Companhia eliminada com sucesso","Sucesso");
                                                    this.reload();
                                                    this.closeModals();
                                                })
                                                .catch(function(error) {
                                                    ApiService.process_request_error(error);  
                                                    miniToastr.error(error, "Erro eliminando Companhia"); 
                                                });
                                        })
                                        .catch(function(error) {
                                            ApiService.process_request_error(error);  
                                            miniToastr.error(error, "Erro eliminando Manager"); 
                                        });
                                })
                                .catch(function(error) {
                                    ApiService.process_request_error(error);  
                                    miniToastr.error(error, "Erro eliminando Manager"); 
                                });

                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro eliminando canal de comunicação");  
                });

            },

            formReset:function(){
                this.modelCompany.CNPJ = "";
                this.modelCompany.name = "";
                this.modelCompany.phone = "";
                this.modelCompany.email = "";
                this.modelCompany.description = "";
                this.modelCompany.whatsapp = "";
                
                this.modelManager.name = "";
                this.modelManager.login = "";
                this.modelManager.email = "";
                this.modelManager.password = "";
                this.modelManager.CPF = "";
                this.modelManager.phone = "";
                this.modelManager.image_path = "";
                this.modelManager.whatsapp_id = "";
                this.modelManager.facebook_id = "";
                this.modelManager.instagram_id = "";
                this.modelManager.linkedin_id = "";

                this.modelRpi.api_user = "";
                this.modelRpi.api_password = "";
                this.modelRpi.root_user = "";
                this.modelRpi.root_password = "";
                this.modelRpi.tcp_tunnel = "";
                this.modelRpi.tcp_port = "";
                this.modelRpi.mac = "";
                this.modelRpi.api_tunnel = "";
                this.modelRpi.soft_version = "";
                this.modelRpi.soft_version_date = "";

            },

            closeModals(){
                this.$emit('modalclose');
            }, 
            
            reload(){
                this.$emit('onreloaddatas');
            }, 

        },

        mounted(){
            if(this.action!='insert')
                this.editCompany();
            this.logued_user = JSON.parse(window.localStorage.getItem('user'));
            
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

    }
</script>

<style scoped>
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
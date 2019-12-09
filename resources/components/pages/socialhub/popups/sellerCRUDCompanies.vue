<template>
    <div>
        <b-container fluid>                
            <form v-show="action!='delete'"> 
                <div>
                    <h3>Dados da empresa</h3>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelCompany.CNPJ" name="CNPJ" id="CNPJ" type="text" required placeholder="CNPJ (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-building-o form-control-feedback"></span>
                            <input v-model="modelCompany.name" id="name" name="name" type="text" required placeholder="Nome da empresa (*)" class="form-control"/>
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelCompany.phone" name="phone" id="phone" type="text" required placeholder="Telefone (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelCompany.email" id="email" name="email" type="email" required placeholder="Email (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="modelCompany.whatsapp" name="whatsapp" id="whatsapp" type="text" required placeholder="whatsapp (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelCompany.ngrok_url" id="ngrok_url" name="ngrok_url" type="text" required placeholder="URL " class="form-control"/>                            
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-12 form-group has-search">
                            <textarea v-model="modelCompany.description" style="width:100%" name="description" id="description" rows="4" placeholder="Descrição"></textarea>
                        </div>                                                                         
                    </div>
                </div>
                <hr>

                <div>
                    <h3>Dados do canal de comunicação</h3>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.api_user" name="api_user" id="api_user" type="text" required placeholder="Usuario da API (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.api_password" id="api_password" name="api_password" type="password" required placeholder="Senha do usuario da API (*)" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.root_user" name="root_user" id="root_user" type="text" required placeholder="Usuario Root (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.root_password" id="root_password" name="root_password" type="password" required placeholder="Senha do usuario Root (*)" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.tcp_tunnel" name="tcp_tunnel" id="tcp_tunnel" type="text" required placeholder="Tunnel TCP (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.tcp_port" id="tcp_port" name="tcp_port" type="text" required placeholder="Porto TCP (*)" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.mac" name="mac" id="mac" type="text" required placeholder="Endereço MAC (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.api_tunnel" id="api_tunnel" name="api_tunnel" type="text" required placeholder="Tunnel da API (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-cog form-control-feedback"></span>
                            <input v-model="modelRpi.soft_version" name="soft_version" id="soft_version" type="text" required placeholder="Versão do Software (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-cog form-control-feedback"></span>
                            <input v-model="modelRpi.soft_version_date" id="soft_version_date" name="soft_version_date" type="text" required placeholder="Data da Versão do Software (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>

                </div>
                <hr>

                <div class="pb-5">
                    <h3>Dados do manager da empresa</h3>
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="modelManager.name" id="name" name="name" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelManager.email" name="email" id="email" type="text" required placeholder="Email (*)" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelManager.CPF" name="CPF" id="CPF" type="text" required placeholder="CPF (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelManager.phone" id="phone" name="phone" type="text" required placeholder="Telefone (*)" class="form-control"/>
                        </div>
                    </div>                
                    <!-- <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="modelManager.whatsapp_id" name="whatsapp_id" id="whatsapp_id" type="text" placeholder="Whatsapp" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-facebook form-control-feedback"></span>
                            <input v-model="modelManager.facebook_id" id="facebook_id" name="facebook_id" type="text" placeholder="Facebook" class="form-control"/>
                        </div>
                    </div>                 -->
                </div> 
                               
                <div class="col-lg-12 m-t-25 text-center">
                    <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" @click.prevent="addCompany">Adicionar</button>
                    <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" @click.prevent="updateCompany">Atualizar</button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>
            <form v-show="action=='delete'">
                Tem certeza que deseja cancelar o contrato dessa Empresa?
                <div class="col-lg-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary btn_width" @click.prevent="deleteCompany">Eliminar</button>
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
    
    export default {
        // name: 'adminCRUDSellers',
        name: 'sellersCRUDCompanies',

        props: {
            companies_url:'',
            users_url:'',
            usersManager_url:'',
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
                    ngrok_url: "",
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
                logued_user:null
            }
        },

        methods:{
            addCompany: function() { //C
                this.modelCompany.id=1;
                this.modelCompany.user_seller_id=this.logued_user.id;
                this.modelManager.id=1;
                this.modelManager.role_id=3;
                this.modelManager.image_path = "images/user.jpg";
                // inserindo company
                ApiService.post(this.companies_url, this.modelCompany)
                .then(response => {
                    this.modelManager.company_id = response.data.id;
                    // inserindo user
                    ApiService.post(this.users_url, this.modelManager)
                        .then(response => {
                           //inserindo userManager
                           ApiService.post(this.usersManager_url, {'user_id':response.data.id})
                                .then(response => {
                                    miniToastr.success("Atendente adicionado com sucesso","Sucesso");
                                    this.formReset();
                                    this.reload();
                                    this.closeModals();
                                })
                            .catch(function(error) {
                                ApiService.process_request_error(error); 
                                miniToastr.error(error, "Erro adicionando Atendente");  
                            });
                           
                        })
                    .catch(function(error) {
                        ApiService.process_request_error(error); 
                        miniToastr.error(error, "Erro adicionando Atendente");  
                    });
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando usuáio");  
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
            },

            deleteCompany: function(){
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
            },

            formReset:function(){
                this.modelCompany.CNPJ = "";
                this.modelCompany.name = "";
                this.modelCompany.phone = "";
                this.modelCompany.email = "";
                this.modelCompany.description = "";
                this.modelCompany.whatsapp = "";
                this.modelCompany.ngrok_url = "";

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
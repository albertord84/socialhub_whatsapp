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
                
                <hr>
                <div v-if="action=='edit'">
                    <h3>Dados do canal de comunicação</h3>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.api_user" title="Ex: Nome da Empresa" name="api_user" id="api_user" type="text" required placeholder="Usuario da API" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.api_password" title="Ex: x2+A*fd!" id="api_password" name="api_password" type="password" required placeholder="Senha do usuario da API" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.root_user" title="Ex: Nome da Empresa" name="root_user" id="root_user" type="text" required placeholder="Usuario Root" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.root_password" title="Ex: x2+A*fd!" id="root_password" name="root_password" type="password" required placeholder="Senha do usuario Root" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.tcp_tunnel" title="Ex: 1.tcp.ngrok.io" name="tcp_tunnel" id="tcp_tunnel" type="text" required placeholder="Tunnel TCP" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.tcp_port" title="Ex: 29426" id="tcp_port" name="tcp_port" type="text" required placeholder="Porto TCP" class="form-control"/>
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
                            <input v-model="modelRpi.soft_version" title="Ex: 0.1.0" name="soft_version" id="soft_version" type="text" required placeholder="Versão do Software" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-cog form-control-feedback"></span>
                            <input v-model="modelRpi.soft_version_date" title="Ex: 30/11/2019" id="soft_version_date" name="soft_version_date" type="text" required placeholder="Data da Versão do Software" class="form-control"/>                            
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
    import validation from "src/common/validation.service";

    
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
                this.modelCompany.id=0;
                this.modelCompany.user_seller_id=this.logued_user.id;
                this.modelManager.id=0;
                this.modelManager.role_id=3;
                this.modelManager.image_path = "images/user.jpg";
                this.isSendingInsert = true;

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
                                        miniToastr.success("Empresa adicionada com sucesso","Sucesso");
                                        this.formReset();
                                        this.reload();
                                        this.closeModals();
                                    })
                                    .catch(function(error) {
                                        miniToastr.error(error, "Erro adicionando Manager");  
                                        ApiService.process_request_error(error); 
                                    });
                                })
                            .catch(function(error) {
                                miniToastr.error(error, "Erro adicionando Manager");  
                                ApiService.process_request_error(error); 
                            });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Erro adicionando Empresa");  
                        ApiService.process_request_error(error); 
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
                
                ApiService.put(this.companies_url+'/'+this.modelCompany.id, this.modelCompany)
                    .then(response => {
                        ApiService.put(this.users_url+'/'+this.modelManager.id, this.modelManager)
                            .then(response => {
                                miniToastr.success("Dados atualizado com sucesso","Sucesso");
                                if(!this.modelRpi.id) 
                                    this.modelRpi.id=0;                                
                                ApiService.put(this.rpi_url+'/'+this.modelRpi.id, this.modelRpi)
                                    .then(response => {
                                        this.isSendingUpdate = false;
                                        this.reload();
                                        this.closeModals();
                                })
                                .catch(function(error) {
                                    this.isSendingUpdate = false;
                                    if(!this.modelRpi.id && this.modelRpi.mac!='')
                                        alert("O endereço MAC informado não existe no banco de dados. Peça ao Gerente dessa empressa ligar o Hardware e concectar à internet");
                                    else
                                        miniToastr.error(error, "Erro atualizando canal de comunicação"); 
                                });
                        })
                        .catch(function(error) {
                            this.isSendingUpdate = false;
                            miniToastr.error(error, "Erro atualizando Manager"); 
                        });
                    })
                    .catch(function(error) {
                        this.isSendingUpdate = false;
                        ApiService.process_request_error(error); 
                        miniToastr.error(error, "Erro atualizando companhia"); 
                    });
            },

            deleteCompany: function(){
                
                this.isSendingDelete = true;
                
                //delete userManager row
                ApiService.delete(this.usersManager_url+'/'+this.modelManager.user_id )
                    .then(response => {                        
                        //delete user row
                        ApiService.delete(this.users_url+'/'+this.modelManager.id)
                            .then(response => {
                                //delete Company row
                                ApiService.delete(this.companies_url+'/'+this.modelCompany.id)
                                    .then(response => {
                                        //delete RPI row
                                        if(this.modelCompany.rpi_id){
                                            ApiService.delete(this.rpi_url+'/'+this.modelRpi.id)
                                                .then(response => {
                                                    miniToastr.success("Empresa eliminada com sucesso","Sucesso");
                                                    this.reload();
                                                    this.closeModals();
                                                    this.isSendingDelete = false;
                                                })
                                                .catch(function(error) {
                                                    ApiService.process_request_error(error);  
                                                    miniToastr.error(error, "Erro eliminando canal de comunicação"); 
                                                });
                                        }else{
                                            miniToastr.success("Empresa eliminada com sucesso","Sucesso");
                                            this.reload();
                                            this.closeModals();
                                            this.isSendingDelete = false;
                                        }
                                    })
                                    .catch(function(error) {
                                        ApiService.process_request_error(error);  
                                        miniToastr.error(error, "Erro eliminando empresa");
                                        this.isSendingDelete = false;
                                    });
                            })
                            .catch(function(error) {
                                ApiService.process_request_error(error);  
                                miniToastr.error(error, "Erro eliminando o usuário"); 
                                this.isSendingDelete = false;
                            });
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error); 
                        miniToastr.error(error, "Erro eliminando o usuário");  
                        this.isSendingDelete = false;
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


            // trimDataModels:function(){
            //     this.modelCompany.CNPJ = this.modelCompany.CNPJ.trim();
            //     this.modelCompany.name = this.modelCompany.name.trim();
            //     this.modelCompany.phone = this.modelCompany.phone.trim();
            //     this.modelCompany.email = this.modelCompany.email.trim();
            //     this.modelCompany.whatsapp = this.modelCompany.whatsapp.trim();
            //     this.modelCompany.description = this.modelCompany.description.trim();

            //     this.modelRpi.api_user = this.modelRpi.api_user.trim();
            //     this.modelRpi.api_password = this.modelRpi.api_password.trim();
            //     this.modelRpi.root_user = this.modelRpi.root_user.trim();
            //     this.modelRpi.root_password = this.modelRpi.root_password.trim();
            //     this.modelRpi.tcp_tunnel = this.modelRpi.tcp_tunnel.trim();
            //     this.modelRpi.tcp_port = this.modelRpi.tcp_port.trim();
            //     this.modelRpi.mac = this.modelRpi.mac.trim();
            //     this.modelRpi.api_tunnel = this.modelRpi.api_tunnel.trim();
            //     this.modelRpi.soft_version = this.modelRpi.soft_version.trim();
            //     this.modelRpi.soft_version_date = this.modelRpi.soft_version_date.trim();

            //     this.modelManager.name = this.modelManager.name.trim();
            //     this.modelManager.role_id = this.modelManager.role_id.trim();
            //     this.modelManager.email = this.modelManager.email.trim();
            //     this.modelManager.login = this.modelManager.login.trim();
            //     this.modelManager.CPF = this.modelManager.CPF.trim();
            //     this.modelManager.phone = this.modelManager.phone.trim();
            //     this.modelManager.image_path = this.modelManager.image_path.trim();
            //     this.modelManager.whatsapp_id = this.modelManager.whatsapp_id.trim();
            //     this.modelManager.facebook_id = this.modelManager.facebook_id.trim();
            //     this.modelManager.instagram_id = this.modelManager.instagram_id.trim();
            //     this.modelManager.linkedin_id = this.modelManager.linkedin_id.trim();
            // },

            // validateData:function(){
                
            //     var flagReference = true;
            //     var check;
            //     var temp = {"success":true };

            //     // Validação dos campos da empresa
            //     check = (this.modelCompany.CNPJ!='')? validation.check('cnpj', this.modelCompany.CNPJ):temp=true;
            //     if(check.success==false){
            //         miniToastr.error(" ", check.error );
            //         flagReference = false;   
            //     } 
            //     check = (this.modelCompany.name!='')? validation.check('complete_name', this.modelCompany.name):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false;   
            //     } 
            //     check = (this.modelCompany.phone!='')?  validation.check('phone', this.modelCompany.phone):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false;  
            //     } 
            //     check = (this.modelCompany.email!='')?  validation.check('email', this.modelCompany.email):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false;   
            //     } 
            //     check = (this.modelCompany.whatsapp!='')?  validation.check('phone', this.modelCompany.whatsapp):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }

            //     // Validação dos campos do canal de comunicação
            //     check = (this.modelRpi.api_user!='')?  validation.check('user', this.modelRpi.api_user):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.api_password!='')?  validation.check('password', this.modelRpi.api_password):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.root_user!='')?  validation.check('user', this.modelRpi.root_user):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.root_password!='')?  validation.check('password', this.modelRpi.root_password):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.tcp_tunnel!='')?  validation.check('tcp_tunnel', this.modelRpi.tcp_tunnel):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.tcp_port!='')?  validation.check('tcp_port', this.modelRpi.tcp_port):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.mac!='')?  validation.check('mac', this.modelRpi.mac):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.api_tunnel!='')?  validation.check('tunnel', this.modelRpi.api_tunnel):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelRpi.soft_version!='')?  validation.check('version', this.modelRpi.soft_version):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check =  (this.modelRpi.soft_version_date!='')? validation.check('date', this.modelRpi.soft_version_date):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }

            //     // Validação dos campos do manager
            //     check = (this.modelManager.name!='')?  validation.check('complete_name', this.modelManager.name):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelManager.email!='')? validation.check('email', this.modelManager.email):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelManager.CPF!='')? validation.check('cpf', this.modelManager.CPF):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
            //     check = (this.modelManager.phone!='')? validation.check('phone', this.modelManager.phone):temp=true;
            //     if(check.success==false){
            //         miniToastr.error("Erro", check.error );
            //         flagReference = false; 
            //     }
                
            //     if (flagReference == false){
            //         miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
            //         return;
            //     }
            // },
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
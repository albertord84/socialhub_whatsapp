<template>
    <div>
        <form-wizard    color="#20a0ff" 
                        title='' 
                        subtitle='' 
                        nextButtonText='Seguinte' 
                        finishButtonText:=Finalizar 
                        stepSize='lg'
                        style="min-height:500px"
                    >
            <tab-content title="Dados da empresa" icon='fa fa-building-o' >
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelCompany.CNPJ" name="CNPJ" id="CNPJ" type="text" required placeholder="CNPJ" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-building-o form-control-feedback"></span>
                            <input v-model="modelCompany.name" id="nameCompany" name="nameCompany" type="text" required placeholder="Nome da empresa (*)" class="form-control"/>
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelCompany.phone" name="phoneCompany" id="phoneCompany" type="text" required placeholder="Telefone (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelCompany.email" id="emailCompany" name="emailCompany" type="email" required placeholder="Email" class="form-control"/>                            
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="modelCompany.whatsapp" name="whatsappCompany" id="whatsappCompany" type="text" required placeholder="whatsapp (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelCompany.ngrok_url" id="ngrok_url" name="ngrok_url" type="text" required placeholder="URL" class="form-control"/>                            
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group has-search">
                            <textarea v-model="modelCompany.description" style="width:100%" name="description" id="description" rows="4" placeholder="Descrição"></textarea>
                        </div>                                                                         
                    </div>
            </tab-content>
            <tab-content title="Dados do manager" icon='fa fa-user-o' >
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="modelManager.name" id="nameManager" name="nameManager" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelManager.email" name="emailManager" id="emailManager" type="text" required placeholder="Email" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelManager.CPF" name="CPF" id="CPF" type="text" required placeholder="CPF (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelManager.phone" id="phoneManager" name="phoneManager" type="text" required placeholder="Telefone (*)" class="form-control"/>
                        </div>
                    </div>  
            </tab-content>
            <tab-content title="Dados do Raspberry" icon='fa fa-hdd-o' >
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="modelManager.name" id="name" name="name" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelManager.email" name="email" id="email" type="text" required placeholder="Email" class="form-control"/>
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
            </tab-content>
            <tab-content title="Fim do cadastro" icon='fa fa-smile-o'>
                <div class="mt-5 mb-5 pt-5 pb-5 text-center">
                    <h5 v-if="action=='insert'">Empresa cadastrada com sucesso</h5> 
                    <h5 v-if="action=='edit'">Empresa atualizada com sucesso</h5> 
                </div>
            </tab-content>
             <!-- <div class="wizard-footer-left">
                <wizard-button  v-if="props.activeTabIndex > 0 && !props.isLastStep" @click.native="props.prevTab()" :style="props.fillButtonStyle">Previous</wizard-button>
            </div>
            <div class="wizard-footer-right">
                <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="wizard-footer-right" :style="props.fillButtonStyle">Next</wizard-button>
                <wizard-button v-else @click.native="alert('Done')" class="wizard-footer-right finish-button" :style="props.fillButtonStyle">  {{props.isLastStep ? 'Done' : 'Next'}}</wizard-button>
            </div> -->
        </form-wizard>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../../common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    
    export default {
        name: 'sellersCRUDCompanies',

        props: {
            companies_url:'',
            users_url:'',
            usersManager_url:'',
            action: "",
            model_company:{},
            model_manager:{},
        },

        components:{
            FormWizard,
            TabContent
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
            addCompany:function(){
                console.log(addCompany);
                return true;
            },

            addManager:function(){
                console.log(addManager);
            },

            addRPI:function(){
                console.log(addRPI);
            },


            addCompanyOld: function() { //C
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
                this.modelManager.image_path= "";
                this.modelManager.whatsapp_id= "";
                this.modelManager.facebook_id= "";
                this.modelManager.instagram_id= "";
                this.modelManager.linkedin_id="";
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
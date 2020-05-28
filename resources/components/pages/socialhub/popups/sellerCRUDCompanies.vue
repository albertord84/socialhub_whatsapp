<template>
    <div>
        <b-container fluid>                
            <form v-show="action!='delete'"> 
                <div>
                    <h3>Dados da empresa</h3>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelCompany.CNPJ" v-mask="'##.###.###/####-##'" title="Ex: 00.000.000/0001-00" name="CNPJ" id="CNPJ" type="text" required placeholder="CNPJ (*)" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-building-o form-control-feedback"></span>
                            <input v-model="modelCompany.name" title="Ex: Nome da Empresa" id="nameCompany" name="nameCompany" type="text" required placeholder="Nome da empresa (*)" class="form-control"/>
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelCompany.phone" v-mask="'###############'" title="Ex: 551188888888" name="phoneCompany" id="phoneCompany" type="text" required placeholder="Telefone fixo" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelCompany.email" title="Ex: company@gmail.com" id="emailCompany" name="emailCompany" type="emailCompany" required placeholder="Email empresarial (*)" class="form-control"/>                            
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="modelCompany.whatsapp" v-mask="'###############'" title="Ex: 5511988888888" name="whatsappCompany" id="whatsappCompany" type="text" required placeholder="Whatsapp (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-info-circle fa-lg form-control-feedback" ></span>
                            <input v-if='action=="insert"' v-model="modelCompany.amount_attendants"  disabled="" name="amount_attendants" id="amount_attendants" type="text" required placeholder="Atendentes permitidos: 3" class="form-control"/>
                            <input v-if='action=="edit"' v-model="modelCompany.amount_attendants"  v-mask="'####'" name="amount_attendants" id="amount_attendants" type="text" required placeholder="Atendentes permitidos" class="form-control"/>
                        </div>
                    </div>


                    <!-- <h6>Endereço postal </h6>
                    <div class="row">
                        <div class="col-lg-4" >
                            <div class="input-group">
                                    <input v-model="modelCompany.CEP" v-mask="'#####-###'" title="Ex: 00000-000" name="CEP" id="CEP" type="text" required placeholder="CEP (*)" class="form-control"/>                                <div class="input-group-append">
                                    <div class="input-group-text hover-pointer" id="btnGroupAddon"  @click.prevent="getAddressByCEP">
                                        <i v-if="isSendingValidationCEP==false" class="fa fa-search" aria-hidden="true"></i>
                                        <i v-else class="fa fa-spinner fa-spin" style="color:blue" ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  class="col-lg-4 form-group has-search">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            <input v-model="modelCompany.cidade" title="Ex: Niterói" id="cidade" name="cidade" type="text" required placeholder="Cidade (*)"  class="form-control"/>                            
                        </div>                                                      
                        <div  class="col-lg-4 form-group has-search">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            <input v-model="modelCompany.estado" title="Ex: RJ" v-mask="'AA'" id="estado" name="estado" type="text" required placeholder="Estado Federal (*)"  class="form-control"/>                            
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-lg-8 form-group has-search">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            <input v-model="modelCompany.rua" title="Ex: São João" name="rua" id="rua" type="text" required placeholder="Rua/Avenida (*)"  class="form-control"/>
                        </div>
                        <div  class="col-lg-4 form-group has-search">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            <input v-model="modelCompany.numero" title="Ex: 000" id="numero" name="numero" type="text" required placeholder="Número (*)" class="form-control"/>                            
                        </div>                                                                               
                    </div>

                    <div class="row">
                        <div  class="col-lg-8 form-group has-search">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            <input v-model="modelCompany.complemento" title="Ex: Casa 00 / Bloco 00, Apto 00" id="complemento" name="complemento" type="text" required placeholder="Complemento" class="form-control"/>
                        </div> 
                        <div class="col-lg-4 form-group has-search">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            <input v-model="modelCompany.bairro" title="Ex: Centro" name="bairro" id="bairro" type="text" required placeholder="Bairro (*)" class="form-control"/>
                        </div>
                    </div> -->

                    <h6>Descrição da empresa</h6>
                    <div class="row">
                        <div class="col-lg-12 form-group has-search">
                            <textarea v-model="modelCompany.description" title="Ex: Describe informaçẽs relevantes da empresa" style="width:100%" name="description" id="description" rows="4" placeholder="Descrição"></textarea>
                        </div>                                                                         
                    </div>

                </div>
                <hr>

                <div>
                    <h3>Dados do manager da empresa</h3>
                    <div class="row">
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="modelManager.name" title="Ex: Nome do Manager" id="nameManager" name="nameManager" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="modelManager.email" title="Ex: manager@gmail.com" name="emailManager" id="emailManager" type="text" required placeholder="Email do manager. Para fazer Loging (*)" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelManager.CPF" v-mask="'###.###.###-##'" title="Ex: 000.000.008-00" name="CPF" id="CPF" type="text" required placeholder="CPF (*)" class="form-control"/>
                        </div> -->
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="modelManager.whatsapp_id" v-mask="'###############'" title="Ex: 5511988888888" name="whatsappManager" id="whatsappManager" type="text" required placeholder="Whatsapp (*)" class="form-control"/>
                        </div>
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="modelManager.phone" v-mask="'###############'" title="Ex: 551188888888" id="phoneManager" name="phoneManager" type="text" required placeholder="Telefone fixo" class="form-control"/>
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
                            <input v-model="modelRpi.api_password" title="Ex: g5Y6e4o" id="api_password" name="api_password" type="password" required placeholder="Senha do usuario da API" class="form-control"/>
                        </div>                                                      
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-id-card form-control-feedback"></span>
                            <input v-model="modelRpi.root_user" title="Ex: Nome da Empresa" name="root_user" id="root_user" type="text" required placeholder="Usuario Root" class="form-control"/>
                        </div>
                        <div  class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="modelRpi.root_password" title="Ex: g5Y6e4o" id="root_password" name="root_password" type="password" required placeholder="Senha do usuario Root" class="form-control"/>
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
                        <!-- <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-link form-control-feedback"></span>
                            <input v-model="modelRpi.mac" v-mask="'NN:NN:NN:NN:NN:NN'" title="Ex: b8:27:eb:76:21:41" name="mac" id="mac" type="text" required placeholder="Endereço MAC (*)" class="form-control"/>
                        </div> -->
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
                            <input v-model="modelRpi.soft_version_date" v-mask="'##/##/####'" title="Ex: dd/mm/aaaa" id="soft_version_date" name="soft_version_date" type="text" required placeholder="Data da Versão do Software" class="form-control"/>                            
                        </div>                                                      
                    </div>

                </div>
                                               
                <div class="col-lg-12 m-t-25 text-center">
                    <button v-show='action=="insert"' type="submit" id="btnInsert" name="btnInsert" class="btn btn-primary btn_width" :disabled="isSendingInsert==true" @click.prevent="addCompany">
                        <i v-show="isSendingInsert==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Adicionar
                    </button>

                    <button v-show='action=="edit"' type="submit" id="btnEdit" name="btnEdit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateCompany">
                        <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                    </button>

                    <button type="reset" id="btnCancel" name="btnCancel" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>

            <form v-show="action=='delete'">
                Tem certeza que deseja cancelar o contrato dessa Empresa?
                <div class="col-lg-12 mt-5 text-center">
                    <button type="submit" id="btnDelete" name="btnDelete" class="btn btn-primary btn_width" :disabled="isSendingDelete==true" @click.prevent="deleteCompany">
                        <i v-show="isSendingDelete==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Eliminar
                    </button>
                    <button type="reset" id="btnCancel" name="btnCancel" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
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
        name: 'sellersCRUDCompanies',

        props: {
                // contact_url:'contacts',
                // attendant_url:'usersAttendants',
                // attendantsContacts_url:'attendantsContacts',
            
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
                modelCompany:{  //dados da empresa
                    CNPJ: "",
                    name: "",
                    phone: "",
                    email: "",
                    whatsapp: "",
                    description: "",
                    CEP: "",
                    cidade: "",
                    estado: "",
                    rua: "",
                    numero: "",
                    complemento: "",
                    bairro: "",
                    amount_attendants: "",
                },

                modelRpi:{      //dados do canal de comunicação
                    api_user: "",
                    api_password: "",
                    root_user: "",
                    root_password: "",
                    tcp_tunnel: "",
                    tcp_port: "",
                    // mac: "",
                    api_tunnel: "",
                    soft_version: "",
                    soft_version_date: "",
                },

                modelManager:{  //manager da empresa
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

                userLogged:{},
                isSendingInsert: false,
                isSendingUpdate: false,
                isSendingDelete: false,
                isSendingValidationCEP: false,
                flagReference: true,
            }
        },

        methods:{
            addCompany: function() { //C
                this.modelCompany.id=0;
                this.modelCompany.user_seller_id=this.userLogged.id;
                this.modelCompany.amount_attendants=3;
                this.modelManager.id=0;
                this.modelManager.role_id=3;
                this.modelManager.image_path = "images/user.jpg";
                this.isSendingInsert = true;

                // Validando dados
                this.trimDataModels();
                this.validateDataModelCompany();
                this.validateDataModelManager();
                if (this.flagReference == false){
                    miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                    this.isSendingInsert = false;
                    this.flagReference = true;
                    return;
                }

                var modelCompany_cpy = Object.assign({}, this.modelCompany);                    //ECR
                modelCompany_cpy.whatsapp = modelCompany_cpy.whatsapp.replace(/ /g, '');        //ECR
                modelCompany_cpy.whatsapp = modelCompany_cpy.whatsapp.replace(/-/i, '');        //ECR
                if(modelCompany_cpy.phone){
                    modelCompany_cpy.phone = modelCompany_cpy.phone.replace(/ /g, '');          //ECR
                    modelCompany_cpy.phone = modelCompany_cpy.phone.replace(/-/i, '');          //ECR
                }

                var modelManager_cpy = Object.assign({}, this.modelManager);                    //ECR
                modelManager_cpy.whatsapp_id = modelManager_cpy.whatsapp_id.replace(/ /g, '');  //ECR
                modelManager_cpy.whatsapp_id = modelManager_cpy.whatsapp_id.replace(/-/i, '');  //ECR
                if(modelManager_cpy.phone){
                    modelManager_cpy.phone = modelManager_cpy.phone.replace(/ /g, '');          //ECR
                    modelManager_cpy.phone = modelManager_cpy.phone.replace(/-/i, '');          //ECR
                }

                // inserindo company
                ApiService.post(this.companies_url, modelCompany_cpy)           //ECR
                    .then(response => {
                        modelManager_cpy.company_id = response.data.id;         //ECR
                        // inserindo user
                        ApiService.post(this.users_url, modelManager_cpy)       //ECR
                            .then(response => {
                                    //inserindo userManager
                                    ApiService.post(this.usersManager_url, {'user_id':response.data.id})
                                        .then(response => {
                                            miniToastr.success("Empresa adicionada com sucesso","Sucesso");
                                            this.formReset();
                                            this.reload();
                                            this.closeModals();
                                        })
                                        .catch(error => {
                                            this.processMessageError(error, this.usersManager_url, "add");
                                        })
                                        .finally(() => this.isSendingInsert = false);
                            })
                            .catch(error => {
                                ApiService.delete(this.companies_url+'/'+modelManager_cpy.company_id)
                                    .then(response => {
                                    })
                                    .catch(error => {
                                    })
                                this.processMessageError(error, this.users_url, "add");
                                this.isSendingInsert = false;
                            });
                    })
                    .catch(error => {
                        this.processMessageError(error, this.companies_url, "add");
                        this.isSendingInsert = false; 
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
                
                // Validando dados
                this.trimDataModels();
                this.validateDataModelCompany();
                this.validateDataModelManager();
                this.validateDataModelRpi();
                if (this.flagReference == false){
                    miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                    this.isSendingUpdate = false;
                    this.flagReference = true;
                    return;
                }

                var modelCompany_cpy = Object.assign({}, this.modelCompany);                    //ECR
                modelCompany_cpy.whatsapp = modelCompany_cpy.whatsapp.replace(/ /g, '');        //ECR
                modelCompany_cpy.whatsapp = modelCompany_cpy.whatsapp.replace(/-/i, '');        //ECR
                if(modelCompany_cpy.phone){
                    modelCompany_cpy.phone = modelCompany_cpy.phone.replace(/ /g, '');          //ECR
                    modelCompany_cpy.phone = modelCompany_cpy.phone.replace(/-/i, '');          //ECR
                }
                
                var modelManager_cpy = Object.assign({}, this.modelManager);                    //ECR
                modelManager_cpy.whatsapp_id = modelManager_cpy.whatsapp_id.replace(/ /g, '');  //ECR
                modelManager_cpy.whatsapp_id = modelManager_cpy.whatsapp_id.replace(/-/i, '');  //ECR
                if(modelManager_cpy.phone){
                    modelManager_cpy.phone = modelManager_cpy.phone.replace(/ /g, '');          //ECR
                    modelManager_cpy.phone = modelManager_cpy.phone.replace(/-/i, '');          //ECR
                }
                //1. atualizando company
                ApiService.put(this.companies_url+'/'+this.modelCompany.id, modelCompany_cpy)   //ECR
                    .then(response => {
                        //2. atualizando usuario
                        delete modelManager_cpy.password;
                        ApiService.put(this.users_url+'/'+this.modelManager.id, modelManager_cpy)   //ECR
                            .then(response => {
                                miniToastr.success('Dados atualizados corretamente', "Sucesso"); 
                                this.reload();
                                this.closeModals();

                                    // 3. atualizando ou criando o rpi (sem MAC agora)
                                    this.modelRpi.company_id = this.modelCompany.id;
                                    if(!this.modelRpi.id) {
                                        this.modelRpi.id=0;
                                    }
                                    var This=this;
                                    ApiService.put(this.rpi_url+'/'+this.modelRpi.id, {
                                            'rpi': this.modelRpi,
                                            'company_id': this.modelCompany.id
                                        })
                                        .then(response => {
                                                miniToastr.success('Dados atualizados corretamente', "Sucesso"); 
                                                this.reload();
                                                this.closeModals();
                                            })
                                        .catch(error => {
                                            
                                        })
                                        .finally(() => this.isSendingUpdate = false);
                            })
                            .catch(error => {
                                this.processMessageError(error, this.users_url, "update");
                                this.isSendingUpdate = false;
                            });
                    })
                    .catch(error => {
                        this.processMessageError(error, this.companies_url, "update");
                        this.isSendingUpdate = false; 
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
                                        // if(this.modelCompany.rpi_id){
                                        //     ApiService.delete(this.rpi_url+'/'+this.modelRpi.id)
                                        //         .then(response => {
                                                    miniToastr.success("Empresa eliminada com sucesso","Sucesso");
                                                    this.reload();
                                                    this.closeModals();
                                        //         })
                                        //         .catch(error => {
                                                    // this.processMessageError(error, this.rpi_url, "delete");
                                        //         });
                                        // }else{
                                        //     miniToastr.success("Empresa eliminada com sucesso","Sucesso");
                                        //     this.reload();
                                        //     this.closeModals();
                                        // }
                                    })
                                    .catch(error => {
                                        this.processMessageError(error,this.companies_url, "delete");
                                    })
                                    .finally(() => this.isSendingDelete = false);
                            })
                            .catch(error => {
                                this.processMessageError(error, this.users_url, "delete");
                                this.isSendingDelete = false;
                            });
                    })
                    .catch(error => {
                        this.processMessageError(error, this.usersManager_url, "delete");
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

            getAddressByCEP: function(){
                this.isSendingValidationCEP = true;
                // Validando CEP inserido
                if(!this.modelCompany.CEP){
                    miniToastr.error("Erro", "O CEP da empresa é obrigatório" );
                    this.isSendingValidationCEP = false;
                    return;
                }
                this.modelCompany.CEP = this.modelCompany.CEP.trim();
                this.modelCompany.CEP = this.modelCompany.CEP.replace(/-/i, '');
                if(this.modelCompany.CEP !=''){
                    var check = validation.check('cep', this.modelCompany.CEP)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.isSendingValidationCEP = false;
                        return;
                    }
                }else{
                    miniToastr.error("Erro", "O CEP da empresa é obrigatório" );
                    this.isSendingValidationCEP = false;
                    return;
                }

                ApiService.get('cep/'+this.modelCompany.CEP)
                    .then(response => {
                        if(response.data.erro && response.data.erro==true ){
                            miniToastr.warn("Confira os dados fornecidos", "O CEP inserido não existe");
                            return;
                        }
                        this.modelCompany.CEP = response.data.cep;
                        this.modelCompany.estado = response.data.uf;
                        this.modelCompany.cidade = response.data.localidade;
                        this.modelCompany.bairro = response.data.bairro;
                        this.modelCompany.rua = response.data.logradouro;
                    })
                    .catch(error => {
                        this.processMessageError(error, "cep", "get");
                    })
                    .finally(() => {
                        Vue.axios.defaults.baseURL = "";
                        this.isSendingValidationCEP = false;
                    });
            },

            trimDataModels: function(){
                if(this.modelCompany.CNPJ) this.modelCompany.CNPJ = this.modelCompany.CNPJ.trim();
                if(this.modelCompany.name) this.modelCompany.name = this.modelCompany.name.trim();
                if(this.modelCompany.phone) this.modelCompany.phone = this.modelCompany.phone.trim();
                if(this.modelCompany.email) this.modelCompany.email = this.modelCompany.email.trim();
                if(this.modelCompany.whatsapp) this.modelCompany.whatsapp = this.modelCompany.whatsapp.trim();
                if(this.modelCompany.CEP) this.modelCompany.CEP = this.modelCompany.CEP.trim();
                if(this.modelCompany.cidade) this.modelCompany.cidade = this.modelCompany.cidade.trim();
                if(this.modelCompany.estado) this.modelCompany.estado = this.modelCompany.estado.trim();
                if(this.modelCompany.rua) this.modelCompany.rua = this.modelCompany.rua.trim();
                if(this.modelCompany.numero) this.modelCompany.numero = this.modelCompany.numero.trim();
                if(this.modelCompany.complemento) this.modelCompany.complemento = this.modelCompany.complemento.trim();
                if(this.modelCompany.bairro) this.modelCompany.bairro = this.modelCompany.bairro.trim();
                if(this.modelCompany.description) this.modelCompany.description = this.modelCompany.description.trim();

                if(this.modelManager.name) this.modelManager.name = this.modelManager.name.trim();
                if(this.modelManager.email) this.modelManager.email = this.modelManager.email.trim();
                if(this.modelManager.login) this.modelManager.login = this.modelManager.login.trim();
                if(this.modelManager.CPF) this.modelManager.CPF = this.modelManager.CPF.trim();
                if(this.modelManager.phone) this.modelManager.phone = this.modelManager.phone.trim();
                if(this.modelManager.image_path) this.modelManager.image_path = this.modelManager.image_path.trim();
                if(this.modelManager.whatsapp_id) this.modelManager.whatsapp_id = this.modelManager.whatsapp_id.trim();
                if(this.modelManager.facebook_id) this.modelManager.facebook_id = this.modelManager.facebook_id.trim();
                if(this.modelManager.instagram_id) this.modelManager.instagram_id = this.modelManager.instagram_id.trim();
                if(this.modelManager.linkedin_id) this.modelManager.linkedin_id = this.modelManager.linkedin_id.trim();

                if(this.modelRpi.api_user) this.modelRpi.api_user = this.modelRpi.api_user.trim();
                if(this.modelRpi.api_user) this.modelRpi.api_password = this.modelRpi.api_password.trim();
                if(this.modelRpi.root_user) this.modelRpi.root_user = this.modelRpi.root_user.trim();
                if(this.modelRpi.root_password) this.modelRpi.root_password = this.modelRpi.root_password.trim();
                // if(this.modelRpi.tcp_tunnel) this.modelRpi.tcp_tunnel = this.modelRpi.tcp_tunnel.trim();
                // if(this.modelRpi.tcp_port) this.modelRpi.tcp_port = this.modelRpi.tcp_port.trim();
                if(this.modelRpi.mac) this.modelRpi.mac = this.modelRpi.mac.trim();
                // if(this.modelRpi.api_tunnel) this.modelRpi.api_tunnel = this.modelRpi.api_tunnel.trim();
                // if(this.modelRpi.soft_version) this.modelRpi.soft_version = this.modelRpi.soft_version.trim();
                // if(this.modelRpi.soft_version_date) this.modelRpi.soft_version_date = this.modelRpi.soft_version_date.trim();  
            },

            validateDataModelCompany:function(){
                // Validação dos dados da empresa
                var check;
                if(this.modelCompany.CNPJ && this.modelCompany.CNPJ !=''){
                    check = validation.check('cnpj', this.modelCompany.CNPJ)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O CNPJ é obrigatório" );
                    this.flagReference = false;
                }

                if(this.modelCompany.name && this.modelCompany.name !=''){
                    check = validation.check('complete_name', this.modelCompany.name)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O nome da empresa é obrigatório" );
                    this.flagReference = false;
                }

                if(this.modelCompany.phone && this.modelCompany.phone !=''){
                    check = validation.check('phone', this.modelCompany.phone)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }

                if(this.modelCompany.email && this.modelCompany.email !=''){
                    check = validation.check('email', this.modelCompany.email)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O e-mail da empresa é obrigatório" );
                    this.flagReference = false;
                }

                if(this.modelCompany.whatsapp && this.modelCompany.whatsapp !=''){
                    check = validation.check('whatsapp', this.modelCompany.whatsapp)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O whatsapp da empresa é obrigatório" );
                    this.flagReference = false;
                }

                // if(this.modelCompany.CEP && this.modelCompany.CEP !=''){
                //     check = validation.check('cep', this.modelCompany.CEP)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "O CEP da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

                // if(this.modelCompany.numero && this.modelCompany.numero !=''){
                //     check = validation.check('house_number', this.modelCompany.numero)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "O número no endereço da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

                // if(this.modelCompany.complemento && this.modelCompany.complemento !=''){
                //     check = validation.check('complement_address', this.modelCompany.complemento)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }

                // if(this.modelCompany.estado && this.modelCompany.estado !=''){
                //     check = validation.check('state_address', this.modelCompany.estado)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "O estado no endereço da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

                // if(this.modelCompany.bairro && this.modelCompany.bairro !=''){
                //     check = validation.check('neighborhood_address', this.modelCompany.bairro)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "O bairro no endereço da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

                // if(this.modelCompany.cidade && this.modelCompany.cidade !=''){
                //     check = validation.check('municipality_address', this.modelCompany.cidade)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "A cidade no endereço da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

                // if(this.modelCompany.rua && this.modelCompany.rua !=''){
                //     check = validation.check('street_address', this.modelCompany.rua)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "A rua no endereço da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

            },

            validateDataModelManager: function(){
                // Validação dos dados do manager
                var check;

                if(this.modelManager.name && this.modelManager.name !=''){
                    check = validation.check('complete_name', this.modelManager.name)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O nome do manager da empresa é obrigatório" );
                    this.flagReference = false;
                }
                if(this.modelManager.email && this.modelManager.email !=''){
                    check = validation.check('email', this.modelManager.email)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O e-mail do manager da empresa é obrigatório" );
                    this.flagReference = false;
                }

                // if(this.modelManager.CPF && this.modelManager.CPF !=''){
                //     check = validation.validate_cpf('cpf', this.modelManager.CPF)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "O CPF do manager da empresa é obrigatório" );
                //     this.flagReference = false;
                // }

                if(this.modelManager.phone && this.modelManager.phone !=''){
                    check = validation.check('phone', this.modelManager.phone)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }

                if(this.modelManager.whatsapp_id && this.modelManager.whatsapp_id !=''){
                    check = validation.check('whatsapp', this.modelManager.whatsapp_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O whatsapp do manager da empresa é obrigatório" );
                    this.flagReference = false;
                }
            },

            // ECR: não se vai utilizar por enquanto
            validateDataModelRpi: function(){
                // Validação dos campos do canal de comunicação
                var check;
                
                // if(this.modelRpi.api_user && this.modelRpi.api_user!=''){
                //     check = validation.check('user', this.modelRpi.api_user);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }

                // if(this.modelRpi.api_password && this.modelRpi.api_password!=''){
                //     check = validation.check('password', this.modelRpi.api_password);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }

                // if(this.modelRpi.root_user && this.modelRpi.root_user!=''){
                //     check = validation.check('user', this.modelRpi.root_user);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }

                // if(this.modelRpi.root_password && this.modelRpi.root_password!=''){
                //     check = validation.check('password', this.modelRpi.root_password);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }

                // if(this.modelRpi.tcp_tunnel && this.modelRpi.tcp_tunnel!=''){
                //     check = validation.check('tcp_tunnel', this.modelRpi.tcp_tunnel);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }

                // if(this.modelRpi.tcp_port && this.modelRpi.tcp_port!=''){
                //     check = validation.check('tcp_port', this.modelRpi.tcp_port);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }
                
                if(this.modelRpi.mac && this.modelRpi.mac !=''){
                    check = validation.check('mac', this.modelRpi.mac)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }

                // if(this.modelRpi.api_tunnel && this.modelRpi.api_tunnel !=''){
                //     check = validation.check('tunnel', this.modelRpi.api_tunnel)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }else{
                //     miniToastr.error("Erro", "O Tunel da API é obrigatório" );
                //     this.flagReference = false;
                // }

                // if(this.modelRpi.soft_version && this.modelRpi.soft_version !=''){
                //     check = validation.check('version', this.modelRpi.soft_version)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }

                // if(this.modelRpi.soft_version_date && this.modelRpi.soft_version_date!=''){
                //     check =  validation.check('date', this.modelRpi.soft_version_date);
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false; 
                //     }
                // }
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
            },
        },

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
        },
        mounted(){
            if(this.userLogged.role_id > 2){
                this.$router.push({name: "login"});
            }
            
            if(this.action!='insert')
                this.editCompany();
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

    .hover-pointer:hover{
        cursor: pointer;
    }
</style>
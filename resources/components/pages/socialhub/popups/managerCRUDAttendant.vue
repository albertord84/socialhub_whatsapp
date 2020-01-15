<template>
    <div>
        <b-container fluid>                
            <form v-show="action!='delete'">                                        
                <div class="row">
                    {{model.user_id}}
                </div>    
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-user form-control-feedback"></span>
                        <input v-model="model.login" title="Ex: Login do Atendente" name="login" id="login" type="text" required placeholder="Login (*)" class="form-control"/>
                    </div>
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-envelope form-control-feedback"></span>
                        <input v-model="model.email" title="Ex: atendente@gmail.com" id="email" name="email" type="email" required placeholder="Email (*)" class="form-control"/>                            
                    </div>                                                      
                </div>
                <div class="row">
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-user form-control-feedback"></span>
                        <input v-model="model.name" title="Ex: Nome do Atendente" id="name" name="name" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                    </div>
                    <div class="col-lg-3 form-group has-search">
                        <span class="fa fa-id-card form-control-feedback"></span>
                        <input v-model="model.CPF" v-mask="'###.###.###-##'" title="Ex: 000.000.008-00" name="CPF" id="CPF" type="text" required placeholder="CPF (*)" class="form-control"/>
                    </div>
                    <div class="col-lg-3 form-group has-search">
                        <span class="fa fa-phone form-control-feedback"></span>
                        <input v-model="model.phone" v-mask="'55 ## ####-####'" title="Ex: 55 11 8888-8888" id="phone" name="phone" type="text" required placeholder="Telefone fixo" class="form-control"/>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-whatsapp form-control-feedback"></span>
                        <input v-model="model.whatsapp_id" v-mask="'55 ## #####-####'" title="Ex: 55 11 98888-8888" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                    </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-facebook form-control-feedback"></span>
                        <input v-model="model.facebook_id" title="Ex: facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-instagram form-control-feedback"></span>
                            <input v-model="model.instagram_id" title="Ex: instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                        </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-linkedin form-control-feedback"></span>
                        <input v-model="model.linkedin_id" title="Ex: linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                    </div>
                </div>
                <div v-if="action=='edit'" class="row">
                    <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="model.password" title="Inserir a nova senha" type="password" placeholder="Senha" class="form-control"/>
                        </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-key form-control-feedback"></span>
                        <input v-model="model.repeat_password" title="Repetir a nova senha" type="password" placeholder="Repetir senha" class="form-control"/>
                    </div>
                </div>
                <div class="col-lg-12 m-t-25 text-center">
                    <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingInsert==true" @click.prevent="addAttendant">
                        <i v-show="isSendingInsert==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Adicionar
                    </button>

                    <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateAttendant">
                        <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                    </button>

                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>
            <form v-show="action=='delete'">
                Tem certeza que deseja remover esse Atendente?
                <div class="col-lg-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary btn_width" :disabled="isSendingDelete==true" @click.prevent="deleteAttendant">
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
    import validation from "src/common/validation.service";
    
    export default {
        name: 'managerCRUDAttendant',

        props: {
            attendant_contact_url: '', // attendantsContacts controller url 
            first_url:'', //user controller url 
            url:'', //userAttendant controller url 
            action: "",
            item:{},
        },

        components:{
        },

        data(){
            return{
                attendant_id: "",
                model:{
                    name: "",
                    role_id: "",
                    company_id:0,
                    email: "",
                    login: "",
                    password:'',
                    CPF: "",
                    phone: "",
                    image_path: "",
                    whatsapp_id: "",
                    facebook_id: "",
                    instagram_id: "",
                    linkedin_id: "",
                    password: "",
                    repeat_password: "",
                },
                
                isSendingInsert: false,
                isSendingUpdate: false,
                isSendingDelete: false,

                flagReference: true,

            }
        },

        methods:{
            addAttendant: function() { //C
                this.model.id=8;
                this.model.role_id=4;
                this.model.password='';
                this.model.image_path = "images/user.jpg";
                this.model.company_id = this.logguedAttendant.company_id;
                this.isSendingInsert = true;

                // Validando dados
                this.trimDataModel();
                this.validateData();
                if (this.flagReference == false){
                    miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                    this.isSendingInsert = false;
                    this.flagReference = true;
                    return;
                }

                var model_cpy = Object.assign({}, this.model);                      //ECR: Para eliminar espaços e traços
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/ /g, '');    //ECR
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/-/i, '');    //ECR
                if(model_cpy.phone){
                    model_cpy.phone = model_cpy.phone.replace(/ /g, '');    //ECR
                    model_cpy.phone = model_cpy.phone.replace(/-/i, '');    //ECR
                }

                //isert user
                ApiService.post(this.first_url, model_cpy)
                .then(response => {
                    //isert userAttendant
                    ApiService.post(this.url, { 
                        'user_id':response.data.id,
                        'user_manager_id':JSON.parse(localStorage.user).id
                        })
                        .then(response => {
                            miniToastr.success("Atendente adicionado com sucesso","Sucesso");
                            this.formReset();
                            this.reload();
                            this.closeModals();
                        })
                    .catch(function(error) {
                        ApiService.process_request_error(error); 
                        miniToastr.error(error, "Erro adicionando Atendente");  
                    })
                    .finally(() => this.isSendingInsert = false);
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando usuáio");  
                });
            },
            
            editAttendant: function() { //U
                this.attendant_id = this.item.id;
                this.model = Object.assign({}, this.item);
                this.model.password = this.model.repeat_password = '';
                this.closeModals();
            },

            updateAttendant: function() { //U
                
                if(this.model.password.trim()!='' && this.model.password!=this.model.repeat_password){
                        miniToastr.error('Erro', "As senha não coincidem"); return;
                }
                
                this.isSendingUpdate = true;

                // Validando dados
                this.trimDataModel();
                this.validateData();
                if (this.flagReference == false){
                    miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                    this.isSendingUpdate = false;
                    this.flagReference = true;
                    return;
                }

                
                var model_cpy = JSON.parse(JSON.stringify(this.model));
                delete model_cpy.created_at;
                delete model_cpy.updated_at;
                delete model_cpy.deleted_at;
                if(this.model.password.trim()==''){
                    delete model_cpy.password;
                    delete model_cpy.repeat_password;
                }

                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/ /g, '');    //ECR
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/-/i, '');    //ECR
                if(model_cpy.phone){
                    model_cpy.phone = model_cpy.phone.replace(/ /g, '');                //ECR
                    model_cpy.phone = model_cpy.phone.replace(/-/i, '');                //ECR
                }
                ApiService.put(this.first_url+'/'+this.attendant_id, model_cpy)
                    .then(response => {
                        miniToastr.success("Atendente atualizado com sucesso","Sucesso");
                            this.reload();
                            this.closeModals();
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error);  
                        miniToastr.error(error, "Erro atualizando Atendente"); 
                    })
                    .finally(() => this.isSendingUpdate = false);
            },

            deleteAttendant: function(){
                this.isSendingDelete = true;
                ApiService.delete('deleteAllByAttendantId/'+this.item.id)
                    .then(response => {
                        ApiService.delete(this.url+'/'+this.item.id)
                            .then(response => {                                
                                ApiService.delete(this.first_url+'/'+this.item.id)
                                    .then(response => {
                                        miniToastr.success("Atendente eliminado com sucesso","Sucesso");
                                        this.reload();
                                        this.closeModals();
                                    })
                                    .catch(function(error) {
                                        ApiService.process_request_error(error);  
                                        miniToastr.error(error, "Erro eliminando Atendente"); 
                                    });
                            })
                            .catch(function(error) {
                                ApiService.process_request_error(error);  
                                miniToastr.error(error, "Erro eliminando Atendente"); 
                            });
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error);  
                        miniToastr.error(error, "Erro eliminando Atendente"); 
                    })
                    .finally(() => this.isSendingDelete = false);
            },

            formReset:function(){
                this.model.name = "";
                this.model.login = "";
                this.model.email = "";
                this.model.password = "";
                this.model.CPF = "";
                this.model.phone = "";
                this.model.image_path= "";
                this.model.whatsapp_id= "";
                this.model.facebook_id= "";
                this.model.instagram_id= "";
                this.model.linkedin_id="";                
            },

            closeModals(){
                this.$emit('modalclose');
            }, 
            
            reload(){
                this.$emit('onreloaddatas');
            }, 


            trimDataModel: function(){
                if(this.model.login) this.model.login = this.model.login.trim();
                if(this.model.email) this.model.email = this.model.email.trim();
                if(this.model.name) this.model.name = this.model.name.trim();
                if(this.model.CPF) this.model.CPF = this.model.CPF.trim();
                if(this.model.phone) this.model.phone = this.model.phone.trim();
                if(this.model.whatsapp_id) this.model.whatsapp_id = this.model.whatsapp_id.trim();
                if(this.model.facebook_id) this.model.facebook_id = this.model.facebook_id.trim();
                if(this.model.instagram_id) this.model.instagram_id = this.model.instagram_id.trim();
                if(this.model.linkedin_id) this.model.linkedin_id = this.model.linkedin_id.trim();
                if(this.model.password) this.model.password = this.model.password.trim();
                if(this.model.repeat_password) this.model.repeat_password = this.model.repeat_password.trim();

            },

            validateData: function(){
                // Validação dos dados do atendente
                var check;
                if(this.model.login && this.model.login !=''){
                    check = validation.check('user', this.model.login)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O login do usuário é obrigatorio" );
                    this.flagReference = false;
                }
                if(this.model.email && this.model.email !=''){
                    check = validation.check('email', this.model.email)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O email do usuário é obrigatorio" );
                    this.flagReference = false;
                }
                if(this.model.name && this.model.name !=''){
                    check = validation.check('complete_name', this.model.name)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O nome do usuário é obrigatorio" );
                    this.flagReference = false;
                }

                if(this.model.CPF && this.model.CPF !=''){
                    check = validation.validate_cpf('cpf', this.model.CPF)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O CPF do usuário é obrigatorio" );
                    this.flagReference = false;
                }
                
                if(this.model.phone && this.model.phone !=''){
                    check = validation.check('phone', this.model.phone)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }

                if(this.model.whatsapp_id && this.model.whatsapp_id !=''){
                    check = validation.check('whatsapp', this.model.whatsapp_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O whatsapp do usuário é obrigatorio" );
                    this.flagReference = false;
                }
                if(this.model.facebook_id && this.model.facebook_id !=''){
                    check = validation.check('facebook_profile', this.model.facebook_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.model.instagram_id && this.model.instagram_id !=''){
                    check = validation.check('instagram_profile', this.model.instagram_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.model.linkedin_id && this.model.linkedin_id !=''){
                    check = validation.check('linkedin_profile', this.model.linkedin_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }

                if(this.model.password && this.model.password !=''){
                    check = validation.check('password', this.model.password)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.model.repeat_password && this.model.repeat_password !=''){
                    check = validation.check('password', this.model.repeat_password)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
            },

        },

        beforeMount(){
            this.logguedAttendant = JSON.parse(window.localStorage.getItem('user'));
        },

        mounted(){
            this.editAttendant();
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
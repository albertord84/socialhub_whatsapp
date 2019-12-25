<template>
    <b-container fluid>                
        <form v-show="action!='delete'">                    
            <div class="row">
                <div  class="col-lg-6 form-group has-search">
                    <span class="fa fa-user form-control-feedback"></span>
                    <input v-model="model.first_name" title="Ex: Nome do Contato" id="name" name="username" type="text" autofocus placeholder="Nome (*)" class="form-control"/>
                </div>
                <div  class="col-lg-6 form-group has-search">
                    <span class="fa fa-headphones form-control-feedback"></span>
                    <select v-model="contact_atendant_id" title="Ex: Escolha um atendente para o contato" class="form-control has-search-color" size="1">
                        <option value="0">Asignar um Atendente agora?</option>
                        <option v-for="(attendant,index) in attendants" v-bind:key="index" :value="attendant.id" :title="attendant.email">{{attendant.name}}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <input v-model="model.email" title="Ex: contato@gmail.com" name="email" id="email" type="email" placeholder="Email" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-phone form-control-feedback"></span>
                    <input v-model="model.phone" id="phone" v-mask="'55 ## ####-####'" title="Ex: 55 11 8888-8888" name="phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                </div>                                
            </div>
            <div class="row">
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-whatsapp form-control-feedback"></span>
                    <input v-model="model.whatsapp_id" v-mask="'55 ## #####-####'" title="Ex: 55 11 98888-8888" id="whatsapp_id" name="whatsapp_id" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-facebook form-control-feedback"></span>
                    <input v-model="model.facebook_id" title="Ex: facebook_id" id="facebook_id" name="facebook_id" type="text" placeholder="Facebook" class="form-control"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-instagram form-control-feedback"></span>
                        <input v-model="model.instagram_id" title="Ex: instagram_id" id="instagram_id" name="instagram_id" type="text" placeholder="Instagram" class="form-control"/>
                    </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-linkedin form-control-feedback"></span>
                    <input v-model="model.linkedin_id" title="Ex: linkedin_id" id="linkedin_id" name="linkedin_id" type="text" placeholder="LinkedIn" class="form-control"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 form-group">
                    <textarea v-model="model.summary" @keyup="countLengthSumary" name="summary" id="summary" placeholder="Adicione um resumo ..." class="form-control" cols="30" rows="4"></textarea>
                    <label class="form-group has-search-color" for="form-group">{{summary_length}}/500</label>
                </div>
                <div class="col-lg-6 form-group">
                    <textarea v-model="model.remember" @keyup="countLengthRemember" name="remember" id="remember" placeholder="Adicione um lembrete ..." class="form-control" cols="30" rows="4"></textarea>
                    <label class="form-group has-search-color" for="form-group">{{remember_length}}/500</label>
                </div>
            </div>
            <div class="col-lg-12 m-t-25 text-center">
                <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingInsert==true" @click.prevent="addContact">
                    <i v-show="isSendingInsert==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Adicionar
                </button>

                <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateContact">
                    <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                </button>

                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="formCancel">Cancelar</button>
            </div>
        </form>
        <form v-show="action=='delete'">
            Tem certeza que deseja remover esse Contato?
            <div class="col-lg-12 mt-5 text-center">
                <button type="submit" class="btn btn-primary btn_width" :disabled="isSendingDelete==true" @click.prevent="deleteContact">
                    <i v-show="isSendingDelete==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Eliminar
                </button>

                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="formCancel">Cancelar</button>
            </div>                    
        </form>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../../common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import validation from "src/common/validation.service";

    
    export default {
        name: 'managerCRUDContact',

        props: {
            url:'', //contacts controller url 
            secondUrl:'',
            action:"",
            attendants:null,
            item:{},
        },

        components:{
        },

        data(){
            return{
                contact_id: "",
                contact_atendant_id:0,

                model:{
                    first_name: "",
                    last_name: "",
                    phone: "",
                    email: "",
                    description: "",
                    remember: "",
                    summary: "",
                    whatsapp_id: "",
                    facebook_id: "",
                    instagram_id: "",
                    linkedin_id: "",
                },
                
                //---------New record properties-----------------------------
                summary_length:0,
                remember_length:0,
                
                isSendingInsert: false,
                isSendingUpdate: false,
                isSendingDelete: false,

                flagReference: true,
            
            }
        },

        methods:{
            addContact: function() { //C

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
                
                this.model.id=4; //TODO: el id debe ser autoincremental, no devo estar mandandolo
                if (this.contact_atendant_id)
                    this.model.status_id = 1;                

                var model_cpy = Object.assign({}, this.model);                      //ECR: Para eliminar espaços e traços
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/ /g, '');    //ECR
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/-/i, '');    //ECR
                if(model_cpy.phone){
                    model_cpy.phone = model_cpy.phone.replace(/ /g, '');                //ECR
                    model_cpy.phone = model_cpy.phone.replace(/-/i, '');                //ECR
                }

                // ApiService.post(this.url,this.model)
                ApiService.post(this.url, model_cpy)            //ECR
                .then(response => {
                    if (this.contact_atendant_id) {
                        ApiService.post(this.secondUrl,{
                            'id':1, //TODO: el id debe ser autoincremental, no devo estar mandandolo
                            'contact_id':response.data.id,
                            'attendant_id':this.contact_atendant_id,
                        })
                        .then(response => {
                            miniToastr.success("Contato adicionado com sucesso","Sucesso");
                            this.reload();
                            this.formCancel();
                        })
                        .catch(function(error) {
                            ApiService.process_request_error(error); 
                            miniToastr.error(error, "Erro adicionando contato");  
                        })
                        .finally(() => this.isSendingInsert = false);       
                    }else{
                        miniToastr.success("Contato adicionado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    }
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando contato");  
                })
                .finally(() => this.isSendingInsert = false);   
            },
            
            editContact: function() { //U
                this.model = Object.assign({}, this.item);

                delete this.model.latest_attendant;
                delete this.model.latest_attendant_contact;
                delete this.model.latestAttendant;
                delete this.model.status;
                delete this.model.updated_at;

                this.contact_atendant_id =  this.model.contact_atendant_id;
                this.modalEditContact = !this.modalEditContact;
            },

            updateContact: function() { //U

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
 
                if(this.contact_atendant_id>0)
                    this.model.status_id = 1;

                var model_cpy = Object.assign({}, this.model);                      //ECR: Para eliminar espaços e traços
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/ /g, '');    //ECR
                model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/-/i, '');    //ECR
                if(model_cpy.phone){
                    model_cpy.phone = model_cpy.phone.replace(/ /g, '');                //ECR
                    model_cpy.phone = model_cpy.phone.replace(/-/i, '');                //ECR
                }

                // ApiService.put(this.url+'/'+this.model.id, this.model) //ecr this.item.contact_id
                ApiService.put(this.url+'/'+this.model.id, model_cpy) //ecr this.item.contact_id       //ECR
                .then(response => {
                    if (this.contact_atendant_id && this.contact_atendant_id != this.item.contact_atendant_id) {
                        ApiService.post(this.secondUrl,{
                            'id':0,
                            'contact_id':this.model.id,
                            'attendant_id':this.contact_atendant_id,                            
                        })
                        .then(response => {
                            miniToastr.success("Contato atualizado com sucesso","Sucesso");
                            this.reload();
                            this.formCancel();
                        })
                        .catch(function(error) {
                            ApiService.process_request_error(error); 
                            miniToastr.error(error, "Erro atualizando contato");  
                        })
                        .finally(() => this.isSendingUpdate = false);     
                    }else{
                        miniToastr.success("Contato atualizado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    }
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando contato");  
                })
                .finally(() => this.isSendingUpdate = false);   
            },

            deleteContact: function() { //D
                
                this.isSendingDelete = true;

                ApiService.delete(this.url+'/'+this.item.id)
                    .then(response => {                        
                        miniToastr.success("Contato eliminado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error);  
                        miniToastr.error(error, "Erro eliminando o contato"); 
                    })
                    .finally(() => this.isSendingDelete = false);                   
            },

            //------ auxiliary methods--------------------
            countLengthSumary: function(){
                this.model.summary = this.model.summary.length > 500 ? this.model.summary.substring(0, 500) : this.model.summary;
                this.summary_length = this.model.summary.length;                    
            },

            countLengthRemember: function(){
                this.model.remember = this.model.remember.length > 500 ? this.model.remember.substring(0, 500) : this.model.remember;
                this.remember_length = this.model.remember.length;
            },

            formCancel(){
                this.$emit('modalclose');
            }, 
            
            reload(){
                this.$emit('onreloaddatas');
            }, 

            formReset:function(){
                this.model.first_name = "";
                this.model.last_name = "";
                this.model.email = "";
                this.model.description = "";
                this.model.remember = "";
                this.model.summary = "";
                this.model.phone = "";
                this.model.whatsapp_id = "";
                this.model.facebook_id = "";
                this.model.instagram_id = "";
                this.model.linkedin_id = "";
            },

            trimDataModel: function(){
                if(this.model.first_name) this.model.first_name = this.model.first_name.trim();
                if(this.model.last_name) this.model.last_name = this.model.last_name.trim();
                if(this.model.email) this.model.email = this.model.email.trim();
                if(this.model.phone) this.model.phone = this.model.phone.trim();
                if(this.model.whatsapp_id) this.model.whatsapp_id = this.model.whatsapp_id.trim();
                if(this.model.facebook_id) this.model.facebook_id = this.model.facebook_id.trim();
                if(this.model.instagram_id) this.model.instagram_id = this.model.instagram_id.trim();
                if(this.model.linkedin_id) this.model.linkedin_id = this.model.linkedin_id.trim();
                if(this.model.remember) this.model.remember = this.model.remember.trim();
                if(this.model.summary) this.model.summary = this.model.summary.trim();
                if(this.model.description) this.model.description = this.model.description.trim();
            },

            validateData: function(){
                // Validação dos dados do contato
                var check;
                if(this.model.first_name && this.model.first_name !=''){
                    check = validation.check('complete_name', this.model.first_name)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O nome do contato é obrigatorio" );
                    this.flagReference = false;
                }
                if(this.model.email && this.model.email !=''){
                    check = validation.check('email', this.model.email)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.model.phone && this.model.phone !=''){
                    check = validation.check('phone', this.model.phone)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.model.whatsapp_id && this.model.whatsapp_id !=''){
                    check = validation.check('phone', this.model.whatsapp_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O whatsapp do contato é obrigatorio" );
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
            },

        },

        beforeUpdate(){
            },

        mounted(){
            this.editContact();            
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

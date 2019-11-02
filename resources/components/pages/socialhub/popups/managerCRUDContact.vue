<template>
    <b-container fluid>                
        <form v-show="action!='delete'">                    
            <div class="row">
                <div  class="col-lg-6 form-group has-search">
                    <span class="fa fa-user form-control-feedback"></span>
                    <input v-model="model.first_name" id="name" name="username" type="text" autofocus placeholder="Nome completo" class="form-control"/>
                </div>
                <div  class="col-lg-6 form-group has-search">
                    <span class="fa fa-headphones form-control-feedback"></span>
                    <select v-model="contact_atendant_id" class="form-control has-search-color" size="1">
                        <option value="0">Asignar um Atendente agora?</option>
                        <option v-for="(attendant,index) in attendants" v-bind:key="index" :value="attendant.id" :title="attendant.email">{{attendant.name}}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <input v-model="model.email" name="email" id="email" type="email" placeholder="Email" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-phone form-control-feedback"></span>
                    <input v-model="model.phone" id="phone" name="hone" type="text" placeholder="Telefone fixo" class="form-control"/>
                </div>                                
            </div>
            <div class="row">
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-whatsapp form-control-feedback"></span>
                    <input v-model="model.whatsapp_id" id="whatsapp_id" name="whatsapp_id" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-facebook form-control-feedback"></span>
                    <input v-model="model.facebook_id" id="facebook_id" name="facebook_id" type="text" placeholder="Facebook" class="form-control"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-instagram form-control-feedback"></span>
                        <input v-model="model.instagram_id" id="instagram_id" name="instagram_id" type="text" placeholder="Instagram" class="form-control"/>
                    </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-linkedin form-control-feedback"></span>
                    <input v-model="model.linkedin_id" id="linkedin_id" name="linkedin_id" type="text" placeholder="LinkedIn" class="form-control"/>
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
                <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" @click.prevent="addContact">Adicionar</button>
                <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" @click.prevent="updateContact">Atualizar</button>
                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="formCancel">Cancelar</button>
            </div>
        </form>
        <form v-show="action=='delete'">
            Tem certeza que deseja remover esse Contato?
            <div class="col-lg-12 mt-5 text-center">
                <button type="submit" class="btn btn-primary btn_width" @click.prevent="deleteContact">Eliminar</button>
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
            }
        },

        methods:{
            addContact: function() { //C
                if(this.model.whatsapp_id.trim() =='' || this.model.first_name.trim() ==''){
                    miniToastr.error(error, "Alguns dados incompletos");  
                    return;
                }
                this.model.id=4; //TODO: el id debe ser autoincremental, no devo estar mandandolo
                if (this.contact_atendant_id)
                    this.model.status_id = 1;
                ApiService.post(this.url,this.model)
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
                        });    
                    }else{
                        miniToastr.success("Contato adicionado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    }
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando contato");  
                });
            },
            
            editContact: function() { //U
                this.model = Object.assign({}, this.item);
                this.contact_atendant_id =  this.item.contact_atendant_id;
                this.modalEditContact = !this.modalEditContact;
            },

            updateContact: function() { //U
                if(!this.model.whatsapp_id || this.model.whatsapp_id.trim() =='' || this.model.first_name.trim() ==''){
                    miniToastr.error(error, "Erro adicionando contato");  
                    return;
                }
                ApiService.post(this.url+'/'+this.item.id, this.model)
                .then(response => {
                    // if (this.contact_atendant_id) {
                    //     ApiService.post(this.secondUrl,{
                    //         // 'id':1, //TODO: el id debe ser autoincremental, no devo estar mandandolo
                    //         'contact_id':this.item.id,
                    //         'attendant_id':this.contact_atendant_id,
                    //     })
                    //     .then(response => {
                    //         miniToastr.success("Contato atualizado com sucesso","Sucesso");
                    //         this.reload();
                    //         this.formCancel();
                    //     })
                    //     .catch(function(error) {
                    //         ApiService.process_request_error(error); 
                    //         miniToastr.error(error, "Erro adicionando contato");  
                    //     });    
                    // }else{
                    //     miniToastr.success("Contato adicionado com sucesso","Sucesso");
                    //     this.reload();
                    //     this.formCancel();
                    // }
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando contato");  
                });
                
                
                
                ApiService.post(+'/'+this.contact_atendant_id,this.model)
                .then(response => {                
                    miniToastr.success("Contato atualizado com sucesso","Sucesso");
                    this.reload();
                    this.formCancel();
                })
                .catch(function(error) {
                    ApiService.process_request_error(error);  
                    miniToastr.error(error, "Erro atualizando contato"); 
                });
            },

            deleteContact: function() { //D
                ApiService.delete(this.url+'/'+this.item.id)
                    .then(response => {                        
                        miniToastr.success("Contato eliminado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error);  
                        miniToastr.error(error, "Erro eliminando o contato"); 
                    });                
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

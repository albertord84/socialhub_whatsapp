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
                        <input v-model="model.login" name="login" id="login" type="text" required placeholder="Login (*)" class="form-control"/>
                    </div>
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-envelope form-control-feedback"></span>
                        <input v-model="model.email" id="email" name="email" type="email" required placeholder="Email (*)" class="form-control"/>                            
                    </div>                                                      
                </div>
                <div class="row">
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-user form-control-feedback"></span>
                        <input v-model="model.name" id="name" name="name" type="text" required autofocus placeholder="Nome completo (*)" class="form-control"/>
                    </div>
                    <div class="col-lg-3 form-group has-search">
                        <span class="fa fa-id-card form-control-feedback"></span>
                        <input v-model="model.CPF" name="CPF" id="CPF" type="text" required placeholder="CPF (*)" class="form-control"/>
                    </div>
                    <div class="col-lg-3 form-group has-search">
                        <span class="fa fa-phone form-control-feedback"></span>
                        <input v-model="model.phone" id="phone" name="phone" type="text" required placeholder="Telefone (*)" class="form-control"/>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-whatsapp form-control-feedback"></span>
                        <input v-model="model.whatsapp_id" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                    </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-facebook form-control-feedback"></span>
                        <input v-model="model.facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-instagram form-control-feedback"></span>
                            <input v-model="model.instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                        </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-linkedin form-control-feedback"></span>
                        <input v-model="model.linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                    </div>
                </div>
                <div class="col-lg-12 m-t-25 text-center">
                    <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" @click.prevent="addAttendant">Adicionar</button>
                    <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" @click.prevent="updateAttendant">Atualizar</button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>
            <form v-show="action=='delete'">
                Tem certeza que deseja remover esse Atendente?
                <div class="col-lg-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary btn_width" @click.prevent="deleteAttendant">Eliminar</button>
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
        name: 'adminCRUDSellers',

        props: {
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
            }
        },

        methods:{
            addAttendant: function() { //C
                this.model.id=8;
                this.model.role_id=3;
                this.model.image_path = "images/user.jpg";
                ApiService.post(this.first_url, this.model)
                .then(response => {
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
                    });
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando usuáio");  
                });
            },
            
            editAttendant: function() { //U
                this.attendant_id = this.item.id;
                this.model = Object.assign({}, this.item);
                this.closeModals();
            },

            updateAttendant: function() { //U
                var model_cpy = JSON.parse(JSON.stringify(this.model));
                delete model_cpy.created_at;
                delete model_cpy.updated_at;
                delete model_cpy.deleted_at;
                ApiService.post(this.first_url+'/'+this.attendant_id, model_cpy)
                    .then(response => {
                        miniToastr.success("Atendente atualizado com sucesso","Sucesso");
                            this.reload();
                            this.closeModals();
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error);  
                        miniToastr.error(error, "Erro atualizando Atendente"); 
                    });
            },

            deleteAttendant: function(){
                ApiService.delete(this.url+'/'+this.item.id)
                    .then(response => {
                        //TODO-JR: eliminar un atendente elimina en cascada?
                        // ApiService.delete(this.first_url+'/'+this.item.id)
                        //     .then(response => {
                                miniToastr.success("Atendente eliminado com sucesso","Sucesso");
                                this.reload();
                                this.closeModals();
                            // })
                            // .catch(function(error) {
                            //     ApiService.process_request_error(error);  
                            //     miniToastr.error(error, "Erro eliminando Atendente"); 
                            // });
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error);  
                        miniToastr.error(error, "Erro eliminando Atendente"); 
                    });
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
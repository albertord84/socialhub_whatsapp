<template>
    <div>
        <b-container fluid>                
            <form>                                        
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
                        <input v-model="model.email" id="email" name="email" type="text" required placeholder="Email (*)" class="form-control"/>                            
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
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="modalAddAttendant=!modalAddAttendant;formReset">Cancelar</button>
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
        name: 'managerAddAttendant',

        props: {
            url:'', //controller url 
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
                ApiService.post(this.url, this.model
                )
                .then(response => {
                    miniToastr.success("Atendente adicionado com sucesso","Sucesso");
                    this.formReset();
                    // this.getAttendants();
                    // this.modalAddAttendant=!this.modalAddAttendant;
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando atendente");  
                });
            },
            
            editAttendant: function() { //U
                this.attendant_id = this.item.id;
                this.model = this.item;
                //this.modalEditAttendant = !this.modalEditAttendant;
            },

            updateAttendant: function() { //U                
                ApiService.post(this.url+'/'+this.attendant_id, this.model)
                .then(response => {
                    miniToastr.success("Atendente atualizado com sucesso","Sucesso");
                    this.formReset();
                    // this.getAttendants();
                    //this.modalEditAttendant=!this.modalEditAttendant;
                })
                .catch(function(error) {
                    ApiService.process_request_error(error);  
                    miniToastr.error(error, "Erro atualizando atendente"); 
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
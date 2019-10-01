<template>
    <div class="">
            <div class="col-lg-12 sect_header">
                <ul class="menu">
                    <li><a href="javascript:void(0)" @click.prevent="toggle_left('close')"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                    <li><p>Novo contato</p> </li>
                    <ul class="menu float-right">
                        <li ><a href="javascript:void(0)" @click.prevent="toggle_left('close')"><i class="fa fa-close"></i></a></li>
                    </ul>
                </ul>
            </div>
            <vue-form class="col-lg-12 form-horizontal form-validation" :state="formstate" @submit.prevent="addContact">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style="padding: 29px 0px 5px" class="form-group has-search">
                            <span class="fa fa-user form-control-feedback"></span>
                            <input v-model="new_first_name" id="new_first_name" name="new_first_name" type="text" autofocus placeholder="Nome completo" class="form-control"/>
                        </div>
                    </div>
                </div>                
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style="" class="form-group has-search">
                            <span class="fa fa-envelope form-control-feedback"></span>
                            <input v-model="new_email" name="email" id="email" type="email" placeholder="Email" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style="" class="form-group has-search">
                            <span class="fa fa-phone form-control-feedback"></span>
                            <input v-model="new_phone" id="new_phone" name="new_phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style="" class="form-group has-search">
                            <span class="fa fa-whatsapp form-control-feedback"></span>
                            <input v-model="new_whatsapp_id" id="new_whatsapp_id" name="new_whatsapp_id" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style="" class="form-group has-search">
                            <span class="fa fa-facebook form-control-feedback"></span>
                            <input v-model="new_facebook_id" id="new_facebook_id" name="new_facebook_id" type="text" placeholder="Facebook" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style=" " class="form-group has-search">
                            <span class="fa fa-instagram form-control-feedback"></span>
                            <input v-model="new_instagram_id" id="new_instagram_id" name="new_instagram_id" type="text" placeholder="Instagram" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div style="" class="form-group has-search">
                            <span class="fa fa-linkedin form-control-feedback"></span>
                            <input v-model="new_linkedin_id" id="new_linkedin_id" name="new_linkedin_id" type="text" placeholder="LinkedIn" class="form-control"/>
                        </div>
                    </div>
                </div>
                
                <div  class="col-lg-12">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="javascript:void(0)" @click.prevent="show_sumary=!show_sumary" v-show="show_sumary==false" class="box"><i class="fa fa-angle-double-down"></i> Resumo</a>
                            <a href="javascript:void(0)" @click.prevent="show_sumary=!show_sumary" v-show="show_sumary==true" class="box"><i class="fa fa-angle-double-up"></i> Resumo</a>
                        </li>
                        <li class="list-inline-item float-right">
                            <a href="javascript:void(0)" @click.prevent="show_remember=!show_remember" v-show="show_remember==false" class="box"><i class="fa fa-angle-double-down"></i> Lembrete</a>
                            <a href="javascript:void(0)" @click.prevent="show_remember=!show_remember" v-show="show_remember==true" class="box"><i class="fa fa-angle-double-up"></i> Lembrete</a>
                        </li>
                    </ul>
                </div>

                <div  class="col-lg-12">
                    <div v-show="show_sumary==true" class="form-group">
                        <textarea v-model="new_summary" @keyup="countLengthSumary" name="new_summary" id="new_summary" placeholder="Adicione um resumo ..." class="form-control" cols="30" rows="3"></textarea>
                        <label class="form-group has-search-color" for="form-group">{{new_summary_length}}/500</label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div v-show="show_remember==true" class="form-group">
                        <textarea v-model="new_remember" @keyup="countLengthRemember" name="new_remember" id="new_remember" placeholder="Adicione um lembrete ..." class="form-control" cols="30" rows="3"></textarea>
                        <label class="form-group has-search-color" for="form-group">{{new_remember_length}}/500</label>
                    </div>
                </div>
                <div class="col-lg-12 mt-2 text-center">
                    <button type="submit" class="btn btn-primary btn_width">Adicionar</button>
                    <button type="reset"  class="btn btn-effect-ripple btn-secondary btn_width reset_btn1" @click.prevent="formReset();toggle_left('close')">Cancelar</button>
                </div>
            </vue-form>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "resources/common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    Vue.use(VueForm, options);
    export default {
        name: "add_user",
        data() {
            return {
                //---------General properties-----------------------------
                url:'contacts',  //route to controller
                
                //---------Specific properties-----------------------------
                contact_id: "",

                //---------New record properties-----------------------------
                new_first_name: "",
                new_last_name: "",
                new_phone: "",
                new_email: "",
                new_description: "",
                new_remember: "",
                new_summary: "",
                new_whatsapp_id: "",
                new_facebook_id: "",
                new_instagram_id: "",
                new_linkedin_id: "",
                new_summary_length:0,
                new_remember_length:0,

                show_sumary:false,
                show_remember:false,

                formstate: {},
                show_error:false,
                show_success:false,
                validationErrors:[],
            }
        },
        methods: {
            addContact: function () {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    ApiService.post('auth/add_user', {
                        'first_name': this.new_first_name,
                        'last_name': this.new_last_name,
                        'email': this.new_email,
                        'remember': this.new_remember,
                        'summary': this.new_summary,
                        'phone': this.new_phone,
                        'description': this.new_description,
                        'whatsapp_id': this.new_whatsapp_id,
                        'facebook_id': this.new_facebook_id,
                        'instagram_id': this.new_instagram_id,
                        'linkedin_id': this.new_linkedin_id,                    
                    })
                    .then(data => {
                        miniToastr.success("Contato adicionado com sucesso","Sucesso");
                        this.formReset();
                        this.toggle_left('close');
                    })                        
                    .catch(error => {
                        ApiService.process_request_error(error); 
                        miniToastr.error(error, "Erro adicionando contato");  
                    });
                }
            },

            formReset:function(){
                this.new_first_name = "";
                this.new_last_name = "";
                this.new_email = "";
                this.new_description = "";
                this.new_remember = "";
                this.new_summary = "";
                this.new_phone = "";
                this.new_whatsapp_id = "";
                this.new_facebook_id = "";
                this.new_instagram_id = "";
                this.new_linkedin_id = "";
            },

            countLengthSumary: function(){
                this.new_summary = this.new_summary.length > 500 ? this.new_summary.substring(0, 500) : this.new_summary;
                this.new_summary_length = this.new_summary.length;                    
            },

            countLengthRemember: function(){
                this.new_remember = this.new_remember.length > 500 ? this.new_remember.substring(0, 500) : this.new_remember;
                this.new_remember_length = this.new_remember.length;
            },

            toggle_left(action) {
                this.$store.commit('leftside_bar', action);
            },
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        mounted: function () {
            
        },
        destroyed: function () {

        }
    }
</script>

<style scoped>
    .dropzone_wrapper {
        width: 100%;
    }

    .align-left {
        float: left;
    }

    .align-right {
        float: right;
    }
    /*-------------------------------------*/
    .sect_header{
        background-color:#eaf5ff;
        height:50px;  
        border: 1px solid #e9e9e9;
    }
    /*-------------------------------------*/
    .menu{
        z-index: 100;
        list-style:none; 
        margin: 0;
        padding: 0;        
    }
    .menu li{
        position:relative; 
        float:left; 
        
    }
    .menu li a,p{
        font-size: 12px;
        display: block;
        color: gray;
        text-align: left;
        padding: 8px;
        padding-top: 16px;
        text-decoration: none;
    }    
    .menu, li, a, a:active, a:focus {
        outline: none;
    }
    /*-------------------------------------*/
      .has-icon .form-control {
        padding-left: 2.375rem;
    }
    .has-icon .form-control {
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
    /*-------------------------------------*/
    .btn_width{
        width: 100px
    }

    .has-search-color{
        color: #aaa;
    }

    .box{
        font-size: 12px;
        color: gray;
    }
</style>

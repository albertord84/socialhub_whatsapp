<template>
    <div class="" style="margin-top:50px; width:100%">
            <div class="col-lg-12 sect_header">
                <ul class="menu">
                    <li><a href="javascript:void(0)" @click.prevent="toggle_right"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                    <li><p>Editar contato</p> </li>
                    <ul class="menu float-right">
                        <li ><a href="javascript:void(0)" @click.prevent="toggle_right()"><i class="fa fa-close"></i></a></li>
                    </ul>
                </ul>
            </div>
            <vue-form class="col-lg-12 form-horizontal form-validation" :state="formstate" @submit.prevent="onSubmit">
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style="padding: 29px 0px 5px" class="form-group has-search">
                                <span class="fa fa-user form-control-feedback"></span>
                                <input v-model="model.name" id="name" name="username" type="text" autofocus placeholder="Nome ou Apelido" class="form-control"/>
                            </div>
                            <field-messages name="username" show="$invalid && $submitted" class="text-danger">
                            </field-messages>
                        </validate>
                    </div>
                </div>                
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style="" class="form-group has-search">
                                <span class="mdi mdi-email-outline form-control-feedback"></span>
                                <input v-model="model.email" name="email" id="email" type="email" placeholder="E-mail" class="form-control"/>
                            </div>
                            <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                                <div slot="email">Email inválido</div>
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style="" class="form-group has-search">
                                <span class="fa fa-phone form-control-feedback"></span>
                                <input v-model="model.fix_phone" id="fix_phone" name="fix_phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                            </div>
                            <field-messages name="fix_phone" show="$invalid && $submitted" class="text-danger">
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style="" class="form-group has-search">
                                <span class="fa fa-whatsapp form-control-feedback"></span>
                                <input v-model="model.whatsapp" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                            </div>
                            <field-messages name="whatsapp" show="$invalid && $submitted" class="text-danger">
                                <div slot="required">Whatssap é obrigatório</div>
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style="" class="form-group has-search">
                                <span class="fa fa-facebook form-control-feedback"></span>
                                <input v-model="model.facebook" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                            </div>
                            <field-messages name="facebook" show="$invalid && $submitted" class="text-danger">
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style=" " class="form-group has-search">
                                <span class="fa fa-instagram form-control-feedback"></span>
                                <input v-model="model.instagram" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                            </div>
                            <field-messages name="instagram" show="$invalid && $submitted" class="text-danger">
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <div style="" class="form-group has-search">
                                <span class="fa fa-linkedin form-control-feedback"></span>
                                <input v-model="model.instagram" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                            </div>
                            <field-messages name="linkedin" show="$invalid && $submitted" class="text-danger">
                            </field-messages>
                        </validate>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <validate tag="div">
                            <textarea v-model="model.decription" name="decription" id="decription" placeholder="Adicione descrição ..." class="form-control" cols="30" rows="5"></textarea>
                            <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                            </field-messages>
                        </validate>
                    </div>
                </div>

                <div class="col-sm-12" v-show="show_error">
                    <ul>
                        <li v-for="error in validationErrors" class="text-danger">{{error[0]}}</li>
                    </ul>
                </div>
                <div class="col-sm-12" v-show="show_success">
                    <ul>
                        <li class="text-success">Your user record has been inserted successfully</li>
                    </ul>
                </div>
                <div class="col-lg-12 m-t-25 text-center">
                    <button type="submit" class="btn btn-primary btn_width" :disabled='isSending'> <i v-show="isSending==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar</button>
                    <button type="reset" class="btn btn-effect-ripple btn-secondary btn_width reset_btn1" @click.prevent="form_reset();toggle_right()">Cancelar</button>
                </div>
            </vue-form>
        <!-- </div> -->
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "resources/common/api.service";

    Vue.use(VueForm, options);
    export default {
        name: "attendantEditContact",
        data() {
            return {
                userLogged:{},
                formstate: {},
                isSending:false,
                model: {
                    name: "",
                    email: "",
                    fix_phone: "",
                    whatsapp: "",
                    facebook: "",
                    instagram: "",
                    linkedin: "",
                    decription: "",
                },
                show_error:false,
                show_success:false,
                validationErrors:[],
            }
        },
        methods: {
            onSubmit: function () {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    ApiService.post('auth/add_user', this.model)
                        .then(data => {
                            this.show_error = false;
                            this.show_success = true;
                        })
                        .then(() => {
                            setTimeout(()=>{
                                this.$router.push("/users_list")
                            },2000);
                        })
                        .catch(error => {
                            if (error.response.status == 422) {
                                this.validationErrors = error.response.data.errors;
                                this.show_error = true;
                                this.show_success = false;
                            }
                        })
                }
            },
            form_reset() {
                this.model = {
                    name: "",
                    email: "",
                    fix_phone: "",
                    whatsapp: "",
                    facebook: "",
                    instagram: "",
                    linkedin: "",
                    decription: "",
                };
            },
            toggle_right() {
               this.$store.commit('rightside_bar', "toggle");
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
        beforeMount: function () {
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
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
</style>

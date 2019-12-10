<template>
    <div class="container-fluid img_backgrond">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 login-content mt-5">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <h2 class="text-center">
                            <img width="200px" src="~img/socialhub/Logo roxo.png" alt="Logo">
                        </h2>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <img width="120px" src="~img/socialhub/login.png" class="rounded-circle">
                        </div>
                    </div>
                </div>
                <vue-form :state="formstate" >
                    <div class="row mx-1 mb-3">
                        <div class="col-sm-12 mt-3 ">
                            <p v-show="show_error" class="text-danger">Email ou senha inválido</p>
                            <div class="form-group">
                                <validate tag="div">
                                    <label for="email">Email</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                        </div>
                                        <input v-model="model.email" name="email" id="email" type="email" required
                                               autofocus placeholder="E-mail" class="form-control"/>
                                    </div>
                                    <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">Email é obrigatório</div>
                                        <div slot="email">Email inválido</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <validate tag="div">
                                    <label for="password"> Senha</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                        </div>
                                        <input v-model="model.password" name="password" id="password" type="password" required placeholder="Senha" class="form-control"/>
                                    </div>
                                    <field-messages name="password" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">A senha é obrigatória</div>
                                        <div slot="minlength">A senha deve ter pelo menos 4 caracteres</div>
                                        <div slot="maxlength">A senha deve conterter máximo 10 caracteres</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6 col-md-6">
                            <validate tag="label">
                                <b-form-checkbox id="remember" v-model="model.remember">Remember Me</b-form-checkbox>
                                <field-messages name="remember" show="$invalid && $submitted" class="text-danger">
                                    <div slot="check-box">Terms must be accepted</div>
                                </field-messages>
                            </validate>
                        </div> -->

                        <div class="col-lg-6 text-right">
                            <div class="form-group">
                                <div class="login-text">
                                <router-link tag="a" to="/forgotpassword" class="">Esqueceu sua senha?</router-link></div>
                            </div>
                        </div>

                        <div class="col-lg-12 text-right">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="isSending==true" @click.prevent="onSubmit">
                                    <i v-show="isSending==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Entrar
                                </button>
                            </div>
                        </div>
                        <br>

                        <!-- <div class="col-lg-12 text-left">
                            <div class="form-group">
                                <div class="login-text">
                                New User?
                                <router-link tag="a" to="/register" class="">Sign Up</router-link></div>
                            </div>
                        </div> -->


                    </div>
                </vue-form>
            </div>

        </div>
    </div>
</template>
<script>
    import Vue from 'vue'

    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "../../common/api.service";

    import miniToastr from "mini-toastr";
    miniToastr.init();

    import validation from "src/common/validation.service";

    Vue.use(VueForm, options);
    export default {
        name: "login2",
        data() {
            return {
                formstate: {},
                show_error: false,
                model: {
                    email: "",
                    password: ""
                },
                isSending: false,
            }
        },
        methods: {
            onSubmit() {
                // if (this.formstate.$invalid) {
                //     return;
                var check = validation.check('email', this.model.email);
                if(check.success==false){
                    miniToastr.error("Erro", check.error );   
                } else {
                    this.isSending = true;
                    ApiService.post('auth/login', this.model)
                        .then(data => {
                            this.$store.dispatch('login', data);
                            this.show_error = false;
                            var logged_user = JSON.parse(localStorage.user);
                            var link;
                            switch(logged_user.role_id) {
                                case 1: /*ADMIN*/ 
                                    link = "admin";
                                    break;
                                case 2: /*SELLER*/ 
                                    link = "seller";
                                    break;
                                case 3: /*MANAGER*/ 
                                    link = "manager";
                                    break;
                                case 4: /*ATTENDANT*/ 
                                    link = "attendant";
                                    break;
                                case 5: /*VISITOR*/ 
                                    link = "visitor";
                                    break;
                                default:
                                    link = "login";
                            } 
                            this.isSending = false;
                            this.$router.push({name: link});
                        })
                        .catch(error => {
                            this.isSending = false;
                            this.show_error = true;
                        })

                }
            }
        },
        mounted: function () {
            
        },
        destroyed: function () {

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

    .login-content {
        margin-top: 7%;
        margin-bottom: 7%;
        box-shadow: 0 0 20px #ccc;
        background-size: 100% 100%;
        border-radius: 7px;
        background-color: #ffffff;

    }


    .img_backgrond {
        /* background-image: url("../../img/pages/Login-03-01.png"); */
        background-image: url("../../img/socialhub/background2.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        padding: 75px 15px;
    }

    label {
        font-size: 14px !important;
    }

    ::-webkit-input-placeholder {
        font-size: 14px;
    }
    .img_backgrond .input-group-text{
        background-color: white;
    }
    .fa-user,.fa-key,.fa{
        color: #ced4da;
    }
    .custom-checkbox label::before {
        background-color: #ced4da !important;
    }
    .login-text{
        font-size:14px;
    }
</style>

<template>
    <div class="container-fluid img_backgrond">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 login-content mt-5">
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <h2 class="text-center">
                            <img width="200px" src="~img/socialhub/Logo roxo.png" alt="Logo">
                        </h2>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <h3 class="page-name text-center">Redefinir Senha</h3>
                    </div>
                </div>
                <v-layout v-show="errorShow">
                    <span style="color:red; text-align:center;">{{message}}</span>
                </v-layout>
                <v-layout v-show="successShow">
                    <span style="color:green; text-align:center;">{{message}}</span><br>
                    <router-link tag="a" to="/" class="mt-3">Ir à página de login</router-link>
                </v-layout>
                <vue-form :state="formstate" @submit.prevent="onSubmit" v-show="!successShow">
                    <input type="hidden"
                            id="token"
                            v-model="model.token"
                            required
                    />
                    <div class="col-md-12">
                        <p class="user-message"> * A senha é sensível a maiúsculas.</p>
                        <div class="form-group">
                            <validate tag="div">

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    </div>
                                    <input v-model="model.password" name="password" type="password" required placeholder="Senha" class="form-control" />
                                </div>


                                <field-messages name="password" show="$invalid && $submitted" class="text-danger">
                                    <div slot="required">A senha é obrigatória</div>
                                    <div slot="minlength">A senha deve ter pelo menos 4 caracteres</div>
                                    <div slot="maxlength">A senha deve conterter máximo 10 caracteres</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <validate tag="div">

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    </div>
                                    <input v-model="model.password_confirmation" name="repeatpassword" type="password" required placeholder="Repetir senha" class="form-control" :sameas="model.password">
                                </div>

                                <field-messages name="repeatpassword" show="$invalid && $submitted" class="text-danger">
                                    <div slot="required">Confirmação de senha é obrigatória</div>
                                    <div slot="sameas">As senhas não coincidem</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i v-show="isSendingResetPassword" class="fa fa-spinner fa-spin"></i>
                                Redefinir senha
                            </button>
                        </div>
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
    import ApiService from "resources/common/api.service";
    Vue.use(VueForm, options);
    export default {
        name: "resetpassword",
        data() {
            return {
                errorShow: false,
                successShow: false,
                formstate: {},
                message: '',
                model: {
                    password: "",
                    password_confirmation: "",
                    token: ""
                },

                isSendingResetPassword:false,

            }
        },
        methods: {
            onSubmit: function () {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    let component = this;
                    component.message = '';
                    this.isSendingResetPassword = true;
                    ApiService.post('/auth/password_save', this.model)
                        .then(response => {
                            if (!!response.data.success) {
                                component.model = {};
                                component.message = "Você pode logar com a sua nova senha!";
                                component.errorShow = false;
                                component.successShow = true;
                                component.showLoginPage = true;
                            } else {
                                component.model.password = '';
                                component.model.password_confirmation = '';
                                component.message = "Alguns dados incorreto!";
                                component.errorShow = true;
                                component.successShow = false;
                                component.showLoginPage = false;
                            }
                        })
                        .catch(error => {
                            this.show_error = true;
                            this.show_success = false;
                        })
                        .finally(() => {this.isSendingResetPassword = false;});
                        ;
                }
            }
        },
        beforeMount(){
            this.model.token = this.$route.params.token;
        },
        mounted: function () {

        },
        destroyed: function () {

        }
    }
</script>
<style scoped>
    .login-content {
        margin-top: 7%;
        margin-bottom: 7%;
        padding-bottom: 20px;
        box-shadow: 0 0 30px #ccc;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-color: #ffffff;
    }

    .img_backgrond {
        /* background-image: url("../../img/pages/Login-03-01.png"); */
        /* background-image: url("../../img/socialhub/background2.jpg"); */
        background-color: #eaedf2;
        background-size: cover;
        height: 100vh;
        width: 100%;
    }

    label {
        font-size: 14px !important;
    }

    ::-webkit-input-placeholder {
        font-size: 14px;
    }

    .user-message {
        padding: 15px 0;
        font-size: 14px;
        color: #777;
    }
    .img_backgrond .input-group-text{
        background-color: white;
    }
    .fa{
        color: #ced4da;
    }

</style>

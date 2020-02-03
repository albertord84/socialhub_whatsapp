<template>
    <div class="container-fluid img_backgrond pt-5">
        <div class="row pt-3">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 login-content mt-5">
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <h2 class="text-center">
                            <img width="200px" src="~img/socialhub/Logo roxo.png" alt="Logo">
                        </h2>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <h3 class="page-name text-center">Recuperar senha</h3>
                    </div>
                </div>
                <vue-form :state="formstate" @submit.prevent="onSubmit">
                    <p v-show="show_success" class="text-success">O email de redefinição de senha foi enviado.</p>
                    <p v-show="show_error" class="text-danger">Email não existe</p>
                    <div class="col-lg-12">
                        <p class="user-message ">Digite o e-mail com o qual você está cadastrado. Uma mensagem será enviada com mais instruções.</p>
                        <div class="form-group">
                            <validate tag="div">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <input v-model="model.email" name="email" type="email" required placeholder="E-mail"
                                           class="form-control"/>
                                </div>
                                <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                                    <div slot="required">Email é obrigatório</div>
                                    <div slot="email">Email é inválido</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> 
                                <i v-show="isSendingEmail" class="fa fa-spinner fa-spin"></i>
                                Enviar Email
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
    import ApiService from "../../common/api.service";

    Vue.use(VueForm, options);
    export default {
        name: "forgetpassword",
        data() {
            return {
                formstate: {},
                model: {
                    email: ""
                },
                show_success: false,
                show_error: false,

                isSendingEmail:false,
            }
        },
        methods: {
            onSubmit() {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    this.isSendingEmail = true;
                    ApiService.post('auth/password_reset', this.model)
                        .then(data => {
                            this.show_error = false;
                            this.show_success = true;
                        })
                        .catch(error => {
                            this.show_error = true;
                            this.show_success = false;
                            this.processMessageError(error, 'password_reset', "add");
                        }).finally(() => {this.isSendingEmail = false;});
                }
            },

            //------ Specific exceptions methods------------
            processMessageError: function(error, url, action) {
                
                var info = ApiService.process_request_error(error, url, action);
                if(info.typeException == "expiredSection"){
                    miniToastr.warn(info.message,"Atenção");
                    
                    window.localStorage.removeItem('token');
                    window.localStorage.removeItem('user');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.push({name: "login"});

                }else if(info.typeMessage == "warn"){
                    miniToastr.warn(info.message,"Atenção");
                }else{
                    miniToastr.error(info.erro, info.message); 
                }
            }
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
        box-shadow: 0 0 20px #ccc;
        background-size: 100% 100%;
        border-radius: 7px;
        background-color: #ffffff;
    }

    .user-message {
        padding: 15px 0;
        font-size: 14px;
        color: #777;
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

    .img_backgrond .input-group-text {
        background-color: white;
    }

    .fa {
        color: #ced4da;
    }

</style>

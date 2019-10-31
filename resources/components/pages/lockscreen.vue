<template>
    <div class="container-fluid img_backgrond">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 login-content mt-5">
                <div class="row">
                    <div class="col-lg-12 col-12 mt-4">
                        <h2 class="text-center">
                            <img width="200px" src="~img/socialhub/logo-social-hub.png" alt="Logo">
                        </h2>
                    </div>
                    <div class="col-lg-12 col-12 mt-4">
                        <h3 class="page-name text-center">
                            <img width="120px" src="~img/socialhub/login.png" class="rounded-circle">
                        </h3>
                    </div>
                </div>
                <vue-form :state="formstate" @submit.prevent="onSubmit">
                    <div class="col-sm-12">
                        <validate tag="div">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                </div>
                                <input v-model="model.password" name="password" type="password" required placeholder="Senha" class="form-control" minlength="4" maxlength="10" />
                            </div>


                            <field-messages name="password" show="$invalid && $submitted" class="text-danger">
                                <div slot="required">A senha é obrigatória</div>
                                <div slot="minlength">A senha deve ter pelo menos 4 carateres</div>
                                <div slot="maxlength">A senha deve ter máximo 10 carateres</div>
                            </field-messages>
                        </validate>
                    </div>
                    <div class="col-12 mt-4 mb-5">
                        <div class="form-group">
                            <input type="submit" value="Desbloquear" class="btn btn-primary btn-block" />
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
    Vue.use(VueForm, options);
    export default {
        name: "lockscreen",
        data() {
            return {
                formstate: {},
                model: {
                    password: ''
                }
            }
        },
        methods: {
            onSubmit() {
                if (this.formstate.$invalid) {
                    return;
                } else {
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
                    this.$router.push({name: link});
                }
            },
        },
        mounted: function () {
        },
        destroyed: function () {

        }
    }
</script>
<style scoped>
    .login-content {
        margin-top: 8%;
        margin-bottom: 7%;
        box-shadow: 0 0 30px #ccc;
        background-size: 100% 100%;
        background-color: #ffffff;
    }

    .user-img {
        margin-bottom: 10px;
    }

    .img_backgrond {
        /* background-image: url("../../img/pages/Login-03-01.png"); */
        background-image: url("../../img/socialhub/background2.jpg");
        background-size: cover;
        height: 100vh;
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
    .fa{
        color: #ced4da;
    }
</style>

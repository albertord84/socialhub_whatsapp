<template>
    <div class="container-fluid img_backgrond">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 login-content mt-5">
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <h2 class="text-center">
                            <img src="~img/logo_black.png" alt="Logo">
                        </h2>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <h3 class="page-name text-center">Reset Password</h3>
                    </div>
                </div>
                <v-layout v-show="errorShow">
                    <span style="color:red; text-align:center;">{{message}}</span>
                </v-layout>
                <v-layout v-show="successShow">
                    <span style="color:green; text-align:center;">{{message}}</span><br>
                    <router-link tag="a" to="/login" class="">Go to Login page</router-link>
                </v-layout>
                <vue-form :state="formstate" @submit.prevent="onSubmit" v-show="!successShow">
                    <input type="hidden"
                            id="token"
                            v-model="model.token"
                            required
                    />
                    <div class="col-md-12">
                        <p class="user-message"> * The Password is case sensitive.</p>
                        <div class="form-group">
                            <validate tag="div">

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                    </div>
                                    <input v-model="model.password" name="password" type="password" required placeholder="Password" class="form-control" minlength="4"
                                           maxlength="10" />
                                </div>


                                <field-messages name="password" show="$invalid && $submitted" class="text-danger">
                                    <div slot="required">Password is required</div>
                                    <div slot="minlength">Password should be atleast 4 characters long</div>
                                    <div slot="maxlength">Password should be atmost 10 characters long</div>
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
                                    <input v-model="model.password_confirmation" name="repeatpassword" type="password" required placeholder="Confirm Password" class="form-control"
                                           :sameas="model.password">
                                </div>


                                <field-messages name="repeatpassword" show="$invalid && $submitted" class="text-danger">
                                    <div slot="required">Password confirmatoin is required</div>
                                    <div slot="sameas">Password and Confirm password should match</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-group">
                            <input type="submit" value="Reset Password" class="btn btn-primary btn-block" />
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
            }
        },
        methods: {
            onSubmit: function () {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    let component = this;
                    component.message = '';
                    ApiService.post('/auth/password_save', this.model)
                        .then(response => {
                            if (!!response.data.success) {
                                component.model = {};
                                component.message = "You can login now with new password!";
                                component.errorShow = false;
                                component.successShow = true;
                                component.showLoginPage = true;
                            } else {
                                component.model.password = '';
                                component.model.password_confirmation = '';
                                component.message = "Some data is not valid!";
                                component.errorShow = true;
                                component.successShow = false;
                                component.showLoginPage = false;
                            }
                        });
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
        background-image: url("../../img/pages/Login-03-01.png");
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

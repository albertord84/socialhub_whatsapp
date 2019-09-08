<template>
    <div class="container-fluid img_backgrond">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 login-content mt-5">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <h2 class="text-center"><img src="~img/logo_black.png" alt="Logo"></h2>
                    </div>
                </div>
                <vue-form :state="formstate" @submit.prevent="onSubmit">
                    <div class="row mx-1">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <validate tag="div">
                                    <label for="name"> Name</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input v-model="model.name" id="name" name="name" type="text"
                                               required autofocus placeholder="Name" class="form-control"/>
                                    </div>
                                    <field-messages name="username" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">Name is a required field</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <div class="col-sm-12">

                            <div class="form-group">
                                <validate tag="div">
                                    <label for="email"> E-mail</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                        </div>
                                        <input v-model="model.email" id="email" name="email" type="email" required
                                               placeholder="E-mail" class="form-control"/>
                                    </div>
                                    <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">Email is a required field</div>
                                        <div slot="email">Email is not valid</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <div class="col-sm-12">



                            <div class="form-group">
                                <validate tag="div">
                                    <label for="password"> Password</label>

                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                        </div>
                                        <input v-model="model.password" id="password" name="password" type="password"
                                               required placeholder="Password" class="form-control" minlength="4"
                                               maxlength="10"/>
                                    </div>



                                    <field-messages name="password" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">Password is required</div>
                                        <div slot="minlength">Password should be atleast 4 characters long</div>
                                        <div slot="maxlength">Password should be atmost 10 characters long</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <validate tag="div">
                                    <label for="confirm_password"> Confirm Password</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                        </div>
                                        <input v-model="model.repeatPassword" name="repeatpassword" id="confirm_password"
                                               type="password" required placeholder="Confirm Password" class="form-control"
                                               :sameas="model.password">
                                    </div>


                                    <field-messages name="repeatpassword" show="$invalid && $submitted"
                                                    class="text-danger">
                                        <div slot="required">Password confirmatoin is required</div>
                                        <div slot="sameas">Password and Confirm password should match</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <validate tag="label">
                                <b-form-checkbox id="terms" v-model="model.terms">I agree the
                                    <span>
                                            <router-link to="/" class="text-info">terms &amp; conditions</router-link>
                                        </span>
                                </b-form-checkbox>
                                <field-messages name="terms" show="$invalid && $submitted" class="text-danger">
                                    <div slot="checkbox">Terms must be accepted</div>
                                </field-messages>
                            </validate>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="submit" value="Sign Up" class="btn btn-block btn-success"/>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12" v-show="show_error">
                            <ul class="list-unstyled">
                                <li class="text-danger" v-for="error in validationErrors">{{error[0]}}</li>
                            </ul>
                        </div>
                        <div class="col-sm-12" v-show="show_success">
                            <ul class="list-unstyled">
                                <li class="text-success">Your details had registered, you can
                                    <router-link tag="a" to="/login" class="">Login</router-link></li>
                            </ul>
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <div class="form-group register-text">
                                Already a member? <router-link tag="a" to="/login" >Sign In</router-link>
                            </div>
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
        name: "register",
        data() {
            return {
                show_error: false,
                show_success: false,
                formstate: {},
                validationErrors: [],
                mail_not_valid: false,
                model: {
                    name: "",
                    email: "",
                    password: '',
                    repeatPassword: '',
                    terms: false
                }
            }
        },
        methods: {
            onSubmit: function () {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    ApiService.post('auth/register', this.model)
                        .then(data => {
                            this.show_error = false;
                            this.show_success = true;
                        })
                        .catch(error => {
                            if (error.response.status == 422){
                                this.validationErrors = error.response.data.errors;
                                this.show_error = true;
                                this.show_success = false;
                            }
                        })
                }
            }
        }
    }
</script>
<style scoped>
    .login-content {
        margin-top: 6%;
        margin-bottom: 6%;
        padding-bottom: 20px;
        box-shadow: 0 0 30px #ccc;
        background-size: 100% 100%;
        border-radius: 7px;
        background-color: #ffffff;
    }

    .img_backgrond {
        background-image: url("../../img/pages/Login-03-01.png");
        background-size: cover;
        padding: 75px 15px;
    }

    .text_gray {
        color: #625e5e;
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
    .register-text{
        font-size:14px;
    }
    /*.custom-checkbox .custom-control-label::before {*/
        /*background-color: #ced4da !important;*/
    /*}*/
    .custom-checkbox label::before {
        background-color: #ced4da !important;
    }
</style>

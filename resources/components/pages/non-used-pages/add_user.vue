<template>
    <div class="row">
        <div class="col-lg-12">
            <b-card header="Add user" header-tag="h4" class="bg-success-card">
                <div class="row">
                    <div class="col-lg-12 col-12 mb-3">
                        <vue-form class="form-horizontal form-validation" :state="formstate" @submit.prevent="onSubmit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <validate tag="div">
                                                <label for="name"> User Name</label>
                                                <input v-model="model.name" id="name" name="username" type="text"
                                                       required autofocus placeholder="User Name" class="form-control"/>
                                                <field-messages name="username" show="$invalid && $submitted"
                                                                class="text-danger">
                                                    <div slot="required">Username is a required field</div>
                                                </field-messages>
                                            </validate>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <validate tag="div">
                                                <label for="email"> E-mail</label>
                                                <input v-model="model.email" name="email" id="email" type="email"
                                                       required placeholder="E-mail" class="form-control"/>
                                                <field-messages name="email" show="$invalid && $submitted"
                                                                class="text-danger">
                                                    <div slot="required">Email is a required field</div>
                                                    <div slot="email">Email is not valid</div>
                                                </field-messages>
                                            </validate>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <validate tag="div">
                                                <label for="password"> Password</label>
                                                <input v-model="model.password" id="password" name="password"
                                                       type="password" required placeholder="Password"
                                                       class="form-control" minlength="4" maxlength="10"/>
                                                <field-messages name="password" show="$invalid && $submitted"
                                                                class="text-danger">
                                                    <div slot="required">Password is required</div>
                                                    <div slot="minlength">Password should be atleast 4 characters long
                                                    </div>
                                                    <div slot="maxlength">Password should be atmost 10 characters long
                                                    </div>
                                                </field-messages>
                                            </validate>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <validate tag="div">
                                                <label for="repeatpassword"> Confirm Password</label>
                                                <input v-model="model.repeatPassword" id="repeatpassword"
                                                       name="repeatpassword" type="password" required
                                                       placeholder="Confirm Password" class="form-control"
                                                       :sameas="model.password">
                                                <field-messages name="repeatpassword" show="$invalid && $submitted"
                                                                class="text-danger">
                                                    <div slot="required">Confirm password is required</div>
                                                    <div slot="sameas">Password and Confirm password should match</div>
                                                </field-messages>
                                            </validate>
                                        </div>
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
                                <div class="col-md-offset-4 col-md-8 m-t-25">
                                    <button type="submit" class="btn btn-primary">Submit
                                    </button>
                                    <button type="reset" class="btn btn-effect-ripple btn-secondary  reset_btn1"
                                            @click="form_reset">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </vue-form>
                    </div>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "resources/common/api.service";

    Vue.use(VueForm, options);
    export default {
        name: "add_user",
        data() {
            return {
                formstate: {},
                model: {
                    name: "",
                    email: "",
                    password: "",
                    repeatPassword: "",
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
                    username: "",
                    email: "",
                    password: "",
                    repeatPassword: "",
                };
            }
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
</style>

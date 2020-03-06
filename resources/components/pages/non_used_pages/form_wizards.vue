<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <b-card class="mb-2 bg-default-card" header="Form Wizards" header-tag="h4">
                    <form-wizard @on-complete="onComplete"
                                 :start-index="0"
                                 color="#e67e22">
                        <tab-content title="Personal details" icon="fa fa-user">
                            <div class="form-group">
                                <label for="step_fname" class="control-label">First Name</label>
                                <input id="step_fname" maxlength="100" type="text" class="form-control"
                                       placeholder="Enter First Name"/>
                            </div>
                            <div class="form-group">
                                <label for="step_lname" class="control-label">Last Name</label>
                                <input id="step_lname" maxlength="100" type="text" class="form-control"
                                       placeholder="Enter Last Name"/>
                            </div>
                            <div class="form-group">
                                <label for="step_email" class="control-label">Email</label>
                                <input id="step_email" maxlength="100" type="email" class="form-control"
                                       placeholder="Enter Email Address"/>
                            </div>
                            <div class="form-group">
                                <label for="step_cemail" class="control-label">Confirm Email</label>
                                <input id="step_cemail" maxlength="100" type="email"
                                       class="form-control"
                                       placeholder="Re-enter Your Email"/>
                            </div>
                        </tab-content>
                        <tab-content title="Additional Info"
                                     icon="fa fa-cog" >
                            <div class="form-group">
                                <label for="step_cname" class="control-label">Company Name</label>
                                <input id="step_cname" maxlength="200" type="text" class="form-control"
                                       placeholder="Enter Company Name"/>
                            </div>
                            <div class="form-group">
                                <label for="step_cadd" class="control-label">Company Address</label>
                                <input id="step_cadd" maxlength="200" type="text" class="form-control"
                                       placeholder="Enter Company Address"/>
                            </div>
                            <div class="form-group">
                                <label for="step_pwd" class="control-label">Password</label>
                                <input id="step_pwd" maxlength="12" type="password" class="form-control"
                                       placeholder="Enter password"/>
                            </div>
                            <div class="form-group">
                                <label for="step_cpwd" class="control-label">Confirm Password</label>
                                <input id="step_cpwd" maxlength="12" type="password"
                                       class="form-control"
                                       placeholder="Confirm password"/>
                            </div>
                        </tab-content>
                        <tab-content title="Last step"
                                     icon="fa fa-check">
                            <div class="form-group">
                                <b-form-checkbox>I agree with the <a  href="javascript:void(0)">terms &amp; Conditions</a></b-form-checkbox>
                            </div>
                        </tab-content>
                    </form-wizard>
                </b-card>

            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import VueFormWizard from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    Vue.use(VueFormWizard)
    export default {
        name: "formwizards",
        mounted:function(){
        },

        methods: {
            onComplete: function(){
                alert('Yay. Done!');
            }
        }
    }

</script>
<style  src="../../css/vue_wizard.css" ></style>


<template>
    <div class="">
            <div class="col-lg-12 sect_header">
                <ul class="menu">
                    <li><a href="javascript:void(0)" @click.prevent="toggle_left()"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                    <li><p>Filtrar contatos</p> </li>
                    <ul class="menu float-right">
                        <li ><a href="javascript:void(0)" @click.prevent="toggle_left()"><i class="fa fa-close"></i></a></li>
                    </ul>
                </ul>
            </div>
            <vue-form class="col-lg-12 form-horizontal form-validation filter-text" :state="formstate" @submit.prevent="onSubmit">
                <div class="form-group p-10">
                    <label class="control-label col-md-4"></label>
                    <label class="control-label col-md-4">Ordenar:</label>
                    <div class=" col-md-12 col-md-offset-2">
                        <b-form-group>
                            <b-form-radio v-model="selected" name="some-radios" value="A">Adhesões recentes</b-form-radio>
                            <b-form-radio v-model="selected" name="some-radios" value="B">Adhesões antigas</b-form-radio>
                            <b-form-radio v-model="selected" name="some-radios" value="C">Conversas recentes</b-form-radio>
                            <b-form-radio v-model="selected" name="some-radios" value="D">Conversas antigas</b-form-radio>
                        </b-form-group>
                    </div>
                </div>
                <hr>
                <div class="form-group p-10">                    
                    <label class="control-label col-md-4">Status:</label>
                    <div class="col-md-12 col-md-offset-2">
                        <div class="checkbox"><b-form-checkbox checked="false" >Todos</b-form-checkbox></div>
                        <div class="checkbox"><b-form-checkbox checked="false" >Ativos</b-form-checkbox></div>
                        <div class="checkbox"><b-form-checkbox checked="false" >Prioridade</b-form-checkbox></div>
                        <div class="checkbox"><b-form-checkbox checked="false" >Seguimento</b-form-checkbox></div>
                        <div class="checkbox"><b-form-checkbox checked="false">Inativos</b-form-checkbox></div>                        
                        <div class="checkbox"><b-form-checkbox checked="false">Transferidos</b-form-checkbox></div>                        
                        <div class="checkbox"><b-form-checkbox checked="false">Encerrados</b-form-checkbox></div>
                    </div>
                </div>
                <hr>
                <div class="form-group p-10">
                    <label class="control-label">Rede Social:</label>
                    <div class=" col-md-12 col-md-offset-2">
                        <div class="checkbox"><b-form-checkbox checked="true">Whatsapp</b-form-checkbox></div>
                        <div class="checkbox"><b-form-checkbox checked="false">Messenger</b-form-checkbox></div>                        
                        <div class="checkbox"><b-form-checkbox checked="false">Directs</b-form-checkbox></div>                        
                        <div class="checkbox"><b-form-checkbox checked="false">LinkedIn</b-form-checkbox></div>                        
                    </div>
                </div>
                
                <div class="col-lg-12 m-t-25 text-center">
                    <button type="submit" class="btn btn-primary btn_width">Filtrar</button>
                    <button type="reset" class="btn btn-effect-ripple btn-secondary  reset_btn1 btn_width" @click.prevent="form_reset();toggle_left()">Cancelar</button>
                </div>
            </vue-form>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "resources/common/api.service";

    Vue.use(VueForm, options);
    export default {
        name: "filter_user",
        data() {
            return {
                userLogged:{},
                formstate: {},
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
            toggle_left() {
                this.$store.commit('leftside_bar', "toggle");
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
    .filter-text checkbox b-form-checkbox {
        font-size: 8px;
        color: gray;
    }
    .btn_width{
        width: 100px
    }
    
</style>

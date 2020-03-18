<template>
    <div class=""> 
        <form class="col-lg-12 form-horizontal form-validation" :state="formstate" style="background-color:white">
            
            <div class="col-lg-12">
                <div class="form-group">
                    <div style="" class="form-group has-search">
                        <span class="mdi mdi-email-outline form-control-feedback"></span>
                        <input v-model="model.email" name="email" id="email" type="text" placeholder="Email" class="form-control"/>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 mt-2 text-center">
                <button v-if='action=="insert"' type="button" class="btn btn-primary btn_width" :disabled='isSending || !whatssapChecked' @click.prevent="addContact"> <i v-show="isSending==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Adicionar</button>
                <button v-if='action=="edit"' type="button" class="btn btn-primary btn_width" :disabled='isSending' @click.prevent="updateContact"> <i v-show="isSending==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar</button>
                <button type="reset"  class="btn btn-effect-ripple btn-secondary btn_width reset_btn1" @click.prevent="formReset();toggle_left('close')">Cancelar</button>
            </div>
        </form>
        
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "resources/common/api.service";    
    import miniToastr from "mini-toastr";
    miniToastr.init();

    import validation from "src/common/validation.service";

    Vue.use(VueForm, options);
    export default {
        name: "add_user",
        props:{
            item:{},
        },

        data() {
            return {
                userLogged:{},
                attendantsContactsUrl:'attendantsContacts',  //route to controller
                newAtendantContactId: null,
                isSendingNwwAtendantContact: false,
            }
        },

        methods: {
            getAttendants: function(){

            },
            
            transferContact(){
                ApiService.delete(this.url+'/'+this.item.id)
                    .then(response => {                        
                        miniToastr.success("Contato eliminado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url, "delete");
                    });  
            },            
            
            formCancel(){
                this.$emit('onclosemodal');
            }, 

            reload(){
                this.$emit('reloadContacts');
            },

            editclose() {                
               this.$emit('onclose');
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

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
            this.getAttendants();
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
      
</style>

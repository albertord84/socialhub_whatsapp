<template>
    <b-container fluid>                
        <form v-show="action!='delete'">

            <h4>Dados do cliente</h4>
            
            <div class="row">
                <div  class="col-lg-6 form-group has-search">
                    <span class="fa fa-user form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.nome" title="Ex: Nome do cliente" id="name" name="name" type="text" autofocus placeholder="Nome do cliente" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-user form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.id" id="clientID" title="Ex: 88888888" name="clientID" type="text" placeholder="ID do cliente" class="form-control"/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.email" title="Ex: cliente@gmail.com" name="email" id="email" type="email" placeholder="Email" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-phone form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.fone" id="phone" title="Ex: 55 1188888888" name="phone" type="text" placeholder="Telefone" class="form-control"/>
                </div>
            </div>

            
            <div class="col-lg-12 m-t-25 text-center">
                <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateSale">
                    <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                </button>
                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="formCancel">Cancelar</button>
            </div>

        </form>

        <form v-show="action=='delete'">
            Tem certeza que deseja remover essa venda?
            <div class="col-lg-12 mt-5 text-center">
                <button type="submit" class="btn btn-primary btn_width" :disabled="isSendingDelete==true" @click.prevent="deleteSales">
                    <i v-show="isSendingDelete==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Eliminar
                </button>

                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="formCancel">Cancelar</button>
            </div>                    
        </form>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../../common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import validation from "src/common/validation.service";

    
    export default {
        name: 'managerCRUDBlingSales',

        props: {
            url:'', //sales controller url 
            action:"",
            item:{},
        },

        components:{
        },

        data(){
            return{
                sales_id: "",
                model:{ },

                //---------New record properties-----------------------------
                
                // isSendingInsert: false,
                isSendingUpdate: false,
                isSendingDelete: false,

                // flagReference: true,
            }
        },

        methods:{
                        
            editSale: function() { //U
                
                this.model = Object.assign({}, this.item);
                console.log(this.model.json_data);
                return;
                delete this.model.created_at;
                delete this.model.updated_at;
                delete this.model.deleted_at;
                // this.modalEditContact = !this.modalEditContact;
            },

            updateSale: function() { //U

                this.isSendingUpdate = true;

                // Validando dados
                // this.trimDataModel();
                // this.validateData();
                // if (this.flagReference == false){
                //     miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                //     this.isSendingUpdate = false;
                //     this.flagReference = true;
                //     return;
                // }
                 
                delete this.model.json_data.itensInHTML;
                delete this.model.messageSended;
                delete this.model.created_at;
                delete this.model.updated_at;
                delete this.model.deleted_at;

                this.model.json_data = JSON.stringify(this.model.json_data);

                ApiService.put(this.url+'/'+this.model.id, this.model) 
                    .then(response => {

                        miniToastr.success("Venda atualizada com sucesso","Sucesso");
                            this.reload();
                            this.closeModals();
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url, "update");
                    })
                    .finally(() => this.isSendingUpdate = false); 
            },


            deleteSales: function() { //D
                
                this.isSendingDelete = true;

                ApiService.delete(this.url+'/'+this.model.id)
                    .then(response => {                        
                        miniToastr.success("Venda eliminada com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url, "delete");
                    })
                    .finally(() => this.isSendingDelete = false);                   
            },





            //------ auxiliary methods--------------------
      

            formCancel(){
                this.$emit('modalclose');
            }, 
            
            reload(){
                this.$emit('onreloaddatas');
            }, 



            // trimDataModel: function(){
            //     if(this.model.first_name) this.model.first_name = this.model.first_name.trim();
            //     if(this.model.last_name) this.model.last_name = this.model.last_name.trim();
            //     if(this.model.email) this.model.email = this.model.email.trim();
            //     if(this.model.phone) this.model.phone = this.model.phone.trim();
            //     if(this.model.whatsapp_id) this.model.whatsapp_id = this.model.whatsapp_id.trim();
            //     if(this.model.facebook_id) this.model.facebook_id = this.model.facebook_id.trim();
            //     if(this.model.instagram_id) this.model.instagram_id = this.model.instagram_id.trim();
            //     if(this.model.linkedin_id) this.model.linkedin_id = this.model.linkedin_id.trim();
            //     if(this.model.remember) this.model.remember = this.model.remember.trim();
            //     if(this.model.summary) this.model.summary = this.model.summary.trim();
            //     if(this.model.description) this.model.description = this.model.description.trim();
            // },

            // validateData: function(){
            //     // Validação dos dados do contato
            //     var check;
            //     if(this.model.first_name && this.model.first_name !=''){
            //         check = validation.check('complete_name', this.model.first_name)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }else{
            //         miniToastr.error("Erro", "O nome do contato é obrigatório" );
            //         this.flagReference = false;
            //     }
            //     if(this.model.email && this.model.email !=''){
            //         check = validation.check('email', this.model.email)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }
            //     if(this.model.phone && this.model.phone !=''){
            //         check = validation.check('phone', this.model.phone)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }
            //     if(this.model.whatsapp_id && this.model.whatsapp_id !=''){
            //         check = validation.check('whatsapp', this.model.whatsapp_id)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }else{
            //         miniToastr.error("Erro", "O whatsapp do contato é obrigatório" );
            //         this.flagReference = false;
            //     }
            //     if(this.model.facebook_id && this.model.facebook_id !=''){
            //         check = validation.check('facebook_profile', this.model.facebook_id)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }
            //     if(this.model.instagram_id && this.model.instagram_id !=''){
            //         check = validation.check('instagram_profile', this.model.instagram_id)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }
            //     if(this.model.linkedin_id && this.model.linkedin_id !=''){
            //         check = validation.check('linkedin_profile', this.model.linkedin_id)
            //         if(check.success==false){
            //             miniToastr.error("Erro", check.error );
            //             this.flagReference = false;
            //         }
            //     }
            // },




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
            }

        },

        beforeUpdate(){
            },

        mounted(){
            this.editSale();            
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
    .pagination {
        margin-top: 12px;
    }

    .sortable {
        cursor: pointer;
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
    .has-search-color{
        color: #aaa;
    }
    .btn_width{
        width: 100px
    }
    .text-18{
        font-size: 18px
    }
</style>

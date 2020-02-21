<template>
    <b-container fluid>                
        <form v-show="action!='delete'">

            <h4>Dados do cliente</h4>
            
            <div class="row">
                <div  class="col-lg-6 form-group has-search">
                    <span class="fa fa-user form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.nome" title="Nome do cliente" id="name" name="name" type="text" autofocus placeholder="Nome do cliente" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-user form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.id" id="clientID" title="Identificador do cliente" name="clientID" type="text" disabled="" placeholder="ID do cliente" class="form-control"/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.email" title="Email do cliente" name="email" id="email" type="email" placeholder="Email" class="form-control"/>
                </div>
                <div class="col-lg-6 form-group has-search">
                    <span class="fa fa-phone form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.cliente.fone" id="phone" v-mask="'55 ############'" title="Telefone do cliente" name="phone" type="text" placeholder="Telefone" class="form-control"/>
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
                modelContact:{ },

                url_contact:'contacts',  //route to controller
                //---------New record properties-----------------------------
                
                // isSendingInsert: false,
                isSendingUpdate: false,
                isSendingDelete: false,

                flagReference: true,
            }
        },

        methods:{
                        
            editSale: function() { //U
                
                this.model = Object.assign({}, this.item);

                delete this.model.created_at;
                delete this.model.updated_at;
                delete this.model.deleted_at;

                ApiService.get(this.url_contact+'/'+this.model.contact_id) 
                    .then(response => {
                        this.modelContact = response.data;
                    })
                    .catch(error => {
                        this.processMessageError(error, this.url_contact, "get");
                    });
            },

            updateSale: function() { //U

                this.isSendingUpdate = true;

                // Validando dados
                this.trimDataModel();
                this.validateData();
                if (this.flagReference == false){
                    miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                    this.isSendingUpdate = false;
                    this.flagReference = true;
                    return;
                }
                
                this.modelContact.first_name = this.model.json_data.pedido.cliente.nome;
                this.modelContact.email = this.model.json_data.pedido.cliente.email;
                this.modelContact.whatsapp_id = this.model.json_data.pedido.cliente.fone;
                delete this.modelContact.created_at;
                delete this.modelContact.updated_at;
                delete this.modelContact.deleted_at;

                delete this.model.json_data.itensInHTML;
                delete this.model.messageSended;
                delete this.model.created_at;
                delete this.model.updated_at;
                delete this.model.deleted_at;
                this.model.json_data = JSON.stringify(this.model.json_data);

                ApiService.put(this.url+'/'+this.model.id, this.model) 
                    .then(response => {

                        miniToastr.success("Venda atualizada com sucesso","Sucesso");

                        ApiService.put(this.url_contact+'/'+this.model.contact_id, this.modelContact) 
                            .then(response => {
                                miniToastr.success("Contato atualizado com sucesso","Sucesso");
                                this.reload();
                                this.closeModals();
                            })
                            .catch(error => {
                                this.processMessageError(error, this.url_contact, "update");
                                this.isSendingUpdate = false;
                            });

                    })
                    .catch(error => {
                        this.processMessageError(error, this.url, "update");
                        this.isSendingUpdate = false;
                    });

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

            trimDataModel: function(){
                if(this.model.json_data.pedido.cliente.nome) this.model.json_data.pedido.cliente.nome = this.model.json_data.pedido.cliente.nome.trim();
                if(this.model.json_data.pedido.cliente.email) this.model.json_data.pedido.cliente.email = this.model.json_data.pedido.cliente.email.trim();
                if(this.model.json_data.pedido.cliente.fone) this.model.json_data.pedido.cliente.fone = this.model.json_data.pedido.cliente.fone.trim();
            },

            validateData: function(){
                // Validação dos dados do contato
                var check;
                if(this.model.json_data.pedido.cliente.nome && this.model.json_data.pedido.cliente.nome !=''){
                    check = validation.check('complete_name', this.model.json_data.pedido.cliente.nome)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }

                // if(this.model.json_data.pedido.cliente.email && this.model.json_data.pedido.cliente.email !=''){
                //     check = validation.check('email', this.model.json_data.pedido.cliente.email)
                //     if(check.success==false){
                //         miniToastr.error("Erro", check.error );
                //         this.flagReference = false;
                //     }
                // }
                
                if(this.model.json_data.pedido.cliente.fone && this.model.json_data.pedido.cliente.fone !=''){
                    check = validation.check('phone', this.model.json_data.pedido.cliente.fone)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O telefone do contato é obrigatório" );
                    this.flagReference = false;
                }
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

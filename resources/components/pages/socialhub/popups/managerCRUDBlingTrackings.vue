<template>
    <b-container fluid>                
        <form v-if="action!='delete'">

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

            <h4>Dados da venda</h4>

            <div class="row">
                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.vendedor" id="vendedor" title="Ex: Nome do vendedor" name="vendedor" type="text" placeholder="Nome do vendedor" class="form-control"/>
                </div>

                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.situacao" id="situacao" title="Ex: Em aberto" name="situacao" type="text" placeholder="Situação da venda" class="form-control"/>
                </div>
                
                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.data" id="data" title="Ex: 31/12/2020" name="data" type="text" placeholder="Data da venda" class="form-control"/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.tipoIntegracao" id="tipoIntegracao" title="Ex: MercadoLivre" name="tipoIntegracao" type="text" placeholder="Tipo de Integracão" class="form-control"/>
                </div>
                
                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.loja" id="loja" title="Ex: 88888888" name="loja" type="text" placeholder="Loja" class="form-control"/>
                </div>

                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.numeroPedidoLoja" id="numeroPedidoLoja" title="Ex: 88888888" name="numeroPedidoLoja" type="text" placeholder="Número de Pedido da Loja" class="form-control"/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.numeroOrdemCompra" id="numeroOrdemCompra" title="Ex: 88888888" name="numeroOrdemCompra" type="text" placeholder="Número de Ordem de Compra" class="form-control"/>
                </div>

                <div class="col-lg-8 form-group has-search">
                    <span class="fa fa-id-card form-control-feedback"></span>
                    <input v-model="model.json_data.pedido.itens" id="produtos" title="Ex: 88888888" name="produtos" type="text" placeholder="Produtos comprados" class="form-control"/>
                </div>
            </div>

            
            <div class="col-lg-12 m-t-25 text-center">
                <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateSale">
                    <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                </button>
                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="formCancel">Cancelar</button>
            </div>

        </form>

        <form v-if="action=='delete'">
            Tem certeza que deseja remover esse envio?
            <div class="col-lg-12 mt-5 text-center">
                <button type="submit" class="btn btn-primary btn_width" :disabled="isSendingDelete==true" @click.prevent="deleteTracking">
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
        name: 'managerCRUDBlingTrackings',

        props: {
            action:"",
            item:{},
        },

        components:{
        },

        data(){
            return{
                url: 'trackings',
                userLogged:{},
                sales_id: "",
                model:{},
                isSendingUpdate: false,
                isSendingDelete: false,
            }
        },

        methods:{

            deleteTracking: function() { //D                
                this.isSendingDelete = true;
                // alert(this.url+'/'+this.item.id);
                ApiService.delete(this.url+'/'+this.item.id)
                    .then(response => {                        
                        miniToastr.success("Envio eliminado com sucesso","Sucesso");
                        this.reload();
                        this.formCancel();
                    })
                    .catch(error => {
                        console.log(error);
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
        },

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
            console.log(this.item);
        },

        mounted(){        
            if(this.userLogged.role_id > 3){
                this.$router.push({name: "login"});
            }    
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

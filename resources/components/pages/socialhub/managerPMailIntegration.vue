<template>
    <div class="card p-3 no-shadows">
        <form-wizard    title = '' subtitle = '' backButtonText = 'Voltar' nextButtonText = 'Seguinte'  finishButtonText = 'Finalizar' stepSize = 'xs' color = "#20a0ff">
            <template v-slot:backButtonText>
                <h2>title hola mundo.com</h2>
            </template>
            <tab-content title="Informação" :beforeChange='steepInformation'>
                <hr>
                    <div class="pt-3 pl-5 pr-5">
                        <h4 style="color:#34AD70">Porque integrar com os Correios?</h4>
                        <p class="text-justify pl-4">
                            Essa funcionalidade é ideal para quem vende mercadorias e faz entregas a través dos <a href="http://www.correios.com.br/" target="_blank" rel="noopener noreferrer">Correios</a>.
                            <br><br>
                            A integração de <b>SocialHUB</b> com os <a href="http://www.correios.com.br/" target="_blank" rel="noopener noreferrer">Correios</a> lhe permite: <br> 
                            <ul class="pl-4">
                                <li class="mb-2"> 1) Monitorar automáticamente todos seus envios;</li>
                                <li class="mb-2"> 2) Notificar a você e seus atendentes com as últimas ocorrências dos seus envios;</li>
                                <li class="mb-2"> 3) Receber alertas por tipo de ocorrência: objeto mal encaminhado, não atendido, fiscalização, extraviado, endereço insuficiente, etc...;</li>
                                <li class="mb-2"> 4) Abrir e reabrir automaticamente seus Pedidos de Indemnização (PI)) nos Correios tanto em caso de atraso quanto em caso de extravio para que você não perca do prazo de 30 dias para reembolso;</li>
                                <li class="mb-2"> 5) Enviar mensagens por whatsapp ou e-mail com o status da entrega aos seus clientes com layouts de mensagens personalisados por você; e</li>
                                <li class="mb-2"> 6) E muito importante, um Dashboard e Relatórios de Performance à sua disposição.</li>
                            </ul>
                        </p>
                    </div>
                    <div class="pt-4 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Pré-requisitos para a integração</h4>
                        <p class="text-justify pl-4">
                            - Ter uma conta nos <a href="http://www.correios.com.br/" target="_blank" rel="noopener noreferrer">Correios</a> que gerencie seus envios.
                        </p>
                    </div>
                <hr>
            </tab-content>

            <tab-content title="Configuração das contas" :beforeChange='steepPMailAccounts'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração das contas a serem monitoradas</h4>
                        <p class="pl-4"> Aqui você deve informar as suas contas nos <a href="http://www.correios.com.br/" target="_blank" rel="noopener noreferrer">Correios</a>  que deseja que sejam monitoradas.
                        </p>

                    </div>
                    <div class="row pl-5 pr-5 pb-3">
                        <div class="col-3"></div>                        
                        <div class="col-6">
                            <b-card header="Personalize a mensagem" header-tag="h4" class="bg-default-card no-shadows">
                                <template v-slot:header>
                                    <h6 class="mb-0" style="float:left">Dados de acesso da conta</h6>                                    
                                </template>
                                <form @submit.prevent="addPMailAccount">
                                    <div class="p-3">
                                        <label for="username">Nome de usuário nos Correios</label>
                                        <input type="text" ref="username" v-model="username" class="w-100 p-1" placeholder="Login nos Correios" required>
                                    </div>
                                    <div class="p-3">
                                        <label for="password">Senha nos Correios</label>
                                        <input type="text" ref="password" v-model="password" class="w-100 p-1" placeholder="Senha nos Correios" required>
                                    </div>
                                    <!-- <div class="p-3 text-center">
                                        <button type="submit" style="background-color: rgb(32, 160, 255); color:white; font-size: 14px;font-weight: 600;padding: 6px 12px;min-width: 140px;" class="btn pl-4 pr-4">
                                            <i v-if="isAddingPMailAccount" class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                            Adiconar
                                        </button>
                                    </div> -->
                                </form>
                            </b-card>
                        </div>
                        <div class="col-3"></div>
                        <!-- <div class="col-6">
                            <b-card header="Palavras chaves" header-tag="h4" class="bg-default-card no-shadows" style="padding:0px !important; margin:0px !important">
                                <template v-slot:header>
                                    <h6 class="mb-0" style="float:left">Contas adicionadas</h6>
                                </template>
                                <managerPMailAddedAccounts :rows="pmailAccounts" @onreload="reloadPMailAccounts"></managerPMailAddedAccounts>
                            </b-card>
                        </div> -->
                    </div>                    
                <hr>
            </tab-content>

            <tab-content title="Configurar mensagem" :beforeChange='steepLayoutMessage'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração da Mensagem</h4>
                        <p class="pl-4">Personalize a mensagem que deseja enviar aos seus cliente após cada pedido de vendas.
                            A mensagem pode conter palavras chaves precedidas do símbolo <b>@</b>, as que serão substituídas 
                            pela informação contida no pedido de venda. 
                        </p>
                    </div>
                    <div class="row pl-5 pr-5 pb-3">
                        <div class="col-8">
                            <b-card  header="Personalize a mensagem" header-tag="h4" class="bg-default-card no-shadows">
                                <template v-slot:header>
                                    <h6 class="mb-0" style="float:left">Personalize a mensagem</h6>
                                    <h6 class="mb-0" style="float:right">
                                        <i class="fa fa-refresh hover text-muted" title="Reiniciar mensagem" aria-hidden="true" @click.prevent="resetDefaultMessage"></i>
                                    </h6>
                                </template>
                                <textarea ref="text_message" v-model="message" style="width:100%; height:300px; resize: none" class="border-0" name="" id="" rows="14" spellcheck="false"></textarea>
                            </b-card>
                        </div>
                        <div class="col-4">
                            <b-card header="Palavras chaves" header-tag="h4" class="bg-default-card no-shadows" style="padding:0px !important; margin:0px !important">
                                <div style="height:300px; overflow-x:hidden; overflow-y:auto"  class="pl-4 pl-0">                                    
                                    <div class="row header">Do pedido</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@desconto')">@desconto</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_observacoes')">@pedido_observacoes</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_data')">@pedido_data</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_vendedor')">@pedido_vendedor</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_valorfrete')">@pedido_valorfrete</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_totalprodutos')">@pedido_totalprodutos</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_totalvenda')">@pedido_totalvenda</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_situacao')">@pedido_situacao</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@pedido_dataPrevista')">@pedido_dataPrevista</div>
                                    <div class="row header">Do cliente</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_nome')">@cliente_nome</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_cnpj')">@cliente_cnpj</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_cpf')">@cliente_cpf</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_ie')">@cliente_ie</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_rg')">@cliente_rg</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_endereco')">@cliente_endereco</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_numero')">@cliente_numero</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_complemento')">@cliente_complemento</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_cidade')">@cliente_cidade</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_bairro')">@cliente_bairro</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_cep')">@cliente_cep</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_email')">@cliente_email</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_celular')">@cliente_celular</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@cliente_fone')">@cliente_fone</div>
                                    <div class="row header">Dos itens</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_codigo')">@item_codigo</div>
                                        <div class="row reserved-word" @click.prevent="insdescontoertReservedWord('@item_descricao')">@item_descricao</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_quantidade')">@item_quantidade</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_valorunidade')">@item_valorunidade</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_precocusto')">@item_precocusto</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_descontoItem')">@item_descontoItem</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_un')">@item_un</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_pesoBruto')">@item_pesoBruto</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_largura')">@item_largura</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_altura')">@item_altura</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_profundidade')">@item_profundidade</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_unidadeMedida')">@item_unidadeMedida</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@item_descricaoDetalhada')">@item_descricaoDetalhada</div>
                                    <div class="row header">Endereço-entrega</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_nome')">@entrega_nome</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_endereco')">@entrega_endereco</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_numero')">@entrega_numero</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_complemento')">@entrega_complemento</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_cidade')">@entrega_cidade</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_bairro')">@entrega_bairro</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_cep')">@entrega_cep</div>
                                        <div class="row reserved-word" @click.prevent="insertReservedWord('@entrega_uf')">@entrega_uf</div>
                                </div>
                            </b-card>
                        </div>
                    </div>
                <hr>
            </tab-content>

            <tab-content title="Fim da integração" :beforeChange='steepEnd'>
                <div class="mt-5 mb-5 pt-5 pb-5 text-center">
                    <h4 style="color:#34AD70; text-align: left; margin-left:100px">
                        Parabéns {{userLogged.name}}, <br><br> sua integração com os Correios foi concluída!
                    </h4>
                </div>
            </tab-content>

        </form-wizard>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../common/api.service";
    import managerPMailAddedAccounts from "./managerPMailAddedAccounts.vue";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    
    export default {
        name: 'managerPMailIntegration',
        
        components:{
            FormWizard,
            TabContent,
            managerPMailAddedAccounts
        },

        data(){
            return{
                userLogged:{},
                pmail_accounts_url:"contacts", // "pmail_accounts_url",
                message:"",
                defaultMessage:"",                
                username:'',
                password:'',
                pmailAccounts:[],
                isAddingPMailAccount:false,
            }
        },

        methods:{
            addPMailAccount(){
                alert("Adicionando conta"); return; //TODO: eliminar

                this.isAddingPMailAccount =true;
                ApiService.post(this.pmail_accounts_url, {
                    "company_id":this.userLogged.company_id,
                    "username":this.username,
                    "password":this.password
                })
                .then(response => {
                    miniToastr.success("Mensagem enviada com sucesso","Sucesso");
                    this.username = "";
                    this.password = "";
                    this.reloadPMailAccounts();
                })
                .catch(error => {
                    this.processMessageError(error, this.url, "update");//TODO: EGBERTO
                })
                .finally(()=>{
                    this.isAddingPMailAccount =false;
                });
            },

            reloadPMailAccounts(){
                ApiService.get(this.pmail_accounts_url, this.userLogged.company_id) 
                .then(response => {
                    this.pmailAccounts = response.data;
                })
                .catch(error => {
                    this.processMessageError(error, this.url, "update");//TODO: EGBERTO
                })
                .finally(()=>{
                });                
            },

            steepInformation(){
                return true;
            },

            steepPMailAccounts(){
                if(this.pmailAccounts.length==0){                    
                    miniToastr.warn("Atenção", "Deve inserir pelo menos uma conta dos Correios");  
                    return false;
                }else{
                    return true;
                }
            },

            steepLayoutMessage(){
                return true; //TODO: elimninar
                let textarea = this.$refs.text_message;
                this.message = textarea.value;
                if(this.message.trim().length==0){                    
                    miniToastr.warn("Atenção", "Deve configurar uma mensagem template para ser enviada aos seus clientes");  
                    reject(false);
                    return false;
                }else{
                    return new Promise((resolve, reject) => {                    
                        //update company and create the respective sales table
                        ApiService.post(this.bling_url, {
                            "company_id":this.userLogged.company_id,
                            "bling_apikey":this.apikey,
                            "bling_message":this.message,
                            // "blingtoken":'',
                        })
                        .then(response => {
                                resolve(true);
                        })
                        .catch(error => {
                            this.processMessageError(error, this.bling_url, "add");
                            reject(false);
                        });
                    });
                }
            },

            steepEnd(){
                miniToastr.success("Integração realizada com sucesso","Sucesso");
                return true;
            },

            insertReservedWord(str){
                let textarea = this.$refs.text_message;
                var position = textarea.selectionStart;
                var before = this.message.substring(0, position);
                var after = this.message.substring(position, this.message.lenght);
                this.message = before + ' ' + str + ' ' + after;
                textarea.selectionStart = (before + ' ' + str).length;
            },

            resetDefaultMessage(){
                let textarea = this.$refs.text_message;
                this.message = this.defaultMessage;
                textarea.value = this.message;
            },

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
            this.reloadPMailAccounts();
        },

        mounted(){
            this.defaultMessage = "Olá, @cliente_nome \n\n"+
            "Obrigado pela compra do produto @item_descricao.\n"+
            "Quantidade de ítens: @item_quantidade.\n\n"+
            "O endereço de entrega informado é rua @entrega_endereco, número @entrega_numero.\n\n"+
            "Em caso de dúvidas, problemas ou sugestões nos contate diretamente pelo nosso whatsapp ou pela Central de Atendimento, para um suporte ágil e eficaz."+
            "Horário de atendimento: De Segunda a Sexta das 07:00 as 15:30 e Sábados das 08:00 as 13:00.\n\n"+
            "Atte. Equipe Coffee Business.";
            this.message = this.defaultMessage;
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
    .w-400{
        width: 40rem;
    }
    .header{        
        background-color: #fafaff;
        padding: 5px;
        font-size: 1.2rem;
        font-weight: bold;
    }
    .reserved-word{
        padding: 5px;
        padding-left: 8px;
        font-size: 1rem;
    }
    .reserved-word:hover{
        cursor: pointer;
        padding: 6px;
        padding-left: 8px;
        font-size: 1.1rem;
        background-color: #f7f7f7 ;
    }

    .hover:hover{
        cursor: pointer;
    }
    .no-shadows{
        box-shadow: none !important;
    }

</style>
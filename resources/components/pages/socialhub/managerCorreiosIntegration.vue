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

            <tab-content title="Configuração da conta" :beforeChange='steepPMailAccounts'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração da conta a ser monitorada</h4>
                        <p class="pl-4"> Aqui você deve informar sua conta nos <a href="http://www.correios.com.br/" target="_blank" rel="noopener noreferrer">Correios</a>  que deseja monitorar.</p>
                    </div>
                    <div class="row pl-5 pr-5 pb-3">
                        <div class="col-3"></div>                        
                        <div class="col-6">
                            <b-card header="Personalize a mensagem" header-tag="h4" class="bg-default-card no-shadows">
                                <template v-slot:header>
                                    <h6 class="mb-0" style="float:left">Dados de acesso da conta</h6>                                    
                                </template>
                                <form>
                                    <div class="p-3">
                                        <label for="username">Nome de usuário nos Correios</label>
                                        <input type="text" ref="username" v-model="model.tracking_user" class="w-100 p-1" placeholder="Login nos Correios" required>
                                    </div>
                                    <div class="p-3">
                                        <label for="password">Senha nos Correios</label>
                                        <input type="password" ref="password" v-model="model.tracking_pass" class="w-100 p-1" placeholder="Senha nos Correios" required>
                                    </div>
                                </form>
                            </b-card>
                        </div>
                        <div class="col-3"></div>
                    </div>                    
                <hr>
            </tab-content>

            <tab-content title="Configurar mensagem" :beforeChange='steepLayoutMessage'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração da Mensagem</h4>
                        <p class="pl-4">Personalize a mensagem que deseja enviar aos seus cliente após cada atialuzação do envio.
                            A mensagem pode conter palavras chaves precedidas do símbolo <b>@</b>, as que serão substituídas 
                            pela informação contida no pedido de venda. 
                        </p>
                    </div>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <input type="checkbox" id="vehicle1" checked v-model="model.tracking_send_messages">
                        <label for="vehicle1"> Desejo enviar mensagens automáticas</label><br>
                    </div>
                    <div v-show="model.tracking_send_messages" class="row pl-5 pr-5 pb-3">
                        <div class="col-8">
                            <b-card  header="Personalize a mensagem" header-tag="h4" class="bg-default-card no-shadows">
                                <template v-slot:header>
                                    <h6 class="mb-0" style="float:left">Personalize a mensagem</h6>
                                    <h6 class="mb-0" style="float:right">
                                        <i class="fa fa-refresh hover text-muted" title="Reiniciar mensagem" aria-hidden="true" @click.prevent="resetDefaultMessage"></i>
                                    </h6>
                                </template>
                                <textarea ref="text_message" v-model="model.tracking_message" style="width:100%; height:300px; resize: none" class="border-0" name="" id="" rows="14" spellcheck="false"></textarea>
                            </b-card>
                        </div>
                        <div class="col-4">
                            <b-card header="Palavras chaves" header-tag="h4" class="bg-default-card no-shadows" style="padding:0px !important; margin:0px !important">
                                <div style="height:300px; overflow-x:hidden; overflow-y:auto"  class="pl-4 pl-0">
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@compradorNome')">@compradorNome</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@compradorApelido')">@compradorApelido</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@compradorEmail')">@compradorEmail</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@compradorFone')">@compradorFone</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@compradorCPF')">@compradorCPF</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@compradorRG')">@compradorRG</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoRua')">@enderecoRua</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoNumero')">@enderecoNumero</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoComplemento')">@enderecoComplemento</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoBairro')">@enderecoBairro</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoCidade')">@enderecoCidade</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoEstado')">@enderecoEstado</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@enderecoCep')">@enderecoCep</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pagamentoStatus')">@pagamentoStatus</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pagamentoForma')">@pagamentoForma</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pedidoID')">@pedidoID</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pedidoTotalProd')">@pedidoTotalProd</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pedidoTotalFrete')">@pedidoTotalFrete</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pedidoStatus')">@pedidoStatus</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pedidoData')">@pedidoData</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@pedidoObservacoes')">@pedidoObservacoes</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@envioTransportadora')">@envioTransportadora</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@envioRastreamento')">@envioRastreamento</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@envioData')">@envioData</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@entregaData')">@entregaData</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@origem')">@origem</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@conta')">@conta</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('@sku')">@sku</div>

                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_tipo')">@tracking_tipo</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_status')">@tracking_status</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_dataHora')">@tracking_dataHora</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_descricao')">@tracking_descricao</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_recebedor')">@tracking_recebedor</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_detalhe')">@tracking_detalhe</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_local')">@tracking_local</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_codigo')">@tracking_codigo</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_cidade')">@tracking_cidade</div>
                                    <div class="row reserved-word" @click.prevent="insertReservedWord('	@tracking_uf')">@tracking_uf</div>
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
    // import managerPMailAddedAccounts from "./managerPMailAddedAccounts.vue";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    
    export default {
        name: 'managerPMailIntegration',
        
        components:{
            FormWizard,
            TabContent,
            // managerPMailAddedAccounts
        },

        data(){
            return{
                userLogged:{},
                pmail_accounts_url:"companies",
                model:{
                    tracking_user:'',
                    tracking_pass:'',
                    tracking_message:"",
                    tracking_contrated: 1,
                    tracking_send_messages: true,
                    action: 'tracking'
                },
                defaultMessage:"",                
                isAddingPMailAccount:false,
            }
        },

        methods:{

            steepInformation(){
                return true;
            },

            steepPMailAccounts(){
                if(this.model.tracking_user.trim()=='' || this.model.tracking_pass.trim()==''){
                    miniToastr.error("Nome de usuário ou senha para integração incorretos","Erro");
                    return false;
                } else{
                    return true;
                }
            },

            steepLayoutMessage(){
                let textarea = this.$refs.text_message;
                this.model.tracking_message = textarea.value;
                return new Promise((resolve, reject) => {   
                    if(this.model.tracking_send_messages){
                        this.model.tracking_send_messages = 1;
                    } else {
                        this.model.tracking_send_messages = 0;
                        this.model.tracking_message = '';
                    }
                    ApiService.put(this.pmail_accounts_url+'/'+this.userLogged.company_id, this.model)
                    .then(response => {
                        resolve(true);
                    })
                    .catch(error => {
                        this.processMessageError(error, this.bling_url, "add");
                        reject(false);
                    });
                });
            },

            steepEnd(){
                miniToastr.success("Integração realizada com sucesso","Sucesso");
                return true;
            },

            insertReservedWord(str){
                let textarea = this.$refs.text_message;
                var position = textarea.selectionStart;
                var before = this.model.tracking_message.substring(0, position);
                var after = this.model.tracking_message.substring(position, this.model.tracking_message.lenght);
                this.model.tracking_message = before + ' ' + str + ' ' + after;
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
            }
        },

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
        },

        mounted(){
            if(this.userLogged.role_id > 3){
                this.$router.push({name: "login"});
            }
            
            this.defaultMessage = "Ola @compradorNome \n\n"+

            "Seu pedido atualizou o status no Correios. Segue abaixo: \n\n"+

            "Data e hora: @tracking_dataHora\n"+
            "Local: @tracking_local\n"+
            "Cidade: @tracking_cidade, @tracking_uf\n"+
            "Descrição: @tracking_descricao \n\n"+

            "Qualquer dúvida é só responder esta mensagem.";

            // this.defaultMessage = "Olá, @compradorNome \n\n"+
            // "Seu produto @pedidoObservacoes ja saiu para entrega.\n"+
            // "O endereço de entrega informado é rua @enderecoRua, número @enderecoNumero.\n\n"+
            // "Em caso de dúvidas, problemas ou sugestões nos contate diretamente pelo nosso whatsapp ou pela Central de Atendimento, para um suporte ágil e eficaz."+
            // "Horário de atendimento: De Segunda a Sexta das 07:00 as 15:30 e Sábados das 08:00 as 13:00.\n\n"+
            // "Atte. Equipe Coffee Business.";
            this.model.tracking_message = this.defaultMessage;
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
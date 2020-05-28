<template>
    <div class="card p-3 no-shadows">
        <form-wizard    title = '' subtitle = '' backButtonText = 'Voltar' nextButtonText = 'Seguinte'  finishButtonText = 'Finalizar' stepSize = 'xs' color = "#20a0ff">
            <template v-slot:backButtonText>
                <h2>title hola mundo.com</h2>
            </template>

            <tab-content title="Informação" :beforeChange='steepInformation'>
                <hr>
                    <div class="pt-3 pl-5 pr-5">
                        <h4 style="color:#34AD70">Porque integrar com o Bling?</h4>
                        <p class="text-justify pl-4">
                            Essa funcionalidade é ideal para quem vende mercadorias ou serviços através de e-commerces como o MercadoLivre, 
                            Amazon, B2W, Via Varejo, Magazine Luiza, ou o Carrefour, e usa o <a href="https://www.bling.com.br" target="_blank" rel="noopener noreferrer">Bling</a> 
                            como Sistema integrado de gestão empresarial (ERP, Enterprise Resource Planning).
                            <br><br>
                            A integração de SocialHUB com o Bling lhe permite enviar mensagens com layouts personalisados através 
                            de Whatsapp aos seus clientes logo depois que o Bling registrar cada pedido de venda feito nos seus e-commerces. 

                            <br><br>
                            Você pode integrar uma ou várias contas Bling com a SocialHub.
                        </p>
                    </div>
                    <div class="pt-4 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Pré-requisitos para a integração</h4>
                        <p class="text-justify pl-4">
                            - Ter uma (ou várias) conta(s) no <a href="https://www.bling.com.br" target="_blank" rel="noopener noreferrer">Bling</a> que gerencie as suas vendas realizadas através dos e-commerces.
                            <br><br>
                            - Ter integrado sua (suas) contas Bling com algum dos e-commerces.
                            <br><br>
                            - Ter ativado a importação automática dos seus pedidos dentro do Bling para cada uma das contas que deseja integrar.
                        </p>
                    </div>
                <hr>
            </tab-content>

            <tab-content title="Integração Automática" :beforeChange='steepAutomaticConfiguration'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração da Integração Automática do Bling</h4>
                        <p class="pt-2">Antes de integrar uma conta Bling na SocialHub é necessário ativar a importação automática dos seus pedidos dentro do Bling. Para isso realize os seguintes passos:</p>
                        <ul class="pl-4">
                            <li class="mb-4"> 1) Acesse em  <a href="https://www.bling.com.br/configuracoes.integracoes.lojas.virtuais.php#list" target="_blank" rel="noopener noreferrer">Preferências ( <i class="fa fa-cog" style="color: #9e9e9e"> </i>) > Integrações >  Configurações de integração com lojas virtuais e Marketplaces</a>.</li>
                            <li class="mb-4"> 2) Clique na integração que deseja <b>ativar</b>  a <b>importação automática</b> de pedidos.</li>
                            <li class="mb-4"> 3) No menu lateral, clique em <b>Integração Automática</b> </li>
                            <li class="mb-2"> 4) Ative o <b>Status do pulling</b> <br>
                                <img src="~img/socialhub/pulling_status.jpeg" alt="" >
                            </li>
                            <li class="mb-4"> 5) Pressionar o botão <b>Salvar</b> para finalizar a configuração da <b>Integração automática</b>.</li>
                            <li class="mb-4"> 6) Observação: Repita o processo para todas as <b>Integrações</b> que desejar.</li>
                        </ul>
                    </div>
                <hr>
            </tab-content>

            <tab-content title="Gerar a API key" :beforeChange='steepAPIKEY'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Criação do Usuário API e da API key</h4>
                        <ul class="pl-4">
                            <li class="mb-4"> 1) Acesse a <a href="https://www.bling.com.br/usuarios.php#add" target="_blank" rel="noopener noreferrer">https://www.bling.com.br/usuarios.php#add</a> e selecione <b>usuário API</b>.</li>
                            <li class="mb-4"> 2) Na sessão <b>Informações da conta</b> preencha os campos <b>Nome</b> e <b>Email</b> do usuário API.</li>
                            <li class="mb-2"> 3) Na sessão <b>API key</b> gere a API key. Seguido copie e cole a API key aqui:</li>
                            <li class="ml-4 mb-4">
                                <div class="container-fluid">
                                    <input type="text" class="w-200" v-model="username" placeholder="Adicione seu nome de usuário Bling aqui">
                                    <input type="text" class="w-400" v-model="apikey" placeholder="Adicione sua API key aqui">
                                </div>
                            </li>
                            <li class="mb-4"> 4) Selecione a aba <b>Vendas</b> na sessão <b>Permissões</b> e marque todos os item da sub-sessão <b>Pedidos de Venda</b>.</li>
                            <li class="mb-4"> 5) Pressionar o botão <b>Salvar</b> para finalizar a <i>Criação do Usuário API e da API key</i>.</li>
                            <li class="mb-4"> 6) ATENÇÃO: Para adicionar outras contas Bling, você deve realizar todos os passos anterios, mas cada novo usuário e apikey devem ser informado para nossa equipe comercial.</li>
                        </ul>
                    </div>
                <hr>
            </tab-content>
            
            <!-- <tab-content title="Configurar callback" :beforeChange='steepCallback'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração do callback</h4>
                        <ul class="pl-4">
                            <li class="mb-4"> 1) Acesse a <a href="https://www.bling.com.br/configuracoes.integracoes.lojas.virtuais.php#add/Api/3" target="_blank" rel="noopener noreferrer">https://www.bling.com.br/configuracoes.integracoes.lojas.virtuais.php#add/Api/3</a>.</li>
                            <li class="mb-4"> 2) No menu esquerdo Selecione a opção <b>Autenticação</b>.</li>
                            <li class="mb-4"> 3) Digite um nome no campo <b>Nome do canal de venda</b>.</li>
                            <li class="mb-4"> 4) No menu esquerdo Selecione a opção <b>Callbacks</b>.</li>
                            <li class="mb-4"> 5) Em <b>Tipo de retorno no callback</b> selecione a opção <b>JSON (urlencoded)</b>.</li>
                            <li class="mb-4"> 6) Ative a opção <b>Callback de pedidos de venda</b>.</li>
                            <li class="mb-4"> 7) Copie o seguinte link: <b>https://app.socialhub.pro/blingsales/code</b> e cole no campo <b>Preencha com a URL de callback de venda</b>.</li>
                            <li class="mb-2"> 8) Pressionar o botão <b>Salvar</b> para finalizar a <i>Configuração do callback</i>.</li>
                        </ul>
                    </div>
                <hr>
            </tab-content> -->

            <tab-content title="Configurar mensagem" :beforeChange='steepLayoutMessage'>
                <hr>
                    <div class="pt-3 pl-5 pr-5 pb-3">
                        <h4 style="color:#34AD70">Configuração da Mensagem</h4>
                        <p class="pl-4"> Personalize a mensagem que deseja enviar aos seus cliente após cada pedido de vendas.
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
                        Parabéns {{userLogged.name}}, <br> sua integração foi concluída!
                    </h4>
                </div>
            </tab-content>

        </form-wizard>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    
    export default {
        name: 'managerIntegrateBling',
        
        components:{
            FormWizard,
            TabContent
        },

        data(){
            return{
                userLogged:{},
                companies_url:"companies",
                sales_url:"companies",
                // bling_url:"blings",
                bling_url:"companiesBlings",
                message:"",
                defaultMessage:"",
                apikey:"",
                username:"",
            }
        },

        methods:{
            steepInformation(){
                return true;
            },

            steepAutomaticConfiguration(){
                return true;
            },

            steepAPIKEY(){
                if(this.username.trim().length==0){                    
                    miniToastr.warn("Atenção", "Deve inserir o nome de usuário da sua conta Bling");  
                    return false;
                }
                if(this.apikey.trim().length==0){                    
                    miniToastr.warn("Atenção", "Deve inserir uma API key para continuar");  
                    return false;
                }
                return true;
                
            },

            steepCallback(){},

            steepLayoutMessage(){
                let textarea = this.$refs.text_message;
                this.message = textarea.value;
                if(this.message.trim().length==0){                    
                    miniToastr.warn("Atenção", "Deve configurar uma mensagem template para ser enviada aos seus clientes");  
                    reject(false);
                    return false;
                }else{
                    //1. Guardar na tabela de companies 
                    ApiService.put(this.companies_url + '/' + this.userLogged.company_id, {
                        "bling_apikey": this.apikey,
                        "bling_message": this.message,
                        "bling_token": this.username,
                        "bling_contrated": 1,
                        "action": 'bling'
                    })
                    .then(response => {                            
                    })
                    .catch(error => {
                    });

                    return new Promise((resolve, reject) => {
                        //update company and create the respective sales table
                        ApiService.post('saveCompanyBling', {
                            "company_id":this.userLogged.company_id,
                            "bling_username":this.username,
                            "bling_apikey":this.apikey,
                            "bling_message":this.message,
                            "bling_contrated": 1,
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
        },

        mounted(){
            if(this.userLogged.role_id > 3){
                this.$router.push({name: "login"});
            }
            
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
    .w-300{
        width: 30rem;
    }
    .w-200{
        width: 20rem;
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
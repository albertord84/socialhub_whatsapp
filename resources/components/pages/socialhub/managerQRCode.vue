<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card no-shadows" id="printableArea">
                <div class="card-block">
                    <div class="row">
                        <div class="col-8 col-md-8">
                            <h4><Strong>Para usar WhatsApp em SocialHub:</Strong></h4>
                            <ol class="terms_conditions_ol">
                                <li>Abra WhatsApp no seu telefone</li>
                                <li>Toque no Menu <i class="fa fa-ellipsis-v icons"  ></i> ou em Settings <i class="fa fa-cog icons"></i> e selecione WhatsApp Web</li> 
                                <li>Aponte seu telefone a essa tela e capture o código QR</li>
                            </ol>
                            <div class="mt-3 ml-5">
                                <Strong>Para mais detalhes assista o video:</Strong>
                                <address>
                                    <video width="400" height="340" controls>
                                        <source src="https://web.whatsapp.com/whatsapp-webclient-login_a0f99e8cbba9eaa747ec23ffb30d63fe.mp4#t=0,7" type="video/mp4">
                                        Seu navegador não suporta a tag de vídeo.
                                    </video> 
                                </address>
                            </div>
                            <div class="mt-5">
                                <h4><Strong>Sugestões para uma boa experiência:</Strong></h4>
                                <ul class="terms_conditions">
                                    <li>Não use o WhatsApp Web em outro computador enquanto estiver usado em SocialHub</li>
                                    <li>Reinicie o hardware adquirido em caso de mau funcionamento e escanee o código novamente</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-3 col-md-3">
                            <div class="col-12 text-left">
                                <a href="javascript:void()" @click.prevent="logoutWhatsapp" class="mb-2" title="Encerra qualquer sessão aberta e volta ao estado inicial">Deslogar do WhatsApp</a>
                                <!-- State 1 - beforeRequest -->
                                <div v-if="beforeRequest" @click.prevent="getNewQRCode" class="no-img">
                                    <i class="mdi mdi-reload fa-2x" ></i>    
                                </div>
                                <!-- State 2 - duringRequest -->
                                <div v-if="duringRequest" class="no-img">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                                </div>
                                <!-- State 3 - qrcodebase64 OK (show image) -->
                                <div v-if="qrcodebase64!=''" class="qrcode">
                                    <img :src="qrcodebase64" width="100%" alt="invoice QR Code"/>
                                </div>
                                <!-- State 4 - isLoggued -->
                                <div v-if="isLoggued" class="no-img">
                                    <i class="mdi mdi-emoticon-happy-outline fa-2x"></i>
                                </div>
                                <!-- State 5 - isError -->
                                <div v-if="isError" class="no-img">
                                    <i class="mdi mdi-emoticon-sad-outline fa-2x"></i>
                                </div>
                                <h6 class="mt-3">{{statusMessage}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import Echo from 'laravel-echo'; window.Pusher = require('pusher-js');

    export default {
        name: "Invoice",

        data() {
            return {
                userLogged:{},
                url:'rpis',
                rpi:{},

                beforeRequest:false,
                duringRequest:false,
                qrcodebase64:false,
                isLoggued:false,
                isError:false,

                handleTimerCounter:null,
                timeForRequest:20000,
                timeCounter:20000,

                statusMessage:'',
                push: null
            }
        },

        methods: {            
            getNewQRCode() {                
                if(this.handleTimerCounter != null){
                    clearInterval(this.handleTimerCounter);
                    this.handleTimerCounter = null;
                }
                console.log("Requesting new QRCode request");
                this.duringRequest=true;
                var This = this;
                ApiService.get(This.url)
                    .then(response => {
                        This.rpi = response.data;
                        if(This.rpi && This.rpi.QRCode && This.rpi.QRCode.status && This.rpi.QRCode.MsgID=='Already connected'){
                            This.isLoggued = true;
                        }else
                        if(This.rpi && This.rpi.QRCode && This.rpi.QRCode.message && This.rpi.QRCode.message=='Ja logado'){
                            This.isLoggued = true;
                        }else
                        if(This.rpi && This.rpi.QRCode && This.rpi.QRCode.qrcodebase64){
                            This.qrcodebase64 = This.rpi.QRCode.qrcodebase64;
                        }else{
                            This.isError=true;
                        }
                    })
                    .catch(error => {
                        This.duringRequest=false;
                        This.isError=true;
                        this.processMessageError(error, This.url,"get");
                    })
                    .finally(() => {                        
                        if(This.handleTimerCounter == null && !This.isLoggued){
                            This.timeCounter = This.timeForRequest;
                            This.handleTimerCounter = setInterval(This.timer, 1000);
                        }
                    });
            },

            timer(){
                if(this.timeCounter<=0 && (!this.isLoggued || !this.qrcodebase64)){
                    // this.getNewQRCode();
                    this.beforeRequest = true;
                }
                else{
                    this.timeCounter-=1000;
                }
            },

            logoutWhatsapp(){
                ApiService.post('RPI/logout')
                    .then(response => {
                        if(typeof(response.data !="undefined") 
                            && typeof(response.data.message) != 'undefined'
                            && (response.data.message == "Logout feito") || response.data.message=="Sessao deletada"){
                                miniToastr.success("Sucesso", "Operação realizada com sucesso");   
                                this.beforeRequest=true;
                                this.duringRequest=false;
                                this.qrcodebase64=false;
                                this.isLoggued=false;
                                this.isError=false;
                                this.erroMessage='';
                        } else{
                            miniToastr.error("Error", response.data);   
                        }
                    })
                    .catch(error => {
                        this.processMessageError(error, "RPI","logout");
                    });
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

        beforeMount: function() {
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
        },

        created: function() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        beforeDestroy: function() {
            clearInterval(this.handleTimerRequest);
        },

        mounted(){
            if(this.userLogged.role_id > 3){
                this.$router.push({name: "login"});
            }

            this.beforeRequest = true;

            // window.Echo = new Echo({
            //     broadcaster: 'pusher',
            //     key: process.env.MIX_PUSHER_APP_KEY,
            //     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            //     wsHost: process.env.MIX_APP_HOST,
            //     // wsHost: window.location.hostname,
            //     wsPort: 6001,
            //     wssPort: 6001,
            //     // enabledTransports: ['ws'],
            //     enabledTransports: ['ws', 'wss'],
            //     // encrypted: true,
            //     encrypted: false,
            //     disableStats: false
            // });

            // window.Echo.channel('sh.whatsapp-logged.' + this.userLogged.id)
            //     .listen('WhatsappLoggedIn', (e) => {                    
            //         this.isLoggued=true;
            // });

            this.pusher = new Pusher(env.process.MIX_PUSHER_APP_KEY, {
                cluster: env.process.MIX_PUSHER_APP_CLUSTER
            });

            var channel = this.pusher.subscribe('sh.whatsapp-logged.' + this.userLogged.id);
            channel.bind('WhatsappLoggedInEvent', (data) => {
                this.isLoggued=true;
            });
        },

        watch:{
            beforeRequest: function(value){
                if(value){
                    this.beforeRequest = true; //is it
                    this.duringRequest = false;
                    this.qrcodebase64 = false;
                    this.isLoggued = false;
                    this.isError = false;
                    this.statusMessage='Solicitar QRCode';
                }
            },
            duringRequest: function(value){
                if(value){
                    this.beforeRequest = false; 
                    this.duringRequest = true; //is it
                    this.qrcodebase64 = false;
                    this.isLoggued = false;
                    this.isError = false;
                    this.statusMessage='Solicitando QRCode';
                }
            },
            qrcodebase64: function(value){
                if(value){
                    this.beforeRequest = false; 
                    this.duringRequest = false; 
                    // this.qrcodebase64 = true; //is it
                    this.isLoggued = false;
                    this.isError = false;
                    this.statusMessage='Escanee o QRCode';
                }
            },
            isLoggued: function(value){
                if(value){
                    this.beforeRequest = false; 
                    this.duringRequest = false; 
                    this.qrcodebase64 = false; 
                    this.isLoggued = true; //is it
                    this.isError = false;
                    this.statusMessage='Já está logado';
                }
            },
            isError: function(value){
                if(value){
                    this.beforeRequest = false; 
                    this.duringRequest = false; 
                    this.qrcodebase64 = false; 
                    this.isLoggued = false; 
                    this.isError = true; //is it
                    //message deve ser tratado segundo o erro
                }
            },
            timeCounter: function(value){
                if(value>=0 && this.qrcodebase64){
                    this.statusMessage= value/1000 + ' segundos restantes';                    
                }
            },

            
        }
    }
</script>


<style scoped>
    #printableArea {
        border: 1px solid #ccc;
    }

    .card-header {
        border-bottom: 1px solid #ccc;
    }

    .card-block {
        padding: 25px;
    }

    @media screen and (min-width: 768px) {
        .invoice_address {
            margin: 20px 0;
        }
    }

    @media print {
        .btn-section {
            display: none !important;
        }
        .table-responsive {
            display: inline-table;
            width: 100%;
        }
    }

    .icons{
        background-color: silver;
        width: 1.5em;
        height: 1.5em;
        padding:  0.5em 1em 1.5em 0.5em;
    }

    .qrcode{
        width: 10rem;
        height: 10rem;
    }

    .no-img{
        /* margin-left:25%; */
        width: 10rem;
        height: 10rem;
        padding-top:4rem;
        padding-bottom:6rem;
        border: 2px solid silver;
        text-align: center;
    }

    .mouse-hover:hover{
        cursor: pointer;
    }

    .no-shadows{
        box-shadow: none !important;
    }
</style>

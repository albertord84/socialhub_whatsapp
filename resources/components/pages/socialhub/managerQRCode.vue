<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card no-shadows" id="printableArea">
                <div class="card-block">
                    <div class="row">
                        <div class="col-8 col-md-8 invoice_address">
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

                        <div class="col-3 col-md-3 text-right invoice_address text-center">
                            <a href="javascript:void()" @click.prevent="logoutWhatsapp" title="Encerra qualquer sessão aberta e volta ao estado inicial">Deslogar</a>
                            
                            <!-- State 1 - beforeRequest -->
                            <h4 v-if="beforeRequest" title="Solicitar código QR" class="mouse-hover" @click.prevent="getNewQRCode">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="mdi mdi-reload fa-2x"></i>
                                </div>
                            </h4>
                            <!-- State 2 - duringRequest -->
                            <h4 v-if="duringRequest">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                                </div>
                            </h4>
                            <!-- State 3 - qrcodebase64 OK (show image) -->
                            <h4 v-if="qrcodebase64!=''">
                                <img :src="qrcodebase64" ref="imgQRCode" class="qrcode" alt="invoice QR Code"/>
                            </h4>

                            <!-- State 4 - isLoggued -->
                            <h4 v-if="isLoggued">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="mdi mdi-emoticon-happy-outline fa-2x"></i>
                                </div>
                            </h4>

                            <!-- State 5 - isError -->
                            <h4 v-if="isError">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="mdi mdi-emoticon-sad-outline fa-2x"></i>
                                </div>
                            </h4>
                            
                            <h6>{{statusMessage}}</h6>

                        </div>
                        <div class="col-3 col-md-3 text-right invoice_address"></div>
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
                logguedManager:{},
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
                        
                        // console.log(response.data);
                        // console.log(response.data.status);
                        // console.log(response.data.message);

                        // if(response.data.status==500 && response.data.message.includes("No query results for model") ){
                        //     miniToastr.warn("Erro solicitando QRCode","Atenção");
                        // }

                        This.rpi = response.data;
                        console.log(This.rpi);
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
                    this.getNewQRCode();
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
                            && response.data.message == "Logout feito"){
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
            this.logguedManager = JSON.parse(window.localStorage.getItem('user'));
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
            this.beforeRequest = true;

            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: process.env.MIX_PUSHER_APP_KEY,
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                wsHost: process.env.MIX_APP_HOST,
                // wsHost: window.location.hostname,
                wsPort: 6001,
                wssPort: 6001,
                // enabledTransports: ['ws'],
                enabledTransports: ['ws', 'wss'],
                // encrypted: true,
                encrypted: false,
                disableStats: false
            });

            window.Echo.channel('sh.whatsapp-logged.' + this.logguedManager.id)
                .listen('WhatsappLoggedIn', (e) => {                    
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
                    this.statusMessage='QRCode';
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

    .card-header span {
        margin-top: -33px;
        font-size: 18px;
    }

    .invoice_address {
        margin: 10px 0;
    }

    .table {
        table-layout: fixed;
        border: 1px solid #ccc;
    }

    .table tbody > tr {
        height: 50px;
    }

    td,
    th {
        word-wrap: break-word;
    }

    .terms_conditions {
        list-style: initial;
        padding-left: 25px;
    }
    .terms_conditions_ol {
        padding-left: 25px;
    }

    .table thead > tr > th {
        padding: 10px 8px;
        width: 80px;
        background-color: #ccc;
    }

    .table thead > tr > th:nth-child(2) {
        max-width: 180px;
    }

    .table-responsive > .table > tbody > tr > td,
    .table-responsive > .table > tfoot > tr > td {
        padding: 15px 8px;
        white-space: normal;
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
        width: 10em;
        height: 10em;
    }

    .qrcode-spinner{
        width: 10em;
        height: 10em;
        position: relative;
        padding: 4em 4em 4em 4em;
        border: 3px solid silver;
    }

    .mouse-hover:hover{
        cursor: pointer;
    }

    .no-shadows{
        box-shadow: none !important;
    }
</style>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="printableArea">
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
                            <h4 v-if="beforeRequest" title="Solicitar código QR" class="mouse-hover" @click.prevent="recurrentGetTunnel">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="mdi mdi-reload fa-2x"></i>
                                </div>
                            </h4>
                            <h4 v-if="duringRequest">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                                </div>
                            </h4>
                            <h4 v-if="qrcodebase64!=''">
                                <img  :src="qrcodebase64" ref="imgQRCode" class="qrcode" alt="invoice QR Code"/>
                            </h4>
                            <h4 v-if="isLoggued">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="mdi mdi-emoticon-happy-outline fa-2x"></i>
                                </div>
                            </h4>
                            <h4 v-if="someError">
                                <div  ref="imgQRCode" class="qrcode-spinner">
                                    <i class="mdi mdi-emoticon-sad-outline fa-2x"></i>
                                </div>
                            </h4>
                            <h6 v-if="isLoggued">Ja está logado</h6>
                            <h6 v-if="!isLoggued">QRCode</h6>
                            <h6 v-if="someError">{{erroMessage}}</h6>
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

    export default {
        name: "Invoice",

        data() {
            return {
                url:'rpis',
                rpi:{},
                beforeRequest:true,
                duringRequest:false,
                qrcodebase64:false,
                isLoggued:false,
                someError:false,
                erroMessage:'',
                handleTimerRequest:null,
                amountTimeRequest:0,
                intervalTimeRequest:10000,
                newTimeRequest:20000,
            }
        },

        methods: {
            recurrentGetTunnel(){
                this.getTunnel();
                return this.handleTimerRequest = setInterval(this.getTunnel, this.intervalTimeRequest);                                
            },

            getTunnel() {
                this.qrcodebase64=false;
                this.isLoggued=false;
                this.someError=false;
                this.beforeRequest=false;
                this.duringRequest=true;

                var reload = 0;
                if(this.amountTimeRequest >= this.newTimeRequest){
                    reload = 1;  
                    this.amountTimeRequest = 0;                  
                }
                this.amountTimeRequest += this.intervalTimeRequest;

                console.log('New qrcode request with reload = '+reload+ ' and amountTimeRequest = '+this.amountTimeRequest);

                var This =this;
                ApiService.get(this.url,{ 'reload':reload})
                    .then(response => {
                        this.rpi = response.data;
                        if(this.rpi.QRCode.message && this.rpi.QRCode.message=='Ja logado'){
                            this.isLoggued = true;
                            clearInterval(this.handleTimerRequest);
                        }else
                        if(this.rpi.QRCode.qrcodebase64){
                            this.qrcodebase64 = this.rpi.QRCode.qrcodebase64;
                            clearInterval(this.handleTimerRequest);
                        }else{
                            this.erroMessage = "Algum problema encontrado"
                            this.someError=true;
                        }
                    })
                    .catch(function(error) {                        
                        This.erroMessage = "Erro na conexão"
                        This.someError=true;
                        if (error.response) {
                            // console.log('error.response');
                            // console.log(error.response.data);
                            // console.log(error.response.data.message);
                            // console.log(error.response.status);
                            // console.log(error.response.headers);
                            miniToastr.warn(error.response.data.message, "Atenção"); 
                        } else
                        if (error.request) {
                            // console.log('error.request');
                            // console.log(error.request);
                        } else{
                            // console.log('some another error');
                            // console.log(error.message);
                            This.erroMessage = "Erro na conexão"
                            This.someError=true;
                        }
                        // console.log('error config');
                        // console.log(error.config);
                    })
                    .finally(() => {
                        This.duringRequest=false;
                    });   
            }
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

</style>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="printableArea">
                <!-- <div class="card-header">
                    <h4><img src="~img/vue-w_logo1.png" alt="Company logo"/></h4>
                    <span class="float-right">
                        <strong> Invoice</strong>
                    </span>
                </div> -->

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
                                        Your browser does not support the video tag.
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

                        <div class="col-3 col-md-3 text-right invoice_address">
                            <h4><img src="~img/pages/invoice_code.jpg" class="qrcode" alt="invoice QR Code"/></h4>
                        </div>
                        <div class="col-3 col-md-3 text-right invoice_address"></div>
                        
                        
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Invoice",
    mounted: function() {

    },
    destroyed: function() {

    },
    methods: {
        printDiv() {
            window.print();
        }
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

</style>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card no-shadows" id="printableArea">
                <frappe_charts></frappe_charts>
                <chartist></chartist>
                <e_barcharts></e_barcharts>
                <e_linecharts></e_linecharts>
                <e_piecharts></e_piecharts>
                <dropdowns></dropdowns>
            </div>
        </div>
    </div>
</template>


<script>
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";    
    import frappe_charts from "../non_used_pages/frappe_charts";    
    import chartist from "../non_used_pages/chartist";    
    import e_barcharts from "../non_used_pages/e_barcharts";    
    import e_linecharts from "../non_used_pages/e_linecharts";    
    import e_piecharts from "../non_used_pages/e_piecharts";    
    import dropdowns from "../non_used_pages/dropdowns";    

    export default {
        name: "PMailStatistics",

        components:{
            frappe_charts,
            chartist,
            e_barcharts,
            e_linecharts,
            e_piecharts,
            dropdowns,
        },

        data() {
            return {
                
            }
        },

        methods: {            
            getStatistics() {                
                ApiService.get(This.url)
                    .then(response => {
                        
                    })
                    .catch(error => {                        
                        this.processMessageError(error, This.url,"get");
                    })
                    .finally(() => { 
                    });
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

<template>
    <div class="card p-3 no-shadows">
        
        <!--========================Dados gerais===========================-->
        <div class="row no-shadows">
            <div class="col-lg-3  col-sm-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow">
                    <div class="widget_social_inner1">
                        <i v-if="isLoggued" class="fa fa-whatsapp fb_text"  style="color:#25d366"></i>
                        <i v-if="!isLoggued" class="fa fa-whatsapp fb_text text-danger" ></i>
                    </div>
                    <div class="text-ash no-shadows">
                        <h3 v-if="isLoggued" class="mt-2">{{staticsModel.whatsappNumber}}</h3>
                        <h3 v-if="!isLoggued" class="mt-2 text-danger">Whatsapp Offline</h3>
                        <p v-if="isLoggued" class="mb-1 mt-2" title="Número cadastrado">Logado em SocialHub</p>
                        <p v-if="!isLoggued" class="mb-1 mt-2 text-danger" title="Número cadastrado">Escanee o QRCode</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3  col-md-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow">
                    <div class="widget_social_inner1">
                        <i class="fa fa-users fb_text text-dark"></i>
                    </div>
                    <div class="text-ash no-shadows">
                        <h4 class="mt-2 text_size">{{staticsModel.totalContacts}}</h4>
                        <p class="m-0 mt-2">Total de contatos</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow">
                    <div class=" widget_social_inner1">
                        <i class="fa fa-paper-plane fb_text text-success" ></i>
                    </div>
                    <div class="text-ash">
                        <h4 class="mb-0 mt-2 text_size">{{staticsModel.totalSendMessages}}</h4>
                        <p class="m-0 mt-2">Mensagens enviadas</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3  col-sm-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow ">
                    <div class="widget_social_inner1">
                        <i class="fa fa-paper-plane-o fb_text fa-rotate-180"></i>
                        <!-- <i class="fa  fb_text"></i> -->
                    </div>
                    <div class="text-ash">
                        <h4 class="mb-0 mt-2 text_size">{{staticsModel.totalReceivedMessages}}</h4>
                        <p class="m-0 mt-2">Mensagens recebidas</p>
                    </div>
                </div>
            </div>
            
        </div>

        <!--========================Contatos e atendentes===========================-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <b-card class="no-shadows">
                    <h5 class="ml-3 head_color">Contatos por atendente</h5>
                    <div style="height: 265px;" class="mt-2">
                        <IEcharts :option="pieContacts" :loading="loading" @ready="onReady"></IEcharts>
                    </div>
                </b-card>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <b-card class="no-shadows">
                    <h5 class="ml-3 head_color">Histórico de contatos por atendente</h5>
                    <div style="display: flex; align-items: baseline; ">
                        <form action="">
                            <input type="radio" name="contactHistory" value="Y-m-d" v-model="contactFrequency" id="contactHistoryDaily">
                            <label for="contactHistoryDaily">Diário</label>
                            <input type="radio" name="contactHistory" value="Y-m" v-model="contactFrequency" id="contactHistoryWeek" class="ml-2">
                            <label for="contactHistoryWeek">Mensal</label>
                            <input type="radio" name="contactHistory" value="Y" v-model="contactFrequency" id="contactHistoryMonth" class="ml-2">
                            <label for="contactHistoryMonth">Anual</label>
                        </form>
                    </div>
                    <div style="height: 265px;" class="mt-2">
                        <IEcharts :option="ajaxbar_chartContacts" :loading="ajaxloading" @ready="onReady" ref="ajaxbar_chart"></IEcharts>
                    </div>
                </b-card>
            </div>
        </div>

        <!--========================Mensagens===========================-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <b-card class="no-shadows">
                    <h5 class="ml-3 head_color">Mensagens enviadas por atendente</h5>                    
                    <div style="height: 265px;" class="mt-2">
                        <IEcharts :option="pieMessages" :loading="loading" @ready="onReady"></IEcharts>
                    </div>
                </b-card>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <b-card class="no-shadows">
                    <h5 class="ml-3 head_color">Histórico de mensagens enviadas por atendente</h5>
                    <div style="display: flex; align-items: baseline; ">
                        <form action="">
                            <input type="radio" name="messageHistory" value="Y-m-d" v-model="messageFrequency" id="messageHistoryDaily">
                            <label for="messageHistoryDaily">Diário</label>
                            <input type="radio" name="messageHistory" value="Y-m" v-model="messageFrequency" id="messageHistoryWeek" class="ml-2">
                            <label for="messageHistoryWeek">Mensal</label>
                            <input type="radio" name="messageHistory" value="Y" v-model="messageFrequency" id="messageHistoryMonth" class="ml-2">
                            <label for="messageHistoryMonth">Anual</label>
                        </form>
                    </div>
                    <div style="height: 265px;" class="mt-2">
                        <IEcharts :option="ajaxbar_chartMessage" :loading="ajaxloading" @ready="onReady" ref="ajaxbar_chart"></IEcharts>
                    </div>
                </b-card>
            </div>
        </div>

    </div>
</template>
<script>
    import Vue from 'vue';
    import ApiService from "../../../common/api.service";
    import VueAwesomeSwiper from 'vue-awesome-swiper';
    import IEcharts from 'vue-echarts-v3/src/full.js';
    import datatable from "components/plugins/DataTable/DataTable.vue";
    import countTo from 'vue-count-to';
    import vScroll from "components/plugins/scroll/vScroll.vue";
    import portfolio from "components/widgets/portfolio/portfolio.vue"
    import 'zrender/lib/vml/vml';
    require('swiper/dist/css/swiper.css')
    import VueChartist from 'v-chartist'
    import 'echarts/lib/chart/pie';



    Vue.use(VueAwesomeSwiper);
    var unsub;
    export default {
        name: "index2",
        components: {
            IEcharts,
            datatable,
            countTo,
            vScroll,
            portfolio,
            VueChartist
        },

        data() {
            return {
                userLogged:{},
                instances: [],
                isLoggued: false,
                staticsModel: {
                    whatsappNumber: '00000000000',
                    totalContacts: 0,
                    totalAttendants: 0,
                    totalSendMessages: 0,
                    totalReceivedMessages: 0,
                    attendants: 0,
                },
                frequencySendedMessages: [],
                frequencyReceivedMessages: [],
                colorsList: ['#ef5350', '#6eb09c', '#6ebabe', '#78bbbf', '#83b3a4'],

                loading: false,
                ajaxloading: false,

                contactFrequency: 'Y-m',
                messageFrequency: 'Y-m',
                
                pieContacts: {
                    tooltip: { trigger: 'item',  formatter: "{a} <br/>{b} : {c} ({d}%)"},
                    legend: { orient: 'vertical', left: 'left', data: ['A', 'B', 'C', 'D', 'E']},                
                    series: [{
                            name: 'Source', type: 'pie', radius: '80%', center: ['50%', '50%'],                        
                            data: [
                                // { value: 335, name: 'Attendant 1', itemStyle : {normal : {color :'#ef5350'}}},
                                // { value: 310, name: 'Attendant 2', itemStyle : {normal : {color :'#6eb09c'}}}, 
                                // { value: 234, name: 'Attendant 3', itemStyle : {normal : {color :'#6ebabe'}}}, 
                                // { value: 135, name: 'D', itemStyle : {normal : {color :'#78bbbf'}}}, 
                                // { value: 1548,name: 'E', itemStyle : {normal : {color :'#83b3a4'}}}
                            ],
                            itemStyle: { emphasis: {shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)'}}
                        }
                    ]
                },

                ajaxbar_chartContacts: {
                    tooltip: {trigger: 'axis'},
                    grid: {bottom: '10%', right: '1%',},
                    toolbox: {show: true, feature: {}},
                    calculable: true,
                    legend: {data: ['Attendant 1', 'Attendant 2', 'Attendant 3']},
                    color: ['#ef5350', '#6eb09c', '#6ebabe'],
                    xAxis: [{
                        type: 'category', 
                        name: 'YEAR', 
                        data: ['2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015','2016', '2017']}],
                    yAxis: [{type: 'value', name: '%', axisLabel: { formatter: '{value} '}}, {type: 'value', axisLabel: {formatter: '{value} '}}],
                    series: [
                        // {name: 'Attendant 1', type: 'bar', data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]},
                        // {name: 'Attendant 2', type: 'bar', data: [2.0, 4.9, 9.0, 21.2, 20.6, 66.7, 115.6, 122.2, 32.6, 20.0, 6.4, 3.3]},
                        // {name: 'Attendant 3', type: 'bar', data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]},
                    ]
                },

                ajaxbar_chartMessage: {
                    tooltip: {trigger: 'axis'},
                    grid: {bottom: '10%', right: '1%',},
                    toolbox: {show: true, feature: {}},
                    calculable: true,
                    legend: {data: ['ENVIADAS', 'RECEVIDAS']},
                    color: ['#a0bce5', '#baf2e1'],
                    xAxis: [{type: 'category', name: 'YEAR', data: ['2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015','2016', '2017']}],
                    yAxis: [{type: 'value', name: '%', axisLabel: { formatter: '{value} '}}, {type: 'value', axisLabel: {formatter: '{value} '}}],
                    series: [
                        {name: 'ENVIADAS', type: 'bar', data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]},
                        {name: 'RECEVIDAS', type: 'bar', data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]},
                    ]
                },

                pieMessages: {
                    tooltip: { trigger: 'item',  formatter: "{a} <br/>{b} : {c} ({d}%)"},
                    legend: { orient: 'vertical', left: 'left', data: ['A', 'B', 'C', 'D', 'E']},                
                    series: [{
                            name: 'Source', type: 'pie', radius: '80%', center: ['50%', '50%'],                        
                            data: [
                                // { value: 200, name: 'Attendant 1', itemStyle : {normal : {color :'#bdbdbd'}}},
                                // { value: 310, name: 'Attendant 2', itemStyle : {normal : {color :'#ff8a65'}}}, 
                                // { value: 2304, name: 'Attendant 3', itemStyle : {normal : {color :'#2962ff'}}}, 
                                // { value: 135, name: 'D', itemStyle : {normal : {color :'#78bbbf'}}}, 
                                // { value: 1548,name: 'E', itemStyle : {normal : {color :'#83b3a4'}}}
                            ],
                            itemStyle: { emphasis: {shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)'}}
                        }
                    ]
                },
                
                tableData: [],
            }
        },

        methods: {
            managerGeneralStatistics: function () {
                ApiService.post('managerGeneralStatistics',{
                    'company_id': this.userLogged.company_id,
                })
                .then(response => {
                    response.data.attendants.some((item, i) => {
                        this.pieContacts.series[0].data.push({ 
                            value: item.contactsAmmount, 
                            name: item.email.split('@')[0], 
                            itemStyle : {normal : {color :this.colorsList[i]}}});
                        this.pieMessages.series[0].data.push({ 
                            value: item.sendedMessageAmmount, 
                            name: item.email.split('@')[0], 
                            itemStyle : {normal : {color :this.colorsList[i]}}});
                    });
                    this.staticsModel = response.data;
                })
                .catch(error => {
                    
                })
                .finally(() => {                        
                    
                });
            },
            
            frequencyOfContactByAttendant: function () {
                ApiService.post('frequencyOfContactByAttendant',{
                    'company_id': this.userLogged.company_id,
                    'contactFrequency': this.contactFrequency,
                })
                .then(response => {
                    //nome do eixo X
                    if(this.contactFrequency == 'Y-m-a') this.ajaxbar_chartContacts.xAxis[0].name = 'Dias';
                    if(this.contactFrequency == 'Y-m') this.ajaxbar_chartContacts.xAxis[0].name = 'Meses';
                    if(this.contactFrequency == 'Y') this.ajaxbar_chartContacts.xAxis[0].name = 'Anos';

                    //nomes dos atendentes
                    this.ajaxbar_chartContacts.legend.data = [];
                    this.ajaxbar_chartContacts.legend.data = Object.keys(response.data);

                     //valores para os nomes do eixo X 
                    this.ajaxbar_chartContacts.xAxis[0].data =[];
                    this.ajaxbar_chartContacts.xAxis[0].data = Object.keys(response.data[this.ajaxbar_chartContacts.legend.data[0]]);
                    
                    //cores
                    this.ajaxbar_chartContacts.color = [];
                    this.ajaxbar_chartContacts.color = this.colorsList.slice(0, this.ajaxbar_chartContacts.legend.data.length);

                    this.ajaxbar_chartContacts.series =[];
                    this.ajaxbar_chartContacts.legend.data.some((item,i)=>{
                        this.ajaxbar_chartContacts.series.push({
                            name: item,
                            type: 'bar',
                            data: []
                        });
                    });

                    this.ajaxbar_chartContacts.legend.data.some((item,i)=>{
                        this.ajaxbar_chartContacts.xAxis[0].data.some((item2,j)=>{
                            this.ajaxbar_chartContacts.series[i].data.push(response.data[item][item2]);
                        });
                    });                
                })
                .catch(error => {
                    
                })
                .finally(() => {                        
                    
                });
            },

            frequencyOfMessageByAttendant: function () {
                ApiService.post('frequencyOfMessageByAttendant',{
                    'company_id': this.userLogged.company_id,
                    'messageFrequency': this.messageFrequency
                })
                .then(response => {
                    //nome do eixo X
                    if(this.contactFrequency == 'Y-m-a') this.ajaxbar_chartMessage.xAxis[0].name = 'Dias';
                    if(this.contactFrequency == 'Y-m') this.ajaxbar_chartMessage.xAxis[0].name = 'Meses';
                    if(this.contactFrequency == 'Y') this.ajaxbar_chartMessage.xAxis[0].name = 'Anos';

                    //nomes dos atendentes
                    this.ajaxbar_chartMessage.legend.data = [];
                    this.ajaxbar_chartMessage.legend.data = Object.keys(response.data);

                     //valores para os nomes do eixo X 
                    this.ajaxbar_chartMessage.xAxis[0].data =[];
                    this.ajaxbar_chartMessage.xAxis[0].data = Object.keys(response.data[this.ajaxbar_chartMessage.legend.data[0]]);
                    
                    //cores
                    this.ajaxbar_chartMessage.color = [];
                    this.ajaxbar_chartMessage.color = this.colorsList.slice(0, this.ajaxbar_chartMessage.legend.data.length);

                    this.ajaxbar_chartMessage.series =[];
                    this.ajaxbar_chartMessage.legend.data.some((item,i)=>{
                        this.ajaxbar_chartMessage.series.push({
                            name: item,
                            type: 'bar',
                            data: []
                        });
                    });

                    this.ajaxbar_chartMessage.legend.data.some((item,i)=>{
                        this.ajaxbar_chartMessage.xAxis[0].data.some((item2,j)=>{
                            this.ajaxbar_chartMessage.series[i].data.push(response.data[item][item2]);
                        });
                    });  
                })
                .catch(error => {
                    
                })
                .finally(() => {                        
                    
                });
            },

            getNewQRCode() {                
                ApiService.get('rpis')
                    .then(response => {
                        this.rpi = response.data;
                        if(this.rpi && this.rpi.QRCode && this.rpi.QRCode.status && this.rpi.QRCode.MsgID=='Already connected'){
                            this.isLoggued = true;
                        }else
                        if(this.rpi && this.rpi.QRCode && this.rpi.QRCode.message && this.rpi.QRCode.message=='Ja logado'){
                            this.isLoggued = true;
                        }else
                        if(this.rpi && this.rpi.QRCode && this.rpi.QRCode.qrcodebase64){
                            this.qrcodebase64 = this.rpi.QRCode.qrcodebase64;
                        }else{
                            this.isLoggued = false;
                        }
                    })
                    .catch(error => {
                    })
                    .finally(() => {                        
                    });
            },

            onReady(instance) {
                this.instances.push(instance)
            }
        },

        mounted: function () {
        },

        beforeMount() {
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));

            this.getNewQRCode();
            this.managerGeneralStatistics();
            this.frequencyOfContactByAttendant();
            this.frequencyOfMessageByAttendant();
        },

        watch: {
            contactFrequency: function(){
                this.frequencyOfContactByAttendant();
            },

            messageFrequency: function(){
                this.frequencyOfMessageByAttendant();
            }
        }
    }
</script>


<style src="../../../css/widgets.css" scoped></style>
<style scoped>
    .swiper-pagination {
        position: relative;
    }

    .swiper-pagination-fraction,
    .swiper-pagination-custom,
    .swiper-container-horizontal > .swiper-pagination-bullets {
        top: 5px;
    }

    .swiper-container {
        margin-top: 0px !important;
    }
    .fa-rotate-45 {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .fa-rotate-90 {
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }
    .fa-rotate-180 {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
</style>
<style type="text/css" lang="scss">
    .index2_table .table-responsive .card {
        border: none;
        box-shadow: none;
        margin-bottom: 0;
    }

    .index2_swiper .swiper-pagination-bullet-active {
        background: #08aa80;
    }

    /*===============================notes========*/

    .notes {
        line-height: 22px;
        font-size: 13px;
        padding: 0 15px 0 36px;
        position: relative;
        outline: none;
        background: #fff;
        background-size: 100% 30px;
    }

    .notes p {
        border-bottom: 1px solid #dfe8ec;;
    }

    .notes::after {
        content: '';
        position: absolute;
        width: 0;
        top: 0;
        left: 25px;
        bottom: 0;
        border-left: 1px solid #0fd1c1;
    }

    .social .bg-default-card .info {
        font-size: 12px;
    }

    .social .bg-default-card span {
        display: block;
        text-transform: uppercase;
    }

    .social .bg-default-card .value {
        font-size: 40px;
        line-height: normal;
    }


    .social .bg-default-card {
        i {
            transition: 300ms;
        }

        &:hover {
            i {
                font-size: 45px;
                transition: 300ms;
            }
        }
    }

    .social_cuntdata {
        font-weight: bold;
        font-size: 18px;
    }

    .subscribe_btn {
        background-color: transparent;
        border: 0;
        outline: none;
    }

    .widget_social_icons {
        background-color: #fff;
    }

    .fb_text {
        color: #215fe2;
        font-size: 28px;
    }

    .box_shadow {
        box-shadow: 2px 2px 15px 0px #ccc;
    }

    .head_color {
        color: #686868;
    }

    .text_size {
        font-size: 25px;
        color: #797f82;
    }

    .text-ash {
        color: #575f65;
    }

    .text_color {
        color: #646161 !important;
    }

    .swiper-pagination {
        margin: 0 !important;
    }

    .text-blue {
        color: #215fe2;
    }

    .progress_color2 .progress-bar {
        background-color: #7FAFF7;
    }

    .icon_color {
        font-size: 27px;
        color: #828686;
    }

    .icon_color1 {
        font-size: 25px;
        color: #6e8dce;
    }

    .line {
        border-top: 1px solid #ccc;
    }

    .text_head_Color {
        color: #707373;
    }

    .below_text {
        color: #a2a1a1;
    }

    .index2_table th {
        color: #686868;
    }

    .index2_table td {
        color: #686868;
    }

    .user_color {
        color: #8e8c8e;
    }

    .count1 {
        font-size: 18px;
        color: #686868;
    }

    .ti_color {
        color: #215fe2;
    }

    .fb_color {
        font-size: 18px;
        color: #3B5998;
    }

    .twi_color {
        color: #00aced;
        font-size: 18px;
    }

    .gi_color {
        color: red;
        font-size: 18px;
    }

    .pin_color {
        color: red;
    }

    .cam_color {
        color: green
    }

    .events1 {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding-top: 2px;
        padding-bottom: 2px;
        margin-top: 15px;
        margin-right: -20px;
        font-size: 18px;
        color: #555;
    }

    .online_dot img {
        position: relative;
    }

    .online_dot::after {
        content: "";
        position: absolute;
        margin-top: -28px;
        height: 11px;
        width: 11px;
        border: 2px solid #FFF;
        border-radius: 50%;
        background-color: green;
        margin-left: -13px;
    }

    .conversation-list .ctext-wrap p {
        margin: 0;
        padding-top: 3px;
    }

    .conversation-list .odd .ctext-wrap:after {
        border-color: rgba(238, 238, 242, 0);
        left: 99%;
        margin-right: -1px;
        border-top: 0 solid #D8F1E4;
        border-left: 12px solid #D8F1E4;
        border-bottom: 14px solid transparent;
    }

    .conversation-list .ctext-wrap p {
        margin: 0;
        /*padding-top: 3px;*/
    }

    .ctext-wrap p {
        margin-bottom: 10px;
    }

    .conversation-list .odd .conversation-text {
        float: right;
        margin-right: 25px;
        text-align: right;
        width: 95%;
    }

    .conversation-list .ctext-wrap i {
        color: #777;
        display: block;
        font-size: 11px;
        font-style: normal;
        position: relative;
    }

    .conversation-list .conversers1 .ctext-wrap {
        background: #D8F1E4;
    }

    .conversation-list .ctext-wrap {
        border-radius: 3px;
        display: inline-block;
        padding: 5px 10px;
        position: relative;
        box-shadow: 2px -2px 4px 0px rgba(0, 0, 0, 0.1)
    }

    .text-field {
        padding: 6px 10px;
    }

    .conversation-list .odd .ctext-wrap:after {
        border-color: rgba(238, 238, 242, 0);
        left: 99%;
        margin-right: -1px;
        border-top: 0 solid #D8F1E4;
        border-left: 12px solid #D8F1E4;
        border-bottom: 14px solid transparent;
    }

    .conversation-list .ctext-wrap:after {
        right: 100%;
        top: 0;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        margin-left: -1px;
        border-top: 0 solid #fff;
        border-right: 12px solid #e9f9ff;
        border-bottom: 14px solid transparent;
    }

    .clearfix:after {
        clear: both;
    }

    .back_color1 {
        width: auto;
        height: 274px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .conversation-list .conversation-text {
        float: left;
        font-size: 13px;
        width: 70%;
    }

    .clearfix:before,
    .clearfix:after {
        content: " ";
        display: table;
    }

    .conversation-list .conversers2 .ctext-wrap {
        background: #e9f9ff;
    }

    .m-t-10 {
        margin-top: 10px !important;
    }

    .conversation-list {
        width: auto;
        height: 340px;
        padding-left: 27px;
    }

    .profile-img {
        background-color: #fff;
    }

    .chat-conversation {
        width: 100%;
    }
    .no-shadows{
        box-shadow: none !important;
    }
</style>
<style src="chartist/dist/chartist.css"></style>

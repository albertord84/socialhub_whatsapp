<template>
    <div >
        
        <!--========================Dados gerais===========================-->
        <div class="row ">
            <div class="col-lg-3  col-sm-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow">
                    <div class="widget_social_inner1">
                        <i class="fa fa-address-book-o fb_text"></i>
                    </div>
                    <div class="text-ash">
                        <h4 class="mt-2 text_size">7465</h4>
                        <p class="m-0 mt-2">Total Contatos</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3  col-md-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow">
                    <div class=" widget_social_inner1">
                        <i class="fa fa-address-book-o fb_text"></i>
                    </div>
                    <div class="text-ash">
                        <h4 class="mb-0 mt-2 text_size">46</h4>
                        <p class="m-0 mt-2">Mais Recentes</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow">
                    <div class=" widget_social_inner1">
                        <i class="fa fa-comments-o fb_text"></i>
                    </div>
                    <div class="text-ash">
                        <h4 class="mb-0 mt-2 text_size">74200+</h4>
                        <p class="m-0 mt-2">Mensagens</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3  col-sm-6 mb-3">
                <div class="text-center p-3 widget_social_icons box_shadow ">
                    <div class="widget_social_inner1">
                        <i class="fa fa-headphones fb_text"></i>
                    </div>
                    <div class="text-ash">
                        <h4 class="mb-0 mt-2 text_size">6</h4>
                        <p class="m-0 mt-2">Atendentes</p>
                    </div>
                </div>
            </div>
            
        </div>

        <!--========================Redes Socias===========================-->
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <b-card>
                    <h5 class="ml-3 head_color">Estatísticas Anuais</h5>
                    <div style="height: 305px;">
                        <IEcharts :option="ajaxbar_chart" :loading="ajaxloading" @ready="onReady"
                                  ref="ajaxbar_chart"></IEcharts>
                    </div>
                </b-card>
            </div>

            <!--======================Monthly Sales========================-->
            <div class="col-lg-12 col-xl-4">
                <div class="row">
                    <!-- <div class="col-lg-6 col-xl-12 col-md-6">
                        <b-card>
                            <h5 class="ml-3 mb-4 head_color">Redes Socias</h5>
                            <div style="height: 150px;" class="mt-2">
                                <IEcharts :option="doughnut" :loading="loading" @ready="onReady"></IEcharts>
                            </div>
                        </b-card>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';

    import IEcharts from 'vue-echarts-v3/src/full.js';
    import 'zrender/lib/vml/vml';

    require('swiper/dist/css/swiper.css')
    import VueAwesomeSwiper from 'vue-awesome-swiper';
    import countTo from 'vue-count-to';
    import datatable from "components/plugins/DataTable/DataTable.vue";
    import vScroll from "components/plugins/scroll/vScroll.vue";
    import portfolio from "components/widgets/portfolio/portfolio.vue"
    import VueChartist from 'v-chartist'
    import ApiService from "../../../common/api.service";


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
                serverdata: [],
                instances: [],
                loading: false,
                ajaxloading: false,
                
                //==========Doughnut chart data start=====
                doughnut: {
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        x: 'left',
                        data: ['Whatsapp', 'Facebook', 'Instagram', 'LinkedIn']

                    },
                    series: [{
                        name: 'Sales',
                        type: 'pie',
                        radius: ['50%', '70%'],
                        avoidLabelOverlap: false,
                        color: ['#137cbc', '#279fc9', '#4cb6e5', '#98d4f9', '#afebf9'],
                        label: {
                            normal: {
                                show: false,
                                position: 'center',

                            },

                            emphasis: {
                                show: true,
                                textStyle: {
                                    fontSize: '30',
                                    fontWeight: 'bold'
                                }
                            }
                        },
                        labelLine: {
                            normal: {
                                show: false
                            }
                        },
                        data: [{
                            value: 455,
                            name: 'Whatsapp',

                        }, {
                            value: 310,
                            name: 'Facebook'
                        }, {
                            value: 234,
                            name: 'Instagram'
                        }, {
                            value: 135,
                            name: 'LinkedIn'
                        }/*, {
                            value: 148,
                            name: 'Dec'
                        }*/]
                    }]
                },
                //==========Doughnut chart data end=====
                // ======donut chart start=======
                donut: {
                    data: {
                        labels: ['C', 'IE', 'F'],
                        series: [50, 20, 30],

                    },
                    options: {

                        donut: true,
                        donutWidth: 42,
                        labelInterpolationFnc: function (value) {
                            return value[0]
                        }
                    },
                    responsiveoptions: [
                        ['screen and (min-width: 640px)', {
                            chartPadding: 30,
                            labelOffset: 40,
                            labelDirection: 'explode',
                            labelInterpolationFnc: function (value) {
                                return value;
                            }
                        }],
                        ['screen and (min-width: 1024px)', {
                            labelOffset: 50,
                            chartPadding: 40
                        }]
                    ]
                },
                // ======donut chart end================

                //==========swipper=========

                swiperOption: {
                    pagination: '.swiper-pagination',
                    paginationClickable: true,
                    spaceBetween: 55,
                    effect: 'flip',
                    centeredSlides: true,
                    autoplay: 2500,
                    autoplayDisableOnInteraction: false,
                    loop: false,
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev'
                },
                //=============progress bar============
                progress2counter1: 20,
                progress2counter4: 50,
                progress2counter5: 30,


                //===========AJAX chart data start=========
                ajaxbar_chart: {
                    tooltip: {
                        trigger: 'axis'
                    },
                    grid: {
                        bottom: '10%',
                        right: '1%',
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            //
                        }
                    },
                    calculable: true,
                    legend: {
                        data: ['PROJECTS', 'SALES']
                    },
                    color: ['#a0bce5', '#baf2e1'],
                    xAxis: [{
                        type: 'category',
                        name: 'YEAR',
                        data: ['2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015',
                            '2016', '2017'
                        ]
                    }],
                    yAxis: [{
                        type: 'value',
                        name: '%',
                        axisLabel: {
                            formatter: '{value} '
                        }
                    },
                        {
                            type: 'value',

                            axisLabel: {
                                formatter: '{value} '
                            }
                        }
                    ],
                    series: [{
                        name: 'PROJECTS',
                        type: 'bar',
                        data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
                    },
                        {
                            name: 'SALES',
                            type: 'bar',
                            data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
                        },

                    ]
                },
                //===========AJAX chart data end=========\
                // ===tabledata
                tableData: [],
                columndata: [{
                    label: 'ID',
                    field: 'id',
                    numeric: true,
                    html: false,
                }, {
                    label: 'Name',
                    field: 'name',
                    numeric: false,
                    html: false,
                }, {
                    label: 'Email',
                    field: 'email',
                    numeric: false,
                    html: false,
                }, {
                    label: 'Actions',
                    field: 'action',
                    numeric: false,
                    html: true,
                }]

            }
        },
        mounted: function () {
            unsub = this.$store.subscribe((mutation, state) => {
                if (mutation.type == "left_menu") {
                    this.instances.forEach(function (item, index) {
                        setTimeout(function () {
                            item.resize();
                        });
                    });
                    setTimeout(() => {
                        this.$refs.swiper.swiper.update();
                    });
                }
            });
            ApiService.get('auth/user_list').then(response => {
                this.tableData = response.data.users;
                this.tableData.forEach((item, index) => {
                    this.$set(item, "action",
                        "<a class='btn btn-info clickable' href='#/edit_user_dashboard/" + item.id + "'>Edit</a> " +
                        "<a class='btn btn-warning clickable' href='#/view_user_dashboard/" + item.id + "'>View</a>");
                });
            })
                .catch(error => {
                    this.processMessageError(error, 'auth/user_list', "get");
                });

            axios.get("http://www.filltext.com/?rows=1&chartdata={numberArray|12,100}").then(response => {
                this.ajaxbar_chart.series[0].data = response.data[0].chartdata;
                this.ajaxloading = false;
            })
                .catch(error => {
                });

        },
        beforeMount() {
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
        },
        beforeRouteLeave(to, from, next) {
            unsub();
            next();
        },

        methods: {
            onReady(instance) {
                this.instances.push(instance)
            },
            // ===chart animation===
            update_chart() {
                setInterval(() => {
                    for (var i = 0; i < this.ajaxbar_chart.series.length; i++) {
                        this.ajaxbar_chart.series[i].data.shift();
                        this.ajaxbar_chart.series[i].data.push(Math.floor((Math.random() * (1000 - 90) + 90) +
                            1));
                    }
                }, 4000);
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
            },

        }
    }
</script>
<!-- styles -->
<!-- adding scoped attribute will apply the css to this component only -->
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
</style>
<style src="chartist/dist/chartist.css"></style>

<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <b-card header="Chartist Line" header-tag="h4" class="bg-primary-card gradient1">
                    <vue-chartist :data="line.data" :options="line.options" type="Line" ref="chartist3"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Chartist Area" header-tag="h4" class="bg-primary-card gradient2">
                    <vue-chartist :data="area.data" :options="area.options" type="Line" ref="area"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Chartist bar" header-tag="h4" class="bg-info-card gradient3">
                    <vue-chartist :data="bar.data" :options="bar.options" :responsiveOptions="bar.responsiveOptions" type="Bar" ref="chartist2"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Horizontal bar" header-tag="h4" class="bg-info-card gradient4">
                    <vue-chartist :data="horizontal.data" :options="horizontal.options" type="Bar" ref="chartist2"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Series Override" header-tag="h4" class="bg-success-card gradient5">
                    <vue-chartist :data="series.data" :options="series.options" :responsiveOptions="series.responsiveOptions" type="Line" ref="chartist4"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header=" Fixed Scale Axis Chart" header-tag="h4" class="bg-success-card gradient6">
                    <vue-chartist :data="axischart.data" :options="axischart.options" type="Line" ref="chartist5"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Pie Chart" header-tag="h4" class="bg-info-card piechart gradient7">
                    <vue-chartist :data="pie.data" :options="pie.options" type="Pie" :responsiveOptions="pie.responsiveoptions" ref="chartist6"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Donut Chart" header-tag="h4" class="bg-info-card gradient8">
                    <vue-chartist :data="donut.data" :options="donut.options" type="Pie" :responsiveOptions="donut.responsiveoptions" ref="chartist6"></vue-chartist>
                </b-card>
            </div>
            <!--==============polar chart ========-->
            <div class="col-sm-6">
                <b-card header="Polar Chart" header-tag="h4" class="bg-primary-card gradient9">
                    <vue-chartist :data="polar.data" :options="polar.options" type="Bar" ref="chartist7"></vue-chartist>
                </b-card>
            </div>
            <div class="col-sm-6">
                <b-card header="Time Series With Moment" header-tag="h4" class="bg-primary-card gradient10">
                    <vue-chartist :data="time.data" :options="time.options" ype="line" ref="chartist8"></vue-chartist>
                </b-card>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from 'vue'
import VueChartist from 'v-chartist';
import Chartist from "chartist";
var unsub;
export default {
    name: "charts",
    components: {
        VueChartist
    },
    mounted: function() {
        unsub = this.$store.subscribe((mutation, state) => {
            if (mutation.type == "left_menu") {
                setTimeout(() => {
                    this.$refs.area.renderChart();
                    this.$refs.chartist2.renderChart();
                    this.$refs.chartist3.renderChart();
                    this.$refs.chartist4.renderChart();
                    this.$refs.chartist6.renderChart();
                    this.$refs.chartist7.renderChart();
                    this.$refs.chartist8.renderChart();
                })
            }
        });
    },
    data() {
        return {
            // =======line chart start===========
            line: {
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                    series: [
                        [12, 9, 7, 8, 5],
                        [2, 1, 3.5, 7, 3],
                        [1, 3, 4, 5, 6]
                    ]
                },
                options: {
                    fullWidth: true,
                    chartPadding: {

                        right: 40
                    }
                }
            },
            // =======Line chart end========
            // =======area chart start========
            area: {
                data: {
                    labels: ['2010', '2011', '2012', '2013', '2014', '2015', '2016'],
                    series: [
                        [2, 8, 3, 7, 4, 6, 4],
                        [5, 2, 6, 2, 7, 2, 6]
                    ]
                },
                options: {
                    top: 0,
                    low: 1,
                    showPoint: true,
                    fullWidth: true,

                    axisY: {
                        labelInterpolationFnc: function(value) {
                            return (value / 1) + 'k';
                        }
                    },
                    showArea: true
                }
            },
            // =======area chart end========
            series: {
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8'],
                    // Naming the series with the series object array notation
                    series: [{
                        name: 'series-3',
                        data: [5, 2, -4, 2, 0, -2, 5, -3]
                    }, {
                        name: 'series-2',
                        data: [4, 3, 5, 3, 1, 3, 6, 4]
                    }, {
                        name: 'series-3',
                        data: [2, 4, 3, 1, 4, 5, 3, 2]
                    }]
                },
                options: {
                    fullWidth: true,
                    // Within the series options you can use the series names
                    // to specify configuration that will only be used for the
                    // specific series.
                    series: {
                        'series-1': {
                            lineSmooth: Chartist.Interpolation.step()
                        },
                        'series-2': {
                            lineSmooth: Chartist.Interpolation.simple(),
                            showArea: true
                        },
                        'series-3': {
                            showPoint: false
                        }
                    }
                },
                responsiveOptions: [
                    // You can even use responsive configuration overrides to
                    // customize your series configuration even further!
                    ['screen and (max-width: 320px)', {
                        series: {
                            'series-1': {
                                lineSmooth: Chartist.Interpolation.none()
                            },
                            'series-2': {
                                lineSmooth: Chartist.Interpolation.none(),
                                showArea: false
                            },
                            'series-3': {
                                lineSmooth: Chartist.Interpolation.none(),
                                showPoint: true
                            }
                        }
                    }]
                ]
            },
            // =========================axis chart===========
            axischart: {
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                    series: [
                        [12, 9, 7, 8, 6, 5, 6, 7, 8, 9, 7, 6],

                        [5, 3, 4, 5, 4, 3, 3, 4, 5, 6, 3, 4],
                        [2.5, 2, 2, 3.5, 1, 2, 2, 2.5, 3, 1, 2, 4]
                    ]
                },
                options: {
                    fullWidth: true,
                    axisX: {
                        onlyInteger: true
                    },
                    axisY: {
                        ticks: [0, 50, 75, 87.5, 100],
                        low: 0
                    },
                    lineSmooth: Chartist.Interpolation.step(),
                    showPoint: false
                }
            },
            bar: {
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    series: [
                        [5, 4, 3, 7, 5, 10, 3, 4, 8, 10, 6, 8],
                        [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4]
                    ]
                },
                options: {
                    seriesBarDistance: 15
                },
                responsiveOptions: [
                    ['screen and (min-width: 641px) and (max-width: 1024px)', {
                        seriesBarDistance: 10,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value;
                            }
                        }
                    }],
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value[0];
                            }
                        }
                    }]
                ]
            },
            horizontal: {
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    series: [
                        [5, 4, 3, 7, 5, 10, 3],
                        [3, 2, 9, 5, 4, 6, 4]
                    ]
                },
                options: {
                    seriesBarDistance: 10,
                    reverseData: true,
                    horizontalBars: true,
                    axisY: {
                        offset: 70
                    }
                }
            },
            // ======pie chart start=======
            pie: {
                data: {
                    labels: ['A', 'B', 'C'],
                    series: [20, 15, 40]
                },
                options: {
                    labelInterpolationFnc: function(value) {
                        return value[0]
                    }
                },
                responsiveoptions: [
                    ['screen and (min-width: 640px)', {
                        chartPadding: 30,
                        labelOffset: 50,
                        labelDirection: 'explode',
                        labelInterpolationFnc: function(value) {
                            return value;
                        }
                    }],
                    ['screen and (min-width: 1024px)', {
                        labelOffset: 45,
                        chartPadding: 20
                    }]
                ]
            },
            // ======pie chart end================
            // ======donut chart start=======
            donut: {
                data: {
                    labels: ['A', 'B', 'C'],
                    series: [30, 20, 50]
                },
                options: {
                    donut: true,
                    donutWidth: 60,
                    labelInterpolationFnc: function(value) {
                        return value[0]
                    }
                },
                responsiveoptions: [
                    ['screen and (min-width: 640px)', {
                        chartPadding: 30,
                        labelOffset: 60,
                        labelDirection: 'explode',
                        labelInterpolationFnc: function(value) {
                            return value;
                        }
                    }],
                    ['screen and (min-width: 1024px)', {
                        labelOffset: 50,
                        chartPadding: 20
                    }]
                ]
            },
            // ======donut chart end================

//            //===========ploar chart===================
            polar: {
                data: {
                    color:['red'],
                    labels: ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', 'W8', 'W9', 'W10'],
                    series: [
                        [1, 2, 4, 8, 6, -2, -1, -4, -6, -2]
                    ]
                },
                options: {
                    high: 10,
                    low: -10,
                    axisX: {
                        labelInterpolationFnc: function(value, index) {
                            return index % 2 === 0 ? value : null;
                        }
                    }
                },
            },
//            //===========ploar chart end===================
            // =======line chart start===========
            time: {
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                    series: [
                        {
                            name: 'series-1',
                            data: [
                                {x: new Date(143134652600), y: 53},
                                {x: new Date(143234652600), y: 40},
                                {x: new Date(143340052600), y: 45},
                                {x: new Date(143366652600), y: 40},
                                {x: new Date(143410652600), y: 20},
                                {x: new Date(143569652600), y: 10},
                                {x: new Date(143579652600), y: 1}
                            ]
                        },
                        {
                            name: 'series-2',
                            data: [
                                {x: new Date(143134652600), y: 53},
                                {x: new Date(143234652600), y: 35},
                                {x: new Date(143334652600), y: 30},
                                {x: new Date(143384652600), y: 30},
                                {x: new Date(143568652600), y: 10},
                                {x: new Date(143568652600), y: 5},
                                {x: new Date(143568652600), y: 1}
                            ]
                        }
                    ]
                },
                options: {
                    fullWidth: true,
                    chartPadding: {
                        right: 40
                    }
                }
            },
            // =======Line chart end========

        }
    },
    methods: {

    },
    beforeRouteLeave (to, from, next) {        unsub();        next();    },


}
</script>
<style src="chartist/dist/chartist.css"></style>
<style>
    .piechart .ct-label{
        fill:#fff;
    }
    #app .gradient1 .card-body {
        background: linear-gradient(to right, #e0ffff 24%, #e9fdff 50%);
    }
    #app .gradient2 .card-body{
        background: linear-gradient(-19deg, #effbff 0%, #f7fdff 100%);
    }
    #app .gradient2 .ct-series-b .ct-area{
        fill:#0025da;
    }
    #app .gradient2 .ct-series-a .ct-area{
        fill:#25ff72;
    }
    #app .gradient3 .card-body{
        background: linear-gradient(-225deg, #e9f9ea 0%, #f4fff5 100%);
    }
    #app .gradient4 .card-body{
        background: linear-gradient(to top, #f6fdf6 0%, #fcfffc 99%, #ffffff 100%);
    }
    #app .gradient5 .card-body{
        background: linear-gradient(to top, #f3f5ff 0%, #f5ecff 50%);
    }
    #app .gradient6 .card-body{
        background: linear-gradient(to top, #f3f5ff 0%, #fbf3ff 50%);
    }
    #app .gradient7 .card-body{
        background: linear-gradient(39deg, #4f8ff5 32%, #1D79F3 67%);
    }
    .ct-series-c .ct-slice-pie{
        fill: #fbeea3 !important;
    }
    .ct-series-b .ct-slice-pie{
        fill: #b4ffdb !important;
    }
    .ct-series-a .ct-slice-pie{
        fill: #ffb4b1 !important;
    }
    #app .gradient8 .card-body{
        background: linear-gradient(136deg, #0ed0cf 42%, #3ee6e5 80%);
    }
    .ct-series-c .ct-slice-donut{
        stroke: #bce9ff !important;
        stroke-width: 40px !important;
    }
    .ct-series-b .ct-slice-donut{
        stroke: #ffaf59 !important;
        stroke-width: 40px !important;
    }
    .ct-series-a .ct-slice-donut{
        stroke: #70a7fd !important;
        stroke-width: 40px !important;
    }
    #app .gradient9 .card-body{
        background: linear-gradient(120deg, #defffc 24%, #ebffff 50%);
    }
    #app .gradient10 .card-body{
        background:linear-gradient(to top, #f6fff0 24%, #edffe0 88%);
    }
    .ct-series-a .ct-bar{
        stroke: #007ea9 !important;
    }
    .ct-series-a .ct-line, .ct-series-a .ct-point{
        stroke: #6699cc !important;
    }
    .ct-series-b .ct-line, .ct-series-b .ct-point{
        stroke:#46b37d !important;
    }
    .ct-series-c .ct-line, .ct-series-c .ct-point{
        stroke: #f59797 !important;
    }
    .ct-line,.ct-point{
        stroke-width:2px;
    }
</style>

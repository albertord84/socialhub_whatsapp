<template>
    <div class="row">
        <div class="col-sm-6">
            <b-card header="Trend chart" header-tag="h4" class="bg-success-card trendvue">
                <trend
                        :data="[0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0]"
                        :gradient="['#6fa8dc', '#42b983', '#f27a09','#ff5454']"

                        smooth>
                </trend>
            </b-card>

        </div>
        <div class="col-sm-6">
            <b-card header="Vue-bar chart" header-tag="h4" class="bg-success-card">
                <bars
                        :data="[1, 2, 5, 9, 5, 10, 3, 5, 2, 5, 1, 8, 2, 9, 0]"
                        :gradient="['#6fa8dc', '#42b983']"
                        :growDuration="1"
                >
                </bars>
            </b-card>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import Trend from 'vuetrend';
    Vue.use(Trend);
    import Bars from 'vuebars'
    Vue.use(Bars);
    export default {
        name: "blank",
        data(){
            return{

            }
        },
        methods:{

    }
    }
</script>
<style>
    .trendvue svg path{
    stroke-width:2px;
    }
    .card svg{
        height: 40vh;
    }
</style>
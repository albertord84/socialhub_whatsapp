<template>
    <div>
        <preloader v-show="this.$store.state.preloader"></preloader>
        <vueadmin_header></vueadmin_header>
        <div class="wrapper row-offcanvas">
            <center_side class="">
                <router-view></router-view>
            </center_side>
        </div>
        <!-- <div class="background-overlay" @click="right_close"></div>
        <div class="background-overlay2" @click="left_close"></div> -->

    </div>
</template>
<script>
    import preloader from 'components/layouts/preloader/preloader'
    import center_side from 'components/layouts/center-side'
    import left_side from 'components/layouts/left-side/default/left-side'
    import vueadmin_header from 'components/layouts/header/fixed-header-attendant'
    import 'resources/sass/custom.scss'
    import 'components/layouts/css/fixed-menu.scss'
    import anime from 'animejs'

    export default {
        name: 'layout',
        components: {
            preloader,
            vueadmin_header,
            center_side
        },
        data() {
            return {
                showtopbtn: false
            }
        },
        methods: {
            right_close() {
                this.$store.commit('rightside_bar', "close");
            },
            left_close() {
                this.$store.commit('leftside_bar', "close");
            }
        },
        beforeMount(){
            this.$store.commit('rightside_bar', "close");
            this.$store.commit('leftside_bar', "close");
        },
        mounted() {
            if (window.innerWidth <= 992) {
                this.$store.commit('left_menu', 'close')
            }
        },

    }
</script>
<style lang="scss" scoped>
    .wrapper:before,
    .wrapper:after {
        display: table;
        content: " ";
    }

    .wrapper:after {
        clear: both;
    }

    .wrapper {
        display: table;
        overflow-x: hidden;
        width: 100%;
        max-width: 100%;
        table-layout: fixed
    }

    .right-aside,
    .left-aside {
        padding: 0;
        display: table-cell;
        vertical-align: top;
    }

    .right-aside {
        background-color: #ebf2f6 !important;
    }

    @media (max-width: 992px) {
        .wrapper>.right-aside {
            width: 100vw;
            min-width: 100vw;
        }
    }
</style>

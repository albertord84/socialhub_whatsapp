<template>
    <div>
        <preloader v-show="this.$store.state.preloader"></preloader>
        <vueadmin_header_admin></vueadmin_header_admin>
        <div class="wrapper row-offcanvas">
            <left_side_seller v-show="this.$store.state.left_open"></left_side_seller>
            <right_side class="pl-4">
                <router-view></router-view>
            </right_side>
        </div>

        <div class="background-overlay" @click="right_close"></div>

    </div>
</template>
<script>
    import preloader from 'components/layouts/preloader/preloader'
    import right_side from 'components/layouts/right-side'
    import left_side_seller from 'components/layouts/left-side/default/left-side-seller'
    import vueadmin_header_admin from 'components/layouts/header/fixed-header-admin'
    import 'resources/sass/custom.scss'
    import 'components/layouts/css/fixed-menu.scss'    
    import anime from 'animejs'

    export default {
        name: 'layout',
        components: {
            preloader,
            vueadmin_header_admin,
            left_side_seller,
            right_side
        },
        data() {
            return {
                showtopbtn: false
            }
        },
        methods: {
            right_close() {
                this.$store.commit('rightside_bar', "close");
            }
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

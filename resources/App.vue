<template>
    <div id="app" class="no-letter-spacing">
        <router-view></router-view>
    </div>
</template>
<script>
    import Vue from "vue";
    import BootstrapVue from 'bootstrap-vue';
    import ToggleButton from 'vue-js-toggle-button';
    Vue.use(ToggleButton)
    Vue.use(BootstrapVue);

    export default {
        name: 'app'
    }

</script>

<style scoped>
    .no-letter-spacing{
        letter-spacing:0px !important;
    }
</style>

<style lang="scss" src="resources/sass/bootstrap/bootstrap.scss"></style>
<style src="font-awesome/css/font-awesome.css"></style>
<style src="@mdi/font/css/materialdesignicons.css"></style>
<style src="bootstrap-vue/dist/bootstrap-vue.css"></style>

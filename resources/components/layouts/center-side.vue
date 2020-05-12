<template>
    <aside class="right-aside">        
        <section class="content">
            <slot></slot>
        </section>
    </aside>
</template>

<script>
    export default {
        name: "center-side",
        components: {
        }
    }
</script>

<style lang="scss" scoped>
    .right-aside {
        padding: 0 0px 0px 0px;
        width: 100%;
        max-width: 100%;
        height: calc(100vh-100px);
        margin-left: 0px;
        
        .content-header > h1 {
            margin: 2px;
            padding-left: 13px;
            padding-top: 12px;
            font-size: 20px;
            line-height: 1.5;
        }
        .content-header {
            margin: -2px -20px 25px -20px;
            height: 55px;
            background: #f9fafb ;
            box-shadow: 3px 1px 5px #ccc;
        }
    }
</style>

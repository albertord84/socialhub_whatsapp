<template>
    <chat :list="chat" class="chat"></chat>
</template>
<script>
    import Vue from "vue"
    import chat from "components/widgets/chat_component/chat-large.vue";
    import chat_data from "../../../js/chat_data";

    export default {
        name: "chat_page",
        props: {
        },
        components: {
            chat,
        },
        data() {
            return {
                chat: chat_data,
            }
        },
        mounted() {
        },
        computed: {
        },
        methods: {
        }
    }
</script>
<style lang="scss" scoped>
    .chat {
        min-height: calc(100vh - 50px);
        height: calc(100vh - 50px);
        // overflow: auto;
        overflow: hidden;
    }
</style>

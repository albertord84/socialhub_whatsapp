<template>
    <div id="left" :class="{ open: this.$store.state.left_open }">
        <div id="left-slim">
            <attendantCRUDContact v-if="left_layout=='toggle-add-contact'" :action='"insert"' :item='item' @reloadContacts='reloadContacts'></attendantCRUDContact>
        </div>
    </div>
</template>
<script>
    import "../../sass/_left_side_bar.scss"

    import attendantCRUDContact from "../pages/socialhub/popups/attendantCRUDContact.vue";

    export default {
        name: "left_side_bar",
        props:{
            item:{},
            left_layout:''
        },
        components:{
            attendantCRUDContact,
        },
        data(){
            return{
                toggle_add:false,
                toggle_filter:false,
            }
        },
        mounted: function() {
            
        },
        destroyed: function() {

        },
        methods: {
            change_skin() {
            },

            reloadContacts(){
                this.$emit('reloadContacts');
            },
        },        
    }
</script>




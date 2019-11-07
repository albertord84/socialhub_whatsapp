<template>
    <div id="left" :class="{ open: this.$store.state.left_open }">
        <div id="left-slim">
            <!-- <slot></slot> -->
            <attendantAddContact v-if="left_layout=='toggle-add-contact'" @onreloaddatas='reloadContacts'></attendantAddContact>
            
            <!-- <attendantFilterContact v-if="left_layout=='toggle-filter-contact'"></attendantFilterContact> -->
        </div>
    </div>
</template>
<script>
    import "../../sass/_left_side_bar.scss"

    import attendantAddContact from "../pages/socialhub/attendantAddContact.vue";
    import attendantFilterContact from "../pages/socialhub/attendantFilterContact.vue";

    export default {
        name: "left_side_bar",
        props:{
            left_layout:''
        },
        components:{
            attendantAddContact,
            attendantFilterContact
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




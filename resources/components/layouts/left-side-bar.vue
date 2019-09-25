<template>
    <div id="left" :class="{ open: this.$store.state.left_open }">
        <div id="left-slim">
            <!-- <slot></slot> -->
            <add_contact v-if="left_layout=='toggle-add-contact'"></add_contact>
            <filter_contact v-if="left_layout=='toggle-filter-contact'"></filter_contact>
            
        </div>
    </div>
</template>
<script>
    import "../../sass/_left_side_bar.scss"

    import add_contact from "../pages/add_contact.vue";
    import filter_contact from "../pages/filter_contact.vue";

    export default {
        name: "left_side_bar",
        props:{
            left_layout:''
        },
        components:{
            add_contact,
            filter_contact
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
            }
        },        
    }
</script>




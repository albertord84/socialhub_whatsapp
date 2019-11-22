<template>
    <div id="right" :class="{ open: this.$store.state.right_open } " class="mt-5">
        <div id="right-slim" class="mt-3" >
            <attendantCRUDContact v-if="right_layout=='toggle-edit-contact'" :action='"edit"' :item='item' @onreloaddatas='reloadEditedContacts'></attendantCRUDContact>
        </div>
    </div>
</template>
<script>
    import "../../sass/_right_side_bar.scss"

    import attendantCRUDContact from "../pages/socialhub/popups/attendantCRUDContact.vue";

    export default {
    name: "right_side_bar",
    props:{
            item:{},
            right_layout:''
        },
    components:{
        attendantCRUDContact,
    },
    mounted: function() {

    },
    destroyed: function() {

    },
    methods: {
        change_skin() {
        },

        reloadEditedContacts(){
            this.$emit('reloadEditedContacts');
        }
    }
}
</script>




<template>
    <div>
        <!-- <picker set="emojione"/> -->
        <!-- <picker @select="addEmoji"/> -->
        <!-- <picker title="Pick your emoji…" emoji="point_up" /> -->
        <!-- <picker :style="{ position: 'absolute', bottom: '20px', right: '20px' }" /> -->
        <!-- <picker :i18n="{ search: 'Recherche', categories: { search: 'Résultats de recherche', recent: 'Récents' } }" /> -->

        <picker 
                set="emojione" 
                @select="addEmoji" 
                title="" 
                emoji=""
                :style="{ position: 'absolute', bottom: '20px', right: '20px'}"
                :i18n="{ 
                    search: 'Pesquisar', 
                    categories: { 
                        search: 'Resultados da pesquisa', 
                        recent: 'Recentes',
                        people: 'Smileys e Pessoas',
                        nature: 'Animais e Natureza',
                        foods: 'Alimentação e bebida',
                        activity: 'Atividade',
                        places: 'Viagens e lugares',
                        objects: 'Objetos',
                        symbols: 'Símbolos',
                        flags: 'Bandeiras',
                        custom: 'Personalizados',
                    }
                }"
                :perLine="15"                                                                                                                                                                                                                                                                                                                                                                                                                                              
                :showPreview="false"
                :showSearch="false"
        />
        <p>Slected emoji is:<emoji :emoji="{ id: 'santa', skin: 3 }" :size="16" /> and id unified code is </p>
    </div>
</template>

<script>
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import { Picker } from 'emoji-mart-vue';
    import { Emoji } from 'emoji-mart-vue';
    import data from 'emoji-mart-vue/data/emojione.json'
    import { NimbleEmojiIndex } from 'emoji-mart-vue';
    

    export default {   
        components:{
            Picker,
            Emoji,
            // data,
            NimbleEmojiIndex
        },

        data() {
            return {
                emoji:null
            }
        },

        methods: {  
            addEmoji: function(emoji) {
                this.emoji = emoji;
            }
        },

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
            
        },

        mounted() {
            
        },        

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        computed: {
            
        },

        watch: {
            
        },
        
    }


</script>

<style scoped>
    .pagination {
        margin-top: 12px;
    }

    .sortable {
        cursor: pointer;
    }

    .has-search .form-control {
        padding-left: 2.375rem;
    }
    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }  
    .has-search-color{
        color: #aaa;
    }
    .btn_width{
        width: 100px
    }
    .text-18{
        font-size: 18px
    }
    .no-shadows{
        box-shadow: none !important;
    }
</style>

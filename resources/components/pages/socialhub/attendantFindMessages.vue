<template>
    <div class="" style="margin-top:50px; width:100%">
        <!-- <div class="col-lg-12"> -->
            <div class="col-lg-12 sect_header">
                <ul class="menu">
                    <li><p>Mensagens anteriores</p> </li>
                    <ul class="menu float-right">
                        <li ><a href="javascript:void(0)" @click.prevent="ftext='';toggle_right()"><i class="fa fa-close"></i></a></li>
                    </ul>
                </ul>
            </div>
            <div class="col-lg-12 sect_header">
                <div style="padding:15px 9px 8px 5px" class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control transp" v-model="ftext" @change="fchange()" placeholder="Digitar texto">
                </div>
            </div>
            
            <!-- <div class="col-lg-12 p-0">
                <div class="converstion_back">                    
                    <v-scroll :height="Height(131)" color="#ccc" bar-width="8px" ref="message_scroller" :style="{ backgroundImage: 'url('+bgColor+')'}">
                        <ul>
                            <li v-for='(item,index) in list[selected_user_index].messages' :key="index" :class="[{ sent: item.from=='me' },{ received: item.from!=='me' }]">
                                <div>
                                    <div class="msg_time">{{item.time}}</div>
                                    <p>{{ item.msg }}</p>
                                </div>
                            </li>
                        </ul>
                    </v-scroll>                    
                </div>
            </div> -->
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    import ApiService from "resources/common/api.service";
    
    Vue.use(VueForm, options);
    export default {
        name: "attendantFindMessagest",
        data() {
            return {
                ftext:'',

                formstate: {},
                model: {
                    name: "",
                    email: "",
                    fix_phone: "",
                    whatsapp: "",
                    facebook: "",
                    instagram: "",
                    linkedin: "",
                    decription: "",                    
                },
                show_error:false,
                show_success:false,
                validationErrors:[],
            }
        },
        methods: {
            fchange(){
                this.ftext = this.ftext.trim();
                if(this.ftext.length>3){
                    //filter messages by content in this.ftext
                }
            },
            fclear(){
                alert(11111111111);
                console.log('sfdsdvsdv');
                //this.ftext='';
            },
            
            toggle_right() {
               this.$store.commit('rightside_bar', "toggle");
            },
        },
        mounted: function () {
        },
        destroyed: function () {

        }
    }
</script>
<style scoped>
    .dropzone_wrapper {
        width: 100%;
    }

    .align-left {
        float: left;
    }

    .align-right {
        float: right;
    }
    /*-------------------------------------*/
    .sect_header{
        background-color:#eaf5ff;
        height:50px;  
        border: 1px solid #e9e9e9;
    }
    /*-------------------------------------*/
    .menu{
        z-index: 100;
        list-style:none; 
        margin: 0;
        padding: 0;        
    }
    .menu li{
        position:relative; 
        float:left; 
        
    }
    .menu li a,p{
        font-size: 12px;
        display: block;
        color: gray;
        text-align: left;
        padding: 8px;
        padding-top: 16px;
        text-decoration: none;
    }    
    .menu, li, a, a:active, a:focus {
        outline: none;
    }
    /*-------------------------------------*/
      .has-icon .form-control {
        padding-left: 2.375rem;
    }
    .has-icon .form-control {
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
    .btn_width{
        width: 100px
    }
    /*-------------------------------------------------*/
        
    .transp {
        background-color:rgba(0, 0, 0, 0);
        color:gray;
        border: none !important;
        outline:none !important;
        height:28px;
        transition:height 1s;
        -webkit-transition:height 1s;
    }
    .transp:focus {
        outline: none !important;
        border: none !important;
        outline-width: 0 !important;
    }

</style>

<template>
    <div class="row chat">

        <right-side-bar  :right_layout ="right_layout"></right-side-bar>
        <left-side-bar  :left_layout ="left_layout"></left-side-bar>

        <!-- Left side of chat-->
        <div id="chat-left-side" class="col-lg-3 p-0">
            <div class="chatalign">
                <div class="sect_header">
                    <ul class='menu'>
                        <li><p>Contatos</p></li>                    
                        <ul class='menu' style="float:right">
                            <li><a href='javascript:void(0)' title="Novo contato" class="round_btn" @click="toggle_left('toggle-add-contact')"><i class="fa fa-user-plus fa-xs" ></i></a></li>
                            <!-- <li><a href='javascript:void(0)' title="Filtar contatos" class="round_btn" @click="toggle_left('toggle-filter-contact')"><i class="fa fa-filter" ></i></a></li> -->
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-paper-plane mt-3" title="Mensagens" style="color:gray"></i>
                                    </template>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-database"></i> Arquivadas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-star-o"></i> Favoritas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-bell-o"></i> Lembretes</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-address-card-o"></i> Resumos</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-envelope-open-o"></i> Lidas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-envelope-o"></i> Não lidas</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li>                             
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-filter mt-3" title="Status"  style="color:gray"></i>
                                    </template>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-users"></i> Todos</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-ambulance"></i> Prioridade</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-eye"></i> Seguimento</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-hand-peace-o"></i> Encerrados</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-exchange"></i> Transferidos</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-sort-amount-desc"></i> Adhesão</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li> 
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-globe fa-lg mt-3" title="Rede Social" style="color:gray"></i>
                                    </template>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-whatsapp"></i> WhatsApp</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-facebook-official"></i> Facebook</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-instagram"></i> Instagram</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-linkedin"></i> LinkedIn</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li>                            
                        </ul>
                    </ul>                    
                </div>
                <div class="sect_header">
                    <div style="width:100%; padding:15px 9px 8px 5px" class="form-group has-search">
                        <span class="fa fa-search form-control-feedback transp"></span>
                        <input type="text" class="form-control transp" placeholder="Buscar contato">
                    </div>
                </div>
                <v-scroll :height="Height(0)"  color="#ccc" bar-width="8px">
                    <ul>
                        <li v-for="(user,index) in list" class="chat_block" :key="index">
                            <a :href="user.user" @click.prevent="show_chat(user,index)">
                                <article class="media mt-3 mb-3">
                                    <a class="float-left desc-img mt-3">
                                        <img :src="user.image" class="img-fluid rounded-circle">
                                    </a>
                                    <span class="status-online"></span>
                                    <div class="media-body pl-3 mb-1 mt-3 chat_content">
                                        <a class="text-success " href="javascript:void(0)">{{user.user}}</a><br>
                                        <a class="text-muted"><span>{{ text_truncate(user.status,20) }}</span></a>
                                    </div>
                                    <span class="mt-2 text-muted">12.54</span>
                                </article>
                            </a>
                        </li>
                    </ul>
                </v-scroll>
            </div>
        </div>

        <!-- Center side of chat-->
        <div id="chat-center-side" class="col-lg-9 p-0"><!-- <div class="col-sm-4 col-md-5 mt-3"> -->
            <div class="converstion_back">
                <div class="sect_header">
                    <ul class='menu'>
                        <li><span class="pl-4"><img :src="list[selected_user_index].image" class="img-fluid rounded-circle desc-img pointer-hover" @click.prevent="fn_show_chat_right_side()"></span></li>
                        <li><span class="pl-3 person_name person_name_style pointer-hover" @click.prevent="fn_show_chat_right_side()"></span></li>
                        <li><p class="pl-0 ml-0 pointer-hover" @click.prevent="fn_show_chat_right_side()">{{ list[selected_user_index].user }} </p></li>                        
                        <ul class='menu' style="float:right">
                            <li><a href="javascript:void()" title="Buscar mensagens" @click="fn_show_chat_find_right_side()/*toggle_right('toggle-find-messages')*/"><i class="fa fa-search"></i></a></li>
                            <li><a href="javascript:void()" title="Anexar imagem"><i class="fa fa-picture-o"></i><!-- <i class="fa fa-paperclip"></i>--></a></li>
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" id="dropdown-right" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-v mt-3" title="Opcões"  style="color:gray"></i>
                                    </template>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-database"></i> Arquivadas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-star-o"></i> Favoritas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-bell-o"></i> Lembretes</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-address-card-o"></i> Resumos</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li> 
                        </ul>
                    </ul> 
                </div>
                <div style="background-color:black; margin-top:0px; padding:0px">
                    <v-scroll :height="Height(170)" color="#ccc" bar-width="8px" ref="message_scroller" :style="{ backgroundImage: 'url('+bgColor+')'}">
                        <ul>
                            <li v-for='(item,index) in list[selected_user_index].messages' :key="index" :class="[{ sent: item.from=='me' },{ received: item.from!=='me' }]">
                                <div class="" >
                                    <p class="message" @mouseover='mouseOverMessage("message-dropdown-"+index)' @mouseleave='mouseLeaveMessage("message-dropdown-"+index)'> 
                                        <b-dropdown class="dropdown hidden-xs-down btn-group float-right message-hout" :id='"message-dropdown-"+index' variant="link" toggle-class="text-decoration-none"  right="">
                                            <template v-slot:button-content>
                                                <i class="fa fa-angle-down fa-lg mb-1" title="Opcões"  style="color:gray"></i>
                                            </template>
                                            <b-dropdown-item exact class="dropdown_content">
                                                <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-reply"></i> Responder</a>
                                            </b-dropdown-item>
                                            <b-dropdown-item exact class="dropdown_content">
                                                <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-database"></i> Arquivar</a>
                                            </b-dropdown-item>
                                            <b-dropdown-item exact class="dropdown_content">
                                                <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-star-o"></i> Favoritar</a>
                                            </b-dropdown-item>
                                            <b-dropdown-item exact class="dropdown_content">
                                                <a href="javascript:void(0)" exact class="drpodowtext"><i class="fa fa-bell-o"></i> Lembrar</a>
                                            </b-dropdown-item>
                                        </b-dropdown>
                                        <span v-show='item.type == "image"' class='mb-2'><img :src='item.src' style='width:100px'/></span>   <br>                                 
                                        <span style='text-align:center' v-show='item.type == "audio"' class='mb-2'>
                                            <audio controls class="mycontrolBar">
                                                <source :src='item.src' type="audio/ogg">
                                                <source :src="item.src" type="audio/mpeg">
                                                Seu navegador não suporta o elemento de áudio.
                                            </audio> <br>
                                        </span>
                                        <span style="font-size:12px; color:#4f4e4e">{{ item.msg }}</span><br>
                                        <span class="msg_time float-right">{{item.time}}</span>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </v-scroll>
                </div>
                
                <div class="input-group p-3" style="background-color:#ebf2f6">
                    <div class="input-group-append">
                        <button class="btn btn-success send-btn" type="submit" @click="send_message"><i class="fa fa-paper-plane-o text-white" aria-hidden="true"></i></button>
                    </div>
                    <input type="text" @keyup.enter="send_message" v-model="newmessage" placeholder="Nova mensagem" class="form-control text-input-message" ref="input">
                </div>
            </div>
        </div>

        <!-- Right side of chat-->
        <div id="chat-right-side" v-show="show_chat_right_side==true" class="col-lg-3 bg-white p-0"><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
            <div class="sect_header">
                <ul class='menu'>
                    <li><p>Detalhes</p></li>
                        <ul class='menu' style="float:right">                            
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-v mt-3" title="Ações sobre contato" style="color:gray"></i>
                                    </template>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="toggle_right('toggle-edit-contact')"><i class="fa fa-pencil-square-o"></i> Editar</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="toggle_right('toggle-edit-contact')"><i class="fa fa-exchange"></i> Transferir</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="toggle_right('toggle-edit-contact')"><i class="fa fa-bell-slash-o"></i> Silenciar</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="toggle_right('toggle-edit-contact')"><i class="fa fa-ban"></i> Bloquear</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="toggle_right('toggle-edit-contact')"><i class="fa fa-trash-o"></i> Eliminar</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li>                            
                        </ul>
                </ul> 
            </div>

            <label></label>
            <div class="profile sec_decription bg-white text-center">
                    <img :src="list[selected_user_index].image"  class="rounded-circle  mb-3 mt-3" alt="User Image">
                    <h4 class="text-gray">{{list[selected_user_index].user}}</h4>
                    <p>{{list[selected_user_index].status}}</p>
                    <p>Mobile Number: <b>{{list[selected_user_index].mbl_num}}</b></p>
                    <p>Organisation: <b>{{list[selected_user_index].work}}</b></p>
                    <div class="attachments  p-4">
                        <h5>Attachments</h5>
                        <div class="row">
                            <div class="col-4 mt-2">
                                <img src="~img/pages/14.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="col-4 mt-2">
                                <img src="~img/pages/15.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="col-4 mt-2">
                                <img src="~img/pages/16.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="col-4 mt-2">
                                <img src="~img/pages/17.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="col-4 mt-2">
                                <img src="~img/pages/18.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="col-4 mt-2">
                                <img src="~img/pages/20.jpg" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>


            </div>
        </div>

        <!-- Find-Right side of chat-->
        <div id="chat-find-right-side" v-show="show_chat_find_right_side==true" class="col-lg-3 bg-white p-0"><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
            <div class="" style="margin-top:0px; width:100%">
                <div class="col-lg-12 sect_header">
                    <ul class="menu">
                        <!-- <li><p>Mensagens anteriores</p> </li> -->
                        <li>
                            <div style="width:100%; padding:15px 9px 8px 5px" class="form-group has-search">
                                <span class="fa fa-search form-control-feedback"></span>
                                <input type="text" class="form-control transp" v-model="ftext" @change="fchange()" placeholder="Procurar mensagens">
                            </div>
                        </li>
                        <ul class="menu float-right">
                            <li ><a href="javascript:void(0)" @click.prevent="ftext='';fn_show_chat_find_right_side()/*toggle_right()*/"><i class="fa fa-close"></i></a></li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
    import vScroll from "../../plugins/scroll/vScroll.vue";
    import rightSideBar from '../../layouts/right-side-bar'
    import leftSideBar  from '../../layouts/left-side-bar'
    import attendantFindMessages  from 'resources/components/pages/socialhub/attendantFindMessages'
    
    import chat_data from "../../../js/chat_data";
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";

    export default {
        components: {
            vScroll,
            rightSideBar,
            leftSideBar,
            attendantFindMessages
        },

         data() {
            return {
                contacts_url: 'contacts',
                messages_url: 'contacts',
                contacts:[],
                messages:[],
                index:0,
                
                list:chat_data,

                ftext:'',
                show_chat_right_side:false,
                show_chat_find_right_side:false,
                bgColor:require('img/pages/chat_background.png'),
                className:'',
                newmessage: '',
                selected_user_index: 0,
                right_layout:'toggle-edit-contact',
                left_layout:'toggle-add-contact',
                window: {
                    width: 0,
                    height: 0
                }
            }
        },
        
        methods: {
            mouseOverMessage(id){
                document.getElementById(id).classList.remove("message-hout");
                document.getElementById(id).classList.add("message-hover");
            },

            mouseLeaveMessage(id){
                document.getElementById(id).classList.add("message-hout");
                document.getElementById(id).classList.remove("message-hover");
            },

            send_message() {
                if (this.newmessage.trim() != "") {
                    this.list[this.selected_user_index].messages.push({
                        msg: this.newmessage,
                        from: "me"
                    });
                    this.newmessage = "";
                    this.$refs.message_scroller.scrolltobottom();
                }
            },

            getContacts: function() { //R
                ApiService.get(this.contacts_url)
                    .then(response => {
                        this.contacts = response.data;
                        console.log(this.contacts);
                        var This=this;
                        response.data.forEach(function(item, i){
                            if(item.status)
                                item.status_name = item.status.name;
                            var name = "";
                            item.contact_atendant_id = 0;
                            if(item.latestAttendant){
                                item.attendant_name = item.latestAttendant.user.name;
                                item.contact_atendant_id = item.latestAttendant.user.id;
                            }
                        });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });
            }, 


            show_chat(user, index) {
                this.selected_user_index = index;
                setTimeout(() => {
                    this.$refs.input.focus();
                }, 20)
            },

            fn_show_chat_right_side(){
                if(this.show_chat_right_side==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.show_chat_find_right_side = false;
                    this.show_chat_right_side = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.show_chat_find_right_side = false;
                    this.show_chat_right_side = false;
                }
            },

            fn_show_chat_find_right_side(){
                if(this.show_chat_find_right_side==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.show_chat_right_side = false;
                    this.show_chat_find_right_side = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.show_chat_right_side = false;
                    this.show_chat_find_right_side = false;
                }
            },

            Height(val){
                return (this.window.height-val)+'px';
            },

            toggle_right(val) {
                this.right_layout = val;
                this.$store.commit('rightside_bar', "toggle");
            },

            toggle_left(val) {
                this.left_layout = val;
                this.$store.commit('leftside_bar', "toggle");
            },

            text_truncate (str, length, ending) {
                if (length == null) {
                    length = 100;
                }
                if (ending == null) {
                    ending = '...';
                }
                if (str.length > length) {
                    return str.substring(0, length - ending.length) + ending;
                } else {
                    return str;
                }
            },

            handleResize() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            }
        },

        beforeMount() {
            this.getContacts();

            this.$store.commit('leftside_bar', "close");
            this.$store.commit('rightside_bar', "close");
        },

        created() {
            // console.log(this.list);

            window.addEventListener('resize', this.handleResize)
            this.handleResize();

            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        destroyed() {
            window.removeEventListener('resize', this.handleResize)
        },
    }
</script>


<style scoped lang="scss">
    .desc-img {
        height: 40px;
        width: 40px;
    }

    .chat_block {
        border-bottom: 1px solid #f4f2f2;
    }

    .chatalign {
        background-color: #fff !important;
        height: calc(100% - 50px);        
        ul {
            padding: 0;
        }
        /deep/ .ss-container{
            padding-right: 10px;
        }
    }

    .converstion_back {
        height: calc(100% - 50px);
        overflow: hidden;
        background: #fff !important;
        border: 1px solid #d8d6d6;

        ul {
            padding: 0;
        }
        &>.chat_header {
            background-color: #eaf5ff;
            padding: 4px;
            font-size: 20px;
            font-weight: 500;
            label{
                width: 25px;
                height: 25px;
            }
            .bg1{
                background-image: url("~img/pages/chat_background.png");
            }
            .bg2{
                background-image: url("~img/pages/chat_background2.jpg");
            }
            .bg3{
                background-image: url("~img/pages/chat_background3.jpg");
            }
        }
       /deep/ .ss-wrapper{
         top: 0%;
         height: 96%;
        //  height: 90%;
        }
    }

    .received div p,
    .sent div p {
        max-width:400px;
        min-width:200px;
        text-overflow:hidden;
        word-break: break-word; 
        // word-break: break-all; 
        border-radius: 7px;
        display: inline-block;
        padding: 7px 12px;
        position: relative;
        border: 1px solid #d4d2d2;
    }

    .received div p::after{
        content: ' ';
        position: absolute;
        width: 0;
        height: 0;
        left: -12px;
        right: auto;
        top: 0px;
        bottom: auto;
        border: 12px solid;
        border-color: #fff transparent transparent transparent;
    }
    .received div p::before{
        content: ' ';
        position: absolute;
        width: 0;
        height: 0;
        left: -12px;
        right: auto;
        top: -1px;
        bottom: auto;
        border: 12px solid;
        border-color: #d4d2d2 transparent transparent transparent;
    }
    .sent div p::before{
        content: ' ';
        position: absolute;
        width: 0;
        height: 0;
        right: -13px;
        top: -1px;
        bottom: auto;
        border: 12px solid;
        border-color: #d4d2d2 transparent transparent transparent;
    }
    .sent div p::after{
        content: ' ';
        position: absolute;
        width: 0;
        height: 0;
        right: -12px;
        top: 0;
        bottom: auto;
        border: 12px solid;
        border-color: #dbf2fa transparent transparent transparent;
    }

    .self {
        justify-content: flex-end;
        align-items: flex-end;
    }
    .self .msg {
        order: 1;
        border-bottom-right-radius: 0px;
        box-shadow: 1px 2px 0px #D4D4D4;
    }

    .sent>div {
        text-align: right;
        padding: 0 17px 0 17px;
        .msg_time{
            font-size: 9px;
        }
        p {
            background-color: #dbf2fa;
        }
    }

    .received>div {
        text-align: left;
        padding: 0 17px 0 17px;
        .msg_time{
            font-size: 9px;
        }
        p {
            background-color: #fff;
        }
    }

    .chat_content {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .status-online {
        width: 12px;
        height: 12px;
        border-radius: 6px;
        background-color: #63c17f;
        position: relative;
        top: 40px;
        left: -8px;
        border: 2px solid #fff;
    }

    .person_name:before {
        content: ' \25CF';
        font-size: 21px;
        position: relative;
        top: -11px;
        left: -27px;
        color: #63c17f;
    }

    .person_name {
        font-size: 12px;
        color: gray;
    }

    .profile {
        padding-bottom: 15px;
        // border: none;
        height: calc(100% - 50px);
        // overflow-y: auto;
        background-color: #FFFFFF;
    }
    .wrapper .converstion_back .ss-container{
        background-image: url("~img/pages/chat_background.png");
    }
    .bgcolor{
        border:2px solid #fff;
        height: 10px;
        width:10px;
    }
    .colors{
        line-height: 1rem;
        margin-top: 2px;
        span{
            font-size: 10px;
        }
    }
    .myscrool{
        height: calc(100% - 50px);
    }






    //added here
    //-----------------------------------------------
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
    
    
    //--------------------------------------------------
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
        font-size: 14px;
        display: block;
        color: gray;
        text-align: left;
        padding: 16px;
        text-decoration: none;
    }    
    .menu li ul{
        position:absolute; 
        top:50px; 
        left:-150px;
        background-color:rgb(250, 248, 248); 
        display:none;
        box-shadow: 4px 4px 4px 4px rgba(0, 0, 0, 0.1)
    }   
    .menu li:hover ul, 
    .menu li.over ul{
        display:block;
    }
    .menu li ul li{
        display:block; 
        width:100%;
    }
    .menu li ul li:hover{
        background-color: rgb(240, 238, 238)
    }
    .round_btn{
        border-radius: 50%;
        width: 50px;
        height: 50px;
    }
    .menu, li, a, a:active, a:focus {
        outline: none;
    }
    //---------------------------------------------------
    .sect_header{
        background-color:#eaf5ff;
        height:50px;  
        border: 1px solid #e9e9e9;
    }
    .sec_decription p, h4{
        text-align: center !important;
        // margin: 0px !important;
        padding: 5px !important;
    }

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
    .pointer-hover:hover{
        cursor: pointer;
    } 

    .chat {
        min-height: calc(100vh - 50px);
        height: calc(100vh - 50px);
        overflow: hidden;
    }  

    .mycontrolBar{
        background-color: white !important;
        opacity:0.5;
        color:white;
    }

    audio {
        width: 270px;
        height: 25px;
        border-radius: 90px;
        transform: scale(1.05);
    }

    .text-input-message{
        background-color:#fffff8;
        padding:22px 30px 22px 30px;
        font-size:17px;
        border-radius:20px;
        border: none;
    }
    .text-input-message:focus{
        outline: 0 !important;
        border: none !important;
        box-shadow: none;
    }

    .message{
        min-width:160px;
    }

    .message-hover{
        visibility:visible;
    }

    .message-hout{
        visibility:hidden;
    }

    .send-btn{
        border-top-right-radius:20px;
        border-bottom-right-radius:20px;
        // border-top-left-radius:20px;
        // border-bottom-left-radius:20px;
    }

</style>

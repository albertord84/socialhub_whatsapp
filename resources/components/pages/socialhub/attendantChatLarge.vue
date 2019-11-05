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
                                        <img width="20px" class="mt-3" src="~img/icons/filter-by-chat.png" title="Filtar por mensagens" alt="">
                                        <!-- <i class="fa fa-paper-plane mt-3" title="Mensagens" style="color:gray"></i> -->
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
                                        <!-- <img width="20px" class="mt-3" src="~img/icons/filter-by-user.jpg" title="Filtar por status" alt=""> -->
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
                    <div class="input-group pb-5 pr-1" style="color:gray" >
                        <div class="input-group-prepend">
                            <div v-if="searchContactByStringInput.length==0" style="background-color:#fffff8;color:gray" class="input-group-text border-right-0 border">
                                <i class="fa fa-search"></i>
                            </div>
                            <div v-if="searchContactByStringInput.length>0" @click="searchContactByStringInput=''" style="background-color:#fffff8;color:#6beda6" class="input-group-text border-right-0 border">
                                <i class="fa fa-arrow-left"></i>
                            </div>
                        </div>
                        <input class="form-control search-input border-left-0 border-right-0 border" type="search" v-model="searchContactByStringInput" placeholder="Buscar contato" >
                        <div v-if="searchContactByStringInput.length>0" class="input-group-prepend">
                            <div style="background-color:#fffff8;color:gray" @click="searchContactByStringInput=''" class="input-group-text border-left-0 border">
                                <i class="fa fa-close"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <v-scroll :height="Height(0)"  color="#ccc" bar-width="8px">
                    <ul>
                        <li v-for="(contact,index) in allContacts" class="chat_block" :key="index">
                            <a :href="contact.first_name" @click.prevent="show_chat(contact)">
                                <article class="media mt-1 mb-4">
                                    <a class="float-left desc-img mt-3">
                                        <img :src="JSON.parse(contact.json_data).urlProfilePicture" class="my-rounded-circle">
                                    </a>
                                    <span class="status-online">7</span>
                                    <div class="media-body pl-3 mb-1 mt-3 chat_content">
                                        <a class="text-success " href="javascript:void(0)">{{contact.first_name + ' ' + contact.last_name}}</a><br>
                                        <a class="text-muted"><span>{{ (contact.last_message) ? text_truncate(contact.last_message.message,20):'' }}</span></a>
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
            <div v-if="selected_contact_index>=0" class="converstion_back">
                <div class="sect_header">
                    <ul class='menu'>
                        <li><span class="pl-4"><img :src="JSON.parse(contacts[selected_contact_index].json_data).urlProfilePicture" class="img-fluid rounded-circle desc-img pointer-hover" @click.prevent="fn_show_chat_right_side()"></span></li>
                        <li><span class="pl-3 person_name person_name_style pointer-hover" @click.prevent="fn_show_chat_right_side()"></span></li>
                        <li><p class="pl-0 ml-0 pointer-hover" @click.prevent="fn_show_chat_right_side()">{{ contacts[selected_contact_index].first_name + ' ' + contacts[selected_contact_index].last_name }} </p></li>                        
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
                <v-scroll :height="Height(170)" color="#ccc" bar-width="8px" ref="message_scroller" :style="{ backgroundImage: 'url('+bgColor+')'}">
                    <ul >
                        <li v-for='(contact,index) in contacts[selected_contact_index].messages' :key="index" :class="[{ sent: contact.from=='me' },{ received: contact.from!=='me' }]">
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
                                    <span v-show='contact.type == "image"' class='mb-2'><img :src='contact.src' style='width:100px'/></span>   <br>                                 
                                    <span style='text-align:center' v-show='contact.type == "audio"' class='mb-2'>
                                        <audio controls class="mycontrolBar">
                                            <source :src='contact.src' type="audio/ogg">
                                            <source :src="contact.src" type="audio/mpeg">
                                            Seu navegador não suporta o elemento de áudio.
                                        </audio> <br>
                                    </span>
                                    <span style="font-size:12px; color:#4f4e4e">{{ contact.msg }}</span><br>
                                    <span class="msg_time float-right">{{contact.time}}</span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </v-scroll>                
                <div class="input-group p-3" style="background-color:#ebf2f6">
                    <div class="input-group-append">
                        <button class="btn btn-success send-btn" type="submit" @click="send_message"><i class="fa fa-paper-plane-o text-white" aria-hidden="true"></i></button>
                    </div>
                    <input type="text" @keyup.enter="send_message" v-model="newmessage" placeholder="Nova mensagem" class="form-control text-input-message" ref="input">
                </div>
            </div>
            <div v-else class="non_converstion_back">
                <div class="non-selected-chat text-center">
                    <img src="~img/socialhub/attendant.jpg" alt="" >
                    <h1>Mantenha seus contatos atualizados</h1>
                    <p class="text-right">"Os clientes se lembram de um bom atendimento durante muito mais tempo do que se lembram do preço ..."
                        <br>
                        <b class="text-right">Kate Zabriskie</b>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right side of chat--><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
        <div id="chat-right-side" v-show="show_chat_right_side==true" class="col-lg-3 bg-white p-0">
            <div class="sect_header">
                <ul class='menu'>
                    <li><a href="javascript:void(0)" @click.prevent="fn_show_chat_right_side()"><i class="fa fa-close" aria-hidden="true"></i></a></li>
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
            <div v-if="selected_contact_index>=0" class="profile sec_decription bg-white text-center">
                    <img :src="JSON.parse(contacts[selected_contact_index].json_data).urlProfilePicture"  class="rounded-circle desc-img2 mb-3 mt-3" alt="User Image">
                    <h4 class="text-gray">{{contacts[selected_contact_index].user}}</h4>
                    <p>{{contacts[selected_contact_index].status}}</p>
                    <p>Mobile Number: <b>{{contacts[selected_contact_index].mbl_num}}</b></p>
                    <p>Organisation: <b>{{contacts[selected_contact_index].work}}</b></p>
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

        <!-- Find-Right side of chat--><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
        <div id="chat-find-right-side" v-show="show_chat_find_right_side==true" class="col-lg-3 bg-white p-0">
            <div class="col-lg-12 sect_header">
                <ul class="menu">
                    <li><a href="javascript:void(0)" @click.prevent="fn_show_chat_find_right_side()"><i class="fa fa-close" aria-hidden="true"></i></a></li>
                    <li><p>Buscar mensagens</p></li>
                </ul>
            </div>
            <div class="col-lg-12 sect_header" style="color:gray;">
                <div class="input-group" style="color:gray; width:110%; left:-5%;" >
                    <div class="input-group-prepend">
                        <div v-if="searchMessageByStringInput.length==0" style="background-color:#fffff8;color:gray" class="input-group-text border-right-0 border">
                            <i class="fa fa-search"></i>
                        </div>
                        <div v-if="searchMessageByStringInput.length>0" @click="searchMessageByStringInput=''" style="background-color:#fffff8;color:#6beda6" class="input-group-text border-right-0 border">
                            <i class="fa fa-arrow-left"></i>
                        </div>
                    </div>
                    <input class="form-control search-input border-left-0 border-right-0 border" type="search" v-model="searchMessageByStringInput" placeholder="Buscar..." >
                    <div v-if="searchMessageByStringInput.length>0" class="input-group-prepend">
                        <div style="background-color:#fffff8;color:gray" @click="searchMessageByStringInput=''" class="input-group-text border-left-0 border">
                            <i class="fa fa-close"></i>
                        </div>
                    </div>
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
    
    // import chat_data from "../../../js/chat_data";

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
                chat_url: 'chats',

                contacts:[],//chat_data,
                messages:[],
                selected_contact_index: -1,
                
                searchContactByStringInput:'',
                searchMessageByStringInput:'',

                newmessage: '',

                show_chat_right_side:false,
                show_chat_find_right_side:false,
                right_layout:'toggle-edit-contact',
                left_layout:'toggle-add-contact',
                bgColor:require('img/pages/chat_background.png'),
                window: {
                    width: 0,
                    height: 0
                }
            }
        },
        
        methods: {
            //primary functions
            send_message() {
                if (this.newmessage.trim() != "") {
                    this.contacts[this.selected_contact_index].messages.push({
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
                        var This = this, i = 0;
                        this.contacts.forEach(function(item, i){
                            // if(item.status)
                            //     item.status_name = item.status.name;
                            item.index = i++;
                        });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });
            }, 

            show_chat(contact) {                
                this.selected_contact_index = contact.index;
                ApiService.get(this.chat_url,{'id':contact.id, 'page':0})
                    .then(response => {
                        console.log(response.data);
                        // this.contacts[this.selected_contact_index].messages = response.data;                        
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });

                setTimeout(() => {
                    this.$refs.input.focus();
                }, 20);
            },

            //secundary functions
            mouseOverMessage(id){
                document.getElementById(id).classList.remove("message-hout");
                document.getElementById(id).classList.add("message-hover");
            },

            mouseLeaveMessage(id){
                document.getElementById(id).classList.add("message-hout");
                document.getElementById(id).classList.remove("message-hover");
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

        updated(){
            if(this.selected_contact_index>=0)
                this.$refs.message_scroller.scrolltobottom();
        },

        beforeMount() {
            this.getContacts();

            this.$store.commit('leftside_bar', "close");
            this.$store.commit('rightside_bar', "close");
        },

        created() {
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

        computed: {
            allContacts: function() {
                var self = this;
                return this.contacts.filter(function(contact) {
                    var str =   contact.name +
                            ' '+contact.first_name +
                            ' '+contact.last_name +
                            ' '+contact.email +
                            ' '+contact.phone +
                            ' '+contact.whatsapp_id +
                            ' '+contact.facebook_id +
                            ' '+contact.linkedin_id +
                            ' '+contact.instagram_id;
                    return (                        
                        str.toLowerCase().indexOf(self.searchContactByStringInput.toLowerCase()) >=0
                    );
                });
            },
            
        },

        watch:{
            
        }

    }
</script>


<style scoped lang="scss">
    .desc-img {
        height: 40px;
        width: 40px;
    }

    .desc-img2 {
        height: 160px;
        width: 160px;
        border-radius: 50%
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
        }
       /deep/ .ss-wrapper{
            background-color: transparent;
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
        width: 18px;
        height: 18px;
        border-radius: 10px;
        background-color: #63c17f;
        color: white;
        font-size: 9px;
        text-align: center;
        position: relative;
        top: 8px;
        left: -10px;
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
    .search-input{
        background-color:#fffff8;
        font-size:12px;
    }
    .search-input:focus{
        outline: 0 !important;
        // border: none !important;
        box-shadow: none;
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

    .non_converstion_back{
        background-image: url("~img/pages/chat_background.png");
        height: 100%;
        width: 100%;
    }

    .non-selected-chat {
        position: absolute;
        top: 40%;
        left:50%;
        transform: translate(-50%,-50%);

        img{
            width:220px; height:220px; border-radius:125px; opacity:0.5;
        }
    }

    .my-rounded-circle{
        border-radius: 50%;
        width: 50px;
        padding: 0px !important;
        margin: 0px !important;
    }

</style>

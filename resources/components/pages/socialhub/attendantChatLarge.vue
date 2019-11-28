<template>
    <div class="row chat p-0" style="background-color:#fefefe !important">

        <left-side-bar  :left_layout ="left_layout" :item='{}' @reloadContacts='reloadContacts'></left-side-bar>

        <!-- Left side of chat-->
        <div id="chat-left-side" class="col-lg-3 p-0">
            <div class="chatalign">
                <div class="sect_header">
                    <ul v-if="isSearchContact==false" class='menu'>
                        <li>
                            <a href="javascript:void()" @click.prevent="modalUserCRUDDatas=!modalUserCRUDDatas" style="padding:0 !important">
                                <img :src="user.image_path" width="50px" height="50px" class="profile-picture" alt="User Image">
                            </a>
                        </li>
                        <ul class='menu' style="float:right; margin-right:5px">
                            <li><i class="fa fa-search icons-action mt-1" title="Buscar contato" @click.prevent="isSearchContact=!isSearchContact"></i></li>
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group " variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-h icons-action" title="Mensagens"  aria-hidden="false"></i>
                                    </template>
                                    <b-dropdown-item title="Obter novo contato" exact class="dropdown_content">
                                        <a href='javascript:void(0)' class="round_btn"><i class="fa fa-users" ></i> Obter contato</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Inserir novo contato" exact class="dropdown_content">
                                        <a href='javascript:void(0)' class="round_btn" @click="toggle_left('toggle-add-contact')"><i class="fa fa-user-plus fa-xs " ></i> Inserir contato</a>
                                    </b-dropdown-item>
                                    <!-- <b-dropdown-item title="Contatos com mensagens favoritas" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="filterContactToken='filterContactByFavorites'" ><i class="fa fa-star-o"></i> Favoritas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos que possuem lembretes" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="filterContactToken='filterContactByRemember'"><i class="fa fa-bell-o"></i> Lembretes</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos que possuem resumo" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="filterContactToken='filterContactBySummary'"><i class="fa fa-address-card-o"></i> Resumos</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos com mensagem lidas somente" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="filterContactToken='filterContactByReadedMsg'"><i class="fa fa-envelope-open-o"></i> Lidas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos com mensagem não lidas somente" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="filterContactToken='filterContactByUnrearedMsg'"><i class="fa fa-envelope-o"></i> Não lidas</a>
                                    </b-dropdown-item> -->
                                </b-dropdown>
                            </li>
                        </ul>
                    </ul>
                    <ul v-if="isSearchContact==true" class='menu'>
                        <li><a href='javascript:void(0)' class="round_btn" @click.prevent="isSearchContact=!isSearchContact"><i class="fa fa-arrow-left" ></i></a></li>
                        <li><input class="form-control search-input border-0 mt-3" style="width:120%: left:-10px" type="search" v-model="searchContactByStringInput" placeholder="Buscar contato" ></li>
                        <ul class='menu' style="float:right; margin-right:10px">
                            <li><i class="fa fa-close icons-action mt-1" @click.prevent="searchContactByStringInput=''; isSearchContact=!isSearchContact"></i></li>
                        </ul>                        
                    </ul>
                </div>
                <div class="sect_header" style="background-color:#fafafa;">
                    <div class="text-center">
                        <img src="~img/socialhub/chats.jpg" width="50px" alt="">
                        <span>Chats</span>
                    </div>                        
                </div>
                <v-scroll :height="Height(100)"  color="#ccc" class="margin-left:0px" style="background-color:white" bar-width="8px">
                    <ul>
                        <li v-for="(contact,index) in allContacts" class="chat_block" :key="index">
                            <a :href="contact.first_name" @click.prevent="getContactChat(contact)">
                                <article class="media mt-1 mb-4">
                                    <a class="float-left desc-img mt-3">
                                        <img :src="JSON.parse(contact.json_data).urlProfilePicture" class="contact-picture">
                                    </a>
                                    <div class="media-body pl-3 mb-1 mt-3 chat_content">
                                        <a class="text-dark font-weight-bold" style="font-size:1.1em" href="javascript:void(0)">
                                            {{contact.first_name }}
                                        </a><br>
                                        <a class="text-muted"><span style="font-size:1em" :title='(contact.last_message) ? contact.last_message.message :""'>{{ (contact.last_message) ? text_truncate(contact.last_message.message,22):'' }}</span></a>
                                    </div>
                                    <span class="mt-2 text-muted" style="font-size:0.8em; color:#a4beda">{{(contact.last_message) ? get_last_message_time(contact.last_message.created_at) : ''}}</span>
                                    <div v-show="contact.count_unread_messagess>0" class="status-new-messages mt-4" :title='contact.count_unread_messagess+" mensagens novas"'><b>{{contact.count_unread_messagess}}</b></div>
                                    <span v-show="contact.count_unread_messagess==0" class="status-not-messages" > </span>
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
                        <input id="fileInputImage" ref="fileInputImage" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="image/*"/>
                        <input id="fileInputAudio" ref="fileInputAudio" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="audio/*"/>
                        <input id="fileInputVideo" ref="fileInputVideo" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="video/*"/>
                        <input id="fileInputDocument" ref="fileInputDocument" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept=".doc, .docx, ppt, pptx, .txt, .pdf"/>
                        <li><span class="pl-4"><img :src="JSON.parse(contacts[selected_contact_index].json_data).urlProfilePicture" class="img-fluid rounded-circle desc-img pointer-hover" @click.prevent="fn_show_chat_right_side()"></span></li>
                        <li><span class="pl-3 person_name person_name_style pointer-hover" @click.prevent="fn_show_chat_right_side()"></span></li>
                        <li><p class="pl-0 ml-0 pointer-hover" @click.prevent="fn_show_chat_right_side()">{{ contacts[selected_contact_index].first_name }} </p></li>                        
                        <ul class='menu' style="float:right">
                            <li><a href="javascript:void()" title="Buscar mensagens" @click="fn_show_chat_find_right_side()"><i class="fa fa-search"></i></a></li>
                            <li>
                                <form action="">
                                    <b-dropdown class="dropdown hidden-xs-down btn-group" id="dropdown-right" variant="link" toggle-class="text-decoration-none"  right="">
                                        <template v-slot:button-content>
                                            <i class="fa fa-paperclip mt-3" title="Anexar arquivo"  style="color:#949aa2;; font-size:1.3em"></i>
                                        </template>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="trigger('fileInputImage')"><i class="fa fa-file-image-o"></i> Imagem</a>                                            
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="trigger('fileInputAudio')"><i class="fa fa-file-audio-o"></i> Audio</a>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="trigger('fileInputVideo')"><i class="fa fa-file-movie-o"></i> Video</a>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="trigger('fileInputDocument')"><i class="fa fa-file-text-o"></i> Documento</a>
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </form>
                            </li> 
                            <li>
                                <!-- <b-dropdown class="dropdown hidden-xs-down btn-group" id="dropdown-right" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-v mt-3" title="Opcões"  style="color:#949aa2;"></i>
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
                                </b-dropdown> -->
                            </li> 
                        </ul>
                    </ul> 
                </div>
                <v-scroll :height="Height(220)" color="#ccc" bar-width="8px" ref="message_scroller" class="bgcolor">    <!-- :style="{ backgroundImage: 'url('+bgColor+')'}" -->
                    <ul >
                        <li v-for='(message,index) in messages' :key="index" :class="[{ sent: message.source==0 },{ received: message.source==1 }]">
                            <div class="" >
                                <p class="message" @mouseover='mouseOverMessage("message-dropdown-"+index)' @mouseleave='mouseLeaveMessage("message-dropdown-"+index)'> 
                                    <!-- <b-dropdown class="dropdown hidden-xs-down btn-group float-right message-hout" :id='"message-dropdown-"+index' variant="link" toggle-class="text-decoration-none"  right="">
                                        <template v-slot:button-content>
                                            <i class="fa fa-angle-down fa-lg mb-1" title="Opcões"  style="color:#949aa2;"></i>
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
                                    </b-dropdown> -->
                                    <span v-if='message.type_id == "2"' class='mb-2 text-center'>
                                        <a href="javascript:void()" @click.prevent="modalShowImageSrc= message.path; modalShowImage=!modalShowImage">
                                            <img :src="message.path" class="midia-files"/>
                                        </a>
                                    </span>                               
                                    <span v-if='message.type_id == "3"' class='text-center'>
                                        <br>
                                        <audio controls class="mycontrolBar">
                                            <source :src="message.path" type="audio/ogg">
                                            <source :src="message.path" type="audio/mp3">
                                            Seu navegador não suporta o elemento de áudio.
                                        </audio>
                                    </span>
                                    <span v-if='message.type_id == "4"' class='mb-2 text-center'>
                                        <a href="javascript:void()" @click.prevent="modalShowVideoSrc= message.path; modalShowVideo=!modalShowVideo">
                                            <video class="midia-files" style="outline: none;text-decoration: none;" preload="metadata">
                                                <source :src="message.path+'#t=2'" type="video/mp4">
                                                Seu navegador não suporta o elemento de vídeo.
                                            </video>
                                        </a>
                                    </span>
                                    <span v-if='message.type_id == "5"' class='mb-2 text-center'>
                                        <a :href="message.path" target="_blank" rel=”noopener”  >
                                            <img src="~img/socialhub/text-file-icon.png" alt="text-file-icon" class="midia-files-document" >
                                        </a>
                                    </span>
                                    <br>
                                    <span class="text-message">
                                        {{ message.message ? message.message : "" }}
                                    </span>
                                    <br>
                                </p>
                                <br>
                                <span class="msg-time" v-if='message.source==0'>
                                    <ul class="menu">
                                        <li><div class="thetime">{{message.created_at}}</div></li>
                                        <li> <img :src="user.image_path" style="width:40px; height:40px" alt="" class="my-rounded-circle"></li>
                                    </ul>
                                </span>
                                <span class="msg-time" v-if='message.source==1'>
                                    <ul class="menu">
                                        <li> <img :src="JSON.parse(contacts[selected_contact_index].json_data).urlProfilePicture" style="width:40px; height:40px" alt="" class="my-rounded-circle"></li>
                                        <li> <div class="thetime">{{message.created_at}}</div></li>
                                    </ul>
                                </span>
                            </div>
                        </li>
                    </ul>
                </v-scroll>                
                <div class="input-group p-3" style="background-color:#ebf2f6">
                    <!-- <input type="text" @keyup.enter="send_message" v-model="newMessage.message" placeholder="Nova mensagem" class="form-control text-input-message" ref="input"> -->
                    <textarea type="text" @keyup.enter.exact="send_message" v-model="newMessage.message" placeholder="Nova mensagem" rows="3" class="form-control text-input-message" ref="input"></textarea>
                    <!-- <div class="input-group-append">
                        <button class="btn btn-success send-btn" type="submit" @click="send_message">
                            <i class="fa fa-paper-plane-o text-white" aria-hidden="true"></i>
                        </button>
                    </div> -->
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
        <div v-show="show_chat_right_side==true" class="col-lg-3 bg-white p-0">
            <div class="sect_header">
                <ul class='menu'>
                    <li><a href="javascript:void(0)" @click.prevent="fn_show_chat_right_side()"><i class="fa fa-close" aria-hidden="true"></i></a></li>
                    <li><p class="header-title">Detalhes</p></li>
                        <ul class='menu' style="float:right">                            
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-v mt-3" title="Ações sobre contato" style="color:#949aa2;"></i>
                                    </template>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="fn_show_edit_right_side()"><i class="fa fa-pencil-square-o"></i> Editar</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" ><i class="fa fa-exchange"></i> Transferir</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" ><i class="fa fa-bell-slash-o"></i> Silenciar</a>
                                    </b-dropdown-item>                                    
                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="fn_show_delete_modal()"><i class="fa fa-trash-o"></i> Eliminar</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li>                            
                        </ul>
                </ul> 
            </div>
            <label></label>
            <div v-if="selected_contact_index>=0" class="profile sec_decription bg-white text-center">
                <v-scroll :height="Height(100)"  color="#ccc" bar-width="8px">
                    <div>
                        <img :src="JSON.parse(contacts[selected_contact_index].json_data).urlProfilePicture"  class="rounded-circle desc-img2 mb-3 mt-3" alt="User Image">
                        <h6 class="text-muted;">{{contacts[selected_contact_index].first_name}}</h6>
                        <!-- <p>{{contacts[selected_contact_index].status}}</p> -->
                        <p>Email: <b>{{contacts[selected_contact_index].email}}</b></p>
                        <p>Telefone: <b>{{contacts[selected_contact_index].phone}}</b></p>
                        <p>Resumo: <b>{{contacts[selected_contact_index].summary}}</b></p>
                        <p>Lembretes: <b>{{contacts[selected_contact_index].remember}}</b></p>
                        <hr>
                        <h5>Redes sociais</h5>
                        <p>WhatsApp: <b>{{contacts[selected_contact_index].whatsapp_id}}</b></p>
                        <p>Facebook: <b>{{contacts[selected_contact_index].facebook_id}}</b></p>
                        <p>Instagram: <b>{{contacts[selected_contact_index].instagram_id}}</b></p>
                        <p>Linkedin: <b>{{contacts[selected_contact_index].linkedin_id}}</b></p>
                        <hr>
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
                </v-scroll>
            </div>
        </div>

        <!-- Find-Right side of chat--><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
        <div v-show="show_chat_find_right_side==true" class="col-lg-3 bg-white p-0">
            <div class="col-lg-12 sect_header">
                <ul class="menu">
                    <li><a href="javascript:void(0)" @click.prevent="fn_show_chat_find_right_side()"><i class="fa fa-close" aria-hidden="true"></i></a></li>
                    <li><p class="header-title">Buscar mensagens</p></li>
                </ul>
            </div>
            <div class="col-lg-12" style="color:#949aa2;">
                <div class="input-group" style="color:#949aa2; width:110%; left:-5%;" >
                    <div class="input-group-prepend">
                        <div v-if="searchMessageByStringInput.length==0" style="background-color:#fffff8;color:#949aa2;" class="input-group-text border-left-0 border-right-0 border-top-0 border">
                            <i class="fa fa-search"></i>
                        </div>
                        <div v-if="searchMessageByStringInput.length>0" @click="searchMessageByStringInput='';messagesWhereLike=[];" style="background-color:#fffff8;color:#6beda6" class="input-group-text border-left-0 border-right-0 border-top-0 border">
                            <i class="fa fa-arrow-left"></i>
                        </div>
                    </div>
                    <input class="form-control search-input border-left-0 border-right-0 border-top-0 border" ref="searchMessageByStringInputref" type="search" v-model="searchMessageByStringInput" @keyup.prevent="getContactChatWhereLike" placeholder="Buscar ..." >
                    <div v-if="searchMessageByStringInput.length>0" class="input-group-prepend">
                        <div style="background-color:#fffff8;color:#949aa2;" @click="searchMessageByStringInput='';messagesWhereLike=[];" class="input-group-text border-left-0 border-right-0  border-top-0 border">
                            <i class="fa fa-close"></i>
                        </div>
                    </div>
                </div>
            </div>
                <v-scroll :height="Height(100)"  color="#ccc" style="background-color:white" bar-width="8px">
                    <ul style="margin-left:-35px">
                        <li v-for="(message,index) in messagesWhereLike" class="chat_block p-3" :key="index">
                            <a href="javascript:void()" @click.prevent="1">
                                <!-- <article class="media mt-1 mb-1"> -->
                                    <span class="mt-2 text-muted" style="font-size:0.8em">{{get_last_message_time(message.created_at)}}</span>
                                    <div class="media-body mb-2 mt-1 chat_content">
                                        <a class="text-muted"><span>{{ message.message}}</span></a>
                                    </div>
                                <!-- </article> -->
                            </a>
                            <!-- <hr> -->
                        </li>
                    </ul>
                </v-scroll>
            <div>
            </div>
        </div>
        
        <!-- Edit side of chat--><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
        <div v-if="show_edit_right_side==true" class="col-lg-3 bg-white p-0">
            <attendantCRUDContact :action='"edit"' :item='item' @onclose='fn_show_edit_right_side' @reloadContacts='reloadContacts'></attendantCRUDContact>
        </div>

        <!-- Modal to delete contact-->
        <b-modal v-model="modalDeleteContact" :hide-footer="true" title="Verificação de exclusão">
            <attendantCRUDContact :action='"delete"' :item='item' @onclosemodal='closemodal' @reloadContacts='reloadContacts'></attendantCRUDContact>
        </b-modal>

        <!-- Modal to show image-->
        <b-modal v-model="modalShowImage" :hide-footer="true" :hide-header="true" size="lg"  class="m-0 modal-body-bg">
            <div class="embed-responsive embed-responsive-16by9">
                <img style="width:100%; height:100%" class="embed-responsive-item modal-body-bg" :src="modalShowImageSrc"/>
            </div>
        </b-modal>

        <!-- Modal to show video-->
        <b-modal v-model="modalShowVideo" :hide-footer="true" :hide-header="true" size="lg"  class="m-0 modal-body-bg">
            <div class="embed-responsive embed-responsive-16by9">
                 <video width="100%" height="100%" style="width:100%; height:100%" controls class="midia-files embed-responsive-item modal-body-bg">
                    <source :src="modalShowVideoSrc" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video> 
            </div>            
        </b-modal>

        <!-- Modal to show user datas-->
        <b-modal v-model="modalUserCRUDDatas" :hide-footer="true" body-class="p-0" :hide-header="false" >
            <userCRUDDatas :contacts='contacts'></userCRUDDatas>
        </b-modal>
        
    </div>
</template>
<script>
    import Vue from 'vue';
    import vScroll from "../../plugins/scroll/vScroll.vue";
    import rightSideBar from '../../layouts/right-side-bar'
    import leftSideBar  from '../../layouts/left-side-bar'
    
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import attendantCRUDContact from "src/components/pages/socialhub/popups/attendantCRUDContact.vue";
    import userCRUDDatas from "src/components/pages/socialhub/popups/userCRUDDatas.vue";

    import Echo from 'laravel-echo';
    window.Pusher = require('pusher-js');
    

    export default {
        components: {
            vScroll,
            rightSideBar,
            leftSideBar,
            userCRUDDatas,
            attendantCRUDContact
        },

        data() {
            return {
                user:{},
                isSearchContact:false,
                modalUserCRUDDatas:false,

                contacts_url: 'contacts',
                chat_url: 'chats',
                contacts:[],
                selected_contact_index: -1,
                searchContactByStringInput:'',
                filterContactToken: '',
                item:{},
                modalDeleteContact:false,
                messages:[],
                newMessage: {
                    'attendant_id':0,
                    'contact_id':0,
                    'message':'',
                    'source':0,
                    'type_id':1, //text //TODO criar tabela
                    'status_id':1, //text //TODO criar tabela
                    'socialnetwork_id':1, //Whatsapp
                },
                searchMessageByStringInput:'',
                messagesWhereLike:[],


                file:false,
                pathFiles:'',
                referenceFileInput:null,

                modalShowImage:false,
                modalShowImageSrc:'',
                modalShowVideo:false,
                modalShowVideoSrc:'',

                show_chat_right_side:false,
                show_chat_find_right_side:false,
                show_edit_right_side:false,
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
                this.newMessage.message = this.newMessage.message.trim();
                if (this.newMessage.message != "" || this.file) {
                    this.newMessage.contact_id = this.contacts[this.selected_contact_index].id;

                    let formData = new FormData();
                    formData.append('attendant_id', this.newMessage.attendant_id);
                    formData.append('contact_id', this.newMessage.contact_id);
                    formData.append('message', this.newMessage.message);
                    formData.append('source', this.newMessage.source);
                    formData.append('type_id', this.newMessage.type_id);
                    formData.append('status_id', this.newMessage.status_id);
                    formData.append('socialnetwork_id', this.newMessage.socialnetwork_id);
                    if(this.newMessage.type_id>1 && this.file){
                        formData.append("file",this.file); //Add the form data we need to submit  
                    }
                    
                    ApiService.post(this.chat_url,formData, {headers: { "Content-Type": "multipart/form-data" }})
                    .then(response => {
                        if (response.data.data) {
                            response.data.data = JSON.parse(response.data.data);
                            response.data.path = this.pathContactMessageFile(response.data.contact_id, response.data.data.SavedFileName);
                        }
                        this.messages.push(response.data);
                        this.contacts[this.selected_contact_index].last_message = this.newMessage;
                        this.newMessage.message = "";
                        this.file = null;
                        this.$refs.message_scroller.scrolltobottom();
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error enviando mensagem");   
                    });
                }
            },

            getContacts: function() { //R
                ApiService.get(this.contacts_url,{
                    'filterContactToken': this.filterContactToken
                })
                    .then(response => {
                        this.contacts = response.data;
                        var This = this, i = 0;
                        this.contacts.forEach(function(item, i){
                            item.index = i++;
                        });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });
            }, 

            getContactChat: function(contact) {
                if(this.selected_contact_index!=contact.index){
                    this.selected_contact_index = contact.index;
                    ApiService.get(this.chat_url,{'contact_id':contact.id, 'page':0})
                        .then(response => {
                            this.messagesWhereLike = [];
                            this.searchMessageByStringInput = [];
                            this.messages = response.data; 
                            var This = this;                       
                            this.messages.forEach(function(item, i){
                                try {
                                    if(item.data != "" && item.data != null && item.data.length>0) {
                                        item.data = JSON.parse(item.data);
                                        if (item.type_id > 1)
                                            item.path = This.pathContactMessageFile(item.contact_id, item.data.SavedFileName);
                                    }
                                } catch (error) {
                                    console.log(error);                                    
                                }
                            });
                        })
                        .catch(function(error) {
                            miniToastr.error(error, "Error carregando os contatos");   
                        });
    
                    setTimeout(() => {
                        this.$refs.input.focus();
                    }, 20);
                }
            },
            
            getContactChatWhereLike: function() {
                this.searchMessageByStringInput = this.searchMessageByStringInput.trim();
                if (this.searchMessageByStringInput.length > 1){
                    ApiService.get(this.chat_url,{
                            'contact_id': this.contacts[this.selected_contact_index].id,
                            'searchMessageByStringInput': this.searchMessageByStringInput,
                            'page': 1
                        })
                        .then(response => {
                            this.messagesWhereLike = response.data;
                        })
                        .catch(function(error) {
                            miniToastr.error(error, "Error carregando os contatos");   
                        });
                } else{
                    this.messagesWhereLike = [];
                }
            },

            get_last_message_time: function(time){
                var weekDays =['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
                var date_format = new Date(time);
                var date1 = Date.parse(time); //to timestamp
                var date2 = Date.now(); //to timestamp
                var Difference_In_Time = date2 - date1; 
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);  
                if(Difference_In_Days < 1){ //menos de 24 horas retornar a hora
                    var timeString =date_format.getHours().toString().padStart(2, '0') + ':' + date_format.getMinutes().toString().padStart(2, '0');
                    return timeString;
                } else //mais de 24 horas e até 7 dias atrás retornar "x dias"
                if(Difference_In_Days >= 1 && Difference_In_Days < 2){
                    return 'Ontem';
                } else
                if(Difference_In_Days >= 2 && Difference_In_Days <= 7){
                    var timeString = weekDays[date_format.getDay()];
                    return timeString;
                } else{ //mais de 7 dias atrás retornar o mes
                    var timeString =date_format.getDate().toString().padStart(2, '0') + '/' + (date_format.getMonth()+1).toString().padStart(2, '0')+ '/' + date_format.getFullYear().toString().padStart(4, '0');
                    return timeString;
                }
            },

            //secundary functions
            trigger (referenceFile) {
                switch(referenceFile){
                    case 'fileInputImage':
                        this.newMessage.type_id = 2; //imagem message type 
                        this.referenceFileInput = this.$refs.fileInputImage;
                        this.$refs.fileInputImage.click();
                        break;
                    case 'fileInputAudio':
                        this.newMessage.type_id = 3; //audio message type 
                        this.referenceFileInput = this.$refs.fileInputAudio;
                        this.$refs.fileInputAudio.click();
                        break;
                    case 'fileInputVideo':
                        this.newMessage.type_id = 4; //video message type 
                        this.referenceFileInput = this.$refs.fileInputVideo;
                        this.$refs.fileInputVideo.click();
                        break;
                    case 'fileInputDocument':
                        this.newMessage.type_id = 5; //document message type 
                        this.referenceFileInput = this.$refs.fileInputDocument;
                        this.$refs.fileInputDocument.click();
                        break;
                }
            },

            handleFileUploadContent: function() {
                this.file = null;
                if(this.referenceFileInput !== undefined && this.newMessage.type_id > 1){
                    if(this.referenceFileInput.files[0].size < 10*1024*1024) {
                        this.file = this.referenceFileInput.files[0];
                    } else{
                        miniToastr.error("O arquivo deve ter tamanho inferior a 10MB", "Erro"); 
                    }
                }
            },

            pathContactMessageFile(contact_id, file_name) {
                let pathFile = process.env.MIX_FILE_PATH +'/' + 
                            JSON.parse(localStorage.user).company_id +'/' +
                            'contacts' +'/' +
                            contact_id +'/' +
                            'chat_files' +'/' +
                            file_name;

                return pathFile;
            },
            
            mouseOverMessage(id){
                // document.getElementById(id).classList.remove("message-hout");
                // document.getElementById(id).classList.add("message-hover");
            },

            mouseLeaveMessage(id){
                // document.getElementById(id).classList.add("message-hout");
                // document.getElementById(id).classList.remove("message-hover");
            },

            fn_show_chat_right_side(){
                if(this.show_chat_right_side==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.show_chat_find_right_side = false;
                    this.show_edit_right_side = false;
                    this.show_chat_right_side = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.show_chat_find_right_side = false;
                    this.show_edit_right_side = false;
                    this.show_chat_right_side = false;
                }
            },

            fn_show_chat_find_right_side(){
                if(this.show_chat_find_right_side==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.show_chat_right_side = false;
                    this.show_edit_right_side = false;
                    this.show_chat_find_right_side = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.show_chat_right_side = false;
                    this.show_edit_right_side = false;
                    this.show_chat_find_right_side = false;
                }
            },

            fn_show_edit_right_side(){
                if(this.show_edit_right_side==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.show_chat_right_side = false;
                    this.show_chat_find_right_side = false;
                    this.show_edit_right_side = true;
                    if(this.selected_contact_index>=0){
                        this.item = this.contacts[this.selected_contact_index];
                    }
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.show_chat_right_side = false;
                    this.show_chat_find_right_side = false;
                    this.show_edit_right_side = false;
                }
            },

            fn_show_delete_modal(){
                this.item = this.contacts[this.selected_contact_index]; 
                this.modalDeleteContact=!this.modalDeleteContact;
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
                if (str == null) {
                    str = "";
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
            },

            reloadContacts(){
                this.getContacts();
            },

            closemodal(){
                this.modalDeleteContact = !this.modalDeleteContact;
            }
        },

        updated(){
            if(this.selected_contact_index>=0)
                this.$refs.message_scroller.scrolltobottom();
        },

        beforeMount() {
            this.user = JSON.parse(window.localStorage.getItem('user'));
            this.getContacts();
            this.$store.commit('leftside_bar', "close");
            this.$store.commit('rightside_bar', "close");
        },

        mounted(){            
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: process.env.MIX_PUSHER_APP_KEY,
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                wsHost: window.location.hostname,
                wsPort: 6001,
                wssPort: 6001,
                encrypted: false,
                disableStats: false
            });

            var attendant_id = JSON.parse(localStorage.user).id;
            window.Echo.channel('sh.message-to-attendant.' + attendant_id)
                .listen('MessageToAttendant', (e) => {
                    var message = JSON.parse(e.message);
                    if(this.selected_contact_index >= 0 && this.contacts[this.selected_contact_index].id == message.contact_id){
                        try {
                            if(message.data != "" && message.data != null && message.data.length>0) {
                                message.data = JSON.parse(message.data);
                                if (message.type_id > 1)
                                    message.path = this.pathContactMessageFile(message.contact_id, message.data.SavedFileName);
                            }
                        } catch (error) {
                            console.log(error);                                    
                        }
                        this.messages.push(message);
                        this.contacts[this.selected_contact_index].last_message = message;
                        this.$refs.message_scroller.scrolltobottom();
                    }else{
                        var This = this;
                        This.contacts.forEach((item, index) => {
                            if(item.id == message.contact_id){
                                item.count_unread_messagess = item.count_unread_messagess + 1;
                                item.last_message = message;
                            }
                        });
                    }                    
                });

            var company_id = JSON.parse(localStorage.user).company_id;
            window.Echo.channel('sh.contact-to-bag.' + company_id)
                .listen('NewContactMessage', (e) => {
                    console.log(e);
                });            
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
                return this.contacts.filter(
                    function(contact) {
                        var str = contact.name +
                            ' '+contact.first_name +
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
            filterContactToken: function(){
                this.getContacts();
            }
        }

    }
</script>


<style scoped lang="scss">

    .desc-img {
        height: 3.6em;
        width: 3.6em;
    }

    .desc-img2 {
        height: 13em;
        width: 13em;
        border-radius: 50%
    }

    .chat_block {
        border-bottom: 1px solid #f4f2f2;
    }

    .chatalign {
        background-color: #fff !important;
        height: calc(100% - 70px);        
        ul {
            padding: 0;
        }
        /deep/ .ss-container{
            padding-right: 10px;
        }
    }

    .converstion_back {        
        height: calc(100% - 70px);
        overflow: hidden;
        background: #fff !important;
        border: 1px solid #d8d6d6;

        ul {
            padding: 0;
        }
        &>.chat_header {
            background-color: #eaf5ff;
            padding: 0.3em;
            font-size: 1.8em;
            font-weight: 500;
            label{
                width: 2em;
                height: 2em;
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
        max-width:26em;
        min-width:14em;
        text-overflow:hidden;
        word-break: break-word; 
        border-radius: 1em;        
        display: inline-block;
        padding: 0.7em 1em;
        position: relative;
        border: 1px solid #d4d2d2;
        margin-top: 30px;
    }

    .received div p::before{
        // content: ' ';
        // position: absolute;
        // width: 0;
        // height: 0;
        // left: -120px;
        // right: auto;
        // top: -1px;
        // bottom: auto;
        // border: 12px solid;
        // border-color: transparent transparent #d4d2d2  transparent;
    }

    .received div p::after{
        // content: ' ';
        // position: absolute;
        // width: 0;
        // height: 0;
        // left: -12px;
        // right: auto;
        // top: auto;  // top: 0;
        // bottom: 0; // bottom: auto;
        // border: 12px solid;
        // border-color:  transparent transparent #fff transparent;
    }

    .received>div {
        text-align: left;
        padding: 0 17px 0 17px;
        .msg-time{
            position: relative;
            font-size: 0.8em;
            float: left;
            top: -15px;
            .thetime{
                position: relative;
                top:20px;
                left:15px;
            }
        }
        p {
            background-color: #fff;
            border-bottom-left-radius:0px;
            left: 55px;
            margin-bottom: 0px;
        }
    }

    .sent div p::before{
        // content: ' ';
        // position: absolute;
        // width: 0;
        // height: 0;
        // right: -13px;
        // top: -1px;
        // bottom: auto;
        // border: 12px solid;
        // border-color: #d4d2d2 transparent transparent transparent;
    }
    
    .sent div p::after{
        // content: ' ';
        // position: absolute;
        // width: 0;
        // height: 0;
        // right: -12px;
        // top: auto;  // top: 0;
        // bottom: 0; // bottom: auto;
        // border: 12px solid;
        // border-color:  transparent transparent #0377FE transparent;  // border-color: #dbf2fa transparent transparent transparent;
    }

    .sent>div {        
        text-align: right;
        padding: 0 17px 0 17px;
        .msg-time{
            position: relative;
            font-size: 0.8em;
            float: right;
            top: -15px;
            .thetime{
                position: relative;
                top:20px;
                right: 15px;
            }
        }
        p {
            background-color: #0377FE;  // background-color: #dbf2fa;
            border-bottom-right-radius:0px;
            right: 55px;
            margin-bottom: 0px;
        }
        .text-message{
            color:white;
        }
    }

    .text-message{
        nfot-size:1.2em; 
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

    .chat_content {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .status-new-messages {
        // width: 2.5em;
        // height: 2.5em;
        border-radius: 50%;
        background-color: #0377FE;
        color: white;
        padding: 0.4em;
        font-size: 0.7em;
        text-align: center;
        position: relative;
        top: 8px;
        left: -25px;
        border: 2px solid #fff;
    }

    .status-not-messages {
        width: 2.5em;
        height: 2.5em;
        border-radius: 50%;
        background-color: transparent;
        text-align: center;
        position: relative;
        top: 8px;
        left: -10px;
    }

    .person_name:before {
        // content: ' \25CF';
        // font-size: 21px;
        // position: relative;
        // top: -11px;
        // left: -27px;
        // color: #63c17f;
    }

    .person_name {
        // font-size: 12px;
        // color: #949aa2;;
    }

    .profile {
        padding-bottom: 15px;
        // border: none;
        height: calc(100% - 70px);
        // overflow-y: auto;
        background-color: #FFFFFF;
    }

    .wrapper .converstion_back .ss-container{
        background-image: url("~img/pages/chat_background.png");
    }

    .colors{
        line-height: 1rem;
        margin-top: 2px;
        span{
            font-size: 10px;
        }
    }

    .myscrool{
        height: calc(100% - 70px);
    }

    //added here
    //-----------------------------------------------
    .search-input{
        background-color:#fffff8;
        font-size:1em;
    }
    
    .search-input:focus{
        outline: 0 !important;
        // border: none !important;
        box-shadow: none;
    }
    
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
        font-size: 1.1em;
        display: block;
        color: #949aa2;
        text-align: left;
        padding: 16px;
        text-decoration: none;
    }    

    .menu li ul{
        position:absolute; 
        top:170px; 
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
   
    .sect_header{
        // background-color:#eaf5ff;
        background-color:#fefefe;
        height:70px;  
        // border: 1px solid #e9e9e9;
        border-bottom: 1px solid #e9e9e9;
        padding-top:10px; 
    }

    .sec_decription p, h4{
        text-align: center !important;
        padding: 5px !important;
    }

    .transp {
        background-color:rgba(0, 0, 0, 0);
        color:#949aa2;;
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
        min-height: calc(100vh - 70px);
        height: calc(100vh - 70px);
        overflow: hidden;
    }  

    .mycontrolBar{
        background-color: white !important;
        // opacity:0.5;
        color:white;
    }

    audio {
        width:23em;
        // width: 270px;
        height: 25px;
        border-radius: 3px;
        transform: scale(1.05);
    }

    .text-input-message{
        background-color:#fffff8;
        // padding:22px 30px 22px 30px;
        font-size:17px;
        border-radius:4px;
        border: none;
    }

    .text-input-message:focus{
        outline: 0 !important;
        border: none !important;
        box-shadow: none;
    }

    .message{
        min-width:13em;
    }

    .message-hover{
        visibility:visible;
    }

    .message-hout{
        visibility:hidden;
    }    

    .send-btn{
        border-top-right-radius:4px;
        border-bottom-right-radius:4px;
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
            width:18em; height:18em; border-radius:50%; opacity:0.5;
        }
    }

    .my-rounded-circle{
        border-radius: 50%;
        width: 30px;
        width: 30px;
        padding: 0px !important;
        margin: 0px !important;
    }

    .contact-picture{
        border-radius: 50%;
        width: 50px;
        width: 50px;
        padding: 0px !important;
        margin: 0px !important;
    }

    .profile-picture{
        position: relative;
        border-radius: 50%;
        width: 50px;
        width: 50px;
        left: 15px;
        // top:-15px !important;
        // padding: 0px !important;
        // margin: 0px !important;
    }

    .midia-files{
        width: 15em;
    }

    .midia-files-document{
        width: 10em;
    }    

    .header-title{
        font-size: 1.3em;
    }

    .icons-action{
        color:#949aa2;
        width: 40px;
        height: 40px;
        padding: 15px;
    }

    .icons-action:hover{
        background-color: #f1f0f0;
        border-radius: 50%;
        cursor: pointer;
    }

</style>

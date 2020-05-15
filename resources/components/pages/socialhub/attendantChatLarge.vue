<template>
    <div class="row chat p-0" style="background-color:#fefefe !important">
        <left-side-bar  :left_layout ="leftLayout" style="top:0px !important" :item='{}' @insertContactAsFirtInList="insertContactAsFirtInList" @reloadContacts='reloadContacts'></left-side-bar>
        <audio ref="newMessageSound"  controls style="display:none" ><source src="audio/newMessage.ogg#t=1" type="audio/ogg"></audio>
        <audio ref="newContactInBag"  controls style="display:none" ><source src="audio/newContactInBag.ogg" type="audio/ogg"></audio>

        <!-- Left side of chat-->
        <div id="chat-left-side" class="width-30 p-0">
            <div class="chatalign">
                <div class="sect_header sect_header_color">
                    <div v-show="isSearchContact==false" class="container-fluid">
                        <ul class='row flex-baseline'>
                            <li class='col-10 col-md-10 col-lg-8 col-xl-9'>
                                <a href="javascript:void()" @click.prevent="modalUserCRUDDatas=!modalUserCRUDDatas" title="Meu perfil" style="padding:0 !important">
                                    <img :src="userLogged.image_path" width="50px" height="50px" class="profile-picture" alt="Foto">
                                </a>
                            </li>
                            <li class='col-1 col-md-1 col-lg-1 col-xl-1 mt-3'>
                                <a href="javascript:void()" @click.prevent="(amountContactsInBag>0)?modalNewContactFromBag=!modalNewContactFromBag:true">
                                    <i class="mdi mdi-message-processing-outline icons-action" title="Adherir novo contato"></i>
                                    <span v-if="amountContactsInBag==0" :title="' Nenhum contato novo disponível'" class="badge badge-primary badge-pill amount-contacts-in-bag  cl-gray" style="padding-left:6px; padding-right:6px; padding-top:2px; padding-bottom:2px">{{amountContactsInBag}}</span>
                                    <span v-if="amountContactsInBag>0" :title="amountContactsInBag + ' contatos novos disponíveis'" class="badge badge-success badge-pill amount-contacts-in-bag" style="padding-left:6px; padding-right:6px; padding-top:2px; padding-bottom:2px">{{amountContactsInBag}}</span>
                                </a>
                            </li>
                            <li class="col-1 col-md-1 col-lg-1 col-xl-1 ">                                
                                <b-dropdown class="dropdown btn-group text-muted" variant="link" toggle-class="text-decoration-none" size="md"  right="">
                                    <template v-slot:button-content>
                                        <i class="mdi mdi-dots-horizontal icons-action" style="top:-50px" title="Opções"  aria-hidden="false"></i>
                                    </template>
                                    <b-dropdown-item title="Inserir novo contato" class="dropdown_content">                                        
                                        <a href='javascript:void(0)' class="drpodowtext text-muted" @click="toggleLeft('toggle-add-contact')">
                                            <i class="fa fa-user-plus fa-xs " ></i> 
                                            Inserir contato
                                        </a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Inserir novo contato" class="dropdown_content">                                        
                                        <a href='javascript:void(0)' title="Som das notificações" class="drpodowtext text-muted" @click.prevent="muteNotificationsOfAttendant">
                                            <span v-if="userLogged.mute_notifications" class="mdi mdi-volume-off"> Ativar som</span>
                                            <span v-if="!userLogged.mute_notifications" class="mdi mdi-volume-high"> Desativar som</span>
                                        </a>
                                    </b-dropdown-item>
                                    <!-- <b-dropdown-item title="Inserir novo contato" class="dropdown_content">                                        
                                        <a href='javascript:void(0)' title="Gerenciar etiquetas" class="drpodowtext text-muted" @click.prevent="showModalCRUDTags = true">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            Ver etiquetas
                                        </a>
                                    </b-dropdown-item> -->
                                    <b-dropdown-item title="Encerrar sessão" class="dropdown_content">
                                        <router-link to="/" class="drpodowtext text-muted">
                                            <div v-on:click="logout">
                                                <i class="fa fa-sign-out"></i> 
                                                Sair da sessão
                                            </div>
                                        </router-link>
                                    </b-dropdown-item>
                                    <!-- <b-dropdown-item title="Contatos com mensagens favoritas" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="='filterContactByFavorites'" ><i class="fa fa-star-o"></i> Favoritas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos que possuem lembretes" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="='filterContactByRemember'"><i class="fa fa-bell-o"></i> Lembretes</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos que possuem resumo" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="='filterContactBySummary'"><i class="fa fa-address-card-o"></i> Resumos</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos com mensagem lidas somente" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="='filterContactByReadedMsg'"><i class="fa fa-envelope-open-o"></i> Lidas</a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Contatos com mensagem não lidas somente" exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="='filterContactByUnrearedMsg'"><i class="fa fa-envelope-o"></i> Não lidas</a>
                                    </b-dropdown-item> -->
                                </b-dropdown>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12 pt-3 pb-3" style="background-color:#; border-bottom: 1px solid #e9e9e9">
                    <div class="container-fluid">
                        <ul class='row' style="margin-left:1rem">
                            <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                                <i class="mdi mdi-magnify icons-action mt-2" v-if="!searchContactFocus" @click="hideSearchContact"></i>
                                <i class="mdi mdi-arrow-left icons-action mt-2" v-if="searchContactFocus" @click="hideSearchContact"></i>
                            </li>
                            <li class='col-9 col-md-9 col-lg-9 col-xl-9'>
                                <input class="form-control search-input border-0"  type="text" @focus="searchContactFocus=true" @blur="seeSearchContactFocus" v-model="searchContactByString" placeholder="Buscar contato">
                            </li>
                            <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                                <i v-if="!requestingNewPageContacts" class="mdi mdi-window-close icons-action" @click="hideSearchContact"></i>
                                <i v-if="requestingNewPageContacts" class="fa fa-circle-o-notch fa-spin fa-fw icons-action"></i>
                            </li>
                        </ul>
                    </div>
                </div>

                <v-scroll :height="Height(130)"  color="#ccc" flag="1" bar-width="8px" ref="contact_scroller" :seeSrolling="'true'" @onbottom="onBottomContacts">
                    <ul>
                        <li v-for="(contact,index) in contacts" class="chat_block contact_item" :id="'contact_item_'+index" :key="index" @mouseover="mouseOverContact('contact_'+contact.id)" @mouseleave="mouseLeaveContact('contact_'+contact.id)">
                            <div class="">
                                <div class="row pt-3 pb-3">
                                    <div class="col-2 pointer-hover" style="left:6px" @click.prevent="getContactChat(contact,index)">
                                        <img v-if="contact.json_data.includes('https://pps.whatsapp.net')" :src="JSON.parse(contact.json_data).picurl" :ref="'contactPicurl'+contact.id" @error="markAsBrokenUrl(contact,index)" class="contact-picture">
                                        <img v-else-if="contact.json_data.includes('images/contacts/default_error.png')" :src="'images/contacts/default_error.png'" :ref="'contactPicurl'+contact.id" class="contact-picture"  @error="markAsBrokenUrl(contact,index)">
                                        <div v-else class="contact-non-picture" 
                                            :class="[
                                                { bg0: contact.whatsapp_id.slice(-1)=='0' },
                                                { bg1: contact.whatsapp_id.slice(-1)=='1' },
                                                { bg2: contact.whatsapp_id.slice(-1)=='2' },
                                                { bg3: contact.whatsapp_id.slice(-1)=='3' },
                                                { bg4: contact.whatsapp_id.slice(-1)=='4' },
                                                { bg5: contact.whatsapp_id.slice(-1)=='5' },
                                                { bg6: contact.whatsapp_id.slice(-1)=='6' },
                                                { bg7: contact.whatsapp_id.slice(-1)=='7' },
                                                { bg8: contact.whatsapp_id.slice(-1)=='8' },
                                                { bg9: contact.whatsapp_id.slice(-1)=='9' },
                                            ]">
                                            <b style="color:white; font-size: 1.1rem; text-transform: uppercase;">
                                                {{ (contact.first_name)? contact.first_name.slice(0,1) : contact.whatsapp_id.slice(-1)}}
                                            </b>
                                        </div>
                                    </div>

                                    <div class="col-7 d-flex" @click.prevent="getContactChat(contact,index)">
                                        <div class="d-flex flex-column pointer-hover ml-2 mt-2">
                                            <!-- Contact name -->
                                            <div class="row">
                                                <a class="text-dark font-weight-bold" style="font-size:1.1em" href="javascript:void(0)">
                                                    {{textTruncate(contact.first_name,30) }}
                                                </a>
                                            </div>
                                            <!-- Contact last_message -->
                                            <div class="row">
                                                <a class="text-muted"> 
                                                    <span v-if="!contact.last_message" style="font-size:1em">
                                                        <i>Sem mensagens</i>
                                                    </span>                                           
                                                    <span v-if="contact.last_message && contact.last_message.type_id==1" style="font-size:1em" :title='textTruncate(contact.last_message.message,40)'>
                                                        {{textTruncate(contact.last_message.message,24)}}
                                                    </span>
                                                    <span v-else-if="contact.last_message && contact.last_message.type_id==2" style="font-size:1em" title='Arquivo de imagem'>
                                                        <i>Arquivo de imagem</i>
                                                    </span>
                                                    <span v-else-if="contact.last_message && contact.last_message.type_id==3" style="font-size:1em" title='Arquivo de audio'>
                                                        <i>Arquivo de audio</i>
                                                    </span>
                                                    <span v-else-if="contact.last_message && contact.last_message.type_id==4" style="font-size:1em" title='Arquivo de video'>
                                                        <i>Arquivo de video</i>
                                                    </span>
                                                    <span v-else-if="contact.last_message && contact.last_message.type_id==5" style="font-size:1em" title='Arquivo de texto'>
                                                        <i>Arquivo de texto</i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="row">
                                            <div class="col-12 text-muted text-right" >
                                                {{(contact.last_message) ? getLastMessageTime(contact.last_message.created_at) : '--:--'}}
                                            </div>
                                        </div>

                                        <div class="d-flex" style="float:right">
                                            <div class="m-0">
                                                <span v-if="contact.status_id == 6" class="mdi mdi-volume-off text-muted fa-1_5x" style="m1argin-top: 7px; m1argin-left:-12px" title="Notificações silenciadas"></span>
                                            </div>
                                            <div class="m-0">
                                                <div v-show="contact.count_unread_messagess>0" class="badge badge-success badge-pill amount-unreaded-messages" style="margin-top: 7px; margin-left:5px; padding-left:6px; padding-right:6px; padding-top:2px; padding-bottom:2px; background:#5AD856"  :title='contact.count_unread_messagess + " mensagens novas"'>{{contact.count_unread_messagess}}</div>
                                                <span v-show="contact.count_unread_messagess==0" class="zero-unreaded-messages"> </span>
                                            </div>

                                            <div :id="'contact_'+contact.id" class="contact-hout m-0">
                                                <b-dropdown class="dropdown hidden-xs-down btn-group text-muted" variant="link" toggle-class="text-decoration-none" style="margin-top:0px"  right="">
                                                    <template v-slot:button-content>
                                                        <i class="fa fa-angle-down text-muted fa-1_5x font-weight-bold" title="Ações sobre contato" @click.prevent="copyContact(contact)"></i>
                                                    </template>
                                                    <b-dropdown-item exact class="dropdown_content">
                                                        <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="copyContact(contact), modalTransferContact=!modalTransferContact">
                                                            <i class="fa fa-exchange"></i> Transferir contato
                                                        </a>
                                                    </b-dropdown-item>
                                                    <b-dropdown-item exact class="dropdown_content" >
                                                        <a v-if="contact.status_id != 6" href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="copyContact(contact), modalMuteNotificationsContacts=!modalMuteNotificationsContacts">
                                                            <i class="mdi mdi-volume-off"></i> Silenciar notificações
                                                        </a>
                                                        <a v-if="contact.status_id == 6" href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="copyContact(contact), modalMuteNotificationsContacts=!modalMuteNotificationsContacts">
                                                            <i class="mdi mdi-volume-high"></i> Reativar notificações
                                                        </a>
                                                    </b-dropdown-item>
                                                    <!-- <b-dropdown-item exact class="dropdown_content">
                                                        <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="1">
                                                            <i class="fa fa-tag"></i> Etiquetas do contato
                                                        </a>
                                                    </b-dropdown-item> -->
                                                    <!-- <b-dropdown-item exact class="dropdown_content">
                                                        <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="1">
                                                            <i class="mdi mdi-pin mdi-rotate-45"></i> Fixar conversa
                                                        </a>
                                                    </b-dropdown-item>
                                                    <b-dropdown-item exact class="dropdown_content">
                                                        <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="1">
                                                            <i class="mdi mdi-broom"></i> Limpar conversa
                                                        </a>
                                                    </b-dropdown-item>
                                                    <b-dropdown-item exact class="dropdown_content">
                                                        <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="1">
                                                            <i class="mdi mdi-circle"></i> Marcar como não lida
                                                        </a>
                                                    </b-dropdown-item> -->
                                                    <b-dropdown-item exact class="dropdown_content">
                                                        <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="copyContact(contact), modalDeleteContact=!modalDeleteContact">
                                                            <i class="fa fa-trash-o"></i> Eliminar contato
                                                        </a>
                                                    </b-dropdown-item>
                                                </b-dropdown>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </v-scroll>
            </div>
        </div>

        <!-- Center side of chat-->
        <div id="chat-center-side" ref="chatCenterSide" class="width-70 p-0 ">            
            <!-- If selected contact -->
            <div v-if="selectedContactIndex>=0" class="converstion_back">
                <div class="sect_header sect_header_color">     
                    <div class="container-fluid ml-2">
                        <ul class='row flex-baseline'>
                            <li class='col-1 col-md-1 col-lg-1 col-xl-1 d-block d-lg-none'>
                                <span id="btn-back" class="mdi mdi-arrow-left btn-back icons-action" @click.prevent="chatCenterSideBack" style="position:relative; top:-18px"></span>
                            </li>
                            <li class='col-9 col-sm-9 col-md-11 col-lg-11 col-xl-11'>
                                <div @click.prevent="displayChatRightSide()" class="pointer-hover" style="display: flex; align-items: center">
                                    <img v-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('https://pps.whatsapp.net')" :src="JSON.parse(contacts[selectedContactIndex].json_data).picurl" class="profile-picture">
                                    <img v-else-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('images/contacts/default_error.png')" :src="'images/contacts/default_error.png'" class="profile-picture">
                                    <div v-else style="width:50px !important; height:50px !important; border-radius:50% !important; margin-right:0px !important; display: flex; align-items: center; justify-content:center;" 
                                        :class="[
                                            { bg0: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='0' },
                                            { bg1: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='1' },
                                            { bg2: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='2' },
                                            { bg3: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='3' },
                                            { bg4: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='4' },
                                            { bg5: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='5' },
                                            { bg6: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='6' },
                                            { bg7: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='7' },
                                            { bg8: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='8' },
                                            { bg9: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='9' },
                                        ]">
                                        <b style="color:white; font-size: 1.1rem; text-transform: uppercase;">
                                            {{ (contacts[selectedContactIndex].first_name)? contacts[selectedContactIndex].first_name.slice(0,1) : contacts[selectedContactIndex].whatsapp_id.slice(-1)}}
                                        </b>
                                    </div>
                                    <b style="font-size:1.1rem; margin-left:2rem">{{ contacts[selectedContactIndex].first_name }}</b>
                                </div>
                            </li>
                            <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                                <i v-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('https://pps.whatsapp.net')" 
                                    title="Buscar mensagens" @click.prevent="displayChatFindMessage()" class="mdi mdi-magnify icons-action" style="position:relative; top:-10px">
                                </i>
                                <i v-else
                                    title="Buscar mensagens" @click.prevent="displayChatFindMessage()" class="mdi mdi-magnify icons-action" style="position:relative; top:5px">
                                </i>
                            </li>
                            <!-- <li> -->
                                <!-- <form action="">
                                    <b-dropdown class="dropdown hidden-xs-down btn-group text-muted" id="dropdown-right" variant="link" toggle-class="text-decoration-none"  right="">
                                        <template v-slot:button-content>
                                            <i class="fa fa-paperclip mt-3" title="Anexar arquivo"  style="color:#949aa2;; font-size:1.3em"></i>
                                        </template>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="triggerEvent('fileInputImage')"><i class="fa fa-file-image-o"></i> Imagem</a>                                            
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="triggerEvent('fileInputAudio')"><i class="fa fa-file-audio-o"></i> Audio</a>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="triggerEvent('fileInputVideo')"><i class="fa fa-file-movie-o"></i> Video</a>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="dropdown_content">
                                            <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="triggerEvent('fileInputDocument')"><i class="fa fa-file-text-o"></i> Documento</a>
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </form> -->
                            <!-- </li> 
                            <li> -->
                                <!-- <b-dropdown class="dropdown hidden-xs-down btn-group text-muted" id="dropdown-right" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="mdi mdi-dots-horizontal mt-3" title="Opcões"  style="color:#949aa2;"></i>
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
                            <!-- </li> -->
                        </ul>
                    </div>               
                </div>

                <!-- Chat messages -->
                <v-scroll :height="Height(170)" :vid="'chat-content'" color="#ccc" bar-width="8px" ref="message_scroller" :percent="percent" :seeSrolling="'true'" @ontop="onTopMessages" @oncontentresize="onContentResize">
                    <ul >
                        <li v-for='(message,index) in messages' :key="index" :id="'message_' + message.id" :ref="'message_' + message.id">                            
                            <A :id="'message_lnk_' + message.id" :name="'#message_lnk_' + message.id"></A>
                            <div></div>
                            <div v-if="message.type_id=='date_separator'" class="pt-5 pb-5">
                                <h6 class="message-time-separator mt-5"><span>{{message.time.date}}</span></h6>
                            </div>
                            
                            <div v-if="message.type_id!='date_separator'">
                                <!-- received messages-->
                                <div v-if="message.source==1" class="row mt-2">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div  class="col-1"></div>
                                            <div class="col-11" >
                                                <div style="float:left;" class="receivedMessageText" @mouseover="1/*mouseOverMessage('message_'+index)*/" @mouseleave="1/*mouseLeaveMessage('message_'+index)*/">
                                                    <!-- <div v-if="message.message && message.message !='' && message.message.isLink" style="min-height:100px; border: 1px solid silver; border-radius: 5px; background-color: rgba(255,255,255,0.1); display: flex; align-items: center;" class="mb-2 mt-2">
                                                        <link-prevue url="https://google.com" style="min-width:350px; max-width:80%; min-height: 150px; max-height: 250px; text-align:center">
                                                            <template slot="loading">
                                                                <h6 style="color: black;"> <i class="fa fa-spinner fa-spin fa-2x ml-3" style="color: black"></i> Pré-visualização ...</h6>
                                                            </template>
                                                        </link-prevue>
                                                    </div> -->
                                                    
                                                    <p>
                                                        <i :id="'message_'+index" class="fa fa-angle-down message-hout message-options-style" aria-hidden="true"></i>
                                                        <span v-if='message.type_id == "2"' class='mb-2 text-center'>
                                                            <a href="javascript:void()" @click.prevent="modalShowImageSrc= message.path; modalShowImage=!modalShowImage">
                                                                <img :src="message.path" class="midia-files"/>
                                                            </a>
                                                            <br>
                                                        </span>                               
                                                        <span v-if='message.type_id == "3"' class='text-center'>
                                                            <br>
                                                            <audio controls class="mycontrolBar m-2">
                                                                <source :src="message.path" type="audio/ogg">
                                                                <source :src="message.path" type="audio/mp3">
                                                                Seu navegador não suporta o elemento de áudio.
                                                            </audio>
                                                            <br>
                                                        </span>
                                                        <span v-if='message.type_id == "4"' class='mb-2 text-center'>
                                                            <a href="javascript:void()" @click.prevent="modalShowVideoSrc= message.path; modalShowVideo=!modalShowVideo">
                                                                <video class="midia-files" style="outline: none;text-decoration: none;" preload="metadata">
                                                                    <source :src="message.path+'#t=2'" type="video/mp4">
                                                                    Seu navegador não suporta o elemento de vídeo.
                                                                </video>
                                                            </a>
                                                            <br>
                                                        </span>
                                                        <span v-if='message.type_id == "5"' class='mb-2 text-center'>
                                                            <img v-if="['pdf'].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/pdf.svg')"/>
                                                            <img v-else-if="['doc','docm','docx','dot','dotm','dotx','odt','rtf'].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/word.svg')"/>
                                                            <img v-else-if="['csv','ods','xlam','xls','xlsb','xlsm','xlsx','xlt','xltm','xltx','xlw','xml','xml','xps'].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/excel.svg')"/>
                                                            <img v-else-if="['pot','potm','potx','ppa','ppam','pps','ppsm','ppsx','ppt','pptm','pptx','','','','','','','','','','','','',''].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/powerpoint.svg')"/>
                                                            <i v-else class="fa fa-file-text fa-3x" aria-hidden="true" style="background-color:white"></i>
                                                            <b style="margin-right:10px" :title="message.data.ClientOriginalName">{{textTruncate(message.data.ClientOriginalName,30)}}</b>
                                                            <a :href="message.path" :download="message.data.ClientOriginalName" class="document_received_download">
                                                                <img src="~/img/socialhub/download.png" class="document_received">
                                                            </a>
                                                            <br>
                                                        </span>

                                                        <!-- <span v-if="message.message && message.message !=''" v-html="message.message.richText" class="text-message" style="color:black"></span>
                                                        <span v-else> </span> -->
                                                        
                                                        <span v-if="message.message && message.message !=''" class="text-message" style="color:black">
                                                            {{ message.message ? message.message.richText : "" }}
                                                        </span>
                                                        <br>
                                                        
                                                    </p>                                                 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1 text-right">
                                        <img v-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('https://pps.whatsapp.net')" :src="JSON.parse(contacts[selectedContactIndex].json_data).picurl" :ref="'contactPicurl'+contacts[selectedContactIndex].id" class="conversation-picture receivedMessageImg">
                                        <img v-else-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('images/contacts/default_error.png')" :src="'images/contacts/default_error.png'" :ref="'contactPicurl'+contacts[selectedContactIndex].id" class="conversation-picture receivedMessageImg">
                                        <div v-else class="conversation-picture receivedMessageDiv" style="display: flex; align-items: center; justify-content:center;" 
                                            :class="[
                                                { bg0: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='0' },
                                                { bg1: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='1' },
                                                { bg2: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='2' },
                                                { bg3: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='3' },
                                                { bg4: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='4' },
                                                { bg5: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='5' },
                                                { bg6: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='6' },
                                                { bg7: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='7' },
                                                { bg8: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='8' },
                                                { bg9: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='9' },
                                            ]">
                                            <b style="color:white; font-size: 1.1rem; text-transform: uppercase;">
                                                {{ (contacts[selectedContactIndex].first_name)? contacts[selectedContactIndex].first_name.slice(0,1) : contacts[selectedContactIndex].whatsapp_id.slice(-1)}}
                                            </b>    
                                        </div>
                                        <!-- <img v-else :src="'images/contacts/default.png'" :ref="'contactPicurl'+contacts[selectedContactIndex].id" class="conversation-picture receivedMessageImg"> -->
                                    </div>
                                    <div class="col-11">
                                        <div style="float:left; padding-left:1rem" class="thetime">{{message.time.hour}}</div>
                                    </div>
                                </div>
                                
                                <!-- sended messages-->
                                <div v-if="message.source==0" class="row mt-2">
                                    <div class="col-11">
                                        <div style="float:right" class="sendedMessageText" @mouseover="1/*mouseOverMessage('message_'+index)*/" @mouseleave="1/*mouseLeaveMessage('message_'+index)*/">
                                            <!-- <div v-if="message.message && message.message !='' && message.message.isLink" style="min-height:100px; border: 1px solid silver; border-radius: 5px; background-color: rgba(255,255,255,0.1); display: flex; align-items: center;" class="mb-2 mt-2">
                                                <link-prevue url="https://google.com" style="min-width:350px; max-width:80%; min-height: 150px; max-height: 250px; text-align:center">
                                                    <template slot="loading">
                                                        <h6 style="color: black;"> <i class="fa fa-spinner fa-spin fa-2x ml-3" style="color: black"></i> Pré-visualização ...</h6>
                                                    </template>
                                                </link-prevue>
                                            </div> -->
                                            
                                            <p>
                                                <i :id="'message_'+index" class="fa fa-angle-down message-hout message-options-style" aria-hidden="true"></i>                                            
                                                <span v-if='message.type_id == "2"' class='mb-2 text-center'>
                                                    <a href="javascript:void()" @click.prevent="modalShowImageSrc= message.path; modalShowImage=!modalShowImage">
                                                        <img :src="message.path" class="midia-files"/>
                                                    </a>
                                                    <br>
                                                </span>                               
                                                <span v-if='message.type_id == "3"' class='text-center'>
                                                    <br>
                                                    <audio controls class="mycontrolBar m-2">
                                                        <source :src="message.path" type="audio/ogg">
                                                        <source :src="message.path" type="audio/mp3">
                                                        Seu navegador não suporta o elemento de áudio.
                                                    </audio>
                                                    <br>
                                                </span>
                                                <span v-if='message.type_id == "4"' class='mb-2 text-center'>
                                                    <a href="javascript:void()" @click.prevent="modalShowVideoSrc= message.path; modalShowVideo=!modalShowVideo">
                                                        <video class="midia-files" style="outline: none;text-decoration: none;" preload="metadata">
                                                            <source :src="message.path+'#t=2'" type="video/mp4">
                                                            Seu navegador não suporta o elemento de vídeo.
                                                        </video>
                                                    </a>
                                                    <br>
                                                </span>
                                                <span v-if='message.type_id == "5"' class='mb-2 text-center'>
                                                    <img v-if="['pdf'].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/pdf.svg')"/>
                                                    <img v-else-if="['doc','docm','docx','dot','dotm','dotx','odt','rtf'].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/word.svg')"/>
                                                    <img v-else-if="['csv','ods','xlam','xls','xlsb','xlsm','xlsx','xlt','xltm','xltx','xlw','xml','xml','xps'].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/excel.svg')"/>
                                                    <img v-else-if="['pot','potm','potx','ppa','ppam','pps','ppsm','ppsx','ppt','pptm','pptx','','','','','','','','','','','','',''].includes(message.data.ClientOriginalExtension)" :src="require('../../../img/icons/powerpoint.svg')"/>
                                                    <i v-else class="fa fa-file-text fa-3x" aria-hidden="true" style="background-color:#007bff" ></i>
                                                    <b  style="margin-right:10px" :title="message.data.ClientOriginalName">{{textTruncate(message.data.ClientOriginalName,30)}}</b>
                                                    <a :href="message.path" :download="message.data.ClientOriginalName" class="document_sent_download">
                                                        <img src="~/img/socialhub/download.png" class="document_sent">
                                                    </a>
                                                    <br>                                      
                                                </span>
                                                <!-- <span v-if="message.message && message.message !=''" v-html="message.message.richText" class="text-message" style="color: white"></span>
                                                <span v-else> </span> -->
                                                <span v-if="message.message && message.message !=''" class="text-message" style="color:#000">
                                                    {{ message.message ? message.message.richText : "" }}
                                                </span>
                                                <br>
                                                <span class="pt-2" style="float:right; font-size:1.3rem">
                                                    <span v-if="message.status_id==4" class="mdi mdi-check " title="Encaminhado"></span>
                                                    <span v-if="message.status_id==2" class="mdi mdi-check-all " title="Enviado"></span>
                                                    <span v-if="message.status_id==7" class="mdi mdi-alert-circle-outline cl-danger" title="Falha no envio"></span>
                                                    <!-- <span v-if="message.status_id==7" class="mdi mdi-check cl-white" title="Encaminhado"></span> -->
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    
                                    <div class="col-10 col-sm-11">
                                        <div style="float:right" class="thetime">{{message.time.hour}}</div>
                                    </div>
                                    <div class="col-1">
                                        <img :src="userLogged.image_path" alt="" class="conversation-picture sendedMessageImg">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </v-scroll> 
                
                <!-- Criate and send new message -->                
                <div class="p-3">
                    <div class="input-group pb-5 pr-1 " style="color:gray">
                        <div class="input-group-prepend">
                            <div class="input-group-text pl-2 pr-2  border border-right-0 border-left-message container-icons-action-message">
                                <i v-if="isSendingNewMessage==false" class="fa fa-keyboard-o icons-no-action" title="Digite uma mensagem"></i>
                                <i v-if="isSendingNewMessage==true" class="fa fa-spinner fa-spin fa-cog icons-no-action" title="Enviando mensagem"></i>
                            </div>
                        </div>
                        <textarea @keyup.enter.exact="sendMessage"  v-model="newMessage.message" placeholder=""                                 
                            class="form-control border border-left-0 border-right-0 text-input-message srcollbar" ref="inputTextAreaMessage">
                        </textarea>
                        <div v-if="file!=null" class="input-group-prepend">
                            <i class="mdi mdi-file-cancel-outline fa-1_5x pr-4 input-group-text border border-left-0 container-icons-action-message pointer-hover" @click.prevent="modalRemoveSelectedFile = !modalRemoveSelectedFile" title="Remover o arquivo" style="color:red"></i>
                        </div>
                        
                        <!-- <div v-if="isRecordingAudio==true" class="input-group-prepend">                           
                                <div class="input-group-prepend" @click.prevent="isRecordingAudio = false; stopNativeRecordVoice()">
                                    <i class="input-group-text mdi mdi-close-circle-outline pr-4 fa-1_5x text-danger border border-left-0 container-icons-action-message pointer-hover" title="Excluir" ></i>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text pr-4 fa-1_5x text-muted border border-left-0 container-icons-action-message pointer-hover">{{timeRecordingAudio}}</span>
                                </div>
                                <div class="input-group-prepend" @click.prevent="stopNativeRecordVoice()">
                                    <i class="input-group-text mdi mdi-check-circle-outline pr-4 fa-1_5x text-success border border-left-0 container-icons-action-message pointer-hover" title="Finalizar"></i>
                                </div>
                        </div>
                        <div v-if="isRecordingAudio==false" class="input-group-prepend" @click.prevent="startNativeRecordVoice()">
                            <i class="input-group-text mdi mdi-microphone pr-4 fa-1_5x text-muted border border-left-0 container-icons-action-message pointer-hover" title="Mensagem de audio" ></i>
                        </div> -->

                        <div class="input-group-prepend border border-left-0 border-right-message container-icons-action-message pr-3" style="margin-right:10px">
                            <b-dropdown class="dropdown btn-group text-muted pr-4" variant="link" toggle-class="text-decoration-none" size="md"  right="">
                                <template v-slot:button-content>
                                    <i class="mdi mdi-paperclip fa-1_5x text-muted" title="Anexar arquivos" aria-hidden="false"></i>
                                </template>                                
                                <b-dropdown-item class="dropdown_content" @click.prevent="triggerEvent('fileInputImage')" title="Anexar imagem">
                                    <a href='javascript:void(0)' class="drpodowtext text-muted">
                                        <i class="fa fa-file-image-o " aria-hidden="true"></i> Imagem
                                    </a>                                        
                                </b-dropdown-item>                                    
                                <b-dropdown-item class="dropdown_content" @click.prevent="triggerEvent('fileInputAudio')" title="Anexar audio">
                                    <a href='javascript:void(0)' class="drpodowtext text-muted">                                        
                                        <i class="fa fa-file-audio-o " aria-hidden="true"></i> Audio
                                    </a> 
                                </b-dropdown-item>                                    
                                <b-dropdown-item class="dropdown_content" @click.prevent="triggerEvent('fileInputDocument')" title="Anexar documento">
                                    <a href='javascript:void(0)' class="drpodowtext text-muted">                                        
                                        <i class="fa fa-file-text-o " aria-hidden="true"></i> Documento
                                    </a> 
                                </b-dropdown-item>
                            </b-dropdown>
                        </div>
                        <div class="input-group-prepend" title="Enviar">
                            <i class="mdi mdi-send icons-action-send" @click.prevent="sendMessage"></i>
                        </div>
                        <input id="fileInputImage" ref="fileInputImage" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="image/*"/>
                        <input id="fileInputAudio" ref="fileInputAudio" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="audio/*"/>
                        <input id="fileInputVideo" ref="fileInputVideo" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="video/*"/>
                        <input id="fileInputDocument" ref="fileInputDocument" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept=".doc, .docx, ppt, pptx, .txt, .pdf"/>
                    </div>
                </div>
            </div>

            <!-- if not selected contact -->
            <div v-if="selectedContactIndex==-1" class="non_converstion_back d-none d-lg-block">
                <div class="non-selected-chat text-center">
                    <img src="~img/socialhub/attendant.jpg" alt="" >
                    <h2>Mantenha seus contatos atualizados</h2>
                    <p class="text-right" >
                        "Os clientes se lembram de um bom atendimento durante muito mais
                        tempo do que se lembram do preço ..."
                        <br>
                        <b class="text-right">Kate Zabriskie</b>
                    </p>
                </div>
            </div>

            <!-- if not selected contact -->
            <div v-if="selectedContactIndex==-2" class="non_converstion_back d-none d-lg-block">
                <div class="non-selected-chat text-center">
                    <span style="top:50%; color:gray" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></span>
                </div>
            </div>
        </div>
        
        <!-- Right side of chat-->
        <div id="chat-right-side" v-show="showChatRightSide==true" class="width-25 p-0">
            <div class="sect_header sect_header_color">
                <div class="container-fluid">
                    <ul class='row ' style="margin-top:0.7rem; margin-left:1rem; text-transform: uppercase;">
                        <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                            <i class="mdi mdi-window-close icons-action mt-2" @click.prevent="displayChatRightSide()" aria-hidden="true"></i>
                        </li>
                        <li class='col-9 col-md-9 col-lg-9 col-xl-9' style="padding-top: 0.4rem;">
                            <strong style="font-size:1em;">Detalhes</strong>
                        </li>
                        <li class="col-1 col-md-1 col-lg-1 col-xl-1">
                            <b-dropdown class="dropdown hidden-xs-down btn-group text-muted" variant="link" toggle-class="text-decoration-none"  right="" >
                                <template v-slot:button-content>
                                    <i class="mdi mdi-dots-vertical icons-action" title="Ações sobre contato" @click.prevent="copyContact(contacts[selectedContactIndex])"></i>
                                </template>
                                <b-dropdown-item exact class="dropdown_content">
                                    <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="modalTransferContact=!modalTransferContact">
                                        <i class="fa fa-exchange"></i> Transferir contato
                                    </a>
                                </b-dropdown-item>
                                <b-dropdown-item exact class="dropdown_content">
                                    <a v-if="selectedContactToEdit.status_id != 6" href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="modalMuteNotificationsContacts=!modalMuteNotificationsContacts">
                                        <i class="mdi mdi-volume-off"></i> Silenciar notificações
                                    </a>
                                    <a v-if="selectedContactToEdit.status_id == 6" href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent="modalMuteNotificationsContacts=!modalMuteNotificationsContacts">
                                        <i class="mdi mdi-volume-high"></i> Reativar notificações
                                    </a>
                                </b-dropdown-item>
                                <b-dropdown-item exact class="dropdown_content">
                                    <a href="javascript:void(0)" exact class="drpodowtext text-muted" @click.prevent=" modalDeleteContact=!modalDeleteContact">
                                        <i class="fa fa-trash-o"></i> Eliminar contato
                                    </a>
                                </b-dropdown-item>

                            </b-dropdown>                        
                        </li>
                    </ul> 
                </div>
            </div>
            <div v-if="selectedContactIndex>=0" class="profile sec_decription bg-white" >
                <v-scroll :height="Height(100)"  color="#ccc" bar-width="8px">
                    <div class="text-center">
                            <img @click.prevent="modalShowContactPicture=!modalShowContactPicture" v-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('https://pps.whatsapp.net')" :src="JSON.parse(contacts[selectedContactIndex].json_data).picurl" :ref="'contactPicurl'+contacts[selectedContactIndex].id" class="rounded-circle desc-img2 mb-3 mt-3 pointer-hover">
                            <img @click.prevent="modalShowContactPicture=!modalShowContactPicture" v-else-if="selectedContactIndex>-1 && contacts[selectedContactIndex].json_data && contacts[selectedContactIndex].json_data.includes('images/contacts/default_error.png')" :src="'images/contacts/default_error.png'" :ref="'contactPicurl'+contacts[selectedContactIndex].id" class="rounded-circle desc-img2 mb-3 mt-3 pointer-hover">
                        <div v-else class="text-center" style="display: flex; align-items: center; justify-content:center">
                            <div class="rounded-circle desc-img2 mb-3 mt-3" style="display: flex; align-items: center; justify-content:center;"
                                :class="[
                                    { bg0: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='0' },
                                    { bg1: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='1' },
                                    { bg2: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='2' },
                                    { bg3: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='3' },
                                    { bg4: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='4' },
                                    { bg5: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='5' },
                                    { bg6: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='6' },
                                    { bg7: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='7' },
                                    { bg8: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='8' },
                                    { bg9: contacts[selectedContactIndex].whatsapp_id.slice(-1)=='9' },
                                ]">
                                <b style="color:white; font-size: 1.1rem; text-transform: uppercase;">
                                    {{ (contacts[selectedContactIndex].first_name)? contacts[selectedContactIndex].first_name.slice(0,1) : contacts[selectedContactIndex].whatsapp_id.slice(-1)}}
                                </b>
                            </div>
                        </div>
                        <h4 class="profile-decription-name">{{contacts[selectedContactIndex].first_name}}</h4>
                        
                        <!-- Informação -->
                        <div class="mt-3 p-1 mr-2" style="background-color: rgba(250, 250, 250, 0); border-bottom: 7px solid #39a063;  text-transform: uppercase;">
                            <div class="container-fluid">
                                <div class="row flex-baseline" >
                                    <div class="col-10 pt-2 pb-2" style="text-align:left">
                                        <span class="" style="font-size:1.1rem; font-weight: 600;color: #39a063 !important;">Informação</span>
                                    </div>
                                    <div class="col-1 pt-2 pb-2" >
                                        <i v-show="showContactInformation" @click.prevent="copyContact(contacts[selectedContactIndex]); isEditingContact=!isEditingContact"  class="fa fa-pencil text-muted action-icons-fade" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-1 pt-2 pb-2 text-left" >
                                        <i v-show="!showContactInformation" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactInformation=!showContactInformation"></i>
                                        <i v-show="showContactInformation"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactInformation=!showContactInformation"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContactInformation" class="border-top-0 p-1 mr-2 fadeIn">
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].first_name || isEditingContact">
                                <li class="list-group-item border-0" title="Nome"><i class="mdi mdi-account-outline fa-1_5x text-muted"></i></li>
                                <li style="margin-top:0.4em !important; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact">{{contacts[selectedContactIndex].first_name}}</span>
                                    <input v-show="isEditingContact" type="text" v-model="selectedContactToEdit.first_name" placeholder="Nome completo (*)" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].email || isEditingContact">
                                <li class="list-group-item border-0" title="Email"><i class="mdi mdi-email-outline fa-1_5x text-muted"></i></li>
                                <li style="margin-top:0.4em !important; margin-left:0.6em !important">
                                    <span  v-show="!isEditingContact">{{contacts[selectedContactIndex].email}}</span>
                                    <input v-show="isEditingContact" type="text" v-model="selectedContactToEdit.email" placeholder="Email" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>                            
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].whatsapp_id || isEditingContact"> 
                                <li class="list-group-item border-0" title="Whatsapp"><i class="mdi mdi-whatsapp fa-1_5x text-muted"></i></li>
                                <li style="margin-top:0.4em !important; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact" style="word-break: break-word;">{{contacts[selectedContactIndex].whatsapp_id}}</span>
                                    <input v-show="isEditingContact" type="text" v-mask="'###############'" title="Ex: 5511988888888" v-model="selectedContactToEdit.whatsapp_id" placeholder="WhatsApp (*)" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].phone || isEditingContact">
                                <li class="list-group-item border-0" title="Telefone"><i class="mdi mdi-phone fa-1_5x text-muted"></i></li>
                                <li style="margin-top:0.4em !important; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact" class="mt-1">{{contacts[selectedContactIndex].phone}}</span>
                                    <input v-show="isEditingContact" type="text" v-mask="'###############'" title="Ex: 551188888888" v-model="selectedContactToEdit.phone" placeholder="Telefone fixo" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].cidade || isEditingContact">
                                <li class="list-group-item border-0" title="Cidade"><i class="fa fa-id-card fa-1_5x text-muted"></i></li>
                                <li style="margin-top:0.4em !important; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact" class="mt-1">{{contacts[selectedContactIndex].cidade}}</span>
                                    <input v-show="isEditingContact" type="text" title="Ex: Niterói" v-model="selectedContactToEdit.cidade" placeholder="Cidade" class="border border-top-0 border-left-0 border-right-0 font-italic" style="width:100%">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].estado || isEditingContact">
                                <li class="list-group-item border-0" title="Estado"><i class="fa fa-id-card fa-1_5x text-muted"></i></li>
                                <li style="margin-top:0.4em !; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact" class="mt-1">{{contacts[selectedContactIndex].estado}}</span>
                                    <input v-show="isEditingContact" type="text" title="Ex: Rio de Janeiro" v-model="selectedContactToEdit.estado" placeholder="Estado" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].categoria1 || isEditingContact">
                                <li class="list-group-item border-0" title="Categoria 1"><i class="fa fa-id-card fa-1_5x text-muted"></i></li>
                                <li style="margin-top:1em !important; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact" class="mt-1">{{contacts[selectedContactIndex].categoria1}}</span>
                                    <input v-show="isEditingContact" type="text" title="Ex: Categoria 1" v-model="selectedContactToEdit.categoria1" placeholder="Categoria 1" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal" v-if="contacts[selectedContactIndex].categoria2 || isEditingContact">
                                <li class="list-group-item border-0" title="Categoria 2"><i class="fa fa-id-card fa-1_5x text-muted"></i></li>
                                <li style="margin-top:1em !important; margin-left:0.6em !important">
                                    <span v-show="!isEditingContact" class="mt-1">{{contacts[selectedContactIndex].categoria2}}</span>
                                    <input v-show="isEditingContact" type="text" title="Ex: Categoria 2" v-model="selectedContactToEdit.categoria2" placeholder="Categoria 2" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>

                            <div v-show="isEditingContact">
                                <button class="btn btn-success text-white pl-5 pr-5 pt-1 pb-1 mt-4 mb-1" @click.prevent="updateContact">
                                    <i v-show="isUpdatingContact==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar
                                </button>
                            </div>
                        </div>

                        <!-- Nota resumo -->
                        <div class="mt-3 p-1 mr-2" style="background-color: rgba(250, 250, 250, 0); border-bottom: 7px solid #39a063;  text-transform: uppercase;">
                            <div class="container-fluid">
                                <div class="row flex-baseline">
                                    <div class="col-10 pt-2 pb-2" style="text-align:left">
                                        <span class="" style="font-size:1.1rem; font-weight: 600;color: #39a063 !important;">Nota resumo</span>
                                    </div>
                                    <div class="col-1 pt-2 pb-2" >
                                        <i v-show="showContactSummary" style="" @click.prevent="copyContact(contacts[selectedContactIndex]); isEditingContactSummary=!isEditingContactSummary"  class="fa fa-pencil text-muted action-icons-fade" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-1 pt-2 pb-2 text-left">
                                        <i v-show="!showContactSummary" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactSummary=!showContactSummary"></i>
                                        <i v-show="showContactSummary"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactSummary=!showContactSummary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContactSummary" class="border-top-0 p-1 mr-2 fadeIn">
                            <div class="attachments p-2" style="min-height:40px">
                                <p v-show="!isEditingContactSummary" style="word-break: break-word; color:black" class="text-center">{{contacts[selectedContactIndex].summary}}</p>
                                <textarea v-show="isEditingContactSummary" rows="4" v-model="selectedContactToEdit.summary" class="font-italic text-center" 
                                        style="word-break: break-word; text-align:justify; width:100%; resize: none;  border: 2px solid #39a063; border-radius: 13px;margin-top: 0.6rem; outline: none"></textarea>
                            </div>
                            <div v-show="isEditingContactSummary">
                                <button class="btn btn-success text-white pl-5 pr-5 pt-1 pb-1 mt-2 mb-1" @click.prevent="updateContact">
                                    <i v-show="isUpdatingContact==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar
                                </button>
                            </div>
                        </div>

                        <!-- Imagens e mídias -->
                        <!-- <div class="border mt-3 p-1 mr-2" style="background-color:#fafafa">
                            <div class="container-fluid">
                                <div class="row flex-baseline" >
                                    <div class="col-1 pt-2 pb-2">
                                        <i class="mdi mdi-camera-enhance-outline fa-1_5x text-muted" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-8 pt-2 pb-2" style="text-align:left">
                                        <span class="text-muted" style="font-size:1.1em">Imagens e mídias</span>
                                    </div>
                                    <div class="col-1 pt-2 pb-2" >
                                    </div>
                                    <div class="col-1 pt-2 pb-2 text-left" >
                                        <i v-show="!showContactMedia" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactMedia=!showContactMedia"></i>
                                        <i v-show="showContactMedia"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactMedia=!showContactMedia"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContactMedia" class="border border-top-0 p-1 mr-2 fadeIn">
                            <div class="attachments  p-4">
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
                        </div> -->

                        <!-- Arquivos e documentos -->
                        <!-- <div class="border mt-3 p-1 mr-2" style="background-color:#fafafa">
                            <div class="container-fluid">
                                <div class="row flex-baseline" >
                                    <div class="col-1 pt-2 pb-2">
                                        <i class="mdi mdi-file-document-outline fa-1_5x text-muted" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-8 pt-2 pb-2" style="text-align:left">
                                        <span class="text-muted" style="font-size:1.1em">Arquivos e documentos</span>
                                    </div>
                                    <div class="col-1 pt-2 pb-2" >
                                    </div>
                                    <div class="col-1 pt-2 pb-2 text-left" >
                                        <i v-show="!showContacDocuments" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContacDocuments=!showContacDocuments"></i>
                                        <i v-show="showContacDocuments"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContacDocuments=!showContacDocuments"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContacDocuments" class="border border-top-0 p-1 mr-2 fadeIn">
                            <div class="attachments  p-4">
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
                        </div> -->

                    </div>
                </v-scroll>
            </div>
        </div>

        <!-- Find-Right side of chat-->
        <div id="chat-find-side" v-show="showChatFindMessages==true" class="width-25 bg-white p-0">
            <div class="col-lg-12 sect_header sect_header_color">
                <div class="container-fluid">
                    <ul class='row' style="margin-left:1rem; margin-top: 1rem; text-transform: uppercase;">
                        <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                            <i class="mdi mdi-window-close icons-action mt-2" @click="searchMessageByStringInput='';messagesWhereLike=[]; displayChatFindMessage()"></i>
                        </li>
                        <li class='col-9 col-md-9 col-lg-9 col-xl-9' style="margin-top: 0.4rem;"><strong>Pesquisar mensagens</strong></li>                        
                    </ul>
                </div>
            </div>

            <div class="col-lg-12 pt-3 pb-3" style="background-color:#; border-bottom: 1px solid #e9e9e9">
                <div class="container-fluid">
                    <ul class='row' style="margin-left:1rem">
                        <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                            <i class="mdi mdi-magnify icons-action mt-2" v-if="!searchMessageFocus" @click="searchMessageByStringInput='';messagesWhereLike=[]; displayChatFindMessage()"></i>
                            <i class="mdi mdi-arrow-left-thick icons-action mt-2" v-if="searchMessageFocus" @click="searchMessageByStringInput='';messagesWhereLike=[]; displayChatFindMessage()"></i>
                        </li>
                        <li class='col-9 col-md-9 col-lg-9 col-xl-9'>
                            <input class="form-control search-input border-0"  type="text" @focus="searchMessageFocus = true" @blur="seeSearchMessageFocus" v-model="searchMessageByStringInput" ref="searchMessageByStringInputref" placeholder="Buscar mensagens" >    
                        </li>
                        <li class='col-1 col-md-1 col-lg-1 col-xl-1'>
                            <i class="mdi mdi-window-close icons-action mt-2" @click="searchMessageByStringInput='';messagesWhereLike=[];"></i>
                            <!-- <i v-if="requestingNewPageContacts" class="fa fa-circle-o-notch fa-spin fa-fw icons-action"></i> -->
                        </li>
                    </ul>
                </div>
            </div>

            <v-scroll :height="Height(100)" class="pl-0" color="#ccc" style="background-color:white" bar-width="8px">
                <ul style="margin-left:-35px">
                    <li v-for="(message,index) in messagesWhereLike" class="chat_block pt-3 pb-3 founded-messages" :key="index">
                        <a href="javascript:void()" @click.prevent="/*findAroundMessageId = message.id,*/ scrollAroundMessageId(message)">
                            <div class="">
                                <span class="mt-2 text-muted" style="font-size:0.8em">{{getLastMessageTime(message.created_at)}}</span>
                                <div class="media-body mb-2 mt-1 chat_content"><span class="text-muted">{{ message.message}}</span></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </v-scroll>
        </div>

        <!-- Modal to show image in message-->
        <b-modal v-model="modalShowImage" :hide-footer="true" centered class="" :hide-header="true" size="lg" content-class="text-center border-0 bg-transparent">
            <b-img  fluid :src="modalShowImageSrc" style="max-height:540px; max-width:700px; padding:0px; text-align:center"></b-img>
        </b-modal>

        <!-- Modal to show video in message-->
        <b-modal v-model="modalShowVideo" :hide-footer="true" centered :hide-header="true" size="lg" content-class="text-center border-0 bg-transparent"  class="m-0 modal-body-bg">
            <div class="">
                <video width="100%" height="100%" style="max-height:540px; max-width:700px; padding:0px; text-align:center" controls class="midia-files embed-responsive-item modal-body-bg">
                    <source :src="modalShowVideoSrc" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video> 
            </div>            
        </b-modal>

        <!-- Modal to show contact image picture-->
        <b-modal v-model="modalShowContactPicture" :hide-footer="true" centered class="" :hide-header="true" size="lg" content-class="text-center border-0 bg-transparent">
                <b-img  fluid :src="(selectedContactIndex>-1 && contacts[selectedContactIndex].json_data)?JSON.parse(contacts[selectedContactIndex].json_data).picurl:'images/contacts/default.png'" style="max-height:540px; max-width:700px; padding:0px; text-align:center"></b-img>
        </b-modal>

        <!-- Modal to show loggued user info-->
        <b-modal v-model="modalUserCRUDDatas" centered :hide-footer="true" body-class="p-0" :hide-header="false" >
            <userCRUDDatas :contacts='contacts'></userCRUDDatas>
        </b-modal>

        <!-- Modal to remove the file attached to the composite message-->
        <b-modal v-model="modalRemoveSelectedFile" :hide-footer="true" title="Verificação">
            Tem certeza que deseja remover o arquivo selecionado?
            <div class="col-lg-12 mt-5 text-center">
                <button type="submit" class="btn btn-primary btn_width" @click.prevent="file=null; modalRemoveSelectedFile=!modalRemoveSelectedFile">Remover</button>
                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="modalRemoveSelectedFile=!modalRemoveSelectedFile">Cancelar</button>
            </div>
        </b-modal>

        <!-- Modal to send message files-->
        <b-modal v-model="modalSendMessageFiles" :hide-footer="true" body-class="p-0" :hide-header="false">
            <sendMessageFiles :file='file'></sendMessageFiles>
        </b-modal>
        
        <!-- Modal to get new contact from bag-->
        <b-modal v-model="modalNewContactFromBag" :hide-footer="true" title="Informação">
            Você adicionará um novo contato automático na sua lista de contatos.
            <div class="col-lg-12 mt-5 text-center">
                <button type="submit" class="btn btn-primary btn_width" @click.prevent="getNewContactFromBag">
                    <i v-if="isAddingContactFromBag==true" class="fa fa-spinner fa-spin"></i>
                    Adicionar
                </button>
                <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="modalNewContactFromBag=!modalNewContactFromBag">Cancelar</button>
            </div>
        </b-modal>

        <!-- Modal to transfer contact-->
        <b-modal v-model="modalTransferContact" :hide-footer="true" title="Transferir contato">
            <attendantCRUDContact :action='"transfer"' :item='selectedContactToEdit' @onclosemodal='closemodal' @removeContactFromList='removeContactFromList'></attendantCRUDContact>
        </b-modal>
        
        <!-- Modal to delete contact-->
        <b-modal v-model="modalDeleteContact" :hide-footer="true" title="Verificação de exclusão">
            <attendantCRUDContact :action='"delete"' :item='selectedContactToEdit' @onclosemodal='closemodal' @removeContactFromList='removeContactFromList'></attendantCRUDContact>
        </b-modal>

        <!-- Modal to Mute/Ativate Notifications of Contacts-->
        <b-modal v-model="modalMuteNotificationsContacts" :hide-footer="true" title="Verificação">            
            <div v-if="selectedContactToEditActions.status_id == 6"> <!-- Notification is mutted for this contact -->
                <span> Tem certeza que deseja reativar as notificações para este contato? </span>
                <div class="col-lg-12 mt-5 text-center">
                    <button type="button" class="btn btn-primary btn_width" :disabled="isSendingNotificationsContacts==true" @click.prevent="muteNotificationsOfContact"> 
                        <i v-show="isSendingNotificationsContacts==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Reativar notificações
                    </button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closemodal">Cancelar</button>
                </div>
            </div>
            <div v-else>
                <span> Tem certeza que deseja silenciar as notificações para este contato? </span>
                <div class="col-lg-12 mt-5 text-center">
                    <button type="button" class="btn btn-primary btn_width" :disabled="isSendingNotificationsContacts==true" @click.prevent="muteNotificationsOfContact"> 
                        <i v-show="isSendingNotificationsContacts==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Silenciar notificações
                    </button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closemodal">Cancelar</button>
                </div>
            </div>
        </b-modal>

        <!-- Modal to CRUD Tags-->
        <b-modal v-model="showModalCRUDTags" :hide-footer="true" size="sm" title="Gerenciar etiquetas">
            <attendantCRUDTags :userLogged="userLogged" @onclosemodal='closemodal'></attendantCRUDTags>
        </b-modal>
    </div>
</template>

<script> 
    import Vue from 'vue';
    import vScroll from "../../plugins/scroll/vScroll.vue";
    import rightSideBar from '../../layouts/right-side-bar'
    import leftSideBar  from '../../layouts/left-side-bar'
    import miniToastr from "mini-toastr"; miniToastr.init();
    import ApiService from "src/common/api.service";
    import validation from "src/common/validation.service";
    import Echo from 'laravel-echo'; window.Pusher = require('pusher-js');
    import attendantCRUDContact from "src/components/pages/socialhub/popups/attendantCRUDContact.vue";
    import userCRUDDatas from "src/components/pages/socialhub/popups/userCRUDDatas.vue";
    import attendantCRUDTags from "src/components/pages/socialhub/popups/attendantCRUDTags.vue";
    import sendMessageFiles from "src/components/pages/socialhub/popups/sendMessageFiles.vue";
    // import LinkPrevue from 'link-prevue';

    // import MicRecorder from "mic-recorder-to-mp3"; 
    import routes from '../../../router/index'; //ECR    
    import OpusMediaRecorder from 'opus-media-recorder';

    // import OpusMediaRecorder from 'opus-media-recorder';
    // // Use worker-loader
    // import Worker from 'opus-media-recorder/encoderWorker.js';
    // // You should use file-loader in webpack.config.js.
    // // See webpack example link in the above section for more detail.
    // import OggOpusWasm from 'opus-media-recorder/OggOpusEncoder.wasm';
    // import WebMOpusWasm from 'opus-media-recorder/WebMOpusEncoder.wasm';
    

    export default {
        components: {
            vScroll,
            rightSideBar,
            leftSideBar,
            userCRUDDatas,
            attendantCRUDContact,
            sendMessageFiles,
            attendantCRUDTags,
            // LinkPrevue
        },

        data() {
            return {                
                userLogged:{},

                isMaouseOverContact:false,

                users_url: 'users',
                contacts_url: 'contacts',
                contacts_bag_url: 'getBagContact',
                chat_url: 'chats',

                contacts:[],

                selectedContactToEdit:{},
                selectedContactToEditActions:{},

                amountContactsInBag:0,
                selectedContactIndex: -1,
                searchContactByString:'',
                hasMorePageContacts:true,
                requestingNewPageContacts:false,

                handleTimeToReloadContacts:null,
                
                messages:[],
                searchMessageByStringInput:'searchMessageByStringInput:',
                messagesWhereLike:[],
                findAroundMessageId:null, //for find in database when the clicked and founded message is not in actual page
                messageTimeDelimeter:'',
                file:null,
                pathFiles:'',
                referenceFileInput:null,
                newMessage: {
                    'attendant_id':0,
                    'contact_id':0,
                    'message':'',
                    'source':0,
                    'type_id':1,
                    'status_id':4,
                    'socialnetwork_id':1, //Whatsapp
                },
                pageNumber:-1,
                hasMorePageMessage:true,
                requestingNewPage:false,
                // messageInTop:null,
                searchMessageFocus: false,
                searchContactFocus: false,

                percent:0,

                showContactInformation:false,
                showContactSummary:false,
                showContactMedia:false,
                showContacDocuments:false,
                showChatRightSide:false,
                showChatFindMessages:false,                
                modalShowContactPicture:false,                
                showModalCRUDTags:false,                

                isSearchContact:false,
                isEditingContact:false,
                isEditingContactSummary:false,
                isSendingNewMessage:false,
                isUpdatingContact:false,                
                isAddingContactFromBag:false,                
                isRecordingAudio:false,
                isSendingNotificationsContacts:false,

                timeRecordingAudio:"00:00",
                recordingTime:0,
                handleTimerCounter:null,
                
                recorderMP3:null,
                recorderOGG:null,
                streamOGG:null,
                dataChunks:[],
                rec:null,

                modalRemoveSelectedFile:false,
                modalSendMessageFiles:false,
                modalDeleteContact:false,
                modalShowImage:false,
                modalShowImageSrc:'',
                modalShowVideo:false,
                modalShowVideoSrc:'',
                modalNewContactFromBag:false,
                modalUserCRUDDatas:false,
                modalTransferContact:false,
                modalMuteNotificationsContacts:false,
                
                rightLayout:'toggle-edit-contact',
                leftLayout:'toggle-add-contact',

                window: {width: 0,height: 0},

                flagReference: true,
                isMuteNotifications: null,

                scrollHeights:[],

                last_selected_contact_ref: '',
                selected_contact_ref: ''
            }
        },
        
        methods: {
            //----------------Messages------------------------------------
            sendMessage: function() {
                if (this.isSendingNewMessage) return;                
                var This = this;
                this.newMessage.message = this.newMessage.message.trim();
                if (this.newMessage.message != "" || this.file) {
                    //-------------------prepare the message to be sended-----------------------------
                    this.newMessage.contact_id = this.contacts[this.selectedContactIndex].id;
                    this.isSendingNewMessage = true;

                    if(!this.file){
                        this.newMessage.type_id = 1;
                    }

                    let formData = new FormData();
                    formData.append('attendant_id', this.newMessage.attendant_id);
                    formData.append('contact_id', this.newMessage.contact_id);
                    formData.append('message', this.newMessage.message);
                    formData.append('source', this.newMessage.source);
                    formData.append('type_id', this.newMessage.type_id);
                    formData.append('status_id', this.newMessage.status_id);
                    formData.append('socialnetwork_id', this.newMessage.socialnetwork_id);                   
                    if(this.newMessage.type_id>1 && this.file){
                        formData.append("file",this.file);
                    }
                    //-----------------------sending the message--------------------------------------
                    try {
                        ApiService.post(this.chat_url,formData, {headers: { "Content-Type": "multipart/form-data" }})
                        .then(response => {
                            if(typeof(response.data) != "object" && response.data.includes("Exception: Erro enviando mensagem, verifique conectividade!")){
                                miniToastr.error("Erro ao enviar mensagem. Verifique se o aparelho está conectado a internet","Erro");
                                This.newMessage.message = "";
                                This.isSendingNewMessage = false;
                                return;
                            }
                            
                            //---------------then, prepare the response message to display------------
                            var message = response.data;
                            message.time = this.getMessageTime(message.created_at);
                            if (message.data) {
                                message.data = JSON.parse(message.data);
                                message.path = message.data.FullPath;
                            }                           
                            
                            //--------------clear the field inputs ----------------------------------
                            this.newMessage.message = "";
                            this.file = null;
                            
                            //---------------set the target contact as the first----------------------
                            this.shiftContactAsFirtInList(this.contacts[this.selectedContactIndex].id);

                            // //----------update the message list and the last message of the contact-----
                            message.status_id = 4;
                            this.contacts[this.selectedContactIndex].last_message = message;
                            message = Object.assign({}, message);
                            message.message = this.transformToRichText(message.message)
                            this.messages.push(message);
                            this.$refs.message_scroller.scrolltobottom();
                            this.$refs.message_scroller.scrolltobottom();
                        })
                        .catch(error => {
                            this.processMessageError(error, this.chat_url,"send");
                        }).finally(() => {This.isSendingNewMessage = false;});
                    } catch (error) {
                        This.newMessage.message = "";
                        This.isSendingNewMessage = false;
                    }
                }
            },

            getMessageTime: function(time){
                var weekDays =['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
                var date_format = new Date(time);
                var date1 = Date.parse(time); //to timestamp
                var date2 = Date.now(); //to timestamp
                var Difference_In_Time = date2 - date1; 
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                var timeString =date_format.getHours().toString().padStart(2, '0') + ':' + date_format.getMinutes().toString().padStart(2, '0');
                //menos de 24 horas retornar "a hora"
                if(Difference_In_Days < 1){
                    return {'hour':timeString,'date':'Hoje'};
                } else
                //entre 1 e 2 dias retornar "Ontem"
                if(Difference_In_Days >= 1 && Difference_In_Days < 2){
                    return {'hour':timeString,'date':'Ontem'};
                } else
                //entre 2 e até 7 dias atrás retornar "Dia da semana"
                if(Difference_In_Days >= 2 && Difference_In_Days <= 7){
                    return {'hour':timeString,'date':weekDays[date_format.getDay()]};
                } else{
                    //mais de 7 dias atrás retornar "dia/mes/ano"
                    return {'hour':timeString,'date':date_format.getDate().toString().padStart(2, '0') + '/' + (date_format.getMonth()+1).toString().padStart(2, '0')+ '/' + date_format.getFullYear().toString().padStart(4, '0')};
                }
            },

            getLastMessageTime: function(time){
                var weekDays =['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
                var date_format = new Date(time);
                var date1 = Date.parse(time); //to timestamp
                var date2 = Date.now(); //to timestamp
                var Difference_In_Time = date2 - date1; 
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);  
                if(Difference_In_Days < 1){ //menos de 24 horas retornar a hora
                    var timeString =date_format.getHours().toString().padStart(2, '0') + ':' + date_format.getMinutes().toString().padStart(2, '0');
                    return timeString;
                } else //entre 1 e 2 dias retornar "Ontem"
                if(Difference_In_Days >= 1 && Difference_In_Days < 2){
                    return 'Ontem';
                } else //entre 2 e até 7 dias atrás retornar "Dia da semana"
                if(Difference_In_Days >= 2 && Difference_In_Days <= 7){
                    var timeString = weekDays[date_format.getDay()];
                    return timeString;
                } else{ //mais de 7 dias atrás retornar "dia/mes/ano"
                    var timeString =date_format.getDate().toString().padStart(2, '0') + '/' + (date_format.getMonth()+1).toString().padStart(2, '0')+ '/' + date_format.getFullYear().toString().padStart(4, '0');
                    return timeString;
                }
            },
            
            //----------------Get contacts-------------------------------
            getContacts: function() { //R
                if(this.requestingNewPageContacts) return;
                this.requestingNewPageContacts = true;
                ApiService.get(this.contacts_url,{
                    'filterContactToken': (this.searchContactByString.trim() !== '') ? this.searchContactByString.trim() : '',
                    'last_contact_id': (this.contacts.length)? this.contacts[this.contacts.length-1].id : 0,
                    'last_contact_idx': this.contacts.length-1,
                })
                .then(response => {
                    if(response.data.length){
                        var This = this, i = this.contacts.length;
                        response.data.forEach((item, index)=>{
                            // item.index = i++;
                            try {
                                if(!(item.json_data && typeof(JSON.parse(item.json_data)) != 'undefined')){
                                    item.json_data = JSON.stringify({'picurl': 'images/contacts/default.png'});
                                }
                            } catch (error) {
                                item.json_data = JSON.stringify({'picurl': 'images/contacts/default.png'});
                            }
                            item.isPictUrlBroken = false;
                        });

                        var arr = Array();
                        response.data.forEach((item, index)=>{
                            if(!this.findContactInList(item)){
                                arr.push(item);
                            }
                        });
                        this.contacts = this.contacts.concat(arr);

                        var a=0;
                        this.contacts.some((item, i)=>{
                            this.contacts[i].index = a;
                            a++;
                        });
                        
                        if(this.selectedContactIndex>=0 ){
                            var This = this;
                            this.contacts.some((item, i)=>{
                                if(This.contacts[This.selectedContactIndex].id == item.id){
                                    This.selectedContactIndex = i;
                                    return;
                                }
                            });
                        }
                    }else{
                        this.hasMorePageContacts = false;
                    }
                })
                .catch(error => {
                    this.processMessageError(error, this.contacts_url,"get");})
                .finally(()=>{this.requestingNewPageContacts = false;});
            },

            onBottomContacts: function(){
                if(!this.requestingNewPageContacts && this.hasMorePageContacts){
                    this.getContacts();                    
                }
            },

            getAmountContactsInBag: function() { //R
                ApiService.get('getBagContactsCount')
                .then(response => {
                    this.amountContactsInBag = response.data;                        
                })
                .catch(error => {
                    this.processMessageError(error, "getBagContact","get");
                });
            },

            getNewContactFromBag: function() { //R
                if(this.amountContactsInBag==0){
                    miniToastr.info("Informação", "Não existem novos contatos para adicionar a sua lista");  
                    return;
                }
                this.isAddingContactFromBag = true;
                ApiService.get(this.contacts_bag_url)
                .then(response => {

                    this.modalNewContactFromBag = !this.modalNewContactFromBag;
                    var newContact = response.data;
                    newContact.index = this.contacts.length;
                    this.contacts.unshift(newContact);
                    var i = 0;
                    this.contacts.forEach(function(item, i){
                        item.index = i++;
                    });
                    miniToastr.success("Sucesso", "Contato adicionado com sucesso");
                    
                    this.selectedContactIndex = 0;
                })
                .catch(error => {
                    this.processMessageError(error, this.contacts_bag_url,"add");
                })
                .finally(()=>{this.isAddingContactFromBag = false;});
            },

            copyContact: function(contact){
                this.item= Object.assign({}, contact);
                // if(this.selectedContactIndex>-1 && contact.id==this.contacts[this.selectedContactIndex].id)
                    this.selectedContactToEdit= Object.assign({}, contact);
                this.selectedContactToEditActions= Object.assign({}, contact);
            },

            deleteAditionalInformationOfContact: function(contact){
                delete contact.status;                
                delete contact.created_at;
                delete contact.updated_at;
                delete contact.index;
                delete contact.isPictUrlBroken;
                delete contact.count_unread_messagess;
                delete contact.last_message;
                delete contact.latest_attendant;
                delete contact.latest_attendant_contact;
                delete contact.deleted_at;
                return contact;
            },

            insertContactAsFirtInList:function(targetContact){                
                var selectedContactId = (this.selectedContactIndex>-1) ? this.contacts[this.selectedContactIndex].id : -1;                
                //1. push targetContact as first
                this.contacts.unshift(targetContact);
                //2. update all contact index and selectecContactIndex
                var a = 0;
                this.contacts.some((item,i)=>{
                    this.contacts[a].index = a++;
                });
                if(selectedContactId>-1) this.selectedContactIndex++;
            },

            shiftContactAsFirtInList:function(contact_id){
                //1. set targetContact as first
                var cnt = new Array();
                var selectedContactId = (this.selectedContactIndex>-1)? this.contacts[this.selectedContactIndex].id : -1;
                this.contacts.some((item,i)=>{
                    if(item.id == contact_id){
                        this.target = Object.assign({}, item);
                    }else{
                        cnt.push(item);
                    }
                });
                cnt.unshift(this.target);
                this.contacts = cnt;
                //2. update all contact index and selectecContactIndex
                this.contacts.some((item,i)=>{
                    item.index = i;
                    if(selectedContactId>-1 && item.id==selectedContactId){
                        this.selectedContactIndex = i;
                    }
                });
            },
            
            removeContactFromList: function(contact_id){
                //1. set targetContact as first
                var cnt = new Array();
                var selectedContactId = (this.selectedContactIndex>-1)? this.contacts[this.selectedContactIndex].id : -1;

                this.contacts.some((item,i)=>{
                    if(item.id != contact_id){
                        cnt.push(item);
                    }
                });
                this.contacts = cnt;
                //2. update all contact index and selectecContactIndex
                this.contacts.some((item,i)=>{
                    item.index = i;
                    if(selectedContactId>-1 && item.id==selectedContactId){
                        this.selectedContactIndex = i;
                    }
                });                
                if(contact_id == selectedContactId){
                    if(this.showChatRightSide)
                        this.displayChatRightSide();   
                    this.selectedContactIndex = -1;
                }
            },

            findContactInList: function(contact){
                var isIn = false;
                this.contacts.some((item,i)=>{                    
                    if(item.id == contact.id){
                        isIn = true;
                        return;
                    }
                });
                return isIn;
            },

            reloadContacts: function(){
                alert("reloadContacts é realmente necessário no left-side?");
                this.getContacts();
            },

            showSearchContact: function () {
                this.isSearchContact= true;
                setTimeout(()=>{
                    this.$refs.inputSearchContactByString.focus();
                },400);
            },

            hideSearchContact: function() {
                this.searchContactByString = '';
                this.isSearchContact = false;
                this.selectedContactIndex = -1;
                this.contacts = [];
                this.getContacts();
            },

            //------------------Get chats----------------------------
            getContactChat: function(contact,index) {   
                this.reloadContactPicUrl(contact);
                this.selectedContactIndex = -2;
                document.getElementById('contact_item_'+index).classList.add("selected_contact_item");
                if(document.getElementById(this.last_selected_contact_ref)){
                    document.getElementById(this.last_selected_contact_ref).classList.remove("selected_contact_item");
                }
                this.last_selected_contact_ref = 'contact_item_'+index;
                if(this.showChatRightSide) this.displayChatRightSide();
                if(this.showChatFindMessages) this.displayChatFindMessage();
                setTimeout(()=>{
                    this.pageNumber = -1;
                    this.messages = [];
                    this.messageTimeDelimeter = '';
                    this.scrollHeights = [];
                    this.hasMorePageMessage=true;                
                    this.requestingNewPage=false;                

                    this.selectedContactIndex = contact.index;
                    
                    document.getElementById("chat-center-side").classList.add("chat-center-side-open");
                    this.getChat();
                },700);
                
            },

            getChat: function(){
                if(this.requestingNewPage){
                    return;
                }else{
                    this.requestingNewPage = true;                
                }
                this.pageNumber = this.pageNumber+1;

                ApiService.get(this.chat_url,{
                    'contact_id':this.contacts[this.selectedContactIndex].id,
                    'message_id': this.findAroundMessageId,
                    'page':this.pageNumber,
                    'set_as_readed':1,
                })
                .then(response => {
                    if(response.data.length){
                        this.findAroundMessageId = null;
                        this.contacts[this.selectedContactIndex].count_unread_messagess = 0;
                        this.messagesWhereLike = [];
                        this.searchMessageByStringInput = '';
                        let messages_copy=new Array();
                        response.data.forEach((item, i)=>{
                            try {
                                item.time = this.getMessageTime(item.created_at);
                                if(item.time.date != this.messageTimeDelimeter){
                                    messages_copy.push({
                                        'type_id': 'date_separator',
                                        'time':{'date':item.time.date}
                                    });
                                    this.messageTimeDelimeter = item.time.date;
                                }
                                if(item.data != "" && item.data != null && item.data.length>0) {
                                    item.data = JSON.parse(item.data);
                                    if (item.type_id > 1)
                                        item.path = item.data.FullPath;
                                }
                                item.lifePreview = false;
                                item.message = this.transformToRichText(item.message,item.source);                                
                                messages_copy.push(item);
                            } catch (error) {
                            }
                        });
                        this.messages = messages_copy.concat(this.messages);
                    }else{
                        this.hasMorePageMessage =false;
                    }
                    this.$refs.inputTextAreaMessage.focus();
                })
                .catch(function(error) {
                    miniToastr.error(error, "Error carregando as mensagens");   
                }).finally(()=>{                    
                });
            },

            onTopMessages: function(scrollTop, totalHeight){
                if(!this.requestingNewPage && this.hasMorePageMessage){
                    this.getChat();
                }
            },

            onContentResize: function(val){
                if(this.requestingNewPage && this.hasMorePageMessage){
                    this.scrollHeights.push(val);
                    var n = this.scrollHeights.length;
                    if(this.scrollHeights.length>1){
                        var p = (this.scrollHeights[n-2] * 100)/this.scrollHeights[n-1];
                        this.$refs.message_scroller.scrolltopercent(100-p-0.8);
                    }
                    this.requestingNewPage = false;
                }
            },

            transformToRichText: function(message, source) {
                return {
                    'firstLink': '',
                    'richText': message,
                    'isLink': false
                };
            },

            transformToRichTextGood: function(message, source) {
                var arr = message.split(' ');
                var str = '';
                var firstLink = '';
                var styleColor = (!source) ? 'color: white !important; text-decoration: none !important' : 'color: black !important; text-decoration: none !important';
                arr.some((item,i) => {
                    var link = '';
                    if(this.validURL(item)){
                        if(item.includes('http://') || item.includes('https://')) {
                            link = '<u><a style=\''+styleColor+'\' target=\'_blank\' href=\'' +item+ '\'>' +item+ '</u></b>';
                        }else { 
                            link = '<u><a style=\''+styleColor+'\' target=\'_blank\' href=\'http://' +item+ '\'>' +item+ '</u></b>';
                        }
                        str += ' ' + link+ ' ';
                        if(firstLink == '')
                            firstLink = link;
                    } else {
                        str += item + ' ';
                    }
                });
                return {
                    'firstLink': firstLink,
                    'richText': str,
                    'isLink': (firstLink != '')? true : false
                };
            },

            validURL: function (str) {
                var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
                    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
                return !!pattern.test(str);
            },

            scrollAroundMessageId: function(message){
                var percent =- 1, total = this.messages.length;
                for (var i = 0; i < total; i++) {
                    if (this.messages[i].id == message.id) {
                        percent = i;
                        break; 
                    }
                }
                if(percent > -1){
                    percent = (percent*100)/total;
                    this.$refs.message_scroller.scrolltopercent(percent);
                }
            },

            //----------------Edit contact------------------------------
            updateContact: function() {
                this.isUpdatingContact = true;
                
                // Validando dados
                this.trimDataSelectedContactToEdit();
                this.validateDataSelectedContactToEdit();
                if (this.flagReference == false){
                    miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                    this.isUpdatingContact = false;
                    this.flagReference = true;
                    return;
                }

                if(this.compareContactsForUpdate(this.contacts[this.selectedContactIndex], this.selectedContactToEdit)){
                    this.selectedContactToEdit = Object.assign({}, this.deleteAditionalInformationOfContact(this.selectedContactToEdit));
                    var selectedContactToEdit_cpy = Object.assign({}, this.selectedContactToEdit);
                    selectedContactToEdit_cpy.whatsapp_id = selectedContactToEdit_cpy.whatsapp_id.replace(/ /g, '');
                    selectedContactToEdit_cpy.whatsapp_id = selectedContactToEdit_cpy.whatsapp_id.replace(/-/i, '');
                    if(selectedContactToEdit_cpy.phone){
                        selectedContactToEdit_cpy.phone = selectedContactToEdit_cpy.phone.replace(/ /g, '');
                        selectedContactToEdit_cpy.phone = selectedContactToEdit_cpy.phone.replace(/-/i, '');
                    }
                    ApiService.put(this.contacts_url+'/'+this.selectedContactToEdit.id, selectedContactToEdit_cpy)
                        .then(response => {
                            if(this.isEditingContact)
                                this.isEditingContact = false;
                            if(this.isEditingContactSummary)
                                this.isEditingContactSummary = false;
                            miniToastr.success("Contato atualizado com sucesso.","Sucesso");

                            this.updateContatDatasInList(this.selectedContactToEdit.id, response.data);
                            this.shiftContactAsFirtInList(response.data.id); 
                        })
                        .catch(error => {
                            this.processMessageError(error, this.contacts_url, "update");
                        })
                        .finally(() => this.isUpdatingContact = false);
                }
                this.isUpdatingContact = false;
                this.isEditingContact = false;
            },
            
            markAsBrokenUrl: function(contact,index){
                this.contacts[index].isPictUrlBroken = true;
            },

            reloadContactPicUrl: function(contact){
                if(contact.isPictUrlBroken){
                    ApiService.get('updateContactPicture/'+contact.id)
                    .then(response => {
                        this.contacts.some((item, i)=>{
                            if(item.id == contact.id){
                                item.json_data = response.data.json_data;
                                this.$refs['contactPicurl'+contact.id].src = JSON.parse(response.data.json_data).picurl;
                                item.isPictUrlBroken = false;
                                return;
                            }
                        });
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error atualizando informação do contato os contatos");   
                    });
                }
            },

            muteNotificationsOfContact: function() {
                this.isSendingNotificationsContacts = true;
                var last_message = this.selectedContactToEditActions.last_message;
                var index = this.selectedContactToEditActions.index;                
                this.selectedContactToEditActions.status_id = (this.selectedContactToEditActions.status_id !=6)? 6:1;
                ApiService.put(this.contacts_url+'/'+this.selectedContactToEditActions.id, 
                    this.deleteAditionalInformationOfContact(this.selectedContactToEditActions)
                )
                .then(response => {
                    if(response.data.status_id != 6) 
                        miniToastr.success("Notificações ativadas com sucesso.","Sucesso");
                    if(response.data.status_id == 6) 
                        miniToastr.success("Notificações silenciadas com sucesso.","Sucesso");

                    this.updateContatStatusInList(this.selectedContactToEditActions.id, response.data.status_id);
                    this.shiftContactAsFirtInList(this.selectedContactToEditActions.id);
                })
                .catch(error => {
                    this.processMessageError(error, this.contacts_url, "update");
                })
                this.isSendingNotificationsContacts = false;
                this.closemodal();
            },

            muteNotificationsOfAttendant: function(){
                var val = (this.userLogged.mute_notifications)?0:1;
                ApiService.put(this.users_url+'/'+this.userLogged.id, {
                    "id": this.userLogged.id,
                    "mute_notifications": val
                })
                .then(response => {     
                    if(val)
                        miniToastr.success("Notificações de som desativadas com sucesso.","Sucesso");
                    else
                        miniToastr.success("Notificações de som ativadas com sucesso.","Sucesso");
                    this.userLogged.mute_notifications = val;
                })
                .catch(error => {
                    this.processMessageError(error, this.users_url, "mute_notifications");
                })
                .finally(() => this.isUpdatingContact = false);
            },
            
            trimDataSelectedContactToEdit: function(){
                if(this.selectedContactToEdit.first_name) this.selectedContactToEdit.first_name = this.selectedContactToEdit.first_name.trim();
                if(this.selectedContactToEdit.last_name) this.selectedContactToEdit.last_name = this.selectedContactToEdit.last_name.trim();
                if(this.selectedContactToEdit.email) this.selectedContactToEdit.email = this.selectedContactToEdit.email.trim();
                if(this.selectedContactToEdit.phone) this.selectedContactToEdit.phone = this.selectedContactToEdit.phone.trim();
                if(this.selectedContactToEdit.whatsapp_id) this.selectedContactToEdit.whatsapp_id = this.selectedContactToEdit.whatsapp_id.trim();
                if(this.selectedContactToEdit.facebook_id) this.selectedContactToEdit.facebook_id = this.selectedContactToEdit.facebook_id.trim();
                if(this.selectedContactToEdit.instagram_id) this.selectedContactToEdit.instagram_id = this.selectedContactToEdit.instagram_id.trim();
                if(this.selectedContactToEdit.linkedin_id) this.selectedContactToEdit.linkedin_id = this.selectedContactToEdit.linkedin_id.trim();
                if(this.selectedContactToEdit.remember) this.selectedContactToEdit.remember = this.selectedContactToEdit.remember.trim();
                if(this.selectedContactToEdit.summary) this.selectedContactToEdit.summary = this.selectedContactToEdit.summary.trim();
                if(this.selectedContactToEdit.description) this.selectedContactToEdit.description = this.selectedContactToEdit.description.trim();
            },

            validateDataSelectedContactToEdit: function(){
                // Validação dos dados do contato
                var check;
                if(this.selectedContactToEdit.first_name && this.selectedContactToEdit.first_name !=''){
                    check = validation.check('complete_name', this.selectedContactToEdit.first_name)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O nome do contato é obrigatório" );
                    this.flagReference = false;
                }
                if(this.selectedContactToEdit.last_name && this.selectedContactToEdit.last_name !=''){
                    check = validation.check('complete_name', this.selectedContactToEdit.last_name)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.selectedContactToEdit.email && this.selectedContactToEdit.email !=''){
                    check = validation.check('email', this.selectedContactToEdit.email)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.selectedContactToEdit.phone && this.selectedContactToEdit.phone !=''){
                    check = validation.check('phone', this.selectedContactToEdit.phone)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.selectedContactToEdit.whatsapp_id && this.selectedContactToEdit.whatsapp_id !=''){
                    check = validation.check('whatsapp', this.selectedContactToEdit.whatsapp_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O whatsapp do contato é obrigatório" );
                    this.flagReference = false;
                }
                if(this.selectedContactToEdit.facebook_id && this.selectedContactToEdit.facebook_id !=''){
                    check = validation.check('facebook_profile', this.selectedContactToEdit.facebook_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.selectedContactToEdit.instagram_id && this.selectedContactToEdit.instagram_id !=''){
                    check = validation.check('instagram_profile', this.selectedContactToEdit.instagram_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
                if(this.selectedContactToEdit.linkedin_id && this.selectedContactToEdit.linkedin_id !=''){
                    check = validation.check('linkedin_profile', this.selectedContactToEdit.linkedin_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }
            },
            
            updateContatStatusInList: function(contact_id, status_id){
                this.contacts.some((item,i)=>{
                    if(item.id == contact_id){
                        item.status_id = status_id;
                        return;
                    }
                });
            },

            updateContatDatasInList: function(contact_id, datas){
                this.contacts.some((item,i)=>{
                    if(item.id == contact_id){
                        item.status_id = datas.status_id;                        
                        item.first_name = datas.first_name;
                        item.last_name = datas.last_name;
                        item.email = datas.email;
                        item.phone = datas.phone;
                        item.whatsapp_id = datas.whatsapp_id;
                        item.facebook_id = datas.facebook_id;
                        item.instagram_id = datas.instagram_id;
                        item.linkedin_id = datas.linkedin_id;
                        item.remember = datas.remember;
                        item.summary = datas.summary;
                        item.description = datas.description;
                        return;
                    }
                });
            },
            

            //-------------------Secundary functions----------------------
            textTruncate: function(str, length, ending) {
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

            chatCenterSideBack: function(){
                document.getElementById("chat-center-side").classList.remove("chat-center-side-open");
            },            

            triggerEvent: function(referenceFile) {
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
                        // this.modalSendMessageFiles = true;
                    } else{
                        miniToastr.error("O arquivo deve ter tamanho inferior a 10MB", "Erro"); 
                    }
                }
            },
            
            mouseOverMessage: function(id){
                document.getElementById(id).classList.remove("message-hout");
                document.getElementById(id).classList.add("message-hover");
            },

            mouseLeaveMessage: function(id){
                document.getElementById(id).classList.add("message-hout");
                document.getElementById(id).classList.remove("message-hover");
            },

            mouseOverContact: function(id){
                document.getElementById(id).classList.remove("contact-hout");
                document.getElementById(id).classList.add("contact-hover");
            },

            mouseLeaveContact: function(id){
                document.getElementById(id).classList.add("contact-hout");
                document.getElementById(id).classList.remove("contact-hover");
            },

            displayChatRightSide: function(){
                if(this.showChatRightSide==false){
                    document.getElementById("chat-center-side").classList.remove("width-70");
                    document.getElementById("chat-center-side").classList.add("width-45");
                    document.getElementById("chat-right-side").classList.add("chat-right-side-open");
                    this.showChatFindMessages = false;
                    this.showChatRightSide = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("width-45");
                    document.getElementById("chat-center-side").classList.add("width-70");
                    document.getElementById("chat-right-side").classList.remove("chat-right-side-open");
                    this.showChatFindMessages = false;
                    this.showChatRightSide = false;
                }
                this.showContactInformation=true;
                this.showContactSummary=false;
                this.showContactMedia=false;
                this.showContacDocuments=false;
            },

            displayChatFindMessage: function(){
                if(this.showChatFindMessages==false){
                    document.getElementById("chat-center-side").classList.remove("width-70");
                    document.getElementById("chat-center-side").classList.add("width-45");
                    document.getElementById("chat-find-side").classList.add("chat-find-side-open");
                    this.showChatRightSide = false;
                    this.showChatFindMessages = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("width-45");
                    document.getElementById("chat-center-side").classList.add("width-70");
                    document.getElementById("chat-find-side").classList.remove("chat-find-side-open");
                    this.showChatRightSide = false;
                    this.showChatFindMessages = false;
                }
            },

            Height: function(val){
                return (this.window.height-val)+'px';
            },

            toggleLeft: function(val) {
                this.leftLayout = val;
                this.$store.commit('leftside_bar', "toggle");
            },

            handleResize: function() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            },            

            closemodal: function(){
                this.modalDeleteContact = false;
                this.modalTransferContact = false;
                this.modalMuteNotificationsContacts = false;
                this.showModalCRUDTags = false;
            },
            
            logout: function() {
                ApiService.put('usersAttendants/'+this.userLogged.id,{
                    'user_id':this.userLogged.id,
                    'selected_contact_id':0
                })
                .then(response => {
                    window.localStorage.removeItem('token');
                    window.localStorage.removeItem('user');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.push({name: "login"});                    
                })
                .catch(error => {
                    this.processMessageError(error, "contacts", "get");
                });
            },

            compareContactsForUpdate:function(original, edited){
                var modifiedData = false;                
                if(original.first_name != edited.first_name) modifiedData = true;
                if(original.email != edited.email) modifiedData = true;
                if(original.whatsapp_id != edited.whatsapp_id) modifiedData = true;
                if(original.phone != edited.phone) modifiedData = true;
                if(original.cidade != edited.cidade) modifiedData = true;
                if(original.estado != edited.estado) modifiedData = true;
                if(original.categoria1 != edited.categoria1) modifiedData = true;
                if(original.categoria2 != edited.categoria2) modifiedData = true;
                if(original.summary != this.selectedContactToEdit.summary) modifiedData = true;
                return modifiedData;
            },

            //------------------Audio messages--------------------------
            preConfigAudio: function(){
                // this.recorderMP3 = this.createMP3Recorder();
    
                // Check if MediaRecorder available.
                // if (!window.MediaRecorder) {
                //     window.MediaRecorder = OpusMediaRecorder;
                // }
                // Check if a target format (e.g. audio/ogg) is supported.
                // else 
                // if (!window.MediaRecorder.isTypeSupported('audio/ogg;codecs=opus')) {
                //     window.MediaRecorder = OpusMediaRecorder;
                // }
            },
            
            timer: function(){
                this.recordingTime ++;
                var minutes = parseInt(this.recordingTime / 60);
                var seconds = this.recordingTime % 60;
                this.timeRecordingAudio = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
            },

            createMP3Recorder: function(){
                return new MicRecorder({bitRate: 128});
            },

            startMP3RecordVoice: function() {
                if(!navigator.mediaDevices){
                    miniToastr.warn("Essa função não é suportada pelo seu navegador", "Atenção");
                    return;
                }
                this.recorderMP3.start()
                    .then(() => {
                        this.timeRecordingAudio = "00:00";
                        this.recordingTime = 0;
                        this.isRecordingAudio = true;
                        this.handleTimerCounter = setInterval(this.timer, 1000);
                    }).catch((e) => {
                    }).finally(()=>{this.isRecordingAudio = true;});
            },

            stopMP3RecordVoice: function() {
                clearInterval(this.handleTimerCounter);
                this.recorderMP3.stop().getMp3()
                    .then(([buffer, blob]) => {
                        if(this.isRecordingAudio){
                            const file = new File(buffer, 'me-at-thevoice.mp3', {
                                type: blob.type,
                                lastModified: Date.now()
                            });
                            // const player = new Audio(URL.createObjectURL(file)); player.play();
                            this.newMessage.type_id = 3;
                            this.file = file;
                            this.sendMessage();
                        }else{
                            this.timeRecordingAudio = "00:00";
                            this.recordingTime = 0;
                            this.isRecordingAudio = false;
                        }                     
                    }).catch((e) => {
                    });
            },

            createOGGRecorder: function(stream) {
                const options = { mimeType: 'audio/ogg; codecs=opus' };
                const workerOptions = {
                    encoderWorkerFactory: function () {
                        return new Worker('opus-media-recorder/encoderWorker.js');
                        // return new Worker('opus-media-recorder/encoderWorker.umd.js');
                    },
                    OggOpusEncoderWasmPath: 'opus-media-recorder/OggOpusEncoder.wasm',
                    WebMOpusEncoderWasmPath: 'opus-media-recorder/WebMOpusEncoder.wasm'
                };

                window.MediaRecorder = OpusMediaRecorder;
                this.rec = new MediaRecorder(stream, options, workerOptions);

                var that = this;
                this.rec.start = () => {
                };

                this.rec.stop = () => {
                    let blob = new Blob(this.dataChunks, {'type': 'audio/ogg; codecs=opus' });
                    this.rec.stream.getTracks().forEach(i => i.stop());
                };

                this.rec.error = (e) => {
                    this.rec.stream.getTracks().forEach(i => i.stop());
                };

                this.dataChunks = [];
                this.rec.start();
            },

            startOGGRecordVoice: function() {                
                if(!navigator.mediaDevices){
                    miniToastr.warn("Essa função não é suportada pelo seu navegador", "Atenção");
                    return;
                }
                var This = this;
                navigator.mediaDevices.getUserMedia({audio:true, video: false}) //getting 
                    .then(stream => {
                        This.createOGGRecorder(stream);
                        This.timeRecordingAudio = "00:00";
                        This.recordingTime = 0;
                        This.isRecordingAudio = true;
                        This.handleTimerCounter = setInterval(This.timer, 1000);
                    }).catch((e) => {
                    }).finally(()=>{This.isRecordingAudio = true;});
            },

            stopOGGRecordVoice: function() {                                
                this.rec.stop();
                clearInterval(This.handleTimerCounter);
                This.recorderOGG.stop().getMp3()
                    .then(([buffer, blob]) => {
                        if(This.isRecordingAudio){
                            const file = new File(buffer, 'me-at-thevoice.mp3', {
                                type: blob.type,
                                lastModified: Date.now()
                            });
                            // const player = new Audio(URL.createObjectURL(file)); player.play();
                            This.newMessage.type_id = 3;
                            This.file = file;
                            This.sendMessage();
                        }else{
                            This.timeRecordingAudio = "00:00";
                            This.recordingTime = 0;
                            This.isRecordingAudio = false;
                        }                     
                    }).catch((e) => {
                    });

            },

            createNativeRecorder: function(stream) {
                this.rec = new MediaRecorder(stream);

                var that = this;
                this.rec.start = () => {
                };
                this.rec.ondataavailable = (e) => {
                    this.dataChunks.push(e.data);                            
                };
                this.rec.stop = (e) => {
                    let blob = new Blob(this.dataChunks, {'type': 'audio/ogg; codecs=opus' });
                    this.rec.stream.getTracks().forEach(i => i.stop());
                };
                this.dataChunks = [];
                this.rec.start();
            },

            startNativeRecordVoice: function() {                
                if(!navigator.mediaDevices){
                    miniToastr.warn("Essa função não é suportada pelo seu navegador", "Atenção");
                    return;
                }
                var This = this;
                navigator.mediaDevices.getUserMedia({audio:true, video: false}) //getting 
                    .then(stream => {
                        This.createNativeRecorder(stream);
                        This.timeRecordingAudio = "00:00";
                        This.recordingTime = 0;
                        This.isRecordingAudio = true;
                        This.handleTimerCounter = setInterval(This.timer, 1000);
                    }).catch((e) => {
                    }).finally(()=>{This.isRecordingAudio = true;});
            },

            stopNativeRecordVoice: function() {                                
                this.rec.stop();
                return;

                clearInterval(This.handleTimerCounter);
                This.recorderOGG.stop().getMp3()
                    .then(([buffer, blob]) => {
                        if(This.isRecordingAudio){
                            const file = new File(buffer, 'me-at-thevoice.mp3', {
                                type: blob.type,
                                lastModified: Date.now()
                            });
                            // const player = new Audio(URL.createObjectURL(file)); player.play();
                            This.newMessage.type_id = 3;
                            This.file = file;
                            This.sendMessage();
                        }else{
                            This.timeRecordingAudio = "00:00";
                            This.recordingTime = 0;
                            This.isRecordingAudio = false;
                        }                     
                    }).catch((e) => {
                    });

            },            

            //---------------Websockets---------------------
            wsCriateTunnel: function(){
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: process.env.MIX_PUSHER_APP_KEY,
                    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                    host: process.env.MIX_APP_HOST,  


                    // No SSL
                    wsHost: process.env.MIX_APP_HOST,
                    wsPort: 6001,
                    enabledTransports: ['ws'],
                    encrypted: false,
                    forceTLS: false,

                    // SSL
                    // wssHost: process.env.MIX_APP_HOST,
                    // wssPort: 6001,
                    // enabledTransports: ['ws', 'wss'],
                    // encrypted: true,
                    // forceTLS: true,

                    disableStats: false,
                });
            },

            wsMessageToAttendant: function(){
                window.Echo.channel('sh.message-to-attendant.' + this.userLogged.id)
                .listen('MessageToAttendant', (e) => {  
                    var message = JSON.parse(e.message);
                    var subjacentContact = null;       
    
                    if(message.source == 0){ //message to update the message_status to 2 or 7
                        if(this.selectedContactIndex>-1 && message.contact_id == this.contacts[this.selectedContactIndex].id){
                            this.messages.some((item,i)=>{
                                if(message.id == item.id){
                                    item.status_id = message.status_id;
                                    return;
                                }
                            });
                        }
                    }
                    else if(message.source == 1){ //message from contact                        
                        //analyse if the contact is in this.contacts list or not
                        if(typeof(message.Contact)!='undefined'){
                            subjacentContact = Object.assign({},message.Contact);
                            delete message.Contact;
                        }
                        
                        //------------prepare message datas to be displayed------------------------
                        message.time = this.getMessageTime(message.created_at);
                        try {
                            if(message.data != "" && message.data != null && message.data.length>0) {
                                message.data = JSON.parse(message.data);
                                if(message.type_id > 1)
                                    message.path = message.data.FullPath;
                            }
                        } catch (error) {
                        }
                        
                        let targetIndex = -1; 
                        var isSelectedContact = false;
                        //------show the recived message if the target contact is selected----------
                        if(this.selectedContactIndex > -1 && this.contacts[this.selectedContactIndex].id == message.contact_id){
                            this.contacts[this.selectedContactIndex].last_message = message;
                            message = Object.assign({}, message);
                            message.message = this.transformToRichText(message.message,1);
                            this.messages.push(message);
                            if(this.$refs.message_scroller)
                                this.$refs.message_scroller.scrolltobottom();
                            targetIndex = this.contacts[this.selectedContactIndex].index;
                            isSelectedContact = true;
                        }else{
                            //-------find contact and update count_unread_messagess and last_message-------
                            this.contacts.some((item, i) => {
                                if(item.id == message.contact_id){
                                    item.count_unread_messagess = item.count_unread_messagess + 1;
                                    item.last_message = message;
                                    targetIndex = i;                                    
                                    return;
                                }
                            });
                        }

                        if(targetIndex > -1){ // set the target contact as firt if is in contacts list
                            this.shiftContactAsFirtInList(this.contacts[targetIndex].id);
                            if(this.contacts[targetIndex].status_id != 6)
                                this.$refs.newMessageSound.play();
                        }else{ //insert the target contact in contacts list if isnt
                            subjacentContact.count_unread_messagess = 1;
                            subjacentContact.last_message = message;
                            this.contacts.unshift(subjacentContact);
                            
                            this.contacts.some((item, i)=>{
                                this.contacts[i].index = i;
                            });
                            
                            if(this.selectedContactIndex > -1){
                                this.selectedContactIndex ++;
                            }
                            if(subjacentContact.status_id != 6)                            
                                this.$refs.newMessageSound.play();
                        }                       

                    }                    
                });
            },

            wsContactToBag: function(){
                window.Echo.channel('sh.contact-to-bag.' + this.userLogged.company_id)
                .listen('NewContactMessage', (e) => {
                    if(this.amountContactsInBag<e.message && !this.userLogged.mute_notifications)
                        this.$refs.newContactInBag.play();
                    this.amountContactsInBag = e.message;
                });
            },

            wsTransferredContact: function(){
                window.Echo.channel('sh.transferred-contact.' + this.userLogged.id)
                .listen('NewTransferredContact', (e) => {
                    var newContact = JSON.parse(e.message);
                    //------------prepare message datas to be displayed------------------------
                    // var message = newContact.message;
                    // newContact.message.time = this.getMessageTime(newContact.message.created_at);
                    // try {
                    //     if(newContact.message.data != "" && newContact.message.data != null && newContact.message.data.length>0) {
                    //         newContact.message.data = JSON.parse(newContact.message.data);
                    //         if(newContact.message.type_id > 1)
                    //             newContact.message.path = newContact.message.data.FullPath;
                    //     }
                    // } catch (error) {
                    // }

                    this.contacts.unshift(newContact);
                    var a = 0;
                    this.contacts.some((item, i)=>{
                        this.contacts[i].index = a++;
                    });
                    if(this.selectedContactIndex >=0){
                        this.selectedContactIndex ++;
                    }
                    miniToastr.success("Sucesso", "Contato transferido com sucesso");   
                });
            },

            //---------------Exceptions---------------------
            processMessageError: function(error, url, action) {
                var info = ApiService.process_request_error(error, url, action);
                if(info.typeException == "expiredSection"){
                    miniToastr.warn(info.message,"Atenção");
                    this.$router.push({name:'login'});
                    window.location.reload(false);
                }else if(info.typeMessage == "warn"){
                    miniToastr.warn(info.message,"Atenção");
                }else{
                    miniToastr.error(info.erro, info.message); 
                }
            },

            seeSearchMessageFocus: function() {
                if (this.searchMessageByStringInput.trim() === '') {
                    this.searchMessageFocus = false;
                } 
            }, 

            seeSearchContactFocus: function() {
                if (this.searchContactByString.trim() === '') {
                    this.searchContactFocus = false;
                } 
            }

        },

        updated(){
            if(this.selectedContactIndex >= 0 && this.$refs.message_scroller && this.pageNumber == 0) {
                this.$refs.message_scroller.scrolltobottom();
            }
        },

        beforeMount() {
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
            this.getContacts();
            this.getAmountContactsInBag();
            this.$store.commit('leftside_bar', "close");
            this.$store.commit('rightside_bar', "close");
        },

        mounted(){
            if(this.userLogged.role_id > 4){
                this.$router.push({name: "login"});
            }
            
           // this.preConfigAudio();
            
            //wbsocket events
            this.wsCriateTunnel();
            this.wsMessageToAttendant();
            this.wsContactToBag();
            this.wsTransferredContact();
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
            // allContacts: function() {    
            //     var self = this;
            //     return this.contacts.filter(
            //         function(contact) {
            //             var str = contact.name +
            //                 ' '+contact.first_name +
            //                 ' '+contact.email +
            //                 ' '+contact.phone +
            //                 ' '+contact.whatsapp_id +
            //                 ' '+contact.facebook_id +
            //                 ' '+contact.linkedin_id +
            //                 ' '+contact.instagram_id;
            //             return (
            //                 str.toLowerCase().indexOf(self.searchContactByString.toLowerCase()) >=0
            //             );
            //     });
            // },
        },

        watch:{
            searchContactByString: function(value){
                // if(value.trim().length > 2){
                    this.selectedContactIndex = -1;
                    this.contacts = [];
                    if(this.showChatRightSide) this.displayChatRightSide();
                    if(this.showChatFindMessages) this.displayChatFindMessage();
                    this.getContacts();
                // }
            },

            searchMessageByStringInput: function(value) {
                value = value.trim();
                if (value.length > 1){
                    ApiService.get(this.chat_url,{
                        'contact_id': this.contacts[this.selectedContactIndex].id,
                        'searchMessageByStringInput': value,
                        'page': 0
                    })
                    .then(response => {
                        this.messagesWhereLike = response.data;
                    })
                    .catch(error => {
                        this.processMessageError(error, this.chat_url,"get");
                    });
                } else{
                    this.messagesWhereLike = [];
                }
            },

            isSendingNewMessage: function(value){
                if(value){
                    //disable new message, and upload and send buttons
                }else{
                    //enable new message, and upload and send buttons
                }
            },             
        }
    }
</script>


<style scoped lang="scss">  
    * {
        margin: 0;
        padding: 0;

        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }
    .width-30 {
        width: 23%!important;
    }
    .width-70{
        width: 76.9% !important;
        // width: 70% !important;
    }
    .width-25{
        width: 22% !important;
        // width: 25% !important;
    }
    .width-45{
        width: 55% !important;
        // width: 45% !important;
    }

    /*JUNIOR*/
    .search-message{
        background-color: #fff !important;
        border-bottom: 1px solid #e9e9e9 !important;
    }


    /* LAYOUT */
    .desc-img {
        height: 3.6rem;
        width: 3.6rem;
    }
    .desc-img2 {
        height: 7rem;
        width: 7rem;
    }
    .chat {
        min-height: calc(100vh); // min-height: calc(100vh - 70px);
        height: calc(100vh); // height: calc(100vh - 70px);
        overflow: hidden;
    }  
    .chat_block {
        border-bottom: 1px solid #f4f2f2;
    }
    .myheight{
        height: calc(100% - 170px);
    }
    .chatalign {
        background-color: #fff !important;
        height:100%;   // height: calc(100%);  // height: calc(100% - 170px);        
        ul {
            padding: 0;
        }
        /deep/ .ss-container{
            padding-right: 10px;
        }
    }
    .converstion_back {
        height:100%; // height: calc(100% - 170px);
        overflow: hidden;
        background: #fff !important;
        border-left: 1px solid #d8d6d6;
        border-right: 1px solid #d8d6d6;
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
        }
    }
    .chat_content {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .wrapper .converstion_back .ss-container{
        // background-color: white;
        background-color: #eaedf2;
        background-size: 716px;
        background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');

    }
    .colors{
        line-height: 1rem;
        margin-top: 2px;
        span{
            font-size: 10px;
        }
    }    
    .sect_header{
        background-color:#fefefe;        
        height:5.2rem; // height:70px;
        border-bottom: 0px solid #e9e9e9;
        padding-top:6px; 
    }
    .sect_header_color{
        background-color:#f5f5f5;        
    }
    .sec_decription p, h4{
        text-align: center !important;
        padding: 5px !important;
    }
    .header-title{
        font-size: 1.3em;
    }
    .non_converstion_back{
        // position: absolute;
        background-color: #eaedf2;
        height: 100%;
        width: 100%;
        padding-left: 20%;
        padding-top: 15%;
    }
    .non-selected-chat {
        
        // margin-top: 20%;
        // left:50%;
        // transform: translate(-50%,-50%);

        img{
            width:18rem; height:18rem; border-radius:50%; opacity:0.5;
        }
    }
    .profile {
        padding-bottom: 15px;
        height: calc(100%); // height: calc(100% - 70px);
        background-color: #FFFFFF;
    }
    .profile-picture{
        position: relative;
        border-radius: 50%;
        width: 50px;
        width: 50px;
        left: 15px;
    }
    .contact-picture{
        border-radius: 50%;
        width: 37px;
        width: 37px;
        padding: 0px !important;
        margin: 0px !important;
    }
    .contact-non-picture{
        display: flex; align-items: center; justify-content:center;
        border-radius: 50%;
        height: 37px;
        width: 37px;
    }
    .bg0{background-color:#ff4444}
    .bg1{background-color:#ffbb33}
    .bg2{background-color:#00C851}
    .bg3{background-color:#33b5e5}
    .bg4{background-color:#FF8800}
    .bg5{background-color:#CC0000}
    .bg6{background-color:#9933CC}
    .bg7{background-color:#4B515D}
    .bg8{background-color:#cddc39}
    .bg9{background-color:#ff8a65}

    .conversation-picture{
        border-radius: 50%;
        width: 30px;
        width: 30px;
        padding: 0px !important;
        margin: 0px !important;
    }
    .pointer-hover:hover{
        cursor: pointer;
    } 
    .profile-decription-name{
        font-weight: 600;
    }
    .fa-1_5x{
        font-size: 1.5em;
    }
    .cl-blue{
        color: #007bff;
    }
    .cl-white{
        color: #ffffff;
    }
    .cl-danger{
        color: red;
    }
    .cl-gray{
        background-color: silver;
    }
    .cl-green{
        background-color:#6adaa5;
    }
    .search-input{
        background:#ffffff !important;
        font-size:1em;
    }
    .search-input:focus{
        outline: 0 !important;
        box-shadow: none;
    }

    
    /* CHAT - MESSAGES  */
    .receivedMessageText{
        color: black;
        // background-color:#eaedf2; 
        background-color:white; 
        padding:1em; 
        border-top-left-radius:1em; 
        border-top-right-radius:1em; 
        border-bottom-right-radius:1em;
        min-width: 15rem;
        // width: 80%;
        max-width: 40rem;
    }    
    .receivedMessageImg{
        width:40px;
        height:40px;
        position:relative; 
        top:-1.6em; 
        right:1em
    }
    .receivedMessageDiv{
        width:40px;
        height:40px;
        position:relative; 
        top:-1.6em; 
        right:-1em
    }
    .sendedMessageText{
        color: #000;
        background-color: #dcf8c6;
        padding:1em; 
        border-top-left-radius:1em; 
        border-top-right-radius:1em; 
        border-bottom-left-radius:1em;
        min-width: 15rem;
        // width: 80%;
        // max-width: 40em;
        max-width: 40rem;
        box-shadow: 3px 3px 5px -4px #000;
    }
    .sendedMessageImg{
        width:40px;
        height:40px;
        position:relative; 
        top:-1.6em; 
        right:-0.9em
    }
    .mycontrolBar{
        background-color: white !important;
        color:white;
    }
    audio {
        width:23em;
        height: 25px;
        border-radius: 3px;
        transform: scale(1.05);
    }
    .message{
        min-width:13em;
    }
    .message-hover{
        display: block;
        visibility:visible;
    }
    .message-hout{
        display: none;
        visibility:hidden;
    }
    .contact-hover{
        // display: block;
        visibility:visible;
    }    
    .contact-hout{
        // display: none;
        visibility:hidden;
    }
    .selected_contact_item{
        background-color:#f5f5f0;
    }
    .contact_item:hover{
        background-color:#f5f5f5;
    }
    .message-options-style{
        position: relative;
        top: 0px;
        float: right;
        z-index: 8888;
        font-size: 1.9rem;
    }
    .text-message{
        word-break: break-word; 
    }    
    .document_sent{
        width: 50px;
        height: 50px;
        color:white;
        padding:0.1rem 0.6rem; 
        border:1px solid white;
        border-radius:50%
    }
    .document_received{
        width: 50px;
        height: 50px;
        color: #007bff;
        padding:0.1rem 0.6rem;
        border:1px solid #007bff;
        border-radius:50%
    }
    .document_sent_download{
        float:right; 
    }
    .document_received_download{
        float:right;
    }

    .midia-files{
        width: 15em;
    }
    .midia-files-document{
        width: 10em;
    }
    .text-input-message{
        // border: none;
        // padding: 0.6rem;
        // margin-top:0.5rem;
        width: 100%;
        font-size:1em;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        resize: none;
        scrollbar-color: rgba(0, 0, 0, 0.3) white;
    }
    .text-input-message:focus{
        outline: 0 !important;
        box-shadow: none !important;
    }
    .message-time-separator {
        color:gray;
        font-size: 1em;
        margin-left: 5%;
        width: 90%; 
        text-align: center !important; 
        border-bottom: 1px solid #d6d4d4 !important; 
        line-height: 0.01em;
    } 
    .message-time-separator span { 
        background-color:#eaedf2 !important; 
        border-radius: 10px;
        padding: 1.2em;
    }
    .message-time-separator span:hover { 
        background-color:#d8d6d6 ; 
    }
    .founded-messages:hover{
        background-color:#fafafa !important;
        cursor: pointer;
    }
    .amount-unreaded-messages {
        // min-width: 3em;
        // height: 2.5em;
        // border-radius: 2em;
        // padding: 0.5em 1em 2em 1em;
        // font-weight: bold;
        // border: 2px solid #fff;
        // background-color: #0377FE;
        // text-align: center;
        // position: relative;
        // top: 8px;
        // left: -25px;
        font-size: 1rem;
        color: white;
    }
    .zero-unreaded-messages {
        width: 2.5em;
        height: 2.5em;
        border-radius: 50%;
        background-color: transparent;
        text-align: center;
        position: relative;
        top: 8px;
        left: -10px;
    }    
    .amount-contacts-in-bag{
        // color: white;        
        // min-width: 3em;
        // height: 2.5em;
        // border-radius: 2em;
        // padding: 0.5em 0.7em 0.5em 0.7em;
        // font-weight: bold;
        // border: 2px solid #fff;        
        // border-radius: 50%;
        font-size: 1rem;
        position:relative; 
        top:-34px;
        left: 10px;
    }
    

    /* ICON STYLES*/
    .action-icons-fade{
        height:2em;
        width:2em;
        padding-top:0.5em; 
    }
    .action-icons-fade:hover{
        cursor: pointer;
    }
    .principal-icons{
        width: 2em !important;
        height: 2em !important;
    }    
    .icons-action-send{
        position: relative;
        top: 0.3rem;
        color: #a1a1a1;
        width: 4rem;
        height: 4rem;
        font-size: 2rem;
        border-radius: 50%;
        padding: 0.5rem 1.1rem;
    }
    .icons-action-send:hover{
        cursor: pointer;
    }
    .icons-action{
        color:#949aa2;
        font-size: 1.5rem;
        font-weight:800; 
        padding: 0px !important;
    }
    .icons-action:hover{
        // background-color: #f1f0f0;
        // border-radius: 50%;
        cursor: pointer;
    }
    .icons-action-search{
        margin-top: 10rem !important;
    }

    .icons-no-action{
        font-size: 1.2rem;
        color:#949aa2;
        width: 40px;
        height: 40px;
        padding: 15px;
    }    
    .container-icons-action-message{
        background-color:#fffff8;
        padding: 0px;
    }
    .icons-action-message{
        font-size: 1.2rem;
        color:#949aa2;
        width: 40px;
        height: 40px;
        padding: 15px;
    }
    .icons-action-message:hover{
        background-color: #f1f0f0;
        border-radius: 50%;
        cursor: pointer;
    }
    .icons-action-2{
        color:#949aa2;
        background-color:#fcf8f8;
        width: 40px;
        height: 40px;
        padding: 15px;
        border-radius:50px
    }
    .icons-action-2:hover{
        background-color: #f1f0f0;
        cursor: pointer;
    }
    .border-left-message{
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
    }
    .border-right-message{
        border-top-right-radius: 30px !important;
        border-bottom-right-radius: 30px !important;
    }    
    .icons-selected-file{
        font-size: 1.8rem;
        color:#2471d6;        
        padding: 25px;
    }
    .icons-selected-file:hover{
        cursor: pointer;
    }

    /* UL-LI-MENU */
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
    .menu li:hover ul, .menu li.over ul{
        display:block;
    }
    .menu li ul li{
        display:block; 
        width:100%;
    }
    .menu li ul li:hover{
        background-color: rgb(240, 238, 238)
    }
    .menu, li, a, a:active, a:focus {
        outline: none;
    }

    /* FADE IN EVENT*/
    .fadeIn {
        -webkit-animation: fadein 1s; 
        -moz-animation: fadein 1s; 
            -ms-animation: fadein 1s; 
            -o-animation: fadein 1s; 
                animation: fadein 1s;
    }
    @keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @-moz-keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @-webkit-keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @-ms-keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @-o-keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }    
    /*Novo - Margin busca*/
    .flex-baseline{
        display: flex;
        align-items: baseline;
    }

    .search-contact{
        width: 100%;
    }

    .btn-back{
        display: none;
    }

    /* On screens that are 992px or less, set the background color to blue */
    @media screen and (max-width: 992px) {
        .btn-back{
            display: block;
        }
        .chat-center-side-open{
            z-index: 99996;
        }
        .chat-center-side-open{
            position: absolute;
            z-index: 99997;
        }
        .chat-right-side-open{
            position: absolute;
            z-index: 99998;
        }
        .chat-find-side-open{
            position: absolute;
            z-index: 99999;
        }
        .width-30{
            width: 100% !important;
        }
        .width-70{
            width: 100% !important;
        }
        .width-25{
            width: 100% !important;
        }
    }

    @media screen and (max-width: 700px) {
        .receivedMessageText{
            color: black;
            background-color:white; 
            padding:1em; 
            border-top-left-radius:1em; 
            border-top-right-radius:1em; 
            border-bottom-right-radius:1em;
            width: 80%;
        }
        .sendedMessageText{
            padding:1em; 
            border-top-left-radius:1em; 
            border-top-right-radius:1em; 
            border-bottom-left-radius:1em;
            width: 80%;
        }
        .receivedMessageImg{
            top: -0.8em;
            right: 0em;
        }
        .sendedMessageImg{
            top: -0.6em;
            // right: 0em;
        }
        .width-30{
            width: 100% !important;
        }
        .width-70{
            width: 100% !important;
        }
        .width-25{
            width: 100% !important;
        }
        .badge-whatsapp-notification{
            background-color: #5AD856 !important;
        }
        .badge-success{
            background-color: #5AD856 !important;
        }
    }
    
</style>

<template>
    <div class="row chat p-0" style="background-color:#fefefe !important">
        <left-side-bar  :left_layout ="leftLayout" style="top:0px !important" :item='{}' @reloadContacts='reloadContacts'></left-side-bar>
        <audio ref="newMessageSound" autoplay controls style="display:none" ><source src="audio/newMessage.ogg#t=1" type="audio/ogg"></audio>
        <audio ref="newContactInBag" autoplay controls style="display:none" ><source src="audio/newContactInBag.ogg" type="audio/ogg"></audio>

        <!-- Left side of chat-->
        <div id="chat-left-side" class="col-lg-3 p-0">
            <div class="chatalign">
                <div class="sect_header">
                    <ul v-if="isSearchContact==false" class='menu'>
                        <li>
                            <a href="javascript:void()" @click.prevent="modalUserCRUDDatas=!modalUserCRUDDatas" title="Meu perfil" style="padding:0 !important">
                                <img :src="logguedAttendant.image_path" width="50px" height="50px" class="profile-picture" alt="Foto de perfil">
                            </a>
                        </li>
                        <ul class='menu' style="float:right; margin-right:5px">
                            <li><i class="fa fa-search icons-action mt-1" title="Buscar contato ..." @click.prevent="isSearchContact=!isSearchContact"></i></li>
                            <!-- <li> -->
                                <b-dropdown class="dropdown btn-group" variant="link" toggle-class="text-decoration-none" size="md"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-h icons-action" title="Opções"  aria-hidden="false"></i>
                                    </template>
                                    <b-dropdown-item title="Inserir novo contato" class="dropdown_content">                                        
                                        <a href='javascript:void(0)' class="drpodowtext" @click="toggleLeft('toggle-add-contact')">
                                            <i class="fa fa-user-plus fa-xs " ></i> 
                                            Inserir contato
                                        </a>
                                    </b-dropdown-item>
                                    <b-dropdown-item title="Encerrar sessão" class="dropdown_content">
                                        <router-link to="/" class="drpodowtext">
                                            <div v-on:click="logout">
                                                <i class="fa fa-sign-out"></i> 
                                                Encerrar sessão
                                            </div>
                                        </router-link>
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
                            <!-- </li> -->
                        </ul>
                    </ul>
                    <ul v-if="isSearchContact==true" class='menu'>
                        <li><i class="fa fa-arrow-left icons-action mt-1" @click.prevent="isSearchContact=!isSearchContact"></i></li>
                        <li><input class="form-control search-input border-0 mt-3" style="width:120%: left:-10px" type="search" v-model="searchContactByStringInput" placeholder="Buscar contato" ></li>
                        <ul class='menu' style="float:right; margin-right:10px">
                            <li><i class="fa fa-close icons-action mt-1" @click.prevent="searchContactByStringInput=''; isSearchContact=!isSearchContact"></i></li>
                        </ul>                        
                    </ul>
                </div>
                <div class="sect_header" style="background-color:#fafafa;">
                    <div class="text-center">
                        <ul style="margin-left:25%" class="list-group list-group-horizontal">
                            <!-- <li class="list-group-item border-0 m-0 p-0  bg-transparent">
                                <a href="javascript:void()">
                                    <span class="mdi mdi-message-text fa-2x cl-blue"></span><br>
                                    <span style="position:relative; top:-0.8em" class="principal-icons">Chats</span>
                                </a>
                            </li> -->
                            <li class="list-group-item border-0 m-0 ml-5 p-0  bg-transparent">
                                <a href="javascript:void()" @click.prevent="modalNewContactFromBag=!modalNewContactFromBag && amountContactsInBag>0">
                                    <span class="mdi mdi-account-box-outline fa-2x cl-blue" @click.prevent="getNewContactFromBag" title="Adherir novo contato"></span><br>
                                    <span style="position:relative; top:-0.8em; left:0.5em" @click.prevent="getNewContactFromBag" title="Adherir novo contato" class="principal-icons">Contatos</span>
                                    <span v-if="amountContactsInBag>0" :title="amountContactsInBag + ' contatos novos disponíveis'" class="amount-contacts-in-bag cl-green">{{amountContactsInBag}}</span>
                                    <span v-if="amountContactsInBag==0" :title="' Nenhum contato novo disponível'" class="amount-contacts-in-bag cl-gray">{{amountContactsInBag}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>                        
                </div>
                <v-scroll :height="Height(170)"  color="#ccc" class="margin-left:0px" style="background-color:white" bar-width="8px">
                    <ul>
                        <li v-for="(contact,index) in allContacts" class="chat_block" :key="index">
                            <a :href="contact.first_name" @click.prevent="getContactChat(contact)">
                                <article class="media mt-1 mb-4">
                                    <a class="float-left desc-img mt-3">
                                        <img :src="(contact.json_data)?JSON.parse(contact.json_data).urlProfilePicture:''" class="contact-picture">
                                    </a>
                                    <div class="media-body pl-3 mb-1 mt-3 chat_content">
                                        <a class="text-dark font-weight-bold" style="font-size:1.1em" href="javascript:void(0)">
                                            {{textTruncate(contact.first_name,20) }}
                                        </a><br>
                                        <a class="text-muted"> 
                                            <span v-if="!contact.last_message" style="font-size:1em">
                                                <i>Sem mensagens</i>
                                            </span>                                           
                                            <span v-if="contact.last_message && contact.last_message.type_id==1" style="font-size:1em" :title='textTruncate(contact.last_message.message,40)'>
                                                {{textTruncate(contact.last_message.message,22)}}
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
                                    <span class="mt-2 text-muted" style="font-size:0.8em; color:#a4beda">{{(contact.last_message) ? getLastMessageTime(contact.last_message.created_at) : '--:--'}}</span>
                                    <div v-show="contact.count_unread_messagess>0" class="amount-unreaded-messages mt-4" :title='contact.count_unread_messagess + " mensagens novas"'>{{contact.count_unread_messagess}}</div>
                                    <span v-show="contact.count_unread_messagess==0" class="zero-unreaded-messages" > </span>
                                </article>
                            </a>
                        </li>
                    </ul>
                </v-scroll>
            </div>
        </div>

        <!-- Center side of chat-->
        <div id="chat-center-side" class="col-lg-9 p-0"><!-- <div class="col-sm-4 col-md-5 mt-3"> -->            
            <div v-if="selectedContactIndex>=0" class="converstion_back">
                <div class="sect_header">                    
                    <ul class='menu'>                        
                        <li><span class="pl-4"><img :src="(selectedContact.json_data)?JSON.parse(selectedContact.json_data).urlProfilePicture:''" class="img-fluid rounded-circle desc-img pointer-hover" @click.prevent="displayChatRightSide()"></span></li>
                        <li><span class="pl-3 person_name person_name_style pointer-hover" @click.prevent="displayChatRightSide()"></span></li>
                        <li><p class="pl-0 ml-0 pointer-hover" @click.prevent="displayChatRightSide()">{{ selectedContact.first_name }} </p></li>                        
                        <ul class='menu' style="float:right">
                            <li><a href="javascript:void()" title="Buscar mensagens" @click.prevent="displayChatFindMessage()"><i class="fa fa-search"></i></a></li>
                            <li>
                                <!-- <form action="">
                                    <b-dropdown class="dropdown hidden-xs-down btn-group" id="dropdown-right" variant="link" toggle-class="text-decoration-none"  right="">
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
                <v-scroll :height="Height(170)" color="#ccc" bar-width="8px" ref="message_scroller" :seeSrolling="'true'" @onscrolling="chatMessageScroling">                       
                    <ul>
                        <li v-for='(message,index) in messages' :key="index">

                            <!-- Date separator message-->
                            <div v-if="message.type_id=='date_separator'" class="pt-5 pb-5">
                                <h6 class="message-time-separator mt-5"><span>{{message.time.date}}</span></h6>
                            </div>

                            <!-- Messages -->
                            <div v-if="message.type_id!='date_separator'" >
                                <div v-if="message.source==1" class="row mt-2">
                                    <div  class="col-lg-1"></div>
                                    <div class="col-lg-11">
                                        <p style="float:left" class="receivedMessageText">
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
                                                    <a :href="message.path" target="_blank" rel=”noopener”  >
                                                        <i class="fa fa-file-text fa-5x" aria-hidden="true" :class="[{ document_sent: message.source==0 },{ document_received: message.source==1 }]"></i>
                                                    </a>  
                                                    <br>                                      
                                                </span>
                                                <span v-if="message.message && message.message !=''" class="text-message">
                                                    {{ message.message ? message.message : "" }}
                                                </span>
                                                <br>
                                        </p>
                                    </div>
                                    <div class="col-lg-1">
                                        <img :src="(selectedContact.json_data)?JSON.parse(selectedContact.json_data).urlProfilePicture:''"  alt="" class="conversation-picture receivedMessageImg">
                                    </div>
                                    <div class="col-lg-11">
                                        <div style="float:left" class="thetime">{{message.time.hour}}</div>
                                    </div>
                                </div>

                                <div v-if="message.source==0" class="row mt-2">
                                    <div class="col-lg-11">
                                        <p style="float:right" class="sendedMessageText">
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
                                                    <a :href="message.path" target="_blank" rel=”noopener”  >
                                                        <i class="fa fa-file-text fa-5x" aria-hidden="true" :class="[{ document_sent: message.source==0 },{ document_received: message.source==1 }]"></i>
                                                    </a>  
                                                    <br>                                      
                                                </span>
                                                <span v-if="message.message && message.message !=''" class="text-message">
                                                    {{ message.message ? message.message : "" }}
                                                </span>
                                                <br>
                                        </p>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    
                                    <div class="col-lg-11">
                                        <div style="float:right" class="thetime">{{message.time.hour}}</div>
                                    </div>
                                    <div class="col-lg-1">
                                        <img :src="logguedAttendant.image_path" alt="" class="conversation-picture sendedMessageImg">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </v-scroll> 

                <!-- Compose and send new message -->
                <div class="p-3">
                    <div class="input-group pb-5 pr-1" style="color:gray">
                        <div class="input-group-prepend">
                            <div class="input-group-text pl-2 pr-2  border border-right-0 border-left-message container-icons-action-message">
                                <i v-if="isSendingNewMessage==false" class="fa fa-keyboard-o icons-no-action" title="Digite uma mensagem"></i>
                                <i v-if="isSendingNewMessage==true" class="fa fa-spinner fa-spin fa-cog icons-no-action" title="Enviando mensagem"></i>
                            </div>
                        </div>
                        <textarea @keyup.enter.exact="sendMessage"  v-model="newMessage.message" placeholder=""                                 
                                class="form-control border border-left-0 border-right-0 text-input-message srcollbar" ref="inputTextAreaMessage">
                        </textarea>
                        <div class="input-group-prepend">
                            <a href="javascript:void()" v-if="file!=null" class="input-group-text border border-left-0 container-icons-action-message" @click.prevent="modalRemoveSelectedFile = !modalRemoveSelectedFile" title="Click para remover o arquivo">
                                <i class="fa fa-clipboard icons-selected-file"></i>
                                <i style="background-color:withe; color:red; position: relative; height:1.5em; width1.5em; top:-0.25em; left:-1.7em; border-radius:20px;" class="fa fa-window-close"></i>
                            </a>
                        </div>
                        <div class="input-group-prepend">
                            <a href="javascript:void()" class="input-group-text border border-left-0 container-icons-action-message" @click.prevent="triggerEvent('fileInputImage')" title="Anexar imagem">
                                <i class="fa fa-file-image-o icons-action-message"></i>
                            </a>
                        </div>                       
                        <div class="input-group-prepend">
                            <a href="javascript:void()" class="input-group-text border border-left-0 container-icons-action-message" @click.prevent="triggerEvent('fileInputAudio')" title="Anexar audio">
                                <i class="fa fa-file-audio-o icons-action-message"></i>
                            </a>
                        </div>
                        <div class="input-group-prepend">
                            <a href="javascript:void()" class="input-group-text pr-2 border border-left-0 border-right-message container-icons-action-message" @click.prevent="triggerEvent('fileInputDocument')" title="Anexar documento">
                                <i class="fa fa-file-text-o icons-action-message"></i>
                            </a>
                        </div>
                        <div class="input-group-prepend">
                            <a href="javascript:void()" class="input-group-text pl-2 pr-3 border-0  container-icons-action-message" @click.prevent="sendMessage">
                                <i class="mdi mdi-send fa-2x icons-action-send ql-color-blue"></i>
                            </a>
                        </div>
                        <input id="fileInputImage" ref="fileInputImage" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="image/*"/>
                        <input id="fileInputAudio" ref="fileInputAudio" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="audio/*"/>
                        <input id="fileInputVideo" ref="fileInputVideo" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="video/*"/>
                        <input id="fileInputDocument" ref="fileInputDocument" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept=".doc, .docx, ppt, pptx, .txt, .pdf"/>
                    </div>
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
        <div v-show="showChatRightSide==true" class="col-lg-3 bg-white p-0">
            <div class="sect_header">
                <ul class='menu'>
                    <li><a href="javascript:void(0)" @click.prevent="displayChatRightSide()"><i class="fa fa-close" aria-hidden="true"></i></a></li>
                    <li><p class="header-title">Detalhes</p></li>
                        <ul class='menu' style="float:right">                            
                            <li>
                                <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none"  right="">
                                    <template v-slot:button-content>
                                        <i class="fa fa-ellipsis-v mt-3" title="Ações sobre contato" style="color:#949aa2;"></i>
                                    </template>
                                    <!-- <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click="fn_show_edit_right_side()"><i class="fa fa-pencil-square-o"></i> Editar</a>
                                    </b-dropdown-item> -->
                                    
                                    <!-- <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" ><i class="fa fa-bell-slash-o"></i> Silenciar</a>
                                    </b-dropdown-item>-->

                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="modalTransferContact=!modalTransferContact"><i class="fa fa-exchange"></i> Transferir</a>
                                    </b-dropdown-item>

                                    <b-dropdown-item exact class="dropdown_content">
                                        <a href="javascript:void(0)" exact class="drpodowtext" @click.prevent="displayDeleteContact()"><i class="fa fa-trash-o"></i> Eliminar</a>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </li>                            
                        </ul>
                </ul> 
            </div>
            <div v-if="selectedContactIndex>=0" class="profile sec_decription bg-white">
                <v-scroll :height="Height(100)"  color="#ccc" bar-width="8px">
                    <div class="text-center">
                        <img :src="(selectedContact.json_data)?JSON.parse(selectedContact.json_data).urlProfilePicture:''" class="rounded-circle desc-img2 mb-3 mt-3" alt="Foto de perfil">
                        <h4 class="profile-decription-name">{{selectedContact.first_name}}</h4>
                        
                        <!-- Informação -->
                        <div class="border mt-3 p-1 mr-2" style="background-color:#fafafa">
                            <div class="row" >
                                <div class="col-lg-1 p-2 ml-3">
                                    <i class="mdi mdi-account-box-outline text-muted" aria-hidden="true"></i>
                                </div>
                                <div class="col-lg-8 p-1" style="text-align:left">
                                    <span class="text-muted" style="font-size:1.1em">Informação</span>
                                </div>
                                <div class="col-lg-1 p-2" >
                                    <i v-show="showContactInformation" style="" @click.prevent="copyContact; isEditingContact=!isEditingContact"  class="fa fa-pencil text-muted action-icons-fade" aria-hidden="true"></i>
                                </div>
                                <div class="col-lg-1 p-2" >
                                    <i v-show="!showContactInformation" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactInformation=!showContactInformation"></i>
                                    <i v-show="showContactInformation"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactInformation=!showContactInformation"></i>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContactInformation" class="border border-top-0 p-1 mr-2 fadeIn">
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item border-0" title="Nome"><i class="mdi mdi-account-box-outline fa-1_5x text-muted"></i></li>
                                <li style="margin-top:1em !important">
                                    <span v-show="!isEditingContact">{{selectedContact.first_name}}</span>
                                    <input v-show="isEditingContact" type="text" v-model="selectedContactToEdit.first_name" placeholder="Nome completo (*)" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item border-0" title="Email"><i class="mdi mdi-contact-mail-outline fa-1_5x text-muted"></i></li>
                                <li style="margin-top:1em !important">
                                    <span  v-show="!isEditingContact">{{selectedContact.email}}</span>
                                    <input v-show="isEditingContact" type="text" v-model="selectedContactToEdit.email" placeholder="Email" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>                            
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item border-0" title="Whatsapp"><i class="mdi mdi-whatsapp fa-1_5x text-muted"></i></li>
                                <li style="margin-top:1em !important">
                                    <span v-show="!isEditingContact" style="word-break: break-word;">{{selectedContact.whatsapp_id}}</span>
                                    <input v-show="isEditingContact" type="text" v-model="selectedContactToEdit.whatsapp_id" placeholder="WhatsApp (*)" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item border-0" title="Telefone"><i class="mdi mdi-contact-phone-outline fa-1_5x text-muted"></i></li>
                                <li style="margin-top:1em !important">
                                    <span v-show="!isEditingContact" class="mt-1">{{selectedContact.phone}}</span>
                                    <input v-show="isEditingContact" type="text" v-model="selectedContactToEdit.phone" placeholder="Telefone fixo" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                            <div v-show="isEditingContact">
                                <button class="btn btn-primary text-white pl-5 pr-5 mt-2 mb-1" @click.prevent="updateContact">
                                    <i v-show="isUpdatingContact==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar
                                </button>
                            </div>
                        </div>

                        <!-- Nota resumo -->
                        <div class="border mt-3 p-1 mr-2" style="background-color:#fafafa">
                            <div class="row" >
                                <div class="col-lg-1 p-2 ml-3">
                                    <i class="mdi mdi-account-badge-horizontal-outline text-muted" aria-hidden="true"></i>
                                </div>
                                <div class="col-lg-8 p-1" style="text-align:left">
                                    <span class="text-muted" style="font-size:1.1em">Nota resumo</span>
                                </div>
                                <div class="col-lg-1 p-2" >
                                    <i v-show="showContactSummary" style="" @click.prevent="copyContact; isEditingContactSummary=!isEditingContactSummary"  class="fa fa-pencil text-muted action-icons-fade" aria-hidden="true"></i>
                                </div>
                                <div class="col-lg-1 p-2" >
                                    <i v-show="!showContactSummary" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactSummary=!showContactSummary"></i>
                                    <i v-show="showContactSummary"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactSummary=!showContactSummary"></i>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContactSummary" class="border border-top-0 p-1 mr-2 fadeIn">
                            <div class="attachments  p-2" style="min-height:40px">
                                <p v-show="!isEditingContactSummary" style="word-break: break-word; color:black" class="text-center">{{selectedContact.summary}}</p>
                                <textarea v-show="isEditingContactSummary" rows="4" v-model="selectedContactToEdit.summary" class="border border-top-0 border-left-0 border-right-0 font-italic text-center" style="word-break: break-word; text-align:justify; width:100%; resize: none;"></textarea>
                            </div>
                            <div v-show="isEditingContactSummary">
                                <button class="btn btn-primary text-white pl-5 pr-5 mt-2 mb-1" @click.prevent="updateContact">
                                    <i v-show="isUpdatingContact==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar
                                </button>
                            </div>
                        </div>

                        <!-- Imagens e mídias -->
                        <div class="border mt-3 p-1 mr-2" style="background-color:#fafafa">
                            <div class="row" >
                                <div class="col-lg-1 p-2 ml-3">
                                    <i class="mdi mdi-camera-enhance-outline text-muted" aria-hidden="true"></i>
                                </div>
                                <div class="col-lg-9 p-1" style="text-align:left">
                                    <span class="text-muted" style="font-size:1.1em">Imagens e mídias</span>
                                </div>
                                <div class="col-lg-1 p-2" >
                                    <i v-show="!showContactMedia" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactMedia=!showContactMedia"></i>
                                    <i v-show="showContactMedia"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContactMedia=!showContactMedia"></i>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContactMedia" class="border border-top-0 p-1 mr-2 fadeIn">
                            <div class="attachments  p-4">
                                <!-- <div class="row">
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
                                </div> -->
                            </div>
                        </div>

                        <!-- Arquivos e documentos -->
                        <div class="border mt-3 p-1 mr-2" style="background-color:#fafafa">
                            <div class="row" >
                                <div class="col-lg-1 p-2 ml-3">
                                    <i class="mdi mdi-file-document-outline text-muted" aria-hidden="true"></i>
                                </div>
                                <div class="col-lg-9 p-1" style="text-align:left">
                                    <span class="text-muted" style="font-size:1.1em">Arquivos e documentos</span>
                                </div>
                                <div class="col-lg-1 p-2" >
                                    <i v-show="!showContacDocuments" class="fa fa-plus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContacDocuments=!showContacDocuments"></i>
                                    <i v-show="showContacDocuments"  class="fa fa-minus text-muted action-icons-fade" aria-hidden="true" @click.prevent="showContacDocuments=!showContacDocuments"></i>
                                </div>
                            </div>
                        </div>
                        <div v-if="showContacDocuments" class="border border-top-0 p-1 mr-2 fadeIn">
                            <div class="attachments  p-4">
                                <!-- <div class="row">
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
                                </div> -->
                            </div>
                        </div>

                    </div>
                </v-scroll>
            </div>
        </div>

        <!-- Find-Right side of chat--><!-- <div class="col-sm-4 col-md-3 mt-3"> -->
        <div v-show="showChatFindMessages==true" class="col-lg-3 bg-white p-0">
            <div class="col-lg-12 sect_header">
                <ul class='menu'>
                    <li><i class="fa fa-close icons-action mt-2" @click="searchMessageByStringInput='';messagesWhereLike=[]; displayChatFindMessage()"></i></li>
                    <li><input class="form-control search-input border-0 mt-3" style="width:120%: left:-20px; top:-10px" type="search" v-model="searchMessageByStringInput" @keyup.prevent="getContactChatWhereLike" ref="searchMessageByStringInputref" placeholder="Buscar mensagem ..." ></li>
                    <ul class='menu' style="float:right; margin-right:10px">
                        <li><i class="fa fa-arrow-right icons-action mt-2" @click="searchMessageByStringInput='';messagesWhereLike=[]; displayChatFindMessage()"></i></li>
                    </ul>                         
                </ul>
            </div>
            <v-scroll :height="Height(100)" class="pl-0" color="#ccc" style="background-color:white" bar-width="8px">
                <ul style="margin-left:-35px">
                    <li v-for="(message,index) in messagesWhereLike" class="chat_block pt-3 pb-3 founded-messages" :key="index">
                        <a href="javascript:void()" @click.prevent="findAroundMessageId;">
                            <div class="">
                                <span class="mt-2 text-muted" style="font-size:0.8em">{{getLastMessageTime(message.created_at)}}</span>
                                <div class="media-body mb-2 mt-1 chat_content"><span class="text-muted">{{ message.message}}</span></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </v-scroll>
        </div>

        <!-- Modal to transfer contact-->
        <b-modal v-model="modalTransferContact" :hide-footer="true" title="Transferir contato">
            <attendantCRUDContact :action='"transfer"' :item='selectedContact' @onclosemodal='closemodal' @reloadAfterTransferContact='reloadAfterTransferContact'></attendantCRUDContact>
        </b-modal>
        
        <!-- Modal to delete contact-->
        <b-modal v-model="modalDeleteContact" :hide-footer="true" title="Verificação de exclusão">
            <attendantCRUDContact :action='"delete"' :item='selectedContact' @onclosemodal='closemodal' @reloadContacts='reloadContactsAfterDelete'></attendantCRUDContact>
        </b-modal>

        <!-- Modal to show image-->
        <b-modal v-model="modalShowImage" :hide-footer="true" :hide-header="true" size="lg" style="background-color:red !important; padding:0px; " class="">
                <img class="img-fluid" style="max-height:540px; max-width:400px; " :src="modalShowImageSrc"/>
                <!-- <img style="width:100%; height:100%" class="embed-responsive-item modal-body-bg" :src="modalShowImageSrc"/> -->
        </b-modal>

        <!-- Modal to show video-->
        <b-modal v-model="modalShowVideo" :hide-footer="true" :hide-header="true" size="lg"  class="m-0 modal-body-bg">
            <div class="">
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

        <!-- Modal to remove the selected file-->
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
                    <button type="submit" class="btn btn-primary btn_width" @click.prevent="getNewContactFromBag">Adicionar</button>
                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="modalNewContactFromBag=!modalNewContactFromBag">Cancelar</button>
                </div>
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
    import sendMessageFiles from "src/components/pages/socialhub/popups/sendMessageFiles.vue";

    export default {
        components: {
            vScroll,
            rightSideBar,
            leftSideBar,
            userCRUDDatas,
            attendantCRUDContact,
            sendMessageFiles
        },

        data() {
            return {
                logguedAttendant:{},

                contacts_url: 'contacts',
                contacts_bag_url: 'getBagContact',
                chat_url: 'chats',

                contacts:[],
                selectedContact:{},
                selectedContactToEdit:{},
                amountContactsInBag:0,
                selectedContactIndex: -1,
                searchContactByStringInput:'',
                filterContactToken: '',
                
                messages:[],
                searchMessageByStringInput:'',
                messagesWhereLike:[],
                findAroundMessageId:null,
                pageNumber:0,
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
                    'status_id':1,
                    'socialnetwork_id':1, //Whatsapp
                },

                showContactInformation:false,
                showContactSummary:false,
                showContactMedia:false,
                showContacDocuments:false,
                showChatRightSide:false,
                showChatFindMessages:false,

                isSearchContact:false,
                isEditingContact:false,
                isEditingContactSummary:false,
                isSendingNewMessage:false,
                isUpdatingContact:false,

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
                
                rightLayout:'toggle-edit-contact',
                leftLayout:'toggle-add-contact',

                window: {width: 0,height: 0},

                flagReference: true,

            }
        },
        
        methods: {    
            sendMessage() {
                if (this.isSendingNewMessage) return;
                var This = this;
                this.newMessage.message = this.newMessage.message.trim();
                if (this.newMessage.message != "" || this.file) {
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
                        formData.append("file",this.file); //Add the form data we need to submit  
                    }
                    try {
                        ApiService.post(this.chat_url,formData, {headers: { "Content-Type": "multipart/form-data" }})
                        .then(response => {
                            var message = response.data;
                            if (message.data) {
                                message.data = JSON.parse(message.data);
                                message.path = message.data.FullPath;
                                // message.path = this.pathContactMessageFile(message.contact_id, message.data.SavedFileName);
                            }
                            message.time = this.getMessageTime(message.created_at)
                            this.messages[this.messages.length]=message;
                            this.contacts[this.selectedContactIndex].last_message = message;
                            this.newMessage.message = "";
                            this.file = null;
                            this.$refs.message_scroller.scrolltobottom();

                            
                            //-----------------------------------------------------
                            //salvar item atual
                            var targetContact = Object.assign({}, this.contacts[this.selectedContactIndex]);
                            //eliminar item da lista de contatos
                            delete this.contacts[this.selectedContactIndex];
                            //inserir item salvo no inicio da lista
                            this.contacts.unshift(targetContact);
                            //atualizar indices
                            var i = 0;
                            this.contacts.forEach(function(item, i){
                                item.index = i++;
                            });
                            this.selectedContactIndex = 0;
                            this.selectedContact = this.contacts[this.selectedContactIndex];
                            //-----------------------------------------------------

                            
                        })
                        .catch(function(error) {                            
                            if (error.response) {
                                console.log('error.response');
                                console.log(error.response.data);
                                console.log(error.response.data.message);
                                console.log(error.response.status);
                                console.log(error.response.headers);
                                if(error.response.data.message && error.response.data.message.includes("Could not resolve host")){
                                    console.log(error.response.data.message);
                                    miniToastr.warn("Verifique a conexão do seu computador e  do hardware à Internet.", "Atenção");                                     
                                }
                            } else
                            if (error.request) {
                                console.log('error.request');
                                console.log(error.request);
                            } else{
                                console.log('some another error');
                                console.log(error.message);
                            }
                            console.log('error config');
                            console.log(error.config);
                        }).finally(() => {This.isSendingNewMessage = false;});
                    } catch (error) {
                        This.newMessage.message = "";
                        This.isSendingNewMessage = false;                        
                    }
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
                        if(this.selectedContactIndex>=0){
                            this.selectedContact = this.contacts[this.selectedContactIndex];
                        }
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });
            },

            getAmountContactsInBag: function() { //R
                ApiService.get('getBagContactsCount')
                    .then(response => {
                        this.amountContactsInBag = response.data;                        
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });
            },

            getNewContactFromBag: function() { //R
                if(this.amountContactsInBag==0){
                    miniToastr.info("Informação", "Não existem novos contatos para adicionar a sua lista");  
                    return;
                }
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
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Erro adicionando o contato");   
                    });
            }, 

            getContactChat: function(contact) {
                if(this.showChatRightSide) this.displayChatRightSide();
                if(this.showChatFindMessages) this.displayChatFindMessage();
                this.messageTimeDelimeter = '';
                if(this.selectedContactIndex!=contact.index){                    
                    this.selectedContactIndex = contact.index;
                    ApiService.get(this.chat_url,{
                        'contact_id':contact.id,
                        'message_id': this.findAroundMessageId,
                        'page':this.pageNumber
                    })
                        .then(response => {
                            this.findAroundMessageId = null;
                            this.contacts[this.selectedContactIndex].count_unread_messagess =0;
                            this.messagesWhereLike = [];
                            this.searchMessageByStringInput = [];
                            this.messages = response.data; 
                            this.messages_copy=[];
                            var This = this;
                            this.messages.forEach(function(item, i){
                                try {
                                    item.time = This.getMessageTime(item.created_at);

                                    if(item.time.date!=This.messageTimeDelimeter){
                                        This.messages_copy.push({
                                            'type_id': 'date_separator',
                                            'time':{'date':item.time.date}
                                        });
                                        This.messageTimeDelimeter = item.time.date;
                                    }
                                    if(item.data != "" && item.data != null && item.data.length>0) {
                                        item.data = JSON.parse(item.data);
                                        if (item.type_id > 1)
                                            item.path = item.data.FullPath;
                                            // item.path = This.pathContactMessageFile(item.contact_id, item.data.SavedFileName);
                                    }
                                    This.messages_copy.push(item);
                                } catch (error) {
                                    console.log(error);
                                }
                            });
                            This.messages = Object.assign({}, This.messages_copy);
                            This.selectedContact = This.contacts[This.selectedContactIndex];

                            This.selectedContact.whatsapp_id = This.selectedContact.whatsapp_id.replace(/@s.whatsapp.net/i, ''); //ECR
                            
                            This.selectedContactToEdit = Object.assign({}, This.selectedContact);
                        })
                        .catch(function(error) {
                            miniToastr.error(error, "Error carregando os contatos");   
                        });
    
                    // setTimeout(() => {
                    //     this.$refs.input.focus();
                    // }, 20);
                }
            },
            
            getContactChatWhereLike: function() {
                this.searchMessageByStringInput = this.searchMessageByStringInput.trim();
                if (this.searchMessageByStringInput.length > 1){
                    ApiService.get(this.chat_url,{
                            'contact_id': this.selectedContact.id,
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

            updateContact: function() {
                // if(!this.selectedContactToEdit.whatsapp_id || this.selectedContactToEdit.whatsapp_id.trim() =='' || this.selectedContactToEdit.first_name.trim() ==''){
                //     miniToastr.error(error, "Confira os dados fornecidos");
                //     return;
                // }
                
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
                
                this.selectedContactToEdit.whatsapp_id += '@s.whatsapp.net';
                
                delete this.selectedContactToEdit.created_at;
                delete this.selectedContactToEdit.updated_at;                
                ApiService.put(this.contacts_url+'/'+this.selectedContactToEdit.id, this.selectedContactToEdit)
                .then(response => {
                    if(this.isEditingContact)
                        this.isEditingContact = false;
                    if(this.isEditingContactSummary)
                        this.isEditingContactSummary = false;
                    miniToastr.success("Contato atualizado com sucesso.","Sucesso");
                    this.getContacts();
                })
                .catch(function(error) {
                    ApiService.process_request_error(error);
                    miniToastr.error(error, "Erro adicionando contato");
                })
                .finally(() => this.isUpdatingContact = false);
            },

            chatMessageScroling: function(value){
                if(value<10){
                    this.pageNumber --;
                    //get new page of messages
                }else
                if(value>90){
                    this.pageNumber ++;
                    //get new page of messages
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

            triggerEvent (referenceFile) {
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
            
            pathContactMessageFile(contact_id, file_name) {
                let pathFile = process.env.MIX_FILE_PATH +'/' + 
                            this.logguedAttendant.company_id +'/' +
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

            displayChatRightSide(){
                if(this.showChatRightSide==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.showChatFindMessages = false;
                    this.showChatRightSide = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.showChatFindMessages = false;
                    this.showChatRightSide = false;
                }
                this.showContactInformation=true;
                this.showContactSummary=false;
                this.showContactMedia=false;
                this.showContacDocuments=false;
            },

            displayChatFindMessage(){
                if(this.showChatFindMessages==false){
                    document.getElementById("chat-center-side").classList.remove("col-lg-9");
                    document.getElementById("chat-center-side").classList.add("col-lg-6");
                    this.showChatRightSide = false;
                    this.showChatFindMessages = true;
                }else{
                    document.getElementById("chat-center-side").classList.remove("col-lg-6");
                    document.getElementById("chat-center-side").classList.add("col-lg-9");
                    this.showChatRightSide = false;
                    this.showChatFindMessages = false;
                }
            },

            displayDeleteContact(){
                this.item = this.selectedContact; 
                this.modalDeleteContact=!this.modalDeleteContact;
            },

            Height(val){
                return (this.window.height-val)+'px';
            },

            toggleLeft(val) {
                this.leftLayout = val;
                this.$store.commit('leftside_bar', "toggle");
            },

            textTruncate (str, length, ending) {
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

            reloadContactsAfterDelete(){
                this.displayChatRightSide();
                this.getContacts();
                this.selectedContact={};
                this.selectedContactIndex = -1;
            },

            reloadAfterTransferContact(){
                this.selectedContactIndex = -1;
                this.selectedContact = null;
                this.displayChatRightSide();
                this.getContacts();
            },

            closemodal(){
                this.modalDeleteContact = false;
                this.modalTransferContact = false;
            },
           
            logout() {
                window.localStorage.removeItem('token')
                window.localStorage.removeItem('user')
                delete axios.defaults.headers.common['Authorization']
                this.$router.push({name: "login"})
            },

            copyContact(){
                this.item= Object.assign({}, this.selectedContact);
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
                    miniToastr.error("Erro", "O nome do contato é obrigatorio" );
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
                    check = validation.check('phone', this.selectedContactToEdit.whatsapp_id)
                    if(check.success==false){
                        miniToastr.error("Erro", check.error );
                        this.flagReference = false;
                    }
                }else{
                    miniToastr.error("Erro", "O whatsapp do contato é obrigatorio" );
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
        },

        updated(){
            if(this.selectedContactIndex>=0 && this.$refs.message_scroller)
                this.$refs.message_scroller.scrolltobottom();
        },

        beforeMount() {
            this.logguedAttendant = JSON.parse(window.localStorage.getItem('user'));
            this.getContacts();
            this.getAmountContactsInBag();
            this.$store.commit('leftside_bar', "close");
            this.$store.commit('rightside_bar', "close");
        },

        mounted(){
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: process.env.MIX_PUSHER_APP_KEY,
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                wsHost: process.env.MIX_APP_HOST,
                // wsHost: window.location.hostname,
                wsPort: 6001,
                wssPort: 6001,
                // enabledTransports: ['ws'],
                enabledTransports: ['ws', 'wss'],
                // encrypted: true,
                encrypted: false,
                disableStats: false
            });

            window.Echo.channel('sh.message-to-attendant.' + this.logguedAttendant.id)
                .listen('MessageToAttendant', (e) => {
                    console.log(e);
                    var message = JSON.parse(e.message);
                    if(this.selectedContactIndex >= 0 && this.selectedContact.id == message.contact_id){
                        try {
                            if(message.data != "" && message.data != null && message.data.length>0) {
                                message.data = JSON.parse(message.data);
                                if (message.type_id > 1)
                                    message.path = message.data.FullPath;
                                    // message.path = this.pathContactMessageFile(message.contact_id, message.data.SavedFileName);
                            }
                        } catch (error) {
                            // console.log(error);
                        }

                        message.time = this.getMessageTime(message.created_at)
                        this.messages[this.messages.length]=message;
                        this.contacts[this.selectedContactIndex].last_message = message;
                        this.selectedContact.last_message = message;
                        if(this.$refs.message_scroller)
                            this.$refs.message_scroller.scrolltobottom();
                    }else{
                        
                        var This = this;
                        This.contacts.forEach((item, index) => {
                            if(item.id == message.contact_id){
                                //atualizar item atual
                                item.count_unread_messagess = item.count_unread_messagess + 1;
                                item.last_message = message;
                                //salvar item atual
                                var targetContact = Object.assign({}, item);
                                //eliminar item da lista de contatos
                                delete This.contacts[index];
                                //inserir item salvo no inicio da lista
                                This.contacts.unshift(targetContact);
                                //atualizar indices
                                var i = 0;
                                This.contacts.forEach(function(item2, i){
                                    item2.index = i++;
                                });
                                if(This.selectedContactIndex >=0 ){
                                    This.selectedContactIndex ++;
                                    This.selectedContact = This.contacts[This.selectedContactIndex];
                                }

                            }
                        });
                    }
                    this.$refs.newMessageSound.play();

                    console.log(this.amountContactsInBag);
            });

            window.Echo.channel('sh.contact-to-bag.' + this.logguedAttendant.company_id)
                .listen('NewContactMessage', (e) => {
                    if(this.amountContactsInBag<e.message)
                        this.$refs.newContactInBag.play();
                    // console.log(e);
                    this.amountContactsInBag = e.message;
            });

            window.Echo.channel('sh.transferred-contact.' + this.logguedAttendant.id)
                .listen('NewTransferredContact', (e) => {
                    var newContact = JSON.parse(e.message);
                    // newContact.index = this.contacts.length;
                    this.contacts.unshift(newContact);
                    var i = 0;
                    this.contacts.forEach(function(item, i){
                        item.index = i++;
                    });
                    if(this.selectedContactIndex >=0){
                        this.selectedContactIndex ++;
                        this.selectedContact = this.contacts[this.selectedContactIndex];
                    }
                    miniToastr.success("Sucesso", "Contato adicionado com sucesso");   
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
            },

            isSendingNewMessage: function(value){
                if(value){
                    console.log('sending message');
                    //disable new message, and upload and send buttons
                }else{
                    console.log('sended message');
                    //enable new message, and upload and send buttons
                }
            }
        }

    }
</script>


<style scoped lang="scss">

    /* LAYOUT */
    .desc-img {
        height: 3.6em;
        width: 3.6em;
    }
    .desc-img2 {
        height: 10rem;
        width: 10rem;
    }
    .chat {
        min-height: calc(100vh); // min-height: calc(100vh - 70px);
        height: calc(100vh); // height: calc(100vh - 70px);
        overflow: hidden;
    }  
    .chat_block {
        border-bottom: 1px solid #f4f2f2;
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
        }
    }
    .chat_content {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .wrapper .converstion_back .ss-container{
        background-color: #eaedf2;
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
        height:6.5rem; // height:70px;
        border-bottom: 1px solid #e9e9e9;
        padding-top:10px; 
    }
    .sec_decription p, h4{
        text-align: center !important;
        padding: 5px !important;
    }
    .header-title{
        font-size: 1.3em;
    }
    .non_converstion_back{
        background-color: #eaedf2;
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
        width: 50px;
        width: 50px;
        padding: 0px !important;
        margin: 0px !important;
    }
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
    .cl-gray{
        background-color: silver;
    }
    .cl-green{
        background-color:#6adaa5;
    }
    .search-input{
        background-color:#fffff8;
        font-size:1em;
    }
    .search-input:focus{
        outline: 0 !important;
        box-shadow: none;
    }

    
    /* CHAT - MESSAGES  */
    .receivedMessageText{
        color: black;
        background-color:white; 
        padding:1em; max-width:30em; 
        border-top-left-radius:1em; 
        border-top-right-radius:1em; 
        border-bottom-right-radius:1em;
        min-width: 15em;
        max-width: 40em;
    }    
    .receivedMessageImg{
        width:40px;
        height:40px;
        position:relative; 
        top:-1.6em; 
        right:-1em
    }
    .sendedMessageText{
        color: white;
        background-color: #0377FE;
        padding:1em; max-width:30em; 
        border-top-left-radius:1em; 
        border-top-right-radius:1em; 
        border-bottom-left-radius:1em;
        min-width: 15em;
        max-width: 40em;
    }
    .sendedMessageImg{
        width:40px;
        height:40px;
        position:relative; 
        top:-1.6em; 
        right:1.4em
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
        visibility:visible;
    }
    .message-hout{
        visibility:hidden;
    }
    .text-message{
        word-break: break-word; 
    }
    .document_sent{
        color:white;
    }
    .document_received{
        color: #007bff;
    }
    .midia-files{
        width: 15em;
    }
    .midia-files-document{
        width: 10em;
    }
    .text-input-message{
        background-color:#fffff8;
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
        min-width: 3em;
        height: 2.5em;
        border-radius: 2em;
        padding: 0.5em 1em 2em 1em;
        font-size: 0.85em;
        font-weight: bold;
        border: 2px solid #fff;
        background-color: #0377FE;
        color: white;
        text-align: center;
        position: relative;
        top: 8px;
        left: -25px;
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
        color: white;        
        min-width: 3em;
        height: 2.5em;
        border-radius: 2em;
        padding: 0.5em 0.7em 0.5em 0.7em;
        font-size: 0.85em;
        font-weight: bold;
        border: 2px solid #fff;        
        border-radius: 50%;
        position:relative; 
        top:-40px;
        left: -20px;
    }
    

    /* ICON STYLES*/
    .action-icons-fade{
        height:2em;width:2em; padding-top:0.5em; 
    }
    .action-icons-fade:hover{
        cursor: pointer;
    }
    .principal-icons{
        width: 2em !important;
        height: 2em !important;
    }    
    .icons-action-send{
        color:white;
        background: #007bff;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        padding: 5px;
    }
    .icons-action-send:hover{
        cursor: pointer;
    }
    .icons-action{
        color:#949aa2;
        width: 40px;
        height: 40px;
        padding: 15px;
    }
    .icons-no-action{
        font-size: 1.2rem;
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
        width: 60px;
        height: 60px;
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
   
</style>

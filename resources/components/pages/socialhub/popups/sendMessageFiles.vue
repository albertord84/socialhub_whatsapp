<template>
    <div >
        <div class="card tweet-profile" style="box-shadow:none">
            <div class="card-header text-center">
                <i class="fa fa-pencil icons-action" title="Editar perfil" style="position:relative; float:right" @click.prevent="editUser"></i>
                <h4>{{userLogged.name}}</h4>
                <p>{{userLogged.email}}</p>
            </div>
            <span class="profile-img text-center">
                <input id="fileUserPhoto" ref="fileUserPhoto" style="display:none"   type="file" @change.prevent="handleFileUserPhoto" accept="image/*"/>
                <img :src="userLogged.image_path" alt="profile image" class="img-fluid">
                <i class="fa fa-camera icons-action" @click.prevent="trigger()" title="Trocar imagem" style="position:relative; top:-40px; left:-30px"></i>
            </span>
            <div class="card-block mt-1">
                <hr>
                <div class="tweet-details">
                    <div class="row text-center">
                        <div class="col-6">
                            <p class="count">{{contacts.length}}</p>
                            <p>Contatos adicionados</p>
                        </div>
                        <div class="col-6">
                            <p class="count">{{totalNewMNessages}}</p>
                            <p>Mensagens novas</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 ml-3">
                        <p class="text-muted font-weight-bold">INFORMAÇÃO PESSOAL</p>
                    </div>
                    
                    <div class="col-12 mt-3 mb-3 text-center">                        
                        <a href="javascript:void(0)" class="btn btn-primary text-white pl-5 pr-5" @click.prevent="updateUser">
                            <i v-show="isSending==true" class="fa fa-spinner fa-spin" style="color:white" ></i> Atualizar
                        </a>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vScroll from "components/plugins/scroll/vScroll.vue"
    import ApiService from "resources/common/api.service";    
    import miniToastr from "mini-toastr";
    miniToastr.init();

     export default {
        name: "sendMessageFiles",

        props:{
            contacts:{},
        },

        components: {
            vScroll
        },

        data() {
            return {
                url:'users',                
                isSending:false,
                file:null,

                newMessage: {
                    'attendant_id':0,
                    'contact_id':0,
                    'message':'',
                    'source':0,
                    'type_id':1, //text //TODO criar tabela
                    'status_id':1, //text //TODO criar tabela
                    'socialnetwork_id':1, //Whatsapp
                },

            }
        },

        methods: {
            send_message() {
                this.newMessage.message = this.newMessage.message.trim();
                if (this.newMessage.message != "" || this.file) {
                    this.newMessage.contact_id = this.contacts[this.selected_contact_index].id;

                    this.isSending = true;

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
                    .catch(error => {
                        this.processMessageError(error, this.chat_url, "send");
                    })
                    .finally(() => this.isSending = false);
                }
            },

            updateUserPhoto(This){
                if(!This.file){
                    return;
                }else{
                    let formData = new FormData();
                    formData.append("file",This.file);

                    ApiService.post(
                        This.url+'/'+This.userLogged.id+'/update_image',
                        formData,
                        {headers: { "Content-Type": "multipart/form-data" }}
                    )
                    .then(response => {
                        This.userLogged.image_path = response.data;
                        window.localStorage.setItem('user', JSON.stringify(This.userLogged));
                        miniToastr.success("Foto atualizada com sucesso.","Sucesso");
                        window.location.reload(false);
                    })
                    .catch(error => {
                        this.processMessageError(error, This.url, "update_image"); 
                    });
                }
            },

            //------ Specific exceptions methods------------
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
           
        },

        beforeMount(){
            this.userLogged = JSON.parse(window.localStorage.getItem('user'));
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        computed:{
            
        },

        watch:{           

        }

       


     }




</script>

<style src="src/css/widgets.css" scoped></style>

<style lang="scss">
    .icons-action{
        color:#949aa2;
        background-color:white;
        width: 40px;
        height: 40px;
        padding: 15px;
        border-radius:50px
    }

    .icons-action:hover{
        background-color: #f1f0f0;
        cursor: pointer;
    }

    
</style>
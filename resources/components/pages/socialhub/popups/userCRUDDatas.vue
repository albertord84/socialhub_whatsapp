<template>
    <div >
        <div class="card tweet-profile" style="box-shadow:none">
            <div class="card-header text-center">
                <i class="fa fa-pencil icons-action" title="Editar perfil" style="position:relative; float:right" @click.prevent="editUser"></i>
                <h4>{{user.name}}</h4>
                <p>{{user.email}}</p>
            </div>
            <span class="profile-img text-center">
                <input id="fileUserPhoto" ref="fileUserPhoto" style="display:none"   type="file" @change.prevent="handleFileUserPhoto" accept="image/*"/>
                <img :src="user.image_path" alt="profile image" class="img-fluid">
                <i class="fa fa-camera icons-action" @click.prevent="trigger()" title="Trocar imagem" style="position:relative; top:-40px; left:-30px"></i>
            </span>
            <div class="card-block mt-1">
                <div v-if="contacts!=null" class="tweet-details">
                    <hr>
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
                    <hr>
                </div>
                <div class="row">
                    <div class="col-12 ml-3">
                        <p class="text-muted font-weight-bold">INFORMAÇÃO PESSOAL</p>
                    </div>
                    <div class="col-12 ml-3 mt-0">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-address-card-o text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">CPF</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <span v-show="!editMode" class="text-muted" >{{user.CPF}}</span>
                                    <input ref="CPF" v-show="editMode" type="text" v-model="model.CPF" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>
                    <div class="col-12 ml-3 mt-0">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-phone text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Telefone</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <span v-show="!editMode" class="text-muted" >{{user.phone}}</span>
                                    <input v-show="editMode" type="text" v-model="model.phone" class="border border-top-0 border-left-0 border-right-0  font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>                    
                    <div class="col-12 ml-3 mt-0">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-whatsapp text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Whatsapp</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <span v-show="!editMode" class="text-muted" >{{user.whatsapp_id}}</span>
                                    <input v-show="editMode" type="text" v-model="model.whatsapp_id" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>
                    <div class="col-12 ml-3 mt-0">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-facebook text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Facebook</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <span v-show="!editMode" class="text-muted" >{{user.facebook_id}}</span>
                                    <input v-show="editMode" type="text" v-model="model.facebook_id" class="border border-top-0 border-left-0 border-right-0  font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>
                    <div class="col-12 ml-3 mt-0">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-instagram text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Instagram</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <span v-show="!editMode" class="text-muted" >{{user.instagram_id}}</span>
                                    <input v-show="editMode" type="text" v-model="model.instagram_id" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>
                    <div class="col-12 ml-3 mt-0">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-linkedin text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Linkedin</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <span v-show="!editMode" class="text-muted" >{{user.linkedin_id}}</span>
                                    <input v-show="editMode" type="text" v-model="model.linkedin_id" class="border border-top-0 border-left-0 border-right-0 font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>

                    <div class="col-12 ml-3 mt-0">
                        <ul v-show="editMode" class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-key text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Senha</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <input v-show="!watchPassword" type="text" v-model="password" class="border border-top-0 border-left-0 border-right-0 " placeholder="Nova senha">
                                    <input v-show="watchPassword" ref="password" type="password" v-model="password" class="border border-top-0 border-left-0 border-right-0  font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>
                    <div class="col-12 ml-3 mt-0">
                        <ul v-show="editMode" class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-key text-muted" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Repetir senha</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item">
                                    <input v-show="!watchRepeatPassword" type="text" v-model="repeat_password" class="border border-top-0 border-left-0 border-right-0 " placeholder="Repetir senha">
                                    <input v-show="watchRepeatPassword" ref="repeat_password" type="password" v-model="repeat_password" class="border border-top-0 border-left-0 border-right-0  font-italic">
                                </li>
                            </ul>
                        </ul>                                               
                    </div>
                    <div class="col-12 mt-3 mb-3 text-center">                        
                        <a v-show="editMode" href="javascript:void(0)" class="btn btn-primary text-white pl-5 pr-5" @click.prevent="updateUser">
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
        name: "userCRUDDatas",

        props:{
            contacts:{},
        },

        components: {
            vScroll
        },

        data() {
            return {
                url:'users',
                user:{},
                model: {},
                editMode:false,
                isSending:false,
                file:null,

                password:'',
                repeat_password:'',
                watchPassword:false,
                watchRepeatPassword:false,
            }
        },

        methods: {
            updateUser(){
                if(this.isSending) 
                    return;
                if(this.password != this.repeat_password){
                    miniToastr.error("As senhas fornecidas não coincidem. Por favor, confira!", "Erro");  
                    return;
                }
                if(this.password.trim() ==''){
                    delete this.model.password;
                }
                else{
                    this.model.password = this.password;
                }
                this.isSending = true;
                ApiService.put(this.url+'/'+this.model.id, this.model)
                .then(response => {
                    // window.location.reload(false);
                    this.user = response.data;
                    window.localStorage.setItem('user', JSON.stringify(response.data));                        
                    miniToastr.success("Perfil atualizado com sucesso.","Sucesso");
                    this.isSending = false;
                    this.editMode = false;
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro atualizando perfil");  
                    this.isSending = false;
                });
                
            },

            updateUserPhoto(This){
                if(!This.file){
                    return;
                }else{
                    let formData = new FormData();
                    formData.append("file",This.file);

                    ApiService.post(
                        This.url+'/'+This.user.id+'/update_image',
                        formData,
                        {headers: { "Content-Type": "multipart/form-data" }}
                    )
                    .then(response => {
                        This.user.image_path = response.data;
                        window.localStorage.setItem('user', JSON.stringify(This.user));
                        
                        miniToastr.success("Foto atualizada com sucesso.","Sucesso");

                        window.location.reload(false);
                    })
                    .catch(function(error) {
                        ApiService.process_request_error(error); 
                        miniToastr.error(error, "Erro atualizando a foto do perfil");  
                    });
                }
            },

            trigger () {
                this.$refs.fileUserPhoto.click();
            },

            handleFileUserPhoto: function() {
                this.file = null;
                if(this.$refs.fileUserPhoto.files[0].size < 4*1024*1024) {
                    this.file = this.$refs.fileUserPhoto.files[0];
                    this.updateUserPhoto(this);
                } else{
                    miniToastr.error("A imagem deve ter tamanho inferior a 4MB", "Erro"); 
                }
            },

            editUser(){
                if(this.editMode == false){
                    this.model = Object.assign({}, this.user);
                    this.repeat_password = this.password = '';
                    this.$refs.CPF.focus();
                    this.editMode = true;
                }else{
                    var This =this;
                    Object.keys(this.model).forEach(function (prop) {
                        This.model[prop]='';
                    });
                    This.editMode = false;
                }
            },
        },

        beforeMount(){
            this.user = JSON.parse(window.localStorage.getItem('user'));
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        computed:{
            totalNewMNessages: function() {
                var self = this;
                var count =0;
                this.contacts.forEach(function(item, i){
                    count = count+ item.count_unread_messagess;
                });
                return count;
            },
        },

        watch:{
            password: function(val){
                this.$refs.password.focus();
                this.watchPassword = (val.length>0)? true : false;
            },
            repeat_password: function(val){
                this.$refs.repeat_password.focus();
                this.watchRepeatPassword = (val.length>0)? true : false;
            }

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
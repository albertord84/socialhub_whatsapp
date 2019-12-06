<template>
    <div >
        <button class="button red-button">
            <i class="record icon"></i> Start / Stop recording
        </button>
        <button class="button green-button">
            <i class="play icon"></i> Play recording
        </button>
        <button class="remove-recording">
            <i class="remove icon"></i> Delete recording
        </button>
        <button class="button green-button">
            <i class="send icon"></i> Send recording
        </button>
        <audio id="audio" preload="auto"></audio>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "resources/common/api.service";    
    import miniToastr from "mini-toastr";
    miniToastr.init();

     export default {
        name: "handleRecordAudio",

        props:{
            contacts:{},
        },

        components: {
            vScroll
        },

        data() {
            return {
                
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
        },

        beforeMount(){
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
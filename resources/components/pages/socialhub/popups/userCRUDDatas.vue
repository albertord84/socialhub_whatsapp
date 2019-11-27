<template>
    <div class="">
        <div class="card tweet-profile">
            <div class="card-header text-center">
                <h4>{{user.name}}</h4>
                <p>{{user.email}}</p>
            </div>
            <span class="profile-img text-center">
                <img :src="user.image_path" alt="profile image" class="img-fluid">
            </span>
            <div class="card-block mt-3">
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
                    <div class="col-12 m-3">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-whatsapp" aria-hidden="false"></i></li>
                            <li class="list-inline-item"><span class="font-weight-bold">Whatsapp</span></li>
                            <ul style="float:right; margin-right:40px">
                                <li class="list-inline-item"><span class="text-muted" >{{user.whatsapp_id}}</span></li>
                            </ul>
                        </ul>                                               
                    </div>
                </div>

                

                <div class="row pl-3 pr-3 pb-3">
                    <div class="col-3">
                        <div class="events text-center">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="events text-center">
                            <i class="fa fa-camera" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" class="btn btn-info btn-block btn-tweet text-white m-t-10">Tweet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';

     export default {
        name: "userCRUDDatas",

        props:{
            user:{},
            contacts:{},
        },

        components: { 
        },

        data() {
            return {}
        },

        methods: {

        },

        computed:{
            totalNewMNessages: function() {
                var self = this;
                var count =0;
                this.contacts.forEach(function(item, i){
                    count = count+ item.count_unread_messagess;
                });
                return count;
            }
        }


     }




</script>

<style src="src/css/widgets.css" scoped></style>
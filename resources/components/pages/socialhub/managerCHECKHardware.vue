<template>
    <div class="container-fluid">
        <div class="row d-flex flex-row">
            <div class="col-lg-12 ">
                <div class="card" id="printableArea">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-8 col-md-8">
                                <div class="pt-3 pl-5">
                                    <h4 class=""><Strong>Consulte o status atual do seu hardware</Strong></h4>
                                    <div class="console-screen">
                                        <p>{{statusMessage}}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary mt-3 pl-5 pr-5" @click.prevent="getHardwareStatus">
                                        <i v-show="isChecking" class="fa fa-spinner fa-spin"></i>    
                                        Consultar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    import Echo from 'laravel-echo'; window.Pusher = require('pusher-js');

    export default {
        name: "Invoice",

        data() {
            return {
                logguedManager:{},
                url:'rpis',

                isChecking:false,
                statusMessage:'',
            }
        },

        methods: {            
            getHardwareStatus() {
                this.isChecking=true;
                ApiService.get(this.url)
                    .then(response => {
                        this.statusMessage = response.data.message;
                    })
                    .catch(error => {
                        this.duringRequest=false;
                        this.isError=true;
                        this.processMessageError(error, this.url, "get");
                    })
                    .finally(() => { this.isChecking = false;});
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

        beforeMount: function() {
            this.logguedManager = JSON.parse(window.localStorage.getItem('user'));
        },

        created: function() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },
    }
</script>


<style scoped>
    #printableArea {
        border: 1px solid #ccc;
        margin-bottom: 1rem;
        min-height: 110%;
    }    

    .console-screen{
        margin-top: 1rem;
        min-height: 26rem;
        background-color: black;
        border: 1px solid gray;
    }
</style>

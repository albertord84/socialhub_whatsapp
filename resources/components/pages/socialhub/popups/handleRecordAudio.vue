<template>
    <div>
        <p>Audio record by JR</p>
        <label for="">Press button to record</label>
        <button class="btn btn-primary" @mousedown="startRecord" @mouseup="stopRecord"><i class="fa fa-microphone"> Record</i></button>
    </div>
        
</template>

<script>
    import Vue from 'vue';
    import ApiService from "resources/common/api.service";    
    import miniToastr from "mini-toastr";
    miniToastr.init();
    
    import MicRecorder from "mic-recorder-to-mp3";
    const recorder = new MicRecorder({
        bitRate: 128
    });

    export default {
        name: "handleRecordAudio",

        props:{
            contacts:{},
        },

        components: {
        },

        data() {
            return {
                isRecording: false,
                audioRecorder: null,
                recordingData: [],
                dataUrl: ''
            }
        },


        methods: {
            startRecord: function() {
                recorder.start()
                    .then(() => {
                        // fazer coisas como piscar o microfone duranta 
                        // a gravação, ou botar em Gravando
                    }).catch((e) => {
                        console.error(e);
                    });             
            },

            stopRecord: function() {
                recorder.stop().getMp3()
                    .then(([buffer, blob]) => {
                        // do what ever you want with buffer and blob---|
                        //                                              |
                        // Example: Create a mp3 file and play    <-----|
                        const file = new File(buffer, 'me-at-thevoice.mp3', {
                            type: blob.type,
                            lastModified: Date.now()
                        });                        
                        const player = new Audio(URL.createObjectURL(file));
                        player.play();
                        
                    }).catch((e) => {
                        alert('We could not retrieve your message');
                        console.log(e);
                    });
            },

            startPlay: function() {

            },

            submitRecord: function() {
                
            }
        },

        beforeMount(){
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});

            console.log(recorder);
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
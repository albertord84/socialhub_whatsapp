<template>
    <div>
        <h1>Recording audio with the MediaStream Recorder API</h1>
        <p><small>Made by the <a href="https://addpipe.com" target="_blank">Pipe Video Recording Platform</a></small></p>
        <p>This demo below shows you <strong>how to record audio directly in the browser</strong> using native browser APIs. The <a href="https://w3c.github.io/mediacapture-record/" target="_blank">MediaStream Recorder API</a> makes media recording in the browser very easy. It allows capturing chunks of (audio) data from a microphone media stream as blobs, which can later be concatenated in a single audio file. The file can then be saved locally or uploaded/POSTed to the web server. <span style="text-decoration: underline;">Recorded audio files contain Opus audio and have the .webm extension</span>.</p>
        <p>At the moment the MediaStream Recorder API is only supported by Chrome, Firefox, Opera and Edge 79 (Chromium). Please comment on <a target="_blank" href="https://bugs.webkit.org/show_bug.cgi?id=85851">this Safari/WebKit feature request</a> to request Safari support.</p>
        <div style="max-width: 28em;">
            <div id="controls">
                <button id="recordButton" ref="recordButton" @click="startRecording()">Record</button>
                <button id="pauseButton" ref="pauseButton" disabled @click="pauseRecording()">Pause</button>
                <button id="stopButton" ref="stopButton" disabled @click="stopRecording()">Stop</button>
            </div>
            <div id="formats">{{formats}}</div>
            <p><strong>Recordings:</strong></p>
            <ol id="recordingsList" ref="recordingsList" ></ol>
            <input id="fileInputImage" ref="fileInputImage" style="display:none"   type="file" @change.prevent="handleFileUploadContent" accept="image/*"/>
        </div>
        <h2>Resources</h2>
        <ul>
            <li>Code for this demo on GitHub: <a href="https://github.com/addpipe/media-recorder-api-audio-demo" target="_blank">https://github.com/addpipe/media-recorder-api-audio-demo</a></li>
            <li>Our blog post on the topic: <a href="https://blog.addpipe.com/recording-audio-in-the-browser-using-pure-html5-and-minimal-javascript/" target="_blank">https://blog.addpipe.com/recording-audio-in-the-browser-using-pure-html5-and-minimal-javascript/</a></li>
            <li>We've also built a <a href="https://addpipe.com/media-recorder-api-demo/" target="_blank">video recording demo</a></li>
        </ul>
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

        data() {
            return {
                // URL : window.URL || window.webkitURL,
                gumStream:[], 						//stream from getUserMedia()
                recorder:'',						//MediaRecorder object
                chunks:[],					//Array of chunks of audio data from the browser
                extension:'',
                formats:'',
            }
        },


        methods: {            
            checkBrowser(){
                // true on chrome, false on firefox
                console.log("audio/webm:"+MediaRecorder.isTypeSupported('audio/webm;codecs=opus'));
                // false on chrome, true on firefox
                console.log("audio/ogg:"+MediaRecorder.isTypeSupported('audio/ogg;codecs=opus'));

                if (MediaRecorder.isTypeSupported('audio/ogg;codecs=opus')){
                    this.extension="ogg";
                }else{
                    this.extension="webm";
                }
            },  

            startRecording() {
                console.log("recordButton clicked");
                var constraints = {audio: true};                

                //Disable the record button until we get a success or fail from getUserMedia() 
                this.$refs.recordButton.disabled = true;
                this.$refs.stopButton.disabled = false;
                this.$refs.pauseButton.disabled = false;

                /*We're using the standard promise based getUserMedia() 
                https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia*/
                navigator.mediaDevices.getUserMedia(constraints).then((stream)=> {
                    console.log("getUserMedia() success, stream created, initializing MediaRecorder");
                    /*  assign to gumStream for later use  */
                    this.gumStream = stream;
                    var options = {
                        audioBitsPerSecond :  256000,
                        videoBitsPerSecond : 2500000,
                        bitsPerSecond:       2628000,
                        mimeType : 'audio/'+this.extension+';codecs=opus'
                    }

                    //update the format 
                    this.formats ='Sample rate: 48kHz, MIME: audio/'+this.extension+';codecs=opus';
                    //Create the MediaRecorder object
                    this.recorder = new MediaRecorder(stream, options);

                    //when data becomes available add it to our attay of audio data
                    // this.recorder.ondataavailable = function(e){
                    this.recorder.ondataavailable = (e)=>{
                        console.log("recorder.ondataavailable:" + e.data);
                        console.log ("recorder.audioBitsPerSecond:"+recorder.audioBitsPerSecond);
                        console.log ("recorder.videoBitsPerSecond:"+recorder.videoBitsPerSecond);
                        console.log ("recorder.bitsPerSecond:"+recorder.bitsPerSecond);
                        // add stream data to chunks
                        this.chunks.push(e.data);
                        // if recorder is 'inactive' then recording has finished
                        if (this.recorder.state == 'inactive') {
                            // convert stream data chunks to a 'webm' audio format as a blob
                            const blob = new Blob(this.chunks, { type: 'audio/'+this.extension, bitsPerSecond:128000});
                            this.createDownloadLink(blob);
                        }
                    };

                    this.recorder.onerror = (e)=>{
                        console.log(e.error);
                    }

                    //start recording using 1 second chunks
                    //Chrome and Firefox will record one long chunk if you do not specify the chunck length
                    this.recorder.start(1000);
                }).catch((err)=> {
                    //enable the record button if getUserMedia() fails
                    this.$refs.recordButton.disabled = false;
                    this.$refs.stopButton.disabled = true;
                    this.$refs.pauseButton.disabled = true
                });
            },

            pauseRecording(){
                console.log("pauseButton clicked recorder.state=",recorder.state );
                if (this.recorder.state=="recording"){
                    //pause
                    this.recorder.pause();
                    this.$refs.pauseButton.innerHTML="Resume";
                }else 
                if (this.recorder.state=="paused"){
                    //resume
                    this.recorder.resume();
                    this.$refs.pauseButton.innerHTML="Pause";
                }
            },

            stopRecording() {
                console.log("stopButton clicked");
                //disable the stop button, enable the record too allow for new recordings
                this.$refs.stopButton.disabled = true;
                this.$refs.recordButton.disabled = false;
                this.$refs.pauseButton.disabled = true;

                //reset button just in case the recording is stopped while paused
                this.$refs.pauseButton.innerHTML="Pause";
                
                //tell the recorder to stop the recording
                this.recorder.stop();

                //stop microphone access
                this.gumStream.getAudioTracks()[0].stop();
            },

            createDownloadLink(blob) {                
                var url = URL.createObjectURL(blob);
                var au = document.createElement('audio');
                var li = document.createElement('li');
                var link = document.createElement('a');

                //add controls to the <audio> element
                au.controls = true;
                au.src = url;

                //link the a element to the blob
                link.href = url;
                link.download = new Date().toISOString() + '.'+this.extension;
                link.innerHTML = link.download;

                //add the new audio and a elements to the li element
                li.appendChild(au);
                li.appendChild(link);

                //add the li element to the ordered list
                this.$refs.recordingsList.appendChild(li);
            }
        },

        mounted() {            
            this.checkBrowser();
        },

    }
</script>

<style lang="scss">
    
</style>



<template>
    <div>
        <h1>Recording audio with the MediaStream Recorder API</h1>
        <p><small>Made by the <a href="https://addpipe.com" target="_blank">Pipe Video Recording Platform</a></small></p>
        <p>This demo below shows you <strong>how to record audio directly in the browser</strong> using native browser APIs. The <a href="https://w3c.github.io/mediacapture-record/" target="_blank">MediaStream Recorder API</a> makes media recording in the browser very easy. It allows capturing chunks of (audio) data from a microphone media stream as blobs, which can later be concatenated in a single audio file. The file can then be saved locally or uploaded/POSTed to the web server. <span style="text-decoration: underline;">Recorded audio files contain Opus audio and have the .webm extension</span>.</p>
        <p>At the moment the MediaStream Recorder API is only supported by Chrome, Firefox, Opera and Edge 79 (Chromium). Please comment on <a target="_blank" href="https://bugs.webkit.org/show_bug.cgi?id=85851">this Safari/WebKit feature request</a> to request Safari support.</p>
        <div style="max-width: 28em;">
            <div id="controls">
                <button ref="recordButton"  id="recordButton" @click="startRecording()">Record</button>
                <button ref="pauseButton" id="pauseButton" disabled @click="pauseRecording()">Pause</button>
                <button ref="stopButton" id="stopButton" disabled @click="stopRecording()">Stop</button>
            </div>
            <div id="formats">{{formats}}</div>
            <p><strong>Recordings:</strong></p>
            <ol ref="recordingsList" id="recordingsList"></ol>
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

                recordButton:null,
                stopButton:null,
                pauseButton:null,
                recordingsList:null,
            }
        },


        methods: {            
            checkBrowser(){
                // true on chrome, false on firefox
                console.log("audio/webm:"+MediaRecorder.isTypeSupported('audio/webm;codecs=opus'));
                // false on chrome, true on firefox
                console.log("audio/ogg:"+MediaRecorder.isTypeSupported('audio/ogg;codecs=opus'));

                if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')){
                    this.extension="webm";
                }else{
                    this.extension="ogg"
                }
            },  

            startRecording() {
                console.log("recordButton clicked");                
                var constraints = {audio: true};

                //Disable the record button until we get a success or fail from getUserMedia() 
                recordButton.disabled = true;
                stopButton.disabled = false;
                pauseButton.disabled = false

                /*We're using the standard promise based getUserMedia() 
                https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia*/
                navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                    console.log("getUserMedia() success, stream created, initializing MediaRecorder");
                    /*  assign to gumStream for later use  */
                    this.gumStream = stream;
                    var options = {
                        audioBitsPerSecond :  256000,
                        videoBitsPerSecond : 2500000,
                        bitsPerSecond:       2628000,
                        mimeType : 'audio/'+extension+';codecs=opus'
                    }

                    //update the format 
                    this.formats ='Sample rate: 48kHz, MIME: audio/'+extension+';codecs=opus';

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
                            const blob = new Blob(chunks, { type: 'audio/'+extension, bitsPerSecond:128000});
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
                    this.recordButton.disabled = false;
                    this.stopButton.disabled = true;
                    this.pauseButton.disabled = true
                });
            },

            pauseRecording(){
                console.log("pauseButton clicked recorder.state=",recorder.state );
                if (this.recorder.state=="recording"){
                    //pause
                    this.recorder.pause();
                    this.pauseButton.innerHTML="Resume";
                }else 
                if (this.recorder.state=="paused"){
                    //resume
                    this.recorder.resume();
                    this.pauseButton.innerHTML="Pause";
                }
            },

            stopRecording() {
                console.log("stopButton clicked");
                //disable the stop button, enable the record too allow for new recordings
                this.stopButton.disabled = true;
                this.recordButton.disabled = false;
                this.pauseButton.disabled = true;

                //reset button just in case the recording is stopped while paused
                this.pauseButton.innerHTML="Pause";
                
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
                link.download = new Date().toISOString() + '.'+extension;
                link.innerHTML = link.download;

                //add the new audio and a elements to the li element
                li.appendChild(au);
                li.appendChild(link);

                //add the li element to the ordered list
                this.recordingsList.appendChild(li);
            }
        },

        created() {
            this.recordButton = this.$refs.recordButton;
            this.stopButton = this.$refs.stopButton;
            this.pauseButton = this.$refs.pauseButton; 
            this.recordingsList = this.$refs.recordingsList; 
            
            this.checkBrowser();
        },

    }
</script>

<style lang="scss">
    html {
        font-size: 100%;
    }
    body {
        line-height: 1.5;
        font-family: sans-serif;
        word-wrap: break-word;
        overflow-wrap: break-word;
        color:black;
        margin:2em;
    }
    h1 {
        text-decoration: underline red;
        text-decoration-thickness: 3px;
        text-underline-offset: 6px;
        font-size: 220%;
        font-weight: bold;
    }
    h2 {
        font-weight: bold;
        color: #005A9C;
        font-size: 140%;
        text-transform: uppercase;
    }
    p {
        margin: 1em 0;
    }
    pre {
        padding: 0px;
        border:0px;
        border-radius: 0px;
    }
    red {
        color: red;
    }
    a {
        color: #337ab7;
    }
    a:visited {
        color: #8d75a3;
    }
    a:hover {
        color:#23527c;
    }
    #controls {
        display: flex;
        margin-top: 2rem;
    }
    button {
        flex-grow: 1;
        height: 2.5rem;
        min-width: 2rem;
        border: none;
        border-radius: 0.15rem;
        background: #ed341d;
        margin-left: 2px;
        box-shadow: inset 0 -0.15rem 0 rgba(0, 0, 0, 0.2);
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        color:#ffffff;
        font-weight: bold;
        font-size: 1rem;
    }
    button:hover, button:focus {
        outline: none;
        background: #c72d1c;
    }
    button::-moz-focus-inner {
        border: 0;
    }
    button:active {
        box-shadow: inset 0 1px 0 rgba(0, 0, 0, 0.2);
        line-height: 3rem;
    }
    button:disabled {
        pointer-events: none;
        background: lightgray;
    }
    button:first-child {
        margin-left: 0;
    }
    audio {
        display: block;
        width: 100%;
        margin-top: 0.2rem;
    }
    #formats {
        margin-top: 0.5rem;
        font-size: 80%;
    }
</style>



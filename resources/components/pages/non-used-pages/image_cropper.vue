<template>
    <div class="row">
        <div class="col-12">
            <b-card class="mb-5 bg-default-card" header="Image Cropper" header-tag="h4">
                <div class="row">
                    <div class="col-6">
                        <croppa v-model="myCroppa" canvas-color="transparent"></croppa>
                        <br>
                        <button @click="generateImage" class="btn btn-success mt-4">Generate</button>
                    </div>
                    <div class="col-6">
                        <img class="output" :src="imgUrl">

                    </div>
                </div>
            </b-card>
        </div>

        <div class="col-12">

            <b-card class="mb-5 bg-default-card" header="Image Resizable" header-tag="h4">
                <div class="row">
                    <div class="col-12">

                        <div class="wrapper-image">
                            <croppa :height="resizableH"
                                    :width="resizableW"
                                    class="resizable-croppa"></croppa>
                            <img  :src="require('../../img/pages/resize-bottom-right.svg')"
                                 class="icon-resize"
                                 @mousedown.stop.prevent="onResizeTouchStart">
                        </div>

                    </div>
                </div>
            </b-card>
        </div>


        <div class="col-12">

            <b-card class="mb-5 bg-default-card" header="Image Rotation" header-tag="h4">
                <div class="row">
                    <div class="col-12">
                        <croppa v-model="croppa2"
                                :width="200"
                                :height="200"></croppa>
                        <div class="row">

                            <div class="col-12 mt-4">
                                <button @click="rotate" class="btn btn-primary">ROTATE</button>
                                <button @click="flipX" class="btn btn-primary ml-2">FLIP-X</button>
                                <button @click="flipY" class="btn btn-primary  ml-2">FLIP-Y</button>

                            </div>
                        </div>
                    </div>
                </div>
            </b-card>
        </div>


        <div class="col-12">

            <b-card class="mb-5 bg-default-card" header="Zoom Slider" header-tag="h4">
                <div class="row">
                    <div class="col-12">
                        <input type="range" @input="onSliderChange" :min="sliderMin" :max="sliderMax" step=".001" v-model="sliderVal"> {{sliderVal}}
                        <br><br>
                        <croppa v-model="croppa" @new-image-drawn="onNewImage" @zoom="onZoom" class="mt-3">
                        </croppa>

                    </div>
                </div>
            </b-card>
        </div>


    </div>
</template>

<script>

    import Vue from 'vue';
    import Croppa from 'vue-croppa';

    Vue.use(Croppa);

    // If your build tool supports css module
    import 'vue-croppa/dist/vue-croppa.css';

    import 'vue-croppa/dist/vue-croppa.js'

    export default {
        data: function () {
            return {
                myCroppa: null,
                imgUrl: '',
                resizing: false,
                resizableW: 200,
                resizableH: 200,
                croppa2: {},
                croppa: {},
                sliderVal: 0,
                sliderMin: 0,
                sliderMax: 0
            }

        },

        mounted() {
            document.documentElement.addEventListener('mousemove', (evt) => {
                evt.preventDefault()
                this.onResizeTouchMove(evt)
            })
            document.documentElement.addEventListener('mouseup', (evt) => {
                evt.preventDefault()
                this.onResizeTouchEnd(evt)
            })
        },

        methods: {
            onNewImage: function onNewImage() {
                this.sliderVal = this.croppa.scaleRatio;
                this.sliderMin = this.croppa.scaleRatio / 2;
                this.sliderMax = this.croppa.scaleRatio * 2;
            },

            onSliderChange: function onSliderChange(evt) {
                var increment = evt.target.value;
                this.croppa.scaleRatio = +increment;
            },

            onZoom: function onZoom(){
                this.sliderVal = this.croppa.scaleRatio;
            },


            rotate() {
                this.croppa2.rotate()
            },

            flipX() {
                this.croppa2.flipX()
            },

            flipY() {
                this.croppa2.flipY()
            },


            onResizeTouchStart (evt) {
                this.resizing = true
            },

            onResizeTouchMove (evt) {
                if (!this.resizing) return
                document.documentElement.style.cursor = 'nwse-resize'

                var croppa = document.querySelector('.resizable-croppa')

                this.resizableW = evt.clientX - croppa.getBoundingClientRect().left
                this.resizableH = evt.clientY - croppa.getBoundingClientRect().top
            },

            onResizeTouchEnd (evt) {
                this.resizing = false
                document.documentElement.style.cursor = 'default'
            },



            generateImage: function () {
                let url = this.myCroppa.generateDataUrl()
                if (!url) {
                    alert('no image')
                    return
                }
                this.imgUrl = url
            }
        }
    }
</script>
<style>
    .croppa-container {
        background-color: white;
        border: 3px solid black
    }

    .wrapper-image{
        position: relative;
        display: inline-block;
        /*font-size: 0;*/
        margin-top:0;
        min-height:auto !important;
    }

    .icon-resize {
        position: absolute;
        right: 4px;
        bottom: 4px;
        font-size: 16px;
        width: 2em;
        cursor: nwse-resize;
    }
    .resizable-croppa canvas{
        max-width:100%;
    }

    input[type=range] {
        width: 500px;
    }

    @media(max-width:767px){
        input[type=range] {
            width: 250px;
        }
    }

</style>






<template>
    <div class="row">
        <div class="col-12">
            <b-card class="mb-5 bg-default-card" header="Vue Draggable" header-tag="h4">
                <div class="color-show">
                    <div v-for="color in colors" v-dragging="{ list: colors, item: color, group: 'color' }"
                         class="color-box card m-2" :key="color.text">
                        <div class="card-body" :style="{'background-color': color.text}">
                            <b-media>
                                <b-img slot="aside" v-bind:src="color.picture" v-bind:alt="color.alt"
                                       class="rounded-circle" style="width:70px;height:70px"/>
                                <h5 class="mt-0">{{color.person_name}}</h5>
                                <p>
                                    "Project -- Setup the project..!"
                                </p>
                            </b-media>
                        </div>
                    </div>
                </div>
            </b-card>
        </div>

        <div class="col-12">

            <b-card class="mb-5 bg-default-card" header="Draggable Resizable" header-tag="h4">

                <div style="height: 300px;  position: relative;">
                    <vue-draggable-resizable v-on:dragging="onDrag" v-on:resizing="onResize" :parent="true"
                                             :maximize="true" :h="170">
                        <b-card class="mb-0">
                            <p>Hello! I'm a flexible component. You can drag me around and you can resize me.<br>
                                <code>X: {{ x }} / Y: {{ y }} - Width: {{ width }} / Height: {{ height }}</code></p>
                        </b-card>
                    </vue-draggable-resizable>
                </div>
            </b-card>
        </div>


    </div>
</template>

<script>
    import Vue from 'vue'
    import VueDND from 'awe-dnd'
    import VueDraggableResizable from 'vue-draggable-resizable'

    Vue.use(VueDND)
    Vue.component('vue-draggable-resizable', VueDraggableResizable)
    export default {
        data() {
            return {
                width: 0,
                height: 0,
                x: 0,
                y: 0,
                colors: [{
                    text: "#6699cc",
                    color_name: "Primary",
                    person_name: "John",
                    picture: "images/avatar2.jpg",
                    alt: "image1"
                }, {
                    text: "#868e96",
                    color_name: "Secondary",
                    person_name: "Robert",
                    picture: "images/avatar1.jpg",
                    alt: "image2"
                }, {
                    text: "#66cc99",
                    color_name: "Success",
                    person_name: "James",
                    picture: "images/avatar7.jpg",
                    alt: "image3"
                }, {
                    text: "#66ccff",
                    color_name: "Info",
                    person_name: "Dolly",
                    picture: "images/avatar4.jpg",
                    alt: "image4"
                }, {
                    text: "#f0ad4e",
                    color_name: "Warning",
                    person_name: "Edgard",
                    picture: "images/avatar6.jpg",
                    alt: "image5"
                }, {
                    text: "#ff6666",
                    color_name: "Danger",
                    person_name: "Hedge",
                    picture: "images/avatar5.jpg",
                    alt: "image6"
                }, {
                    text: "#343a40",
                    color_name: "Dark",
                    person_name: "Zorge",
                    picture: "images/avatar3.jpg",
                    alt: "image7"
                }]
            }
        },
        methods: {
            onResize: function (x, y, width, height) {
                this.x = x
                this.y = y
                this.width = width
                this.height = height
            },
            onDrag: function (x, y) {
                this.x = x
                this.y = y
            }

        },
        mounted: function () {

        },
        destroyed: function () {

        }
    }
</script>
<style src="../../css/portlet.css"></style>
<style>

    .playground {
        display: flex;
        margin-top: 4rem;
    }

    .color-item {
        background: #f5f5f5;
        padding: .5rem;
        color: #5f5f5f;
        transition: transform .3s;
    }

    .color-item.dragging {
        background-color: #fff;
    }

    .color-show {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .color-box {
        width: 31%;
        color: #fff;
        transition: transform .3s;
    }

    @media (min-width: 320px) and (max-width: 425px) {
        .color-show .color-box {
            width: 100% !important;
        }
    }

    .color-box.dragging {
        transform: scale(1.1);
    }

    .in-out-translate-fade-enter-active, .in-out-translate-fade-leave-active {
        transition: all .5s;
    }

    .in-out-translate-fade-enter, .in-out-translate-fade-leave-active {
        opacity: 0;
    }

    .in-out-translate-fade-enter {
        transform: translate3d(100%, 0, 0);
    }

    .in-out-translate-fade-leave-active {
        transform: translate3d(-100%, 0, 0);
    }
</style>





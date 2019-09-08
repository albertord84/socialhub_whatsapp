<!--<template>-->
    <!--<div class="submenu collapse-item">-->
        <!--<div class="submenu-header touchable" role="tab" :aria-expanded="selected ? 'true' : 'fase'">-->
            <!--<i class="fa fa-fw left_icon" :class="icon"></i><br/>-->
            <!--<span class="submenu-header-title">{{ name }}</span>-->
        <!--</div>-->
        <!--<div class="submenu-content">-->
            <!--<div class="submenu-content-box" ref="box">-->
                <!--<slot></slot>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</template>-->
<!--<script>-->
<!--import anime from 'animejs'-->
<!--export default {-->
    <!--props: {-->
        <!--selected: Boolean,-->
        <!--icon: String,-->
        <!--name: {-->
            <!--type: String,-->
            <!--required: true-->
        <!--}-->
    <!--}-->
<!--}-->
<!--</script>-->
<!--<style lang="scss" scoped>-->
    <!--@import "../../../css/customvariables";-->
<!--.collapse-item {-->
    <!--position: relative;-->
    <!--.submenu-header {-->
        <!--cursor: pointer;-->
        <!--color: $menu_color;-->
        <!--padding: 11px 10px 11px 20px;-->
        <!--border-bottom: 1px solid #eee;-->
        <!--&:hover {-->
        <!--}-->
    <!--}-->
    <!--.submenu-content {-->
        <!--background: $submenu_color;-->
        <!--overflow-y: hidden;-->
        <!--position: absolute;-->
        <!--left: 100px;-->
        <!--width: 200px;-->
        <!--top: 15px;-->
        <!--display: none;-->
        <!--z-index: 50;-->
        <!--margin: 0;-->
        <!--padding: 0;-->
    <!--}-->

    <!--&:hover .submenu-content {-->
        <!--display: block;-->
    <!--}-->
    <!--&.active {-->
        <!--&gt;.submenu-header {-->
            <!--background: $menu_active;-->
            <!--color: $menu_active_color;-->
        <!--}-->
    <!--}-->
<!--}-->

<!--.left_icon {-->
    <!--font-size: 25px;-->
<!--}-->
<!--.collapse-item .submenu-header{-->
    <!--padding: 11px 10px !important;-->
<!--}-->
<!--.collapse-item .submenu-content{-->
    <!--top:-1px !important;-->
<!--}-->
<!--</style>-->

<template>
    <div class="submenu collapse-item" :class="{ 'active': isActived }">
        <div class="submenu-header touchable" role="tab" :aria-expanded="selected ? 'true' : 'false'" @click="toggle()">
            <i class="fa fa-fw left_icon" :class="icon"></i><br/>
            <span class="submenu-header-title">{{ name }}</span>
        </div>
        <transition name="collapsed-fade" :css="false" @before-appear="before" @appear="enter" @appear-cancel="cancel" @before-enter="before" @enter="enter" @enter-cancel="cancel" @leave="leave" @leave-cancel="cancel">

            <div class="submenu-content" v-show="isActived">
                <div class="submenu-content-box" ref="box">
                    <slot></slot>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
    import anime from 'animejs'
    export default {
        props: {
            selected: Boolean,
            icon: String,
            name: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isActived: this.selected
            }

        },
        created() {
            this._isCollapseItem = true
        },

        mounted() {
            function activate(self) {
                if (self.$refs.box) {
                    self.isActived = self.$refs.box.querySelectorAll("a.active").length >= 1 ? true : false;
                }
            }
            //change when route changes
            this.$store.subscribe((mutation, state) => {
                if (mutation.type == "routeChange" && mutation.payload == "end") {
                    setTimeout(() => {
                        activate(this);
                    }, 0);
                }
            });
            activate(this);
        },
        methods:{
            toggle() {
                this.$parent.$emit('closeall', this.index);
                this.isActived = !this.isActived;
            },
            cancel() {
                this.anime.pause()
            },
            before(targets) {
                targets.removeAttribute('style')
            },
            enter(targets, done) {
                const height = targets.scrollHeight
                targets.style.height = 0
                targets.style.opacity = 0
                anime({
                    targets: targets,
                    duration: 377,
                    easing: 'easeOutExpo',
                    opacity: [0, 1],
                    height: height,
                    complete() {
                        targets.removeAttribute('style')
                        done()
                    }
                });
            },
            leave(targets, complete) {
                anime({
                    targets: targets,
                    duration: 377,
                    easing: 'easeOutExpo',
                    opacity: [1, 0],
                    height: 0
                });
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../css/customvariables";
    .collapse-item {
        position: relative;
        .submenu-header {
            cursor: pointer;
            color: $menu_color;
            padding: 11px 10px 11px 20px;
            /*border-bottom: 1px solid #eee;*/
            &:hover {
                color: $menu_color;
                background: $menu_active;
            }

        }
        .submenu-content {
            overflow-y: hidden;
            position: absolute;
            left: 100px;
            width: 200px;
            top: 15px;
            display: none;
            z-index: 50;
            margin: 0;
            padding: 0;
            background: #fff;
            box-shadow: 0 0 15px #CCC;
        }

        &:hover .submenu-content {
            display: block;
        }
        &.active {
            >.submenu-header {
                background: $menu_active;
                color: $menu_active_color;
            }
            i{
                color:#33CC99;
            }
        }
    }

    .left_icon {
        font-size: 20px;
    }
    .collapse-item .submenu-header{
        padding: 11px 10px !important;
    }
    .collapse-item .submenu-content{
        top:-1px !important;
    }


    .submenu.active:after {
        position: absolute;
        top: 12px;
        right: 0;
        width: 0;
        height: 0;
        content: "";
        border-top: 10px solid transparent;
        border-right: 10px solid #2E576B;
        border-bottom: 10px solid transparent;
        border-left: 0;
    }


</style>

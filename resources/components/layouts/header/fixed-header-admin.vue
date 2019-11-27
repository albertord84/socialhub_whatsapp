<template>
    <header class="header fixed-top">
        <nav>
            <!--SocualHUB logo-->
            <router-link to="../admin/" class="logo">
                <img src="~img/socialhub/Logo branca.png" alt="logo"/>
            </router-link>

             <!-- Sidebar toggle button-->
            <div class="float-left">
                <a href="javascript:void(0)" class="sidebar-toggle" @click="toggle_menu">
                    <i class="fa fa-bars text-white"></i>
                </a>
            </div>  

            <!--drop downs-->
            <div class="navbar-right">
                <div>
                    
                    <!--fullscreen button-->
                    <div class="dropdown hidden-xs-down btn-group fullscreen" v-if="fullscreen">
                        <a href="javascript:void(0)" @click="fullscreen" title="Tela Cheia">
                            <i class="fa fa-arrows-alt text-white"></i>
                        </a>
                    </div>

                    <!--Chat acess toggle-->
                    <!-- <div class="dropdown hidden-xs-down btn-group">
                        <router-link to="../attendant/" title="Dashboard">
                            <i class="fa fa-tachometer text-white" aria-hidden="true"></i>                            
                        </router-link>
                    </div>
                    <div class="dropdown hidden-xs-down btn-group">
                        <router-link to="/attendant/chat" title="Chat">
                            <i class="fa fa-weixin text-white" aria-hidden="true"></i>                            
                        </router-link>
                    </div> -->

                    <!--rightside toggle-->
                    <!-- <div class="dropdown hidden-xs-down btn-group " id="right-side" @click="toggle_right">
                        <a href="javascript:void(0)">
                            <i class="fa fa-envelope noti-icon"></i>
                            <div class="notifications_badge_top">
                                <span class="badge badge-success">2
                                </span>
                            </div>
                        </a>
                    </div> -->

                    <!-- User Account: style can be found in dropdown-->
                    <b-dropdown class="dropdown hidden-xs-down btn-group" variant="link" toggle-class="text-decoration-none" >
                        <template v-slot:button-content>
                            <img :src="pictureProfile" class="my-rounded-circle" alt="User Image">
                        </template>
                        <b-dropdown-item exact class="dropdown_content">
                            <router-link to="admin/user_profile" exact class="drpodowtext">
                                <i class="fa fa-user-o"></i> Perfil
                            </router-link>
                        </b-dropdown-item>
                        <!-- <b-dropdown-item exact class="dropdown_content">
                            <router-link to="/admin/edit_user" exact class="drpodowtext">
                                <i class="fa fa-cog"></i> Configuração
                            </router-link>
                        </b-dropdown-item> -->
                        <b-dropdown-item exact class="dropdown_content">
                            <router-link to="/lockscreen" exact class="drpodowtext">
                                <i class="fa fa-lock"></i> Bloquear
                            </router-link>
                        </b-dropdown-item>
                        <b-dropdown-item exact class="dropdown_content">
                            <router-link to="/" class="drpodowtext">
                                <div v-on:click="logout">
                                    <i class="fa fa-sign-out"></i> Sair
                                </div>
                            </router-link>
                        </b-dropdown-item>
                    </b-dropdown>


                </div>
            </div>



        </nav>
    </header>
</template>
<script>
    import screenfull from "screenfull"

    export default {
        name: "vueadmin_header",

        data() {
            return {
                name: "",
                user: {},
                pictureProfile:'',
            }
        },

        methods: {
            toggle_menu() {
                this.$store.commit('left_menu', "toggle");
            },

            fullscreen() {
                if (screenfull.enabled) {
                    screenfull.toggle();
                }
            },

            toggle_right() {
                this.$store.commit('rightside_bar', "toggle");
            },

            logout() {
                window.localStorage.removeItem('token')
                window.localStorage.removeItem('user')
                delete axios.defaults.headers.common['Authorization']
                this.$router.push({name: "login"})
            },

            urlIMG: function(){
                // return require('../../../img/');
                // /var/www/html/socialhub/resources/img/pages/User-01.png
                // return require('../../../img/pages/default-matter-photo.jpg');
            },
        },

        beforeMount: function () {
            this.user = window.localStorage.getItem('user');
            if (this.user != null) {
                this.name = JSON.parse(this.user)['name'];
                this.pictureProfile = JSON.parse(this.user)['image_path'];
            }
        },
    }
</script>


<style lang="scss" scoped>
    @import "../css/customvariables";

    .header {
        z-index: 1030;

        nav {
            margin-bottom: 0;
            height: 50px;
            background: $header_color;
            background-size: 100% 100%;
            box-shadow: 0px 0px 10px #ccc;
        }

        .navbar-right {
            float: right;
            margin-right: 15px;
        }

        .logo {
            display: block;
            float: left;
            height: 50px;
            line-height: 41px;
            padding: 3px 10px;
            text-align: center;
            width: 250px;
            background: $header_color;

            img {
                width: 125px;
            }
        }

        .navbar-right {
            .dropdown-item {
                padding: 0;
                width: 100%;
                outline: none;
            }

            div.dropdown {
                > a {
                    color: $zoom_color;
                }

                .dropdown-menu > button {
                    padding: 10px 15px;
                }

                &.notifications-menu {
                    height: 50px;

                    .noti-icon {
                        font-size: 18px;
                    }
                }

                > a > i {
                    font-size: 23px;
                }

                > a {
                    display: block;
                    padding: 12px;
                }

                &:hover > a {
                    background-color: #ededed;
                    color: #000;
                }

                > a.padding-user {
                    padding-top: 8px;
                    padding-bottom: 6px;
                }
            }
        }

        nav .sidebar-toggle {
            float: left;
            color: $toggle_color;
            font-size: 19px;
            padding-top: 10px;
        }
    }

    .user_name_max {
        display: inline-block;
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
        margin: 0 0 -4px;
    }

    .noti_msg {
        font-size: 16px;
        padding: 10px;
        border: 1px solid #4f90c1;
        border-radius: 50px;
        margin-top: 10px;
    }

    .user.user-menu > button img {
        width: 35px;
        height: 35px;
    }

    /**** END HEADER RIGHT SIDE DROPDOWNS ****/

    @media screen and (max-width: 767px) {
        .dropdown.open .dropdown-menu {
            position: absolute;
        }
        .navbar-right > li > a {
            padding: 10px 12px;
        }
    }

    /* Fix menu positions on xs screens to appear correctly and fully */

    @media (max-width: 560px) {
        body .header .logo,
        body .header nav {
            width: 100%;
        }
        body .header nav .sidebar-toggle {
            padding-left: 15px;
        }
        nav {
            height: 100px !important;
        }
    }

    .notifications_badge_top {
        margin-top: -28px;
        margin-left: 10px;
        position: absolute;

        span {
            top: 1px;
            left: 2px;
            border-radius: 50%;
            font-size: 9px;
            padding: 0.23em 0.45em;
        }
    }

    .notifications-menu .dropdown-item {
        width: 100%;
        display: block;
    }

    .dropdown-footer {
        padding: 10px !important;
    }    

.my-rounded-circle{
    border-radius: 50%;
    height: 40px;
    width: 40px;
    padding: 0px !important;
    margin: 0px !important;
}
.dropdown{
    outline: none
}

</style>

<style type="text/css" lang="scss">
    @import "../css/customvariables";

    .wrapper {
        margin-top: 50px;
        @media screen and (max-width: 560px) {
            margin-top: 100px;
        }
    }

    .sidebar-toggle {
        margin-left: 10px;
    }

    .bell_bg {
        button.btn-secondary {
            background-color: $bell-color;
            border: none;
            border-radius: 0;
            box-shadow: none !important;

            &:hover {
                background-color: #ededed !important
            }

            &:active {
                color: $toggle_color !important;
            }
        }

        //.btn-secondary:active
        &.show button {
            background-color: $bell-active !important
        }

        &.user_btn .dropdown-toggle {
            padding: 7px 9px;
        }
    }

    .tabs_cont,
    .event_date {
        background-color: #fff !important;
    }

    body.left-hidden aside.right-aside {
        margin-left: 0;
    }

    body.left-hidden .header.fixed-top {
        padding-right: 0 !important;
    }

</style>

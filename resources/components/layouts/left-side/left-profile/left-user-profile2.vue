<template>
    <div>
        <div class="user_section">
            <div class="row">
                <div class="col-12">
                    <div class="img-wrapper">
                        <a href="javascript:void()" @click.prevent="modalUserCRUDDatas=!modalUserCRUDDatas">
                            <img :src="pictureProfile" style="width:80px; height:80px" alt="user not found" class="rounded-circle" />
                        </a>
                    </div>
                    <p class="mt-2 mb-1 user_name_max text-center">{{name}}</p>
                </div>
                <div class="leftuser_icons col-12 ">
                    <div class="row text-center">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <!-- <a :href='"#/"+link+"/user_profile"' title="Perfil"><i class="fa fa-user-o"></i></a> -->
                            <a href="javascript:void()" title="Dados do Usuario" @click.prevent="modalUserCRUDDatas=!modalUserCRUDDatas"><i class="fa fa-user-o"></i></a>
                        </div>
                        <div class="col-md-2">
                            <a href="#/lockscreen" title="Bloquear"><i class="fa fa-lock" aria-hidden="true"></i></a>
                        </div>
                        <div class="col-md-2 ">
                            <a href="javascript:void()" title="Sair" @click.prevent="logout"><i class="fa fa-sign-out"></i></a>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to show user datas-->
        <b-modal v-model="modalUserCRUDDatas" :hide-footer="true" body-class="p-0" :hide-header="false" >
            <userCRUDDatas :contacts='contacts'></userCRUDDatas>
        </b-modal>

    </div>
</template>

<script>
    import Vue from 'vue';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "src/common/api.service";
    import userCRUDDatas from "src/components/pages/socialhub/popups/userCRUDDatas.vue";


    export default {
      name:'leftUserProfile2',
      components:{
          userCRUDDatas
      },

      data() {
        return {
          user: {},
          email: "",
          name: "",
          link:'',
          pictureProfile:'',
          modalUserCRUDDatas:false,
          contacts:null,
        };
      },

      methods:{
            logout() {
                window.localStorage.removeItem('token');
                window.localStorage.removeItem('user');
                delete axios.defaults.headers.common['Authorization'];
                this.$router.push({name: "login"});          
            },
      },

      created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },


      beforeMount: function() {
          this.user = window.localStorage.getItem("user");
          if (this.user != null) {
            this.name = JSON.parse(this.user)["name"];
            this.email = JSON.parse(this.user)["email"];
            this.pictureProfile = JSON.parse(this.user)['image_path'];
          }

          var logged_user = JSON.parse(localStorage.user);
          switch(logged_user.role_id) {
              case 1: /*ADMIN*/ 
                  this.link = "admin";
                  break;
              case 2: /*SELLER*/ 
                  this.link = "seller";
                  break;
              case 3: /*MANAGER*/ 
                  this.link = "manager";
                  break;
              case 4: /*ATTENDANT*/ 
                  this.link = "attendant";
                  break;
              case 5: /*VISITOR*/ 
                  this.link = "visitor";
                  break;
              default:
                  this.link = "login";
          }
      },

      destroyed: function() {
        
      }
    };
</script>

<style scoped lang="scss">
    /*user section*/
    @import "../../css/customvariables";

    .user_section {
      height: 188px;
      padding: 15px 20px;

      .img-wrapper {
        width: 100px;
        border-radius: 50%;
        padding: 7px;
        margin: auto;
      }
      img {
        width: 84px;
        border: 2px solid #ccc;
      }

      p {
        font-size: 15px;
      }
      .leftuser_icons .logout_padd {
        padding: 1px !important;
      }
    }
    .user_name_max {
      text-transform: uppercase;
      font-weight: 700;
      max-width: 210px;
      white-space: nowrap;
      overflow: hidden !important;
      text-overflow: ellipsis;
      margin: 0 0 -4px;
      padding-top: 2px;
      padding-bottom: 5px;
    }

    .leftuser_icons div {
      cursor: pointer;
      padding: 1px 12px;
      font-size: 18px;
      background-color: transparent;
      margin-right: 3px;
      border-radius: 50px;
      margin: auto;
      width: 100%;
      display: inline;
    }
    .user_name_max,
    .leftuser_icons i {
      color: $menu_color;
    }
</style>

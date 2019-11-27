<template>
    <div>
        <div class="user_section">
            <div class="row">
                <div class="col-12">
                    <div class="img-wrapper">
                        <img :src="pictureProfile" style="width:80px; height:80px" alt="user not found" class="rounded-circle" />
                    </div>
                    <p class="mt-2 mb-1 user_name_max text-center">{{name}}</p>
                </div>
                <div class="leftuser_icons col-12 ">
                    <div class="row text-center">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <a :href='link+"/user_profile"' title="Perfil"><i class="fa fa-user-o"></i></a>
                        </div>
                        <div class="col-md-2">
                            <a href="#/lockscreen" title="Bloquear"><i class="fa fa-lock" aria-hidden="true"></i></a>
                        </div>
                        <!-- <div class="col-md-3">
                            <a href="#/edit_profile" title="E-mail"><i class="fa fa-cog"></i></a>
                        </div> -->
                        <div class="col-md-2 ">
                            <a href="#/login" title="Sair" @click="logout"><i class="fa fa-sign-out"></i></a>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      user: {},
      email: "",
      name: "",
      link:'',
      pictureProfile:'',
    };
  },

  methods:{
    logout() {
        window.localStorage.removeItem('token')
        window.localStorage.removeItem('user')
        delete axios.defaults.headers.common['Authorization']
        this.$router.push({name: "login"})
    },
  },

  beforeMount: function() {
    this.user = window.localStorage.getItem("user");
    if (this.user != null) {
      this.name = JSON.parse(this.user)["name"];
      this.email = JSON.parse(this.user)["email"];
      this.pictureProfile = JSON.parse(this.user)['image_path'];
    }
  },

  mounted() {
      var logged_user = JSON.parse(localStorage.user);
      var link;
      switch(logged_user.role_id) {
          case 1: /*ADMIN*/ 
              link = "admin";
              break;
          case 2: /*SELLER*/ 
              link = "seller";
              break;
          case 3: /*MANAGER*/ 
              link = "manager";
              break;
          case 4: /*ATTENDANT*/ 
              link = "attendant";
              break;
          case 5: /*VISITOR*/ 
              link = "visitor";
              break;
          default:
              link = "login";
      }
  },

  destroyed: function() {}
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

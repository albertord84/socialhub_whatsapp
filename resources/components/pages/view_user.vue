<template>
    <div class="row">
        <div class="col-lg-12">
            <b-card header="View user" header-tag="h4" class="bg-success-card">
                <div class="row">
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p class="font-weight-bold">User Name</p>
                                        <p>{{model.name}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p class="font-weight-bold"> E-mail</p>
                                        <p>{{model.email}}</p>
                                    </div>
                                </div>
                                <div class="col-md-offset-4 col-md-8 m-t-25">
                                    <button class="btn btn-info" v-on:click="back">Back</button>
                                    <b-button v-b-modal.modal1 class="btn btn-danger" v-show="can_delete">Delete
                                    </b-button>
                                    <b-modal id="modal1" title="Delete user" ok-title="Yes" cancel-title="No"
                                             ok-variant="danger" @ok="deleteItem">
                                        <p class="my-4">Are you sure want to delete this user?</p>
                                    </b-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script type="text/javascript">
    import ApiService from "../../common/api.service";

    export default {
        name: "add_user",
        data() {
            return {
                model: {
                    user_id: 0,
                    name: "",
                    email: "",
                },
                can_delete: false,
                back_url:"",
            }
        },
        methods: {
            getUser: function () {
                ApiService.get('auth/get_user/' + this.model.user_id).then(response => {
                    this.model.email = response.data.email;
                    this.model.name = response.data.name;
                    if (this.model.user_id == JSON.parse(window.localStorage.getItem('user'))['id']) {
                        this.can_delete = false;
                    }else{
                        this.can_delete = true;
                    }
                })
                    .catch(function (error) {
                    });
            },
            deleteItem() {
                ApiService.get('auth/delete_user/' + this.model.user_id).then(response => {
                    if(this.$route.name == 'view_user_dashboard'){
                        this.$router.push("/")
                    }
                    else if(this.$route.name == 'view_user_api'){
                        this.$router.push("/api")
                    }else {
                        this.$router.push("/users_list")
                    }
                })
                    .catch(function (error) {
                    });
            },
            back(){
                this.$router.push(this.back_url)
            }
        },
        mounted() {
        },
        beforeMount() {
            this.model.user_id = this.$route.params.user_id;
            this.getUser();
            if(this.$route.name == 'view_user_dashboard'){
                this.back_url='/';
            }else if(this.$route.name == 'view_user_api'){
                this.back_url='/api';
            }else{
                this.back_url='/users_list';
            }
        },
    }
</script>

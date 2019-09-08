<template>
    <div id="right" :class="{ open: this.$store.state.right_open }">
        <div id="right-slim">
            <div class="rightsidebar-right">

                <b-tabs ref="tabs" card>
                    <b-tab active>
                        <template slot="title">
                            <i class='fa fa-user-o text-success'></i>
                        </template>

                        <div id="slim_t1">
                            <div>
                                <h5 class="rightsidebar-right-heading text-uppercase text-xs bg-success text-white">
                                    <!--<i class="menu-icon  fa fa-comment"></i>-->
                                    Recent Chats
                                </h5>
                                <ul class="list-unstyled margin-none">
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar6.jpg" class="rounded-circle " alt="avatar-image"> Annette
                                            <i class="fa fa-comment float-right text-success" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar.jpg" class="rounded-circle " alt="avatar-image"> Jordan
                                            <i class="fa fa-comment float-right text-success" aria-hidden="true"></i>

                                        </a>
                                    </li>
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar2.jpg" class="rounded-circle" alt="avatar-image"> Stewart
                                            <i class="fa fa-comment float-right text-secondary" aria-hidden="true"></i>

                                        </a>
                                    </li>
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar3.jpg" class="rounded-circle" alt="avatar-image"> Alfred
                                            <i class="fa fa-comment float-right text-secondary" aria-hidden="true"></i>

                                        </a>
                                    </li>
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar4.jpg" class="rounded-circle" alt="avatar-image"> Eileen
                                            <i class="fa fa-comment float-right text-secondary" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar5.jpg" class="rounded-circle" alt="avatar-image"> Robert
                                            <i class="fa fa-comment float-right text-secondary" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="rightsidebar-contact-wrapper">
                                        <a class="rightsidebar-contact" href="javascript:void(0)">
                                            <img src="../../img/authors/avatar7.jpg" class="rounded-circle" alt="avatar-image"> Cassandra
                                            <i class="fa fa-comment float-right text-secondary" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </b-tab>
                    <b-tab>
                        <template slot="title">
                            <i class='fa fa-upload text-danger' aria-hidden='true'></i>
                        </template>


                        <div id="slim_t2">
                            <h5 class="rightsidebar-right-heading text-uppercase text-xs bg-danger text-white">
                                Recent Updates
                            </h5>

                            <div><ul class="list-unstyled"><li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class="fa fa-smile-o  text-primary"></i> New Comment
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-twitter  text-success"></i> 3 New Followers
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-inbox  text-info"></i> Message Sent
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-file-text-o  text-warning"></i> New Task
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-upload  text-danger"></i> Server Rebooted
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-info-circle  text-primary"></i> Server Not Responding
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-shopping-cart  text-success"></i> New Order Placed
                            </a></li> <li class="rightsidebar-contact-wrapper"><a class="rightsidebar-contact" href="javascript:void(0)"><i class=" fa fa-usd  text-info"></i> Payment Received
                            </a></li></ul></div>
                        </div>

                    </b-tab>
                </b-tabs>


            </div>
        </div>
    </div>
</template>
<script>
    import "../../sass/_right_side_bar.scss"

    export default {
    name: "right_side_bar",
    mounted: function() {

    },
    destroyed: function() {

    },
    methods: {
        change_skin() {
        }
    }
}
</script>




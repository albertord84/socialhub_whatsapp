<template>
    <div>
        <div class="contact-page">
            <div class="container-fluid bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="p-5 box-shadow mt-3 mb-3">
                            <h4>
                            <span>
                                <i class="fa fa-address-book-o"></i> Contacts
                            </span>
                                <span class="float-right">
                                <input type="search"  placeholder="Search here" class="search form-control pl-2 pr-2" v-model="search">
                            </span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid bg-white mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row pb-4">
                            <div class="col-12 col-sm-4 col-lg-3">
                                <div class="box-shadow mt-4">
                                    <div class="border-bottom border-secondary p-3">
                                        <img src="~img/authors/avatar1.jpg" alt="user profile" class="contact-profile d-inline-block rounded-circle">
                                        <p class="d-inline-block">&nbsp;&nbsp;Jon Doe</p>
                                    </div>
                                    <div class="options border-bottom border-secondary">
                                        <a href="#/contacts" class="p-3 d-block text-dark active">All Contacts</a>
                                        <a href="#/contacts" class="p-3 d-block text-dark">Frequently contacted </a>
                                        <a href="#/contacts" class="p-3 d-block text-dark">Starred Contacts</a>
                                    </div>
                                    <div class="options2">
                                        <a href="#/contacts" class="p-3 d-block text-dark">Groups</a>
                                        <a href="#/contacts" class="p-3 d-block text-dark">Friends</a>
                                        <a href="#/contacts" class="p-3 d-block text-dark">Clients</a>
                                        <a href="#/contacts" class="p-3 d-block text-dark">Recent Workers</a>
                                        <a href="#/contacts" class="p-3 d-block text-dark">New Group</a>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-3" @click="modalShow = !modalShow" >Add New Contact</button>
                                <b-modal v-model="modalShow" :hide-footer="true" title="Add your contact here">
                                    <b-container fluid>
                                        <form>
                                            <input type="text" class="form-control mt-3" placeholder="Enter name" v-model="newname">
                                            <input type="file" class="btn btn-primary mt-3" @change="onFileChange">
                                            <input type="number" class="form-control mt-3" placeholder="Enter phone number" v-model="newnumber">
                                            <input type="email" class="form-control mt-3" placeholder="Enter email" v-model="newemail">
                                            <input type="text" class="form-control mt-3" placeholder="Enter role" v-model="newrole">
                                            <input type="text" class="form-control mt-3 mb-3" placeholder="Location" v-model="newlocation">
                                            <b-btn  class="float-right" variant="primary" @click="addContact">
                                                Submit
                                            </b-btn>
                                        </form>
                                    </b-container>
                                </b-modal>
                            </div>
                            <div class="col-12 col-sm-8 col-lg-9">
                                <div class="box-shadow mt-4">
                                    <div class="contacts-box">
                                        <div class="total-contacts p-5 ">
                                            <span>All Contacts(25)</span>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr v-for="(contact, index) in allContacts">
                                                    <td>
                                                        <b-form-checkbox></b-form-checkbox>
                                                    </td>
                                                    <td>{{contact.name}}</td>
                                                    <td><img :src="contact.img" alt="profile" class="contact-pic rounded-circle"></td>
                                                    <td>{{contact.email}}</td>
                                                    <td>{{contact.contact_num}}</td>
                                                    <td>{{contact.role}}</td>
                                                    <td>{{contact.location}}</td>
                                                    <td><span class="fa fa-edit" @click="editcontact(index)"></span></td>
                                                    <td><span class="fa fa-trash-o" @click="deletecontact(index)"></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <b-modal ref="editcontact" hide-footer title="Using Component Methods">
            <div class="d-block">
                <form>
                    <input type="text" class="form-control mt-3" placeholder="Enter name" v-model="editname">
                    <input type="email" class="form-control mt-3" placeholder="Enter email" v-model="editemail">
                    <input type="number" class="form-control mt-3" placeholder="Enter number" v-model="editnumber">
                    <input type="text" class="form-control mt-3 mb-3" placeholder="role" v-model="editrole">
                    <input type="text" class="form-control mt-3 mb-3" placeholder="role" v-model="editlocation">
                </form>
            </div>
            <b-btn class="mt-3 text-white" variant="success" block @click="updateContact(contactid)">Update</b-btn>
            <b-btn class="mt-3 text-white"  variant="danger" block @click="cancel">Cancel</b-btn>
        </b-modal>
        <b-modal ref="deletecontact" hide-footer title="Using Component Methods">
            <div class="d-block text-center">
                <h3>Are you sure you want to delete modal</h3>
            </div>
            <b-btn class="mt-3 text-danger" variant="outline-danger" block >Yes</b-btn>
            <b-btn class="mt-3 text-primary"  variant="outline-primary" block>No</b-btn>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name:'blank',
        data(){
            return{
                modalShow: false,
                newname:'',
                newemail:'',
                newnumber:'',
                newlocation:'',
                newrole:'',
                contacts:[{
                    name:'Jon',
                    img:require('../../img/authors/avatar1.jpg'),
                    email:'jon@gmail.com',
                    contact_num:'0123456789',
                    role:'Web developer',
                    location:'Hyderabad',
                },{
                    name:'Doe',
                    img:require('../../img/authors/avatar2.jpg'),
                    email:'doe@gmail.com',
                    contact_num:'0123456789',
                    role:'Web developer',
                    location:'Hyderabad'
                },{
                    name:'Addison',
                    img:require('../../img/authors/avatar3.jpg'),
                    email:'addison@gmail.com',
                    contact_num:'0123456789',
                    role:'Web developer',
                    location:'Hyderabad'
                },{
                    name:'Jon',
                    img:require('../../img/authors/avatar4.jpg'),
                    email:'jon@gmail.com',
                    contact_num:'0123456789',
                    role:'Web developer',
                    location:'Hyderabad'
                },{
                    name:'Doe',
                    img:require('../../img/authors/avatar1.jpg'),
                    email:'jon@gmail.com',
                    contact_num:'0123456789',
                    role:'Web developer',
                    location:'Hyderabad'
                },{
                    name:'Jon',
                    img:require('../../img/authors/avatar.jpg'),
                    email:'jon@gmail.com',
                    contact_num:'0123456789',
                    role:'Web developer',
                    location:'Hyderabad'
                },],
                editname:'',
                editemail:'',
                editnumber:'',
                editlocation:'',
                editrole:'',
                contactid:'',
                search:'',
                userImage:'',
            }
        },
        components:{
        },
        mounted:function(){

        },
        methods: {
            addContact: function () {
                this.contacts.push({
                    name: this.newname,
                    email: this.newemail,
                    contact_num: this.newnumber,
                    location: this.newlocation,
                    role: this.newrole,
                    img:this.userImage,
                }),
                    this.newname='',
                    this.newemail='',
                    this.newnumber='',
                    this.newlocation='',
                    this.newrole='',
                    this.modalShow = false
            },
            deletecontact (index) {
//                this.$refs.deletemodal.show()
                this.contacts.splice(index,1);
            },
            editcontact(index){
                this.editname = this.contacts[index].name;
                this.editemail = this.contacts[index].email;
                this.editnumber = this.contacts[index].contact_num;
                this.editlocation = this.contacts[index].location;
                this.editrole = this.contacts[index].role;
                this.contactid = index;
                this.$refs.editcontact.show();
            },
            updateContact (contactid) {
                this.contacts[contactid].name = this.editname;
                this.contacts[contactid].email = this.editemail;
                this.contacts[contactid].contact_num = this.editnumber;
                this.contacts[contactid].location = this.editlocation;
                this.contacts[contactid].role= this.editrole;
                this.$refs.editcontact.hide()
//                console.log(this.tasks[index].tasktitle);
                this.modalTask=false
            },
            cancel(){
                this.modalTask=false
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files
                if (!files.length) {
                    return
                }
                this.createImage(files[0])
            },
            createImage(file) {
                var reader = new FileReader()
                var vm = this

                reader.onload = (e) => {
                    vm.userImage = e.target.result
                }
                reader.readAsDataURL(file)

            }
        },
        computed:{
            allContacts:function()
            {
                var self=this;
                return this.contacts.filter(function(newcontact){return newcontact.name.toLowerCase().indexOf(self.search.toLowerCase())>=0;});
                //return this.customers;
            }
        }
    }
</script>
<style scoped>
    .search{
        border: 1px solid #bdb3b3;
    }
    .contact-profile{
        width:50px;
        height: 50px;
    }
    .box-shadow{
        box-shadow: 0px 0px 1px 1px #cfcfcf;
    }
    .contact-pic{
        width: 50px;
        height: 50px;
    }
    .table td{
        padding: 16px;
        vertical-align: middle;
    }
    .contacts-box .custom-control-inline{
        margin-right: 0;
    }
    .custom-control-label::before{
        width: 100px;
        height: 100px;
    }
    .contact-page{
        font-size: 14px;
    }
    .options a:hover,.options2 a:hover{
        background-color: #eee;
    }
    .bg-title{
        background-color: #f5f5f5;
    }
    .options .active{
        background-color: #eee;
        color: #3e6174 !important;
    }
    .custom-control-inline{
        margin-right: 0;
    }
</style>

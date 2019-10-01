<template>
    <div class="bg-white p-4">
        <div class="todo ">
            <div class="todoside-menu">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-3 ">
                        <div class="side-content ">
                            <div class="box-shadow">
                                <h1 class="p-3 mb-0">Todo's</h1>
                                <div class="p-3">
                                    <button class="btn btn-primary btn-block" @click="modalTask = !modalTask" >Add Task</button>
                                </div>
                                <b-modal v-model="modalTask" :hide-footer="true" title="Add Your Task Here">
                                    <b-container fluid>
                                        <form>
                                            <label for="tasktitle" class="mt-2">Task Title</label>
                                            <input type="text" id="tasktitle" class="form-control" placeholder="Enter Title" v-model="newtaskname">
                                            <label for="taskdesc" class="mt-2">Task Description</label>
                                            <textarea name="description" placeholder="Add description here" class="form-control" rows="5" id="taskdesc" v-model="newtaskdesc"></textarea>
                                            <label for="deadline" class="mt-2">Deadline</label>
                                            <input type="date" class="form-control" placeholder="Deadline" id="deadline" v-model="newtaskdeadline">
                                            <label><b-form-checkbox class="mt-2" v-model="newimportant"></b-form-checkbox> Click if this a important task</label>
                                            <b-btn  class="float-right mt-2" variant="primary" @click="addTask">
                                                Submit
                                            </b-btn>
                                        </form>
                                    </b-container>
                                </b-modal>
                                <a href="#/tasks" class="alltasks border-bottom border-secondary d-block p-3 active"><i class="fa fa-tasks" aria-hidden="true"></i>&nbsp; All Tasks</a>
                                <a href="#/tasks" class="today d-block p-3"><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp;Today's Tasks (10)</a>
                                <a href="#/tasks" class="needaction d-block p-3"><i class="fa fa-reply" aria-hidden="true"></i> &nbsp;Action Needed Taks (25)</a>
                                <a href="#/tasks" class="important d-block p-3"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp;Important Tasks (13)</a>
                                <a href="#/tasks" class="pending d-block p-3"><i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp;Pending Taks (15)</a>
                                <a href="#/tasks" class="deleted d-block p-3"><i class="fa fa-trash-o" aria-hidden="true"></i> &nbsp;Deleted Tasks</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-9">
                        <div class="tasksearch p-3">
                            <input type="text" class="form-control mt-4 mb-4" placeholder="Search" v-model="search">
                        </div>
                        <div class="tasks-list mt-5">
                            <div class="task-type p-3">
                                <h4>All Tasks</h4>
                            </div>
                            <div class="tasks-table-list">
                                <table class="table">
                                    <tr v-for="(task, index) in allTasks">
                                        <td>
                                            <b-form-checkbox></b-form-checkbox>
                                        </td>
                                        <td>
                                            <h5 v-bind:class="{textDanger: task.important==true}">{{task.tasktitle}}</h5>
                                            <p>{{task.taskdescription}}</p>
                                            <span class="text-danger">Deadline:</span> {{task.taskdeadline}}
                                            <span class="float-right mr-5"><span class="text-danger">Status:</span> {{task.status}}</span>
                                        </td>
                                        <td class="align-center"><span class="fa fa-edit" @click="editModal(index)"></span></td>
                                        <td class="align-center"><span class="fa fa-trash-o" @click="deleteModal(index)"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <b-modal ref="editmodal" hide-footer title="Using Component Methods">
            <div class="d-block">
                <form>
                    <input type="text" class="form-control mt-3" placeholder="Enter title" v-model="edittitle">
                    <textarea name="" id="" class="form-control mt-3" cols="30" rows="10"  v-model="editdescription"></textarea>
                    <input type="email" class="form-control mt-3" placeholder="Enter deadline" v-model="editdeadline">
                    <select v-model="newstatus" id="dropdown" class="form-control mt-3">
                        <option disabled value="">Status</option>
                        <option>Pending</option>
                        <option>Completed</option>
                    </select>
                </form>
            </div>
            <b-btn class="mt-3 text-white" variant="success" block @click="updateModal(taskid)">Update</b-btn>
            <b-btn class="mt-3 text-white"  variant="danger" block>Cancel</b-btn>
        </b-modal>
        <b-modal ref="deletemodal" hide-footer title="Using Component Methods">
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
                modalTask:false,
                newtaskname:'',
                newtaskdesc:'',
                newtaskdeadline:'',
                newimportant:'',
                newstatus:'',
                tasks:[{
                    tasktitle:'Task-1',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:true,
                    status:'pending'
                },{
                    tasktitle:'Task-2',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:true,
                    status:'pending'
                },{
                    tasktitle:'Task-3',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:false,
                    status:'completed'
                },{
                    tasktitle:'Task-4',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:'true',
                    status:'completed'
                },{
                    tasktitle:'Task-5',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:'true',
                    status:'completed'
                },{
                    tasktitle:'Task-6',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:'true',
                    status:'pending'
                },{
                    tasktitle:'Task-7',
                    taskdescription:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, hic quasi! Doloribus esse magni necessitatibus officia recusandae. Aliquam, aspernatur commodi, debitis harum illum odio porro quasi quia repudiandae ullam ut?',
                    taskdeadline:'14/04/2018',
                    important:'true',
                    status:'pending'
                },],
                edittitle:'',
                editdescription:'',
                editdeadline:'',
                important:'',
                editnewstatus:'',
                taskid:'',
                search:''
            }
        },
        components:{
        },
        mounted:function(){


        },
        methods: {
            addTask:function () {
                this.tasks.push({
                    tasktitle:this.newtaskname,
                    taskdescription:this.newtaskdesc,
                    taskdeadline:this.newtaskdeadline,
                    important:this.newimportant,
                    status:'pending',
                }),
                    this.newtaskname='',
                    this.newtaskdesc='',
                    this.newtaskdeadline='',
                    this.newimportant=false,
                    this.newstatus='',
                    this.modalTask=false
            },

            updateModal (taskid) {
                this.tasks[taskid].tasktitle = this.edittitle;
                this.tasks[taskid].taskdescription = this.editdescription;
                this.tasks[taskid].taskdeadline = this.editdeadline;
                this.tasks[taskid].status = this.newstatus;
//                console.log(this.editnewstatus);
                this.$refs.editmodal.hide()
//                console.log(this.tasks[index].tasktitle);
                this.modalTask=false
            },
            editModal (index) {
                this.edittitle = this.tasks[index].tasktitle;
                this.editdescription = this.tasks[index].taskdescription;
                this.editdeadline = this.tasks[index].taskdeadline;
                this.editnewstatus = this.tasks[index].status;
//                console.log(this.editdeadline);
                this.taskid = index;
                this.$refs.editmodal.show()
//                console.log(this.tasks[index].tasktitle);
            },
            deleteModal (index) {
//                this.$refs.deletemodal.show()
                this.tasks.splice(index,1);
            }
        },
        computed:{
            allTasks:function()
            {
                var self=this;
                return this.tasks.filter(function(newtask){return newtask.tasktitle.toLowerCase().indexOf(self.search.toLowerCase())>=0;});
                //return this.customers;
            }
        }
    }
</script>
<style scoped>
    /* to do list */
    .todoside-menu a:hover{
        background-color: #f5f5f5;
    }
    .todoside-menu a{
        font-size: 15px;
        color: #333;
    }
    .faExclamationCircle::before{
        content: "\f06a";
        font-size: 14px;
        top:-8px;
        position: relative;
    }
    .tasksearch,.tasks-list{
        box-shadow:0px 0px 1px 1px #cfcfcf;
    }
    /*.custom-control-label::after, .custom-control-label::before{*/
        /*width: 2rem;*/
        /*height: 2rem;*/
    /*}*/
    .box-shadow{
        box-shadow: 0px 0px 1px 1px #cfcfcf;
    }
    .tasks-table-list{
        max-height: 80vh;
        overflow-y: scroll;
        margin-bottom: 10px;
    }
    .todoside-menu .side-content .active{
        background-color: #eee;
        color: #3e6174;
    }
    .table td .custom-control.custom-checkbox{
        margin-top: 1px;
    }
    .custom-control-inline{
        margin-right: 0;
    }
    .task-type{
        border-bottom: 1px solid #eee;
    }
    .textDanger{
        /*color: #ff6666;*/
        font-weight: 600;
    }
    .textDanger::before{
        content: '.';
        font-size: 42px;
        line-height: 5px;
        font-weight: 900;
        top: -3px;
        left: -5px;
        position: relative;
        color: #fd7570;
    }

</style>
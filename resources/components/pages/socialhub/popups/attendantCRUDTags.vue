<template>
    <div>


        
        <b-container fluid>  

                <!-- <div v-show="show_tag==true"> -->
            <form v-show="showAttendantCRUDTagModal==0">
                <div >
                    <h5> Etiquetas disponíveis para uso:</h5>
                
                
                    <div  class="table-responsive text-center">
                        <table ref="table" class="table table-borderless" style="width:100%">
                            <thead>
                                <!-- <tr> <th class="text-left" v-for="(column, index) in columns"  @click="sort(index)" :class="(sortable ? 'sortable' : '') + (sortColumn === index ? (sortType === 'desc' ? ' sorting-desc' : ' sorting-asc') : '')" :style="{width: column.width ? column.width : 'auto'}" :key="index"> {{column.label}} <i class="fa float-right" :class="(sortColumn === index ? (sortType === 'desc' ? ' fa fa-angle-down' : ' fa fa-angle-up') : '')"> </i> </th> <slot name="thead-tr"></slot> </tr> -->
                            </thead>
                            <tbody>
                                <!-- <tr v-for="(row, index) in paginated" @click="click(row, index)" :key="index">
                                    <template v-for="(column,index) in columns">
                                        <td :class="column.numeric ? 'numeric' : ''" v-if="!column.html" :key="index">
                                            {{ collect(row, column.field) }}
                                        </td>
                                        <td :class="column.numeric ? 'numeric' : ''" v-if="column.html" :key="index">
                                            <a class="text-18" href="javascript:void(0)" title="Editar dados" @click.prevent="actionEditAttendant(row)"> <i class='fa fa-pencil text-success mr-3' ></i> </a>
                                            <a class="text-18" href="javascript:void(0)" title="Eliminar atendente" @click.prevent="actionDeleteAttendant(row)"><i class='fa fa-trash text-danger'  ></i> </a>
                                        </td>
                                    </template>
                                    <slot name="tbody-tr" :row="row"></slot>
                                </tr> -->

                                <tr>
                                    <td>
                                        <p class=" mt-3 p-1 mr-2" style="background-color:blue"> Etiqueta 1 </p>
                                    </td>
                                    <td>
                                        <a class="text-18" href="javascript:void(0)" title="Editar etiqueta" @click.prevent="showAttendantCRUDTagModal=2"> <i class='fa fa-pencil fa-1_5x '></i> </a>
                                    </td>
                                    <td>
                                        <a class="text-18" href="javascript:void(0)" title="Eliminar etiqueta" @click.prevent="showAttendantCRUDTagModal=3"><i class='mdi mdi-tag-remove fa-1_5x text-danger'></i> </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12 text-center">
                        <button id="addTag" type="submit" class="btn btn-primary " :disabled="isSendingAddTag==true" @click.prevent="showAttendantCRUDTagModal=1">
                            <i v-show="isSendingAddTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Criar Etiqueta
                        </button>
                        <button id="cancel2" type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModal">Cancelar</button>
                    </div>

                </div>
            </form>
            
            <form v-show="showAttendantCRUDTagModal==1"> 
                <h5 class="mb-5"> Adicionando uma nova etiqueta</h5>
                <div class="row mb-2 text-center">
                    <div  class="col-lg-8 form-group has-search">
                        <span class="fa fa-tag form-control-feedback"></span>
                        <input v-model="model.name" title="Ex: Nome da etiqueta" id="tag_name" name="tag_name" type="text" required autofocus placeholder="Nome da etiqueta" class="form-control"/>
                    </div>
                    <div class="col-lg-4 form-group has-search">
                        <input v-model="model.color" title="Ex: Cor da etiqueta" name="tag_cor" id="tag_cor" type="text" :disabled="true" class="form-control"/>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-12 mb-2">
                        <h5> Selecione uma cor para a etiqueta </h5>
                    </div>
                </div>
                <div class="row mb-1 text-center">
                    <div class="col-lg-12">
                        <button id="colorTag1" type="submit" class="btn btn-sm btn-tag " style="background-color:#00FF00;" @click.prevent="model.color='#00FF00', colorTag1=!colorTag1">
                            <i v-show="colorTag1==true" class="fa fa-check" style="color:white" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag2" type="submit" class="btn btn-sm btn-tag " style="background-color:#FFFF00;" @click.prevent="model.color='#FFFF00', colorTag2=!colorTag2">
                            <i v-show="colorTag2==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag3" type="submit" class="btn btn-sm btn-tag " style="background-color:#FF9900;" @click.prevent="model.color='#FF9900', colorTag3=!colorTag3">
                            <i v-show="colorTag3==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag4" type="submit" class="btn btn-sm btn-tag " style="background-color:#FF0000;" @click.prevent="model.color='#FF0000', colorTag4=!colorTag4">
                            <i v-show="colorTag4==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag5" type="submit" class="btn btn-sm btn-tag " style="background-color:#CC6699;" @click.prevent="model.color='#CC6699', colorTag5=!colorTag5">
                            <i v-show="colorTag5==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag6" type="submit" class="btn btn-sm btn-tag " style="background-color:#0000FF;" @click.prevent="model.color='#0000FF', colorTag6=!colorTag6">
                            <i v-show="colorTag6==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                    </div>
                </div>
                <div class="row mb-5 text-center">
                    <div class="col-lg-12">
                        <button id="colorTag7" type="submit" class="btn btn-sm btn-tag " style="background-color:#33CCFF;" @click.prevent="model.color='#33CCFF', colorTag7=!colorTag7">
                            <i v-show="colorTag7==true" class="fa fa-check" style="color:white" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag8" type="submit" class="btn btn-sm btn-tag " style="background-color:#CCFF66;" @click.prevent="model.color='#CCFF66', colorTag8=!colorTag8">
                            <i v-show="colorTag8==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag9" type="submit" class="btn btn-sm btn-tag " style="background-color:#FF66CC;" @click.prevent="model.color='#FF66CC', colorTag9=!colorTag9">
                            <i v-show="colorTag9==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag10" type="submit" class="btn btn-sm btn-tag " style="background-color:#660066;" @click.prevent="model.color='#660066', colorTag10=!colorTag10">
                            <i v-show="colorTag10==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag11" type="submit" class="btn btn-sm btn-tag " style="background-color:#333300;" @click.prevent="model.color='#333300', colorTag11=!colorTag11">
                            <i v-show="colorTag11==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag12" type="submit" class="btn btn-sm btn-tag " style="background-color:#121742;" @click.prevent="model.color='#121742', colorTag12=!colorTag12">
                            <i v-show="colorTag12==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                    </div>
                </div>
                <div class="col-lg-12 m-t-25 text-center">
                    <button id="addTag" type="submit" class="btn btn-primary btn_width" :disabled="isSendingAddTag==true" @click.prevent="addTag, showAttendantCRUDTagModal=0">
                        <i v-show="isSendingAddTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Criar
                    </button>
                    <button id="cancel2" type="reset" class="btn  btn-secondary btn_width" @click.prevent="showAttendantCRUDTagModal=0">Cancelar</button>
                </div>
            </form>

            <form v-show="showAttendantCRUDTagModal==2">
                <h5 class="mb-5"> Editando a etiqueta selecionada</h5>
                <div class="row mb-2 text-center">
                    <div  class="col-lg-8 form-group has-search">
                        <span class="fa fa-tag form-control-feedback"></span>
                        <input v-model="model.name" title="Ex: Nome da etiqueta" id="tag_name" name="tag_name" type="text" required autofocus placeholder="Nome da etiqueta" class="form-control"/>
                    </div>
                    <div class="col-lg-4 form-group has-search">
                        <input v-model="model.color" title="Ex: Cor da etiqueta" name="tag_cor" id="tag_cor" type="text" :disabled="true" class="form-control"/>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-12 mb-2">
                        <h5> Selecione uma cor para a etiqueta </h5>
                    </div>
                </div>
                <div class="row mb-1 text-center">
                    <div class="col-lg-12">
                        <button id="colorTag1" type="submit" class="btn btn-sm btn-tag " style="background-color:#00FF00;" @click.prevent="model.color='#00FF00', colorTag1=!colorTag1">
                            <i v-show="colorTag1==true" class="fa fa-check" style="color:white" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag2" type="submit" class="btn btn-sm btn-tag " style="background-color:#FFFF00;" @click.prevent="model.color='#FFFF00', colorTag2=!colorTag2">
                            <i v-show="colorTag2==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag3" type="submit" class="btn btn-sm btn-tag " style="background-color:#FF9900;" @click.prevent="model.color='#FF9900', colorTag3=!colorTag3">
                            <i v-show="colorTag3==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag4" type="submit" class="btn btn-sm btn-tag " style="background-color:#FF0000;" @click.prevent="model.color='#FF0000', colorTag4=!colorTag4">
                            <i v-show="colorTag4==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag5" type="submit" class="btn btn-sm btn-tag " style="background-color:#CC6699;" @click.prevent="model.color='#CC6699', colorTag5=!colorTag5">
                            <i v-show="colorTag5==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag6" type="submit" class="btn btn-sm btn-tag " style="background-color:#0000FF;" @click.prevent="model.color='#0000FF', colorTag6=!colorTag6">
                            <i v-show="colorTag6==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                    </div>
                </div>
                <div class="row mb-5 text-center">
                    <div class="col-lg-12">
                        <button id="colorTag7" type="submit" class="btn btn-sm btn-tag " style="background-color:#33CCFF;" @click.prevent="model.color='#33CCFF', colorTag7=!colorTag7">
                            <i v-show="colorTag7==true" class="fa fa-check" style="color:white" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag8" type="submit" class="btn btn-sm btn-tag " style="background-color:#CCFF66;" @click.prevent="model.color='#CCFF66', colorTag8=!colorTag8">
                            <i v-show="colorTag8==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag9" type="submit" class="btn btn-sm btn-tag " style="background-color:#FF66CC;" @click.prevent="model.color='#FF66CC', colorTag9=!colorTag9">
                            <i v-show="colorTag9==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag10" type="submit" class="btn btn-sm btn-tag " style="background-color:#660066;" @click.prevent="model.color='#660066', colorTag10=!colorTag10">
                            <i v-show="colorTag10==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag11" type="submit" class="btn btn-sm btn-tag " style="background-color:#333300;" @click.prevent="model.color='#333300', colorTag11=!colorTag11">
                            <i v-show="colorTag11==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                        <button id="colorTag12" type="submit" class="btn btn-sm btn-tag " style="background-color:#121742;" @click.prevent="model.color='#121742', colorTag12=!colorTag12">
                            <i v-show="colorTag12==true" style="color:white" class="fa fa-check" aria-hidden="true"></i> &nbsp;</button>
                    </div>
                </div>
                <div class="col-lg-12 m-t-25 text-center">
                    <button id="updateTag" type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdateTag==true" @click.prevent="updateTag, showAttendantCRUDTagModal=0">
                        <i v-show="isSendingUpdateTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                    </button>
                    <button id="cancel2" type="reset" class="btn  btn-secondary btn_width" @click.prevent="showAttendantCRUDTagModal=0">Cancelar</button>
                </div>
            </form>

            <form v-show="showAttendantCRUDTagModal==3">
                <h5 class="mb-5"> Verificação de exclusão</h5>
                Tem certeza que deseja remover a etiqueta selecionada?
                <div class="col-lg-12 mt-5 text-center">
                    <button id="deleteTag" type="submit" class="btn btn-primary btn_width" :disabled="isSendingDeleteTag==true" @click.prevent="deleteTag, showAttendantCRUDTagModal=0">
                        <i v-show="isSendingDeleteTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Eliminar
                    </button>
                    <button id="cancel3" type="reset" class="btn  btn-secondary btn_width" @click.prevent="showAttendantCRUDTagModal=0">Cancelar</button>
                </div>                    
            </form>

        </b-container>
    </div>
</template>

<script>
    import Vue from 'vue';
    import ApiService from "../../../../common/api.service";
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import validation from "src/common/validation.service";
    
    export default {
        name: 'attendantCRUDTags',

        props: {
            attendant_id: '',       // attendant ID 
            attendantTags_url:'',   //attendants_tags controller url 
            item:{},                // model_attendantTags
        },

        components:{
        },

        data(){
            return{
                
                model:{
                    attendant_id: "",
                    name: "",
                    color: "",
                },

                showAttendantCRUDTagModal: 0,

                show_tag: true,
                add_tag: false,
                edit_tag: false,
                delete_tag: false,

                isSendingAddTag: false,
                isSendingUpdateTag: false,
                isSendingDeleteTag: false,
                
                
                // rows:[],
            }
        },

        methods:{

            getTags: function() { 
                ApiService.get(this.attendantTags_url)
                    .then(response => {
                        this.rows = [];
                        var This=this;
                        response.data.forEach(function(item, i){
                            var obj = item.user;
                            obj.created_at = item.created_at;
                            obj.deleted_at = item.deleted_at;
                            obj.updated_at = item.updated_at;
                            This.rows.push(obj);
                        });
                    })
                    .catch(error => {
                        this.processMessageError(error, this.attendantTags_url,"get");
                    });
            }, 


            addTag: function() { //C

                // this.model.attendant_id = this.logguedAttendant.id;
                this.add_tag =true;
                this.show_tag =false;

                // this.isSendingInsert = true;

                // // Validando dados
                // this.trimDataModel();
                // this.validateData();
                // if (this.flagReference == false){
                //     miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                //     this.isSendingInsert = false;
                //     this.flagReference = true;
                //     return;
                // }

                // var model_cpy = Object.assign({}, this.model);                      //ECR: Para eliminar espaços e traços
                // model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/ /g, '');    //ECR
                // model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/-/i, '');    //ECR
                // if(model_cpy.phone){
                //     model_cpy.phone = model_cpy.phone.replace(/ /g, '');    //ECR
                //     model_cpy.phone = model_cpy.phone.replace(/-/i, '');    //ECR
                // }

                // //isert user
                // ApiService.post(this.first_url, model_cpy)
                //     .then(response => {
                //         //isert userAttendant
                //         ApiService.post(this.url, { 
                //             'user_id':response.data.id,
                //             'user_manager_id':JSON.parse(localStorage.user).id
                //             })
                //             .then(response => {
                //                 miniToastr.success("Atendente adicionado com sucesso","Sucesso");
                //                 this.formReset();
                //                 this.reload();
                //                 this.closeModals();
                //             })
                //         .catch(error => {
                //             this.processMessageError(error, this.url,"add");
                //         })
                //         .finally(() => this.isSendingInsert = false);
                //     })
                //     .catch(error => {
                //         this.processMessageError(error, this.first_url,"add");
                //         this.isSendingInsert = false;
                //     });
            },
            
            editTag: function() { //U

                // ecr: cuando se clique em edit  model recebe el  el model a editar
                // this.model = Object.assign({}, this.item);

                this.isEdittingTag=!this.isEdittingTag; // para Mostrar la parde de edicion 
                
            },

            updateTag: function() { //U
                
                // if(this.model.password.trim()!='' && this.model.password!=this.model.repeat_password){
                //         miniToastr.error('Erro', "As senha não coincidem"); return;
                // }
                
                // this.isSendingUpdate = true;

                // // Validando dados
                // this.trimDataModel();
                // this.validateData();
                // if (this.flagReference == false){
                //     miniToastr.error("Erro", 'Por favor, confira os dados inseridos' );
                //     this.isSendingUpdate = false;
                //     this.flagReference = true;
                //     return;
                // }
                
                // var model_cpy = JSON.parse(JSON.stringify(this.model));
                // delete model_cpy.created_at;
                // delete model_cpy.updated_at;
                // delete model_cpy.deleted_at;
                // if(this.model.password.trim()==''){
                //     delete model_cpy.password;
                //     delete model_cpy.repeat_password;
                // }

                // model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/ /g, '');    //ECR
                // model_cpy.whatsapp_id = model_cpy.whatsapp_id.replace(/-/i, '');    //ECR
                // if(model_cpy.phone){
                //     model_cpy.phone = model_cpy.phone.replace(/ /g, '');                //ECR
                //     model_cpy.phone = model_cpy.phone.replace(/-/i, '');                //ECR
                // }
                // ApiService.put(this.first_url+'/'+this.attendant_id, model_cpy)
                //     .then(response => {
                //         miniToastr.success("Atendente atualizado com sucesso","Sucesso");
                //             this.reload();
                //             this.closeModals();
                //     })
                //     .catch(error => {
                //         this.processMessageError(error, this.first_url,"update");
                //     })
                //     .finally(() => this.isSendingUpdate = false);
            },

            deleteTag: function(){

                // this.isSendingDelete = true;
                // ApiService.delete('deleteAllByAttendantId/'+this.item.id)
                //     .then(response => {
                //         ApiService.delete(this.url+'/'+this.item.id)
                //             .then(response => {                                
                //                 ApiService.delete(this.first_url+'/'+this.item.id)
                //                     .then(response => {
                //                         miniToastr.success("Atendente eliminado com sucesso","Sucesso");
                //                         this.reload();
                //                         this.closeModals();
                //                     })
                //                     .catch(error => {
                //                         this.processMessageError(error, this.first_url, "delete");
                //                     })
                //                     .finally(() => this.isSendingDelete = false);
                //             })
                //             .catch(error => {
                //                 this.processMessageError(error, this.url, "delete");
                //                 this.isSendingDelete = false;
                //             });
                //     })
                //     .catch(error => {
                //         this.processMessageError(error, this.url, "delete");
                //         this.isSendingDelete = false;
                //     });
            },

            formReset:function(){
                this.model.name = "";
                this.model.color = "";
              
            },

            closeModals(){
                this.$emit('modalclose');
            }, 
            
            reload(){
                this.$emit('onreloaddatas');
            }, 


            trimDataModel: function(){
                if(this.model.name) this.model.name = this.model.name.trim();
            },

           
            
            //------ Specific exceptions methods------------
            processMessageError: function(error, url, action) {
                var info = ApiService.process_request_error(error, url, action);
                if(info.typeException == "expiredSection"){
                    miniToastr.warn(info.message,"Atenção");
                    this.$router.push({name:'login'});
                    window.location.reload(false);
                }else if(info.typeMessage == "warn"){
                    miniToastr.warn(info.message,"Atenção");
                }else{
                    miniToastr.error(info.erro, info.message); 
                }
            }

        },

        beforeMount(){
            this.logguedAttendant = JSON.parse(window.localStorage.getItem('user'));
        },

        mounted(){
            this.editTag();
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

    }
</script>

<style scoped>
    .has-search .form-control {
        padding-left: 2.375rem;
    }
    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }  
    .has-search-color{
        color: #aaa;
    }
    .btn_width{
        width: 100px
    }
    .text-18{
        font-size: 18px
    }
    .btn-tag{
        /* width: 100%; */
        width: 50px;
    }
</style>
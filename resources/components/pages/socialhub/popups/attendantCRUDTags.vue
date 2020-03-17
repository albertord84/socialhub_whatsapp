<template>
    <div>

        <div>

            <h5> Etiquetas disponíveis para uso</h5>
        
        
            <div class="table-responsive">
                <table ref="table" class="table">
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
                    </tbody>
                </table>
            </div>

        </div>

        
        <b-container fluid>  

            <hr>

            <form v-show="action!='delete'">                                        
                <div class="row">
                    {{model.user_id}}
                </div>    
                <div class="row">
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-user form-control-feedback"></span>
                        <input v-model="model.name" title="Ex: Nome do Atendente" id="name" name="name" type="text" required autofocus placeholder="Nome completo *" class="form-control"/>
                    </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-user form-control-feedback"></span>
                        <input v-model="model.login" title="Ex: Login do Atendente" name="login" id="login" type="text" required placeholder="Login" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-envelope form-control-feedback"></span>
                        <input v-model="model.email" title="Ex: atendente@gmail.com" id="email" name="email" type="email" required placeholder="Email *" class="form-control"/>                            
                    </div> 
                    <div class="col-lg-3 form-group has-search">
                        <span class="fa fa-id-card form-control-feedback"></span>
                        <input v-model="model.CPF" v-mask="'###.###.###-##'" title="Ex: 000.000.008-00" name="CPF" id="CPF" type="text" required placeholder="CPF *" class="form-control"/>
                    </div>
                    <div class="col-lg-3 form-group has-search">
                        <span class="fa fa-phone form-control-feedback"></span>
                        <input v-model="model.phone" v-mask="'###############'" title="Ex: 551188888888" id="phone" name="phone" type="text" required placeholder="Telefone fixo" class="form-control"/>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-whatsapp form-control-feedback"></span>
                        <input v-model="model.whatsapp_id" v-mask="'###############'" title="Ex: 5511988888888" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp *" class="form-control"/>
                    </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-facebook form-control-feedback"></span>
                        <input v-model="model.facebook_id" title="Ex: facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-instagram form-control-feedback"></span>
                            <input v-model="model.instagram_id" title="Ex: instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                        </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-linkedin form-control-feedback"></span>
                        <input v-model="model.linkedin_id" title="Ex: linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                    </div>
                </div>
                <div v-if="action=='edit'" class="row">
                    <div class="col-lg-6 form-group has-search">
                            <span class="fa fa-key form-control-feedback"></span>
                            <input v-model="model.password" title="Inserir a nova senha" type="password" placeholder="Senha" class="form-control"/>
                        </div>
                    <div class="col-lg-6 form-group has-search">
                        <span class="fa fa-key form-control-feedback"></span>
                        <input v-model="model.repeat_password" title="Repetir a nova senha" type="password" placeholder="Repetir senha" class="form-control"/>
                    </div>
                </div>
                <div class="col-lg-12 m-t-25 text-center">
                    <button v-show='action=="insert"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingInsert==true" @click.prevent="addAttendant">
                        <i v-show="isSendingInsert==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Adicionar
                    </button>

                    <button v-show='action=="edit"' type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdate==true" @click.prevent="updateAttendant">
                        <i v-show="isSendingUpdate==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                    </button>

                    <button type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>

            <form v-show="edit_tag">                                        


                <div class="row">
                    <div  class="col-lg-6 form-group has-search">
                        <span class="fa fa-tag form-control-feedback"></span>
                        <input v-model="model.name" title="Ex: Nome da etiqueta" id="tag_name" name="tag_name" type="text" required autofocus placeholder="Nome da etiqueta *" class="form-control"/>
                    </div>
                    <div class="col-lg-6 form-group has-search" style="background-color:#0033CC">
                        <span class="fa fa-tag form-control-feedback"></span>
                        <input v-model="model.color" title="Ex: Cor da etiqueta" name="tag_cor" id="tag_cor" type="text" :disabled="true" required placeholder="Cor da etiqueta" class="form-control"/>
                    </div>
                </div>

                <div class="row">
                    <span> Para mudar a cor da etiqueta, escolha uma nova cor na paleta de cores. </span>


                </div>

                
                
                

                <div class="col-lg-12 m-t-25 text-center">
                    
                    <button id="updateTag" type="submit" class="btn btn-primary btn_width" :disabled="isSendingUpdateTag==true" @click.prevent="updateTag">
                        <i v-show="isSendingUpdateTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Atualizar
                    </button>

                    <button id="cancel2" type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
                </div>
            </form>

            <form v-show="delete_tag">
                Tem certeza que deseja remover a etiqueta selecionada?
                <div class="col-lg-12 mt-5 text-center">
                    <button id="deleteTag" type="submit" class="btn btn-primary btn_width" :disabled="isSendingDeleteTag==true" @click.prevent="deleteTag">
                        <i v-show="isSendingDeleteTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>Eliminar
                    </button>
                    <button id="cancel3" type="reset" class="btn  btn-secondary btn_width" @click.prevent="closeModals">Cancelar</button>
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

                this.model.attendant_id = this.logguedAttendant.id;

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
</style>
<template>
    <div >
        <div>
            <label>Nome</label>
            <input v-model="model.name" title=" Nome da nova etiqueta" type="text" autofocus placeholder="Nome da etiqueta" class="form-control" style="width:100%"/>
        </div>
        <div >
            <label for="" style="margin-top: 1rem">Selecionar uma cor</label>
            <div class="row" style="margin-left:-3px; margin-right:-3px">
                <div v-for="(color, index) in colors" class="col-2" style="padding-left:0px" v-bind:key="index">
                    <button class="btn" :disabled="color.used" :style="'color:white; width:44px; height: 34px; margin-bottom: 3px; background-color:'+color.color" @click="selectColor(color)">
                        <i v-if="selectedColor && selectedColor.color === color.color && !color.used" class="fa fa-check"></i>
                        <i v-if="color.used" class="fa fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary text-white pl-3 pr-3 mt-2 mb-1" @click.prevent="addAttendantTag">
                <i v-show="isAddingTag==false" class="fa fa-plus" style="color:white" > </i> 
                <i v-show="isAddingTag==true" class="fa fa-spinner fa-spin" style="color:white" ></i>
                Adicionar etiqueta
            </button>
        </div>
        
        <hr>

        <label>Etiquetas criadas</label>
        <div v-for="(tag, index) in attendantTags" v-bind:key="index" class="row mx-0 my-1 border" :style="'background-color:'+tag.color">
            <div class="col-10 py-2" >
                <span style="color:white">{{tag.name}}</span>
            </div>
            <div class="col-2 d-inline-flex py-2 pointer-hover text-center" @click.prevent="deleteTag(tag, index)">
                <i class="fa fa-times mt-1" style="color:red; font-size:1rem; " aria-hidden="true"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import Fuse from 'fuse.js';
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../../common/api.service";
    

    export default {   
        props:{        
            userLogged: null,            
        },

        components:{            
        },

        data() {
            return {
                attendantTags: null,
                isAddingTag: false,
                selectedColor: null,
                colors:[
                    {color : '#60bb4e', used: false},
                    {color : '#f3d421', used: false},
                    {color : '#f79e29', used: false},
                    {color : '#eb5947', used: false},
                    {color : '#c378e1', used: false},
                    {color : '#1a77c2', used: false},

                    {color : '#42c1e0', used: false},
                    {color : '#5fe597', used: false},
                    {color : '#f175ca', used: false},
                    {color : '#334563', used: false},
                    {color : '#b3b9c5', used: false},
                    {color : '#000000', used: false}
                ],
                model: {
                    id: 0,
                    name : '',
                    color: ''
                }
            }
        },

        methods: {

            getAttendantTags () {
                ApiService.get('attendantsTags', {'attendant_id': this.userLogged.id})
                .then(response => {
                    response.data.some((item,i)=>{
                        this.disableTagButton(item.color)
                    });
                    this.attendantTags = response.data;
                })
                .catch(error => {
                    // this.processMessageError(error, "getAttendantTags","get");
                })
                .finally(() => {
                });
            },

            addAttendantTag() {
                if(this.model.name.trim() == '') {
                    miniToastr.warn("Atenção", "A etiqueta deve ter um nome");
                    return false;
                }
                if(!this.selectedColor || this.selectedColor.color == '' || this.selectedColor.used){
                    miniToastr.warn("Atenção", "A etiqueta deve ter uma cor");
                    return false;
                }
                var flag = false;
                this.attendantTags.some((item,i)=>{
                    if(item.name.toLowerCase() === this.model.name.toLowerCase()){
                        flag = true;
                        return;
                    }
                });
                if(flag) {
                    miniToastr.warn("Atenção", "O nome da etiqueta já está em uso");
                    return false;
                }
                this.isAddingTag = true;
                this.model.color = this.selectedColor.color;
                this.selectedColor.used = true;
                this.model.attendant_id = this.userLogged.id;
                ApiService.post('attendantsTags',this.model)
                .then(response => {
                    this.attendantTags.push(Object.assign({}, this.model));
                    this.model.name = '';
                    this.model.color = '';
                    this.disableTagButton(this.model.color)
                })
                .catch(error => {
                    // this.processMessageError(error, "getAttendantTags","get");
                })
                .finally(() => {
                    this.isAddingTag = false;
                });
            },

            deleteTag(tag, index) {
                ApiService.delete('attendantsTags/'+tag.id)
                .then(response => {
                    this.enableTagButton(tag.color)
                    this.attendantTags.splice(index,1);
                })
                .catch(error => {
                    // this.processMessageError(error, "getAttendantTags","get");
                })
                .finally(() => {
                });
            },
            
            selectColor(color) {
                this.selectedColor = color;
            },

            enableTagButton(color) {
                this.colors.some((item,i)=>{
                    if(item.color === color){
                        item.used = false;
                        return;
                    }
                });
            }, 

            disableTagButton(color) {
                this.colors.some((item,i)=>{
                    if(item.color === color){
                        item.used = true;
                        return;
                    }
                });
            }
        },

        beforeMount(){
            this.getAttendantTags();
        },

        mounted() {
            
        },        

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        computed: {
            
        },

        watch: {
            
        },
        
    }


</script>

<style scoped>
    .pagination {
        margin-top: 12px;
    }

    .sortable {
        cursor: pointer;
    }

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
    .no-shadows{
        box-shadow: none !important;
    }
    .pointer-hover:hover{
        cursor: pointer;
    }
</style>

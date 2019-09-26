<template>
    <div class="row">
         <div class="col-lg-12 m-0 ">
                <datatable title="" :rows="rowdata" :columns="columndata"></datatable>
        </div>         
    </div>
</template>

<script>
    import Vue from 'vue';
    import {ClientTable,Event} from 'vue-tables-2';
    import datatable from "components/pages/socialhub/DataTableContacts.vue";
    Vue.use(ClientTable, {}, false);
    
    import miniToastr from "mini-toastr";
    miniToastr.init();
    import ApiService from "../../../common/api.service";
    

    export default {
        name: "advanced_tables",
        components: {
            datatable
        },        
        data() {
            return {
                contacts_status:[],

                rowdata: [
                    {
                        "status_id": "Ativo",
                        "first_name": "Mcmyne Thomskins Anjo",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Walls",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Tony Ramos',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Wittcop",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'João Nunes',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }
                ],

                columndata: [
                    {
                        label: 'Status',
                        field: 'status_id',
                        numeric: true, 
                        width: "90px",
                        html: false,
                    },{
                        label: 'Whatsapp',
                        field: 'whatsapp_id',
                        numeric: false,
                        html: false,
                    },{
                        label: 'Nome', 
                        field: 'first_name', 
                        numeric: false, 
                        html: false, 
                    }, {
                        label: 'Email',
                        field: 'email',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Atendente',
                        field: 'attendant_id',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Action',
                        field: 'button',
                        numeric: false,
                        html: true,
                    }
                ],
            }
        },
        methods: {
            getContacts: function() { //R
                var url = "contacts";
                this.rowdata =[];
                ApiService.get(url)
                    .then(response => {
                        this.rowdata = response.data;
                        var This=this;
                        console.log(this.contacts_status);
                        response.data.forEach(function(item, i){
                            // adicionar o nome do status a cada registro
                            
                            // adicionar o nome do repectivo atendente a cada registro

                            //adicionar as ações de ver conversas, editar e eliminar contato a cada registro

                            // item.checked ='false';
                            //item.nameType = This.getNameByType(This.contentsTypes, item.type_id);
                            //This.contents.push(response.data[i]);
                        });
                        // this.getClassrooms(); 
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os contatos");   
                    });
            },  

            getContactStatus: function() { //R
                var url = "contacts_status";
                this.rowdata =[];
                ApiService.get(url)
                    .then(response => {
                        this.contacts_status = response.data;                        
                    })
                    .catch(function(error) {
                        miniToastr.error(error, "Error carregando os status dos contatos");   
                    });
            },
        },

        beforeMount(){
            this.getContactStatus();
        },

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
            this.getContacts();
        },
    }
</script>


<style>
    .VuePagination {
        text-align: center;
    }

    .vue-title {
        text-align: center;
        margin-bottom: 10px;
    }

    .vue-pagination-ad {
        text-align: center;
    }

    .fa.fa-eye {
        width: 16px;
        display: block;
        margin: 0 auto;
    }

    th:nth-child(3) {
        text-align: center;
    }

    .VueTables__child-row-toggler {
        width: 16px;
        height: 16px;
        line-height: 16px;
        display: block;
        margin: auto;
        text-align: center;
    }

    .VueTables__child-row-toggler--closed::before {
        content: "+";
    }

    .VueTables__child-row-toggler--open::before {
        content: "-";
    }
    table{
        width: 100%;
    }

</style>

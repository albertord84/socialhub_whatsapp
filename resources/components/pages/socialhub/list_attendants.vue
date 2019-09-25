<template>
    <div class="row">
         <div class="col-lg-12 m-0 ">
                <datatable title="" :rows="rowdata" :columns="columndata"></datatable>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import {
        ClientTable,
        Event
    } from 'vue-tables-2';
    import datatable from "components/pages/socialhub/DataTableAttendants.vue";
    Vue.use(ClientTable, {}, false);

    export default {
        name: "advanced_tables",
        components: {
            datatable
        },
        data() {
            return {
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
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Mahan",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Kiab",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Odonoghue",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Schuessler",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Schotuen",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Sacks",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Knaus",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Downing",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Downing",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Wallace",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Morrison",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Wade",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Bommi",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Azcunaga",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Ingham",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Sergent",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }, {
                        "status_id": "Ativo",
                        "first_name": "Malmfeldt",
                        "email": "exemplo@gmail.com",
                        "attendant_id": 'Primo Rico',
                        "whatsapp_id": "5521961234",
                        "button":  "<i class='fa fa-comments-o text-info mr-3'></i>"+"<i class='fa fa-pencil text-success mr-3'></i>"+"<i class='fa fa-trash text-danger'></i>"
                    }
                ],

                columndata: [
                    {
                        label: 'Status', // Column name
                        field: 'status_id', // Field name from row
                        numeric: true, // Affects sorting
                        width: "90px", //width of the column
                        html: false, // Escapes output if false.
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
                    },  /*{
                        label: 'Facebook',
                        field: 'facebook_id',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'Intagram',
                        field: 'instagram_id',
                        numeric: false,
                        html: false,
                    }, {
                        label: 'LinkedIn',
                        field: 'linkedin_id',
                        numeric: false,
                        html: false,
                    },*/{
                        label: 'Action',
                        field: 'button',
                        numeric: false,
                        html: true,
                    }
                ],
            
            }
        },
        mounted() {
        
        }
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

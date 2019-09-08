<template>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <b-card header="Basic Client Table" header-tag="h4" class="bg-danger-card">
                <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
            </b-card>
        </div>
        <div class="col-lg-12 mb-3">
            <b-card header="AJAX Client Table" header-tag="h4" class="bg-info-card">
                <v-client-table :data="tableData2" :columns="columns" :options="options"></v-client-table>
            </b-card>
        </div>
        <div class="col-lg-12 mb-3">
            <b-card header="Vue2-datatable" header-tag="h4" class="bg-success-card">
                <datatable title="" :rows="rowdata" :columns="columndata"></datatable>
            </b-card>
        </div>
        <div class="col-lg-12 mb-3">
            <b-card header="Vue Client Table" header-tag="h4" class="bg-warning-card">
                <v-client-table :columns="columnsnew" :data="datanew" :options="optionsnew">
                    <a slot="uri" slot-scope="props" target="_blank" :href="props.row.uri" class="fa fa-eye"></a>

                    <div slot="child_row" slot-scope="props">
                        The link to {{props.row.name}} is <a :href="props.row.uri">{{props.row.uri}}</a>
                    </div>

                </v-client-table>
            </b-card>
        </div>
    </div>
</template>
<script>
import Vue from 'vue';
import {
    ClientTable,
    Event
} from 'vue-tables-2';
import datatable from "components/plugins/DataTable/DataTable.vue";
Vue.use(ClientTable, {}, false);
function getData() {
    return [{
        code: "ZW",
        name: "Zimbabwe",
        created_at: "2015-04-24T01:46:50.459583",
        updated_at: "2015-04-24T01:46:50.459593",
        uri: "http://api.lobbyfacts.eu/api/1/country/245",
        id: 245
    }, {
        code: "ZM",
        name: "Zambia",
        created_at: "2015-04-24T01:46:50.457459",
        updated_at: "2015-04-24T01:46:50.457468",
        uri: "http://api.lobbyfacts.eu/api/1/country/244",
        id: 244
    }, {
        code: "YE",
        name: "Yemen",
        created_at: "2015-04-24T01:46:50.454731",
        updated_at: "2015-04-24T01:46:50.454741",
        uri: "http://api.lobbyfacts.eu/api/1/country/243",
        id: 243
    }, {
        code: "EH",
        name: "Western Sahara",
        created_at: "2015-04-24T01:46:50.452002",
        updated_at: "2015-04-24T01:46:50.452011",
        uri: "http://api.lobbyfacts.eu/api/1/country/242",
        id: 242
    }, {
        code: "WF",
        name: "Wallis & Futuna",
        created_at: "2015-04-24T01:46:50.449346",
        updated_at: "2015-04-24T01:46:50.449355",
        uri: "http://api.lobbyfacts.eu/api/1/country/241",
        id: 241
    }, {
        code: "VN",
        name: "Vietnam",
        created_at: "2015-04-24T01:46:50.446644",
        updated_at: "2015-04-24T01:46:50.446652",
        uri: "http://api.lobbyfacts.eu/api/1/country/240",
        id: 240
    }, {
        code: "VE",
        name: "Venezuela",
        created_at: "2015-04-24T01:46:50.444031",
        updated_at: "2015-04-24T01:46:50.444040",
        uri: "http://api.lobbyfacts.eu/api/1/country/239",
        id: 239
    }, {
        code: "VU",
        name: "Vanuatu",
        created_at: "2015-04-24T01:46:50.441423",
        updated_at: "2015-04-24T01:46:50.441433",
        uri: "http://api.lobbyfacts.eu/api/1/country/238",
        id: 238
    }, {
        code: "UZ",
        name: "Uzbekistan",
        created_at: "2015-04-24T01:46:50.438748",
        updated_at: "2015-04-24T01:46:50.438757",
        uri: "http://api.lobbyfacts.eu/api/1/country/237",
        id: 237
    }, {
        code: "UY",
        name: "Uruguay",
        created_at: "2015-04-24T01:46:50.435761",
        updated_at: "2015-04-24T01:46:50.435770",
        uri: "http://api.lobbyfacts.eu/api/1/country/236",
        id: 236
    }, {
        code: "VI",
        name: "United States Virgin Islands",
        created_at: "2015-04-24T01:46:50.433229",
        updated_at: "2015-04-24T01:46:50.433238",
        uri: "http://api.lobbyfacts.eu/api/1/country/235",
        id: 235
    }, {
        code: "US",
        name: "United States",
        created_at: "2015-04-24T01:46:50.430335",
        updated_at: "2015-04-24T01:46:50.430340",
        uri: "http://api.lobbyfacts.eu/api/1/country/234",
        id: 234
    }, {
        code: "GB",
        name: "United Kingdom",
        created_at: "2015-04-24T01:46:50.427956",
        updated_at: "2015-04-24T01:46:50.427961",
        uri: "http://api.lobbyfacts.eu/api/1/country/233",
        id: 233
    }, {
        code: "AE",
        name: "United Arab Emirates",
        created_at: "2015-04-24T01:46:50.425383",
        updated_at: "2015-04-24T01:46:50.425392",
        uri: "http://api.lobbyfacts.eu/api/1/country/232",
        id: 232
    }, {
        code: "UA",
        name: "Ukraine",
        created_at: "2015-04-24T01:46:50.422970",
        updated_at: "2015-04-24T01:46:50.422980",
        uri: "http://api.lobbyfacts.eu/api/1/country/231",
        id: 231
    }, {
        code: "UG",
        name: "Uganda",
        created_at: "2015-04-24T01:46:50.419963",
        updated_at: "2015-04-24T01:46:50.419968",
        uri: "http://api.lobbyfacts.eu/api/1/country/230",
        id: 230
    }, {
        code: "TV",
        name: "Tuvalu",
        created_at: "2015-04-24T01:46:50.417896",
        updated_at: "2015-04-24T01:46:50.417906",
        uri: "http://api.lobbyfacts.eu/api/1/country/229",
        id: 229
    }, {
        code: "TC",
        name: "Turks & Caicos Islands",
        created_at: "2015-04-24T01:46:50.414854",
        updated_at: "2015-04-24T01:46:50.414868",
        uri: "http://api.lobbyfacts.eu/api/1/country/228",
        id: 228
    }, {
        code: "TM",
        name: "Turkmenistan",
        created_at: "2015-04-24T01:46:50.412601",
        updated_at: "2015-04-24T01:46:50.412605",
        uri: "http://api.lobbyfacts.eu/api/1/country/227",
        id: 227
    }, {
        code: "TR",
        name: "Turkey",
        created_at: "2015-04-24T01:46:50.411105",
        updated_at: "2015-04-24T01:46:50.411110",
        uri: "http://api.lobbyfacts.eu/api/1/country/226",
        id: 226
    }, {
        code: "TN",
        name: "Tunisia",
        created_at: "2015-04-24T01:46:50.409535",
        updated_at: "2015-04-24T01:46:50.409539",
        uri: "http://api.lobbyfacts.eu/api/1/country/225",
        id: 225
    }, {
        code: "TT",
        name: "Trinidad & Tobago",
        created_at: "2015-04-24T01:46:50.408030",
        updated_at: "2015-04-24T01:46:50.408034",
        uri: "http://api.lobbyfacts.eu/api/1/country/224",
        id: 224
    }, {
        code: "TO",
        name: "Tonga",
        created_at: "2015-04-24T01:46:50.406306",
        updated_at: "2015-04-24T01:46:50.406311",
        uri: "http://api.lobbyfacts.eu/api/1/country/223",
        id: 223
    }, {
        code: "TK",
        name: "Tokelau",
        created_at: "2015-04-24T01:46:50.404794",
        updated_at: "2015-04-24T01:46:50.404799",
        uri: "http://api.lobbyfacts.eu/api/1/country/222",
        id: 222
    }, {
        code: "TG",
        name: "Togo",
        created_at: "2015-04-24T01:46:50.403306",
        updated_at: "2015-04-24T01:46:50.403310",
        uri: "http://api.lobbyfacts.eu/api/1/country/221",
        id: 221
    }, {
        code: "TH",
        name: "Thailand",
        created_at: "2015-04-24T01:46:50.400840",
        updated_at: "2015-04-24T01:46:50.400849",
        uri: "http://api.lobbyfacts.eu/api/1/country/220",
        id: 220
    }, {
        code: "TZ",
        name: "Tanzania",
        created_at: "2015-04-24T01:46:50.397846",
        updated_at: "2015-04-24T01:46:50.397855",
        uri: "http://api.lobbyfacts.eu/api/1/country/219",
        id: 219
    }, {
        code: "TJ",
        name: "Tajikistan",
        created_at: "2015-04-24T01:46:50.394924",
        updated_at: "2015-04-24T01:46:50.394933",
        uri: "http://api.lobbyfacts.eu/api/1/country/218",
        id: 218
    }, {
        code: "TW",
        name: "Taiwan",
        created_at: "2015-04-24T01:46:50.391969",
        updated_at: "2015-04-24T01:46:50.391978",
        uri: "http://api.lobbyfacts.eu/api/1/country/217",
        id: 217
    }, {
        code: "SY",
        name: "Syria",
        created_at: "2015-04-24T01:46:50.389120",
        updated_at: "2015-04-24T01:46:50.389124",
        uri: "http://api.lobbyfacts.eu/api/1/country/216",
        id: 216
    }, {
        code: "CH",
        name: "Switzerland",
        created_at: "2015-04-24T01:46:50.386939",
        updated_at: "2015-04-24T01:46:50.386943",
        uri: "http://api.lobbyfacts.eu/api/1/country/215",
        id: 215
    }, {
        code: "SE",
        name: "Sweden",
        created_at: "2015-04-24T01:46:50.385345",
        updated_at: "2015-04-24T01:46:50.385349",
        uri: "http://api.lobbyfacts.eu/api/1/country/214",
        id: 214
    }, {
        code: "SZ",
        name: "Swaziland",
        created_at: "2015-04-24T01:46:50.383834",
        updated_at: "2015-04-24T01:46:50.383838",
        uri: "http://api.lobbyfacts.eu/api/1/country/213",
        id: 213
    }, {
        code: "SR",
        name: "Suriname",
        created_at: "2015-04-24T01:46:50.382073",
        updated_at: "2015-04-24T01:46:50.382078",
        uri: "http://api.lobbyfacts.eu/api/1/country/212",
        id: 212
    }, {
        code: "SD",
        name: "Sudan",
        created_at: "2015-04-24T01:46:50.380114",
        updated_at: "2015-04-24T01:46:50.380119",
        uri: "http://api.lobbyfacts.eu/api/1/country/211",
        id: 211
    }, {
        code: "LK",
        name: "Sri Lanka",
        created_at: "2015-04-24T01:46:50.378189",
        updated_at: "2015-04-24T01:46:50.378195",
        uri: "http://api.lobbyfacts.eu/api/1/country/210",
        id: 210
    }, {
        code: "ES",
        name: "Spain",
        created_at: "2015-04-24T01:46:50.376105",
        updated_at: "2015-04-24T01:46:50.376109",
        uri: "http://api.lobbyfacts.eu/api/1/country/209",
        id: 209
    }, {
        code: "SS",
        name: "South Sudan",
        created_at: "2015-04-24T01:46:50.373942",
        updated_at: "2015-04-24T01:46:50.373946",
        uri: "http://api.lobbyfacts.eu/api/1/country/208",
        id: 208
    }, {
        code: "KR",
        name: "South Korea",
        created_at: "2015-04-24T01:46:50.371790",
        updated_at: "2015-04-24T01:46:50.371794",
        uri: "http://api.lobbyfacts.eu/api/1/country/207",
        id: 207
    }, {
        code: "GS",
        name: "South Georgia & The South Sandwish Islands",
        created_at: "2015-04-24T01:46:50.369460",
        updated_at: "2015-04-24T01:46:50.369465",
        uri: "http://api.lobbyfacts.eu/api/1/country/206",
        id: 206
    }, {
        code: "ZA",
        name: "South Africa",
        created_at: "2015-04-24T01:46:50.367247",
        updated_at: "2015-04-24T01:46:50.367252",
        uri: "http://api.lobbyfacts.eu/api/1/country/205",
        id: 205
    }, {
        code: "SO",
        name: "Somaliland",
        created_at: "2015-04-24T01:46:50.362905",
        updated_at: "2016-09-18T18:34:35.724427",
        uri: "http://api.lobbyfacts.eu/api/1/country/204",
        id: 204
    }, {
        code: "SB",
        name: "Solomon Islands",
        created_at: "2015-04-24T01:46:50.360631",
        updated_at: "2015-04-24T01:46:50.360635",
        uri: "http://api.lobbyfacts.eu/api/1/country/203",
        id: 203
    }, {
        code: "SI",
        name: "Slovenia",
        created_at: "2015-04-24T01:46:50.358394",
        updated_at: "2015-04-24T01:46:50.358399",
        uri: "http://api.lobbyfacts.eu/api/1/country/202",
        id: 202
    }, {
        code: "SK",
        name: "Slovakia",
        created_at: "2015-04-24T01:46:50.356154",
        updated_at: "2015-04-24T01:46:50.356158",
        uri: "http://api.lobbyfacts.eu/api/1/country/201",
        id: 201
    }, {
        code: "SX",
        name: "Sint Maarten",
        created_at: "2015-04-24T01:46:50.353807",
        updated_at: "2015-04-24T01:46:50.353811",
        uri: "http://api.lobbyfacts.eu/api/1/country/200",
        id: 200
    }, {
        code: "SG",
        name: "Singapore",
        created_at: "2015-04-24T01:46:50.349354",
        updated_at: "2015-04-24T01:46:50.349358",
        uri: "http://api.lobbyfacts.eu/api/1/country/199",
        id: 199
    }, {
        code: "SL",
        name: "Sierra Leone",
        created_at: "2015-04-24T01:46:50.347186",
        updated_at: "2015-04-24T01:46:50.347190",
        uri: "http://api.lobbyfacts.eu/api/1/country/198",
        id: 198
    }, {
        code: "SC",
        name: "Seychelles",
        created_at: "2015-04-24T01:46:50.344980",
        updated_at: "2015-04-24T01:46:50.344984",
        uri: "http://api.lobbyfacts.eu/api/1/country/197",
        id: 197
    }, {
        code: "RS",
        name: "Serbia",
        created_at: "2015-04-24T01:46:50.342496",
        updated_at: "2015-04-24T01:46:50.342501",
        uri: "http://api.lobbyfacts.eu/api/1/country/196",
        id: 196
    }];
}

export default {
    name: "advanced_tables",
    components: {
        datatable
    },
    data() {
        return {
            rowdata: [{
                "fname": "Gale",
                "lname": "Mcmyne",
                "age": 16,
                "state": "RI",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Tighe",
                "lname": "Walls",
                "age": 43,
                "state": "AL",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Anuj",
                "lname": "Wittcop",
                "age": 16,
                "state": "MO",
                "button": "<i class='fa fa-pencil text-info mr-3 text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Elisha",
                "lname": "Mahan",
                "age": 28,
                "state": "MA",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Sutman",
                "lname": "Kiab",
                "age": 18,
                "state": "ME",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Wazir",
                "lname": "Odonoghue",
                "age": 27,
                "state": "ND",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Renardo",
                "lname": "Schuessler",
                "age": 5,
                "state": "OK",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Colleen",
                "lname": "Schotuen",
                "age": 33,
                "state": "DE",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Natalia",
                "lname": "Sacks",
                "age": 24,
                "state": "FL",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Kamaniee",
                "lname": "Knaus",
                "age": 11,
                "state": "ID",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Deena",
                "lname": "Downing",
                "age": 39,
                "state": "NM",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Gueorgui",
                "lname": "Downing",
                "age": 22,
                "state": "LA",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Toya",
                "lname": "Wallace",
                "age": 19,
                "state": "MD",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Deborah",
                "lname": "Morrison",
                "age": 14,
                "state": "VT",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Nerissa",
                "lname": "Wade",
                "age": 7,
                "state": "DE",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Glenn",
                "lname": "Bommi",
                "age": 8,
                "state": "MO",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Kate",
                "lname": "Azcunaga",
                "age": 25,
                "state": "ME",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Jesse",
                "lname": "Ingham",
                "age": 50,
                "state": "OK",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Gateri",
                "lname": "Sergent",
                "age": 50,
                "state": "MA",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }, {
                "fname": "Marian",
                "lname": "Malmfeldt",
                "age": 50,
                "state": "DC",
                "button": "<i class='fa fa-pencil text-info mr-3'></i><i class='fa fa-trash text-danger'></i>"
            }],

            columndata: [ // Array of objects
                {
                    label: 'First Name', // Column name
                    field: 'fname', // Field name from row
                    numeric: false, // Affects sorting
                    width: "200px", //width of the column
                    html: false, // Escapes output if false.
                }, {
                    label: 'Last Name',
                    field: 'lname',
                    numeric: false,
                    html: false,
                }, {
                    label: 'Age',
                    field: 'age',
                    numeric: true,
                    html: false,
                }, {
                    label: 'State',
                    field: 'state',
                    numeric: false,
                    html: false,
                }, {
                    label: 'Action',
                    field: 'button',
                    numeric: false,
                    html: true,
                }
            ],
            columns: ['id', 'name', 'age'],
            tableData: [{
                id: 1,
                name: "John",
                age: "20"
            }, {
                id: 2,
                name: "Jane",
                age: "24"
            }, {
                id: 3,
                name: "Susan",
                age: "16"
            }, {
                id: 4,
                name: "Chris",
                age: "55"
            }, {
                id: 5,
                name: "Dan",
                age: "40"
            }],
            tableData2: [],
            options: {
                sortIcon: {
                    base: 'fa',
                    up: 'fa fa-angle-up',
                    down: 'fa fa-angle-down'
                },
                // see the options API
                skin: "table-hover table-striped table-bordered",
                perPage: 7,
                // footerHeadings: true,
                highlightMatches: true,
                pagination: {
                    chunk: 3,
                    //set dropdown to true to get dropdown instead of pagenation
                    dropdown: false
                }
            },
            columnsnew: ['name', 'code', 'uri'],
            datanew: getData(),
            optionsnew: {
                sortIcon: {
                    base: 'fa',
                    up: 'fa fa-angle-up',
                    down: 'fa fa-angle-down'
                },
                pagination: {
                    chunk: 3,
                    //set dropdown to true to get dropdown instead of pagenation
                    dropdown: false
                },
                headings: {
                    name: 'Country Name',
                    code: 'Country Code',
                    uri: 'View Record'
                },
                filterable: ['name', 'code']
            }
        }
    },
    mounted() {
        axios.get("http://www.filltext.com/?rows=50&id={index}&name={firstName}~{lastName}&age={numberRange|20,60}").then(response => {
                this.tableData2 = response.data;
            })
            .catch(function(error) {

            });
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

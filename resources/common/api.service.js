import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import JwtService from "./jwt.service";

window.axios = require('axios');

const ApiService = {
    
    init() {
        Vue.use(VueAxios, axios);
        Vue.axios.defaults.baseURL = ''; // Vue.axios.defaults.baseURL = 'api/';
        Vue.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        //Jose R: Vue.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
    
    setHeader() {
        Vue.axios.defaults.headers.common["Authorization"] = `Bearer ${JwtService.getToken()}`;
    },

    query(resource, params) {
        return Vue.axios.get(resource, params).catch(error => {
            throw new Error(`[RWV] ApiService ${error}`);
        });
    },

    get(resource, slug = "") {
        if (JwtService.getToken() !== null) {
            this.setHeader();
        } else {
        }
        let params = '';
        if (!_.isNaN(slug) && slug) {
            params = '?' + slug;
        }
        if (_.isObject(slug)) {
            params = '?' + _.keys(slug).filter(key => (slug[key] != null && slug[key] !== 'null'))
                .map(key => key + '=' + slug[key]).join('&');
        }
        return Vue.axios.get(`${resource}${params}`);
        //ECR
        // return Vue.axios.get(`${resource}${params}`).catch(error => {
        //     throw new Error(`[RWV] ApiService ${error}`);
        // });
    },

    post(resource, params) {
        if (JwtService.getToken() !== null) {
            this.setHeader();
        } else {
        }
        return Vue.axios.post(`${resource}`, params);
    },

    update(resource, slug, params) {
        return Vue.axios.put(`${resource}/${slug}`, params);
    },

    put(resource, params) {
        return Vue.axios.put(`${resource}`, params);
    },

    delete(resource) {
        return Vue.axios.delete(resource);
    },

    process_request_error(error, url) {

        var object = {
            erro: "",
            typeException: "", // "duplicateEntry", "expiredSection", 
            typeMessage: "", // "error", "warn", "info", "succes",
            message: "",
        }

        object.erro = error;

        if (error.response) {
            
            if(error.response.data.message.includes("Duplicate entry")){

                object.typeException = "duplicateEntry";
                object.typeMessage = "warn";
                if (url == "users") object.message = "O e-mail do usuário informado já está cadastrado.";
                if (url == "contacts") object.message = "Onúmero de Whatsapp informado já está cadastrado.";
   
            }else if (error.response.data.message.includes("of non-object")){

                object.typeException = "expiredSection";
                object.typeMessage = "warn";
                object.message = "A conexão aberta expirou. É necessário realizar o login novamente.";
            
            }else if (error.response.data.message.includes("")){

                object.typeException = "expiredSection";
                object.typeMessage = "warn";
                object.message = "A conexão aberta expirou. É necessário realizar o login novamente.";

            }else{

                object.typeMessage = "error";
                object.message = "Não foi possível finalizar a acção realizada!";

            }

        } else if (error.request) {
            // The request was made but no response was received
            // console.log(error.request);
        } else {
            // Something happened in setting up the request that triggered an Error
            // console.log('Error', error.message);
        }
        
        return object;

    }
};

export default ApiService;

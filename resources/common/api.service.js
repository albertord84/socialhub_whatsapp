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

    process_request_error(error, url, action) {

        var object = {
            erro: "",
            typeException: "", // "duplicateEntry", "expiredSection", "WithoutConnection",
            typeMessage: "", // "error", "warn", "info", "succes",
            message: "",
        }

        object.erro = error;

        if (error.response.status == 401 && error.response.data.error.includes("Unauthorized")){
            // Quando dados de login errados
            object.typeMessage = "warn";
            object.message = "Confira os dados fornecidos para login.";
            return object;
        }

        if (error.response) {

            // console.log("error");
            // console.log(error);
            // console.log("error.response");
            // console.log(error.response);
            // console.log("error.response.data");
            // console.log(error.response.data);
            // console.log("error.response.data.message");
            // console.log(error.response.data.message);
            // console.log("error.response.data.exception");
            // console.log(error.response.data.exception);
            // console.log("error.response.status");
            // console.log(error.response.status);
            // console.log("error.response.headers");
            // console.log(error.response.headers);

            if(error.response.data.message && error.response.data.message.includes("Duplicate entry")){
                // Entrada duplicada no BD. 
                object.typeException = "duplicateEntry";
                object.typeMessage = "warn";
                if (url == "users") object.message = "O e-mail do usuário informado já está cadastrado.";
                if (url == "contacts") object.message = "O número de Whatsapp informado já está cadastrado.";

            }else if(error.response.data.message && error.response.data.message.includes("Could not resolve host")){
                
                object.typeException = "WithoutConnection";
                object.typeMessage = "warn";
                object.message = "Verifique a conexão do seu computador e do hardware à Internet.";

            }else if (error.response.data.message && error.response.data.message.includes("Trying to get property 'api_tunnel' of non-object")){
                // Quando tenta verificar número de whatsapp e o hardware está desconectado
                object.typeMessage = "warn";
                object.message = "Verifique a conexão do seu computador e do hardware à Internet.";
                
            }else if (error.response.status == 419 && error.response.data.message.includes("")){
                // Secção expirada.
                object.typeException = "expiredSection";
                object.typeMessage = "warn";
                object.message = "A conexão aberta expirou. É necessário realizar o login novamente.";

            }else if (error.response.data.message && error.response.data.message.includes("Erro enviando mensagem")){
                // Quando não se pode enviar mensagem
                object.typeMessage = "warn";
                object.message = "Não foi possível enviar a mensagem! Verifique a conexão do seu computador e do hardware à Internet.";
                
            }else{
                
                object.typeMessage = "error";
                if (url == "users" && action == "get") object.message = "Erro carregando usuários.";
                if (url == "users" && action == "add") object.message = "Erro adicionando usuário.";
                if (url == "users" && action == "update") object.message = "Erro atualizando usuário.";
                if (url == "users" && action == "delete") object.message = "Erro eliminando usuário.";
                if (url == "users" && action == "mute_notifications") object.message = "Erro atualizando notificações de som.";
                if (url == "users" && action == "update_image") object.message = "Erro atualizando a foto do perfil";

                if (url == "usersSeller" && action == "get") object.message = "Erro carregando vendedores.";
                if (url == "usersSeller" && action == "add") object.message = "Erro adicionando vendedor.";
                if (url == "usersSeller" && action == "update") object.message = "Erro atualizando vendedor.";
                if (url == "usersSeller" && action == "delete") object.message = "Erro eliminando vendedor.";

                if (url == "usersManagers" && action == "get") object.message = "Erro obtendo manager.";
                if (url == "usersManagers" && action == "add") object.message = "Erro adicionando manager.";
                if (url == "usersManagers" && action == "update") object.message = "Erro atualizando manager.";
                if (url == "usersManagers" && action == "delete") object.message = "Erro eliminando manager.";

                if (url == "usersAttendants" && action == "get") object.message = "Erro carregando attendente.";
                if (url == "usersAttendants" && action == "add") object.message = "Erro adicionando attendente.";
                if (url == "usersAttendants" && action == "update") object.message = "Erro atualizando attendente.";
                if (url == "usersAttendants" && action == "delete") object.message = "Erro eliminando attendente.";

                if (url == "contacts" && action == "get") object.message = "Erro carregando contato.";
                if (url == "contacts" && action == "add") object.message = "Erro adicionando contato.";
                if (url == "contacts" && action == "update") object.message = "Erro atualizando contato.";
                if (url == "contacts" && action == "delete") object.message = "Erro eliminando contato.";
                
                if (url == "companies" && action == "get") object.message = "Erro carregando empresa";
                if (url == "companies" && action == "add") object.message = "Erro adicionando empresa";
                if (url == "companies" && action == "update") object.message = "Erro atualizando empresa";
                if (url == "companies" && action == "delete") object.message = "Erro eliminando empresa";
                
                if (url == "rpis" && action == "get") object.message = "Erro obtendo canal de comunicação";
                if (url == "rpis" && action == "add") object.message = "Erro adicionando canal de comunicação";
                if (url == "rpis" && action == "update") object.message = "Erro atualizando canal de comunicação";
                if (url == "rpis" && action == "delete") object.message = "Erro eliminando canal de comunicação";
                
                if (url == "RPI" && action == "logout") object.message = "Erro fechando o canal de comunicação";
                
                if (url == "getBagContact" && action == "get") object.message = "Error carregando os contatos da sacola.";
                if (url == "getBagContact" && action == "add") object.message = "Error adicionando o contato da sacola.";
                
                if (url == "attendantsContacts" && action == "add") object.message = "Error adicionando contato na tabela attendantsContacts."; 
                if (url == "attendantsContacts" && action == "update") object.message = "Error atualizando contato na tabela attendantsContacts."; 
                if (url == "attendantsContacts" && action == "transferring") object.message = "Erro tranferindo o contato."; 
                
                if (url == "cep" && action == "get") object.message = "Erro validando CEP.";
                if (url == "getContactInfo" && action == "get") object.message = "Número de Whatsapp incorreto ou não existe.";
                if (url == "chats" && action == "send") object.message = "Erro enviando mensagem.";
                if (url == "chats" && action == "get") object.message = "Error carregando os contatos.";
                if (url == "login" && action == "get") object.message = "Error realizando loging.";
                if (action == "logout") object.message = "Error encerrando sessão."; 
                if (url == "password_reset" && action == "add") object.message = "Email não existe."; 
                if (url == "auth/add_user" && action == "add") object.message = "Erro adicionando usuário."; 
                if (url == "auth/password_save" && action == "add") object.message = "Erro salvando sua nova senha.";

                if (url == "blings" && action == "add") object.message = "Erro atualizando os dados da integração."; 

            }

        } else if (error.request) {
            // The request was made but no response was received
            
            // console.log("error.request");
            // console.log(error.request);
        } else {
            // Something happened in setting up the request that triggered an Error
            // console.log('some another error');
            // console.log('Error', error.message);
        }


        // console.log("error.request");
        // console.log(error.request);

        // console.log("error.config");
        // console.log(error.config);

        
        
        return object;

    }
};

export default ApiService;

// import Vue from "vue";

var regexp={
    'complete_name':{
        'regexp':'^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._-]{2,150}$',
        'error':'Confira a escrita do nome'
    },
    'cpf':{
        'regexp':'^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$',
        'error':'CPF inválido' 
    },
    'cnpj':{
        'regexp':'^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})$',
        'error':'CNPJ inválido'
    },
    'cep':{
        'regexp':'^([0-9]{5}[\-]?[0-9]{3})|([0-9]{8})$',  
        'error':'CEP inválido'
    },
    'email':{
        'regexp':'^[a-zA-Z0-9\._-]+@([a-zA-Z0-9-]{2,}[.])*[a-zA-Z]{2,}$',
        'error':'Email inválido'
    },
    'phone':{
        // 'regexp':'^(([5]{2} [1-9]{2} (?:[2-8]|9[1-9])[0-9]{3}[0-9]{4})|([5]{2}[1-9]{2}(?:[2-8]|9[1-9])[0-9]{3}[0-9]{4})|([1-9]{2} (?:[2-8]|9[1-9])[0-9]{3}[0-9]{4})|([1-9]{2}(?:[2-8]|9[1-9])[0-9]{3}[0-9]{4}))$',
        // 'regexp':'^([5]{2} [1-9]{2} [1-9][0-9]{3}-[0-9]{4})$',
        // 'regexp':'^([5]{2} [1-9]{2} [1-9][0-9]{7})|([5]{2} [1-9]{2} [1-9][0-9]{8})|([5]{2}[1-9]{2}[1-9][0-9]{7})|([5]{2}[1-9]{2}[1-9][0-9]{8})$',
        // 'regexp':'^([5]{2} [1-9]{2} [1-9][0-9]{7})|([5]{2} [1-9]{2} [1-9][0-9]{8})|([5]{2}[1-9]{2}[1-9][0-9]{7})|([5]{2}[1-9]{2}[1-9][0-9]{8})$',
        // 'regexp':'^([5]{2} [0-9]{2}[0-9][0-9]{7})|([5]{2} [0-9]{2}[0-9][0-9]{8})|([5]{2}[0-9]{2}[0-9][0-9]{7})|([5]{2}[0-9]{2}[0-9][0-9]{8}|[5]{2} [0-9]{12}|[5]{2}[0-9]{12}|[5]{2} [0-9]{9})$',
        'regexp':'^([0-9]{2} [0-9]{2}[0-9][0-9]{7})|([0-9]{2} [0-9]{2}[0-9][0-9]{8})|([0-9]{2}[0-9]{2}[0-9][0-9]{7})|([0-9]{2}[0-9]{2}[0-9][0-9]{8})|([0-9]{2}[0-9]{13})|([0-9]{2}[0-9]{12})|([0-9]{2}[0-9]{9})$',
        // 'regexp':'^([5]{2} [0-9]{12}|[5]{2}[0-9]{12})$',
        'error':'Número de telefone inválido. Confira se o número inserido corresponde a um telefone fixo e que o DDD seja válido'
    },
    'whatsapp':{
        // 'regexp':'^(([5]{2} [1-9]{2} (?:[2-8]|9[1-9])[0-9]{3}[0-9]{4})|([5]{2}[1-9]{2}(?:[2-8]|9[1-9])[0-9]{3}[0-9]{4})|([1-9]{2} (?:[2-8]|9[1-9])[0-9]{3}[0-9]{4})|([1-9]{2}(?:[2-8]|9[1-9])[0-9]{3}[0-9]{4}))$',
        // 'regexp':'^([5]{2} [1-9]{2} [1-9][0-9]{4}-[0-9]{4})$',
        // 'regexp':'^([5]{2} [1-9]{2} [1-9][0-9]{7})|([5]{2} [1-9]{2} [1-9][0-9]{8})|([5]{2}[1-9]{2}[1-9][0-9]{7})|([5]{2}[1-9]{2}[1-9][0-9]{8})$',
        // 'regexp':'^([5]{2} [0-9]{2}[0-9][0-9]{7})|([5]{2} [0-9]{2}[0-9][0-9]{8})|([5]{2}[0-9]{2}[0-9][0-9]{7})|([5]{2}[0-9]{2}[0-9][0-9]{8}|[5]{2} [0-9]{12}|[5]{2}[0-9]{12}|[5]{2} [0-9]{9})$',
        'regexp':'^([0-9]{2} [0-9]{2}[0-9][0-9]{7})|([0-9]{2} [0-9]{2}[0-9][0-9]{8})|([0-9]{2}[0-9]{2}[0-9][0-9]{7})|([0-9]{2}[0-9]{2}[0-9][0-9]{8})|([0-9]{2}[0-9]{13})|([0-9]{2}[0-9]{12})|([0-9]{2}[0-9]{9})$',
        // 'regexp':'^([5]{2} [0-9]{12}|[5]{2}[0-9]{12})$',
        'error':'Número de whatsapp inválido. Confira o número inserido.'
    },
    'date':{
        'regexp':'^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}$',
        'error':'Data inválida'
    },
    'mac':{
        'regexp':'^(([0-9a-f]{2}):){5}([0-9a-f]{2})$',
        'error':'Endereço MAC inválido'
    },
    
    'tunnel':{
        'regexp':'^[a-z A-Z0-9áÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._]{2,150}$',
        'error':'Endereço MAC inválido'
    },

    'user':{
        // 'regexp':'^[a-zA-Z0-9\._]{1,100}$',
        'regexp':'^[a-z A-Z0-9çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._]{1,100}$',
        'error':'Usuario inválido'
    },
    'password':{
        // 'regexp':'^[a-zA-Z0-9\._]{4,15}$',
        'regexp':'^[a-zA-Z0-9.,/ çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ_-]{4,15}$',
        'error':'Insira uma senha de entre 4 e 15 carateres, contendo letras e números'
    },
    
    'linkedin_profile':{
        'regexp':'^[a-zA-Z0-9\._]{1,300}$',
        'error':'Perfil de Linkedin provavelmente inválido'
    },

    'facebook_profile':{
        'regexp':'^[a-zA-Z0-9\._]{1,300}$',
        'error':'Perfil de Facebook provavelmente inválido'
    },

    'instagram_profile':{
        'regexp':'^[a-zA-Z0-9\._]{1,300}$',
        'error':'Perfil de Instagram provavelmente inválido'
    },
    'instagram_geolocation':{
        'regexp':'^[a-zA-Z-0-9\._áéíóúàèìòùâêîôûãõẽçÇ]{1,300}$',
        'error':''
    },
    'instagram_hashtag':{
        'regexp':'^[a-zA-Z0-9\._áéíóúàèìòùâêîôûãõẽçÇ]{1,300}$',
        'error':''
    },
    'email_verification_code':{
        'regexp':'^[0-9]{4}$',
        'error':''
    },

    'credit_card_cvv':{
        'regexp':'^[0-9]{3,4}$',
        'error':''
    },
    'credit_card_month':{
        'regexp':'^[0-10-9]{2,2}$',
        'error':''
    },
    'credit_card_year':{
        'regexp':'^[2-20-01-20-9]{4,4}$',
        'error':''
    },
    'credit_card_name':{
        'regexp':'^[A-Z ]{4,50}$',
        'error':''
    },
    'credit_card_visa':{
        'regexp':'^(?:4[0-9]{12}(?:[0-9]{3})?)$',   //Visa card starting with 4, length 13 or 16 digits
        'error':''
    },
    'credit_card_mastercard':{
        'regexp':'^(?:5[1-5][0-9]{14})$',  //MasterCard starting with 51 through 55, length 16 digits.
        'error':''
    },
    'credit_card_americanexprex':{
        'regexp':'^(?:3[47][0-9]{13})$',  //AmericanExpress credit card starting with 34 or 37, length 15 digits.
        'error':''
    },
    'credit_card_discover':{
        'regexp':'^(?:6(?:011|5[0-9][0-9])[0-9]{12})$', //Discover card starting with 6011, length 16 digits or starting with 5, length 15 digits.
        'error':''
    },
    'credit_card_':{
        'regexp':'^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$', //DinersClub card starting with 300 through 305, 36, or 38, length 14 digits.
        'error':''
    },
    'credit_card_elo':{
        'regexp':'^(?:((((636368)|(438935)|(504175)|(451416)|(636297))[0-9]{0,10})|((5067)|(4576)|(4011))[0-9]{0,12}))$',  //Elo credit card
        'error':''
    },
    'credit_card_hypercard':{
        'regexp':'^(?:(606282[0-9]{10}([0-9]{3})?)|(3841[0-9]{15}))$',  //Hypercard credit card
        'error':''
    },
    'ticket_bank_client_name':{
        'regexp':'^[A-Za-z ]{4,50}$',
        'error':''
    },
    'street_address':{
        // 'regexp':'^[a-zA-Z0-9. áéíóúãõẽâîô]{2,80}$',
        'regexp':'^[a-zA-Z0-9.,/ çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ_-]{1,80}$',
        'error':'Confira o nome da rua do endereço fornecido'
    },
    'complement_address':{
        // 'regexp':'^[a-zA-Z0-9.,/ áéíóúãõẽâîô]{2,80}$',
        'regexp':'^[a-zA-Z0-9.,/ çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ_-]{2,80}$',
        'error':'Confira o complemento do endereço fornecido'
    },
    'neighborhood_address':{
        // 'regexp':'^[a-zA-Z0-9. áéíóúãõẽâîô]{2,80}$',
        'regexp':'^[a-zA-Z0-9.,/ çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ_-]{2,80}$',
        'error':'Confira o nome do bairro do endereço fornecido'
    },
    'municipality_address':{
        // 'regexp':'^[a-zA-Z0-9. áéíóúãõẽâîô]{2,80}$',
        'regexp':'^[a-zA-Z0-9.,/ çÇáÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ_-]{2,80}$',
        'error':'Confira o nome da cidade do endereço fornecido'
    },
    'state_address':{
        'regexp':'^[A-Z]{2}$',
        'error':'Confira que o estado do endereço fornecido esteje correto'
    },
    'house_number':{
        'regexp':'^[0-9]{1,7}$',
        'error':'O número do endereço pode estar errado'
    },
    '':{
        'regexp':'',
        'error':''
    },
};

const validation = {
   
    check(type, string) {
        var response={
            'success':false,
            'error':regexp[type].error
        };
        if(string.match(regexp[type].regexp)){
            response.success=true;
            response.error='';
        }
        return response;
    },
    checkCPF(type, string){
        
        var response={
            'success':false,
            'error':regexp[type].error
        };
        response.success=true;
        response.error='';

        return response;
    },

    validate_cpf(type, cpf) {

        var response={
            'success':false,
            'error':regexp[type].error
        };

        if(cpf.match(regexp[type].regexp)){
            cpf = cpf.replace(/[^\d]+/g,'');    
            
            if(cpf == '') {
                return response;
            }
            // Elimina CPFs invalidos conhecidos    
            if (cpf.length != 11 || 
                cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" 
                || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" 
                || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" 
                || cpf == "99999999999"){
                return response;
            }
            // Valida 1o digito 
            var add = 0;
            for (var i=0; i < 9; i ++){
                add += parseInt(cpf.charAt(i)) * (10 - i);  
            }    
            var rev = 11 - (add % 11);  
            if(rev == 10 || rev == 11)     
                rev = 0;    
            if(rev != parseInt(cpf.charAt(9))){
                return response;
            }
            // Valida 2o digito 
            add = 0;
            for (var i = 0; i < 10; i ++){
                add += parseInt(cpf.charAt(i)) * (11 - i);  
            }
            rev = 11 - (add % 11);
            if (rev == 10 || rev == 11)
                rev = 0;
            if (rev != parseInt(cpf.charAt(10))){
                return response;
            }   
            response.success=true;
            response.error='';
            return response;

        }else{
            return response;
        }
    }


};

export default validation;

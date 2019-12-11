// import Vue from "vue";

var regexp={
    'email':{
        'regexp':'^[a-zA-Z0-9\._-]+@([a-zA-Z0-9-]{2,}[.])*[a-zA-Z]{2,}$',
        'error':'Email inválido'
    },
    'phone':{
        'regexp':'^[0-9]{2}-([0-9]{8}|[0-9]{9})$',
        'error':'Número de telefone inválido'
    },
    'date':{
        'regexp':'^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}$',
        'error':'Data inválida'
    },
    'mac':{
        'regexp':'^(([0-9a-f]{2}):){5}([0-9a-f]{2})$',
        'error':'Endereço MAC inválido'
    },
    'user':{
        'regexp':'^[a-zA-Z0-9\._]{1,100} $',
        'error':'Usuario inválido'
    },
    'password':{
        'regexp':'^[^\W_]{4}$',
        'error':'Insira uma senha com ao menos 4 carateres, contendo letras e números'
    },
    'instagram_profile':{
        'regexp':'^[a-zA-Z0-9\._]{1,300}$',
        'error':''
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
    'complete_name':{
        'regexp':'^[a-z A-Z0-9áÁéÉíÍóÓúÚàÀèÈìÌòÒùÙãÃõÕâÂêÊôÔûÛñ\._]{2,150}$',
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
    'cpf':{
        'regexp':'^[0-9]{11}$',
        'error':''
    },
    'cnpj':{
        'regexp':'^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$',
        'error':''
    },
    'cep':{
        'regexp':'^[0-9]{8}$',
        'error':''
    },
    'street_address':{
        'regexp':'^[a-zA-Z0-9. áéíóúãõẽâîô]{5,80}$',
        'error':''
    },
    'neighborhood_address':{
        'regexp':'^[a-zA-Z0-9. áéíóúãõẽâîô]{2,80}$',
        'error':''
    },
    'municipality_address':{
        'regexp':'^[a-zA-Z0-9. áéíóúãõẽâîô]{2,80}$',
        'error':''
    },
    'state_address':{
        'regexp':'^[A-Z]{2}$',
        'error':''
    },
    'house_number':{
        'regexp':'^[0-9/]{1,7}$',
        'error':''
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
    }
};

export default validation;

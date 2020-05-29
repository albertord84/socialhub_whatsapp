const layout = [
    {
        path: '/manager',
        name: 'manager',//
        component: resolve => require(['pages/socialhub/managerDashboard'], resolve),
        meta: {
            title: "Dashboard",
        }
    }, {
        path: '/manager/contacts',
        component: resolve => require(['pages/socialhub/managerContacts'], resolve),
        meta: {
            title: "Contatos",
        }
    },{
        path: '/manager/attendant',
        component: resolve => require(['pages/socialhub/managerAttendants'], resolve),
        meta: {
            title: "Atendentes",
        }
    },{
        path: '/manager/qrcode',
        component: resolve => require(['pages/socialhub/managerQRCode'], resolve),
        meta: {
            title: "QR Code",
        }
    },{
        path: '/manager/hardware',
        component: resolve => require(['pages/socialhub/managerCHECKHardware'], resolve),
        meta: {
            title: "Consultar o hardware",
        }    
    },{
        path: '/manager/audio',
        component: resolve => require(['pages/socialhub/popups/handleRecordAudio'], resolve),
        meta: {
            title: "Audio test",
        }
    },{
        path: '/manager/user_profile',    
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Perfil",
        }
    },{
        path: '/manager/bling',
        component: resolve => require(['pages/socialhub/managerBlingIntegration'], resolve),
        meta: {
            title: "Integração com o Bling",
        }
    },{
        path: '/manager/blingSales',    
        component: resolve => require(['pages/socialhub/managerBlingSales'], resolve),
        meta: {
            title: "Pedidos de venda no Bling",
        }
    },

    
    {
        path: '/manager/correios',
        component: resolve => require(['pages/socialhub/managerCorreiosIntegration'], resolve),
        meta: {
            title: "Integração",
        }
    },{
        path: '/manager/trackings',    
        component: resolve => require(['pages/socialhub/managerCorreiosTracking'], resolve),
        meta: {
            title: "Envios",
        }
    },{
        path: '/manager/correiosSatistics',    
        component: resolve => require(['pages/socialhub/managerCorreiosStatistics'], resolve),
        meta: {
            title: "Estatísticas",
        }
    },
    
    
    {
        path: '/manager/emoji',    
        component: resolve => require(['pages/socialhub/emoji'], resolve),
        meta: {
            title: "Estatísticas",
        }
    }
]
    
    export default layout

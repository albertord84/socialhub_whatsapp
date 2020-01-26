const layout = [
    {
        path: '/manager',
        name: 'manager',//
        component: resolve => require(['pages/socialhub/managerContacts'], resolve),
        meta: {
            title: "Contatos",
        }
    }, {
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
        path: '/manager/bling',
        component: resolve => require(['pages/socialhub/managerIntegrateBling'], resolve),
        meta: {
            title: "Integração com o Bling",
        }
    },{
        path: '/manager/audio',
        component: resolve => require(['pages/socialhub/popups/handleRecordAudio'], resolve),
        meta: {
            title: "Audio test",
        }
    },/*{
        path: '/manager/company',
        component: resolve => require(['pages/socialhub/managerCompany'], resolve),
        meta: {
            title: "Empresa",
        }
    },*/{
        path: '/manager/user_profile',    
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Perfil",
        }
    }
   // {
   //     path: '/manager',
   //     name: 'manager',
   //     component: resolve => require(['pages/socialhub/managerDashboard'], resolve),
   //     meta: {
   //         title: "Dashboard",
   //     }
    
    
    ]
    
    export default layout
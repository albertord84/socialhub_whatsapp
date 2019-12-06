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
// }, {
//     path: '/manager/contacts',
//     component: resolve => require(['pages/socialhub/managerContacts'], resolve),
//     meta: {
//         title: "Contatos",
//     }
// }, {
//     path: '/manager/attendant',
//     component: resolve => require(['pages/socialhub/managerAttendants'], resolve),
//     meta: {
//         title: "Chat",
//     }
// },{
//     path: '/manager/qrcode',
//     component: resolve => require(['pages/socialhub/managerQRCode'], resolve),
//     meta: {
//         title: "QR Code",
//     }
// },{
//     path: '/manager/company',
//     component: resolve => require(['pages/socialhub/managerCompany'], resolve),
//     meta: {
//         title: "Empresa",
//     }
// },{
//     path: '/manager/user_profile',    
//     component: resolve => require(['pages/socialhub/user_profile'], resolve),
//     meta: {
//         title: "Perfil",
//     }
// }


]

export default layout

const layout = [{
        path: '/seller',
        name: 'seller',
        component: resolve => require(['pages/socialhub/sellerDashboard'], resolve),
        meta: {
            title: "Dashboard",
        }
    }, {
        path: '/seller/companies',
        component: resolve => require(['pages/socialhub/sellerCompanies'], resolve),
        meta: {
            title: "Empresas",
        }
    }, {       
        path: '/seller/user_profile',
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Perfil",
        }
    }


]

export default layout
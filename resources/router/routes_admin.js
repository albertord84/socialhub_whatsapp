const layout = [{
        path: '/admin',
        name: 'admin',
        component: resolve => require(['pages/socialhub/adminDashboard'], resolve),
        meta: {
            title: "Dashboard",
        }
    }, {
        path: '/admin/sellers',
        component: resolve => require(['pages/socialhub/adminSellers'], resolve),
        meta: {
            title: "Vendedores",
        }
    }, {
        path: '/admin/configurations',
        component: resolve => require(['pages/socialhub/adminConfiguration'], resolve),
        meta: {
            title: "Configuração",
        }
    }, {
        path: '/admin/user_profile',
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Perfil",
        }
    }


]

export default layout
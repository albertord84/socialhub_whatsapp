const layout = [
    {
        path: '/visitor',
        name: 'visitor',
        component: resolve => require(['pages/socialhub/index'], resolve),
        meta: {
            title: "Dashboard",
        }
    }, {
        path: '/visitor/user_profile',
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Perfil",
        }
    }, 
]

export default layout

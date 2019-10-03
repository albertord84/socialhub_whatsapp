const layout = [
    {
        path: '/visitor',
        name: 'visitor',
        component: resolve => require(['pages/socialhub/index'], resolve),
        meta: {
            title: "Dashboard",
        }
    }, {
        path: '/visitor/chat',
        component: resolve => require(['pages/socialhub/attendantChat'], resolve),
        meta: {
            title: "Chat",
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

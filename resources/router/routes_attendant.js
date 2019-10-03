const layout = [
    {
        path: '/attendant',
        name: 'attendant',
        component: resolve => require(['pages/socialhub/index'], resolve),
        meta: {
            title: "Dashboard",
        }
    }, {
        path: '/attendant/chat',
        component: resolve => require(['pages/socialhub/attendantChat'], resolve),
        meta: {
            title: "Chat",
        }
    }, {
        path: '/attendant/user_profile',
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Perfil",
        }
    }, 
]

export default layout

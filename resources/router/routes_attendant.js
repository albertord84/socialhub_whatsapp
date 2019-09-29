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
        component: resolve => require(['pages/socialhub/attendant_chat'], resolve),
        meta: {
            title: "Chat",
        }
    }, {
        path: '/attendant/user_profile',
        component: resolve => require(['pages/socialhub/user_profile'], resolve),
        meta: {
            title: "Chat",
        }
    }, 
]

export default layout

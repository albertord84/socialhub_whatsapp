const layout = [
{
    path: '/admin',
    component: resolve => require(['pages/socialhub/admin_dashboard'], resolve),
    meta: {
        title: "Dashboard",
    }
}, {
    path: '/admin/contacts',
    component: resolve => require(['pages/socialhub/DataTableContacts'], resolve),
    meta: {
        title: "Contatos",
    }
}, {
    path: '/admin/attendant',
    component: resolve => require(['pages/socialhub/DataTableAttendants'], resolve),
    meta: {
        title: "Chat",
    }
},{
    path: '/admin/manage',
    component: resolve => require(['pages/socialhub/manage_company'], resolve),
    meta: {
        title: "Empresa",
    }
},







{
    path: '/admin/user_profile',
    name: 'admin',
    component: resolve => require(['pages/socialhub/user_profile'], resolve),
    meta: {
        title: "Dashboard",
    }
}, {
    path: '/admin/edit_user',
    //name: 'dashboard',
    component: resolve => require(['pages/socialhub/edit_user'], resolve),
    meta: {
        title: "Chat",
    }
}, {
    path: '/admin/lockscreen',
    //name: 'dashboard',
    component: resolve => require(['pages/socialhub/lockscreen'], resolve),
    meta: {
        title: "Chat",
    }
}, 


]

export default layout

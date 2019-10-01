const layout = [
{
    path: '/manager',
    name: 'manager',
    component: resolve => require(['pages/socialhub/manager_dashboard'], resolve),
    meta: {
        title: "Dashboard",
    }
}, {
    path: '/manager/contacts',
    component: resolve => require(['pages/socialhub/DataTableContacts'], resolve),
    meta: {
        title: "Contatos",
    }
}, {
    path: '/manager/attendant',
    component: resolve => require(['pages/socialhub/DataTableAttendants'], resolve),
    meta: {
        title: "Chat",
    }
},{
    path: '/manager/company',
    component: resolve => require(['pages/socialhub/manage_company'], resolve),
    meta: {
        title: "Empresa",
    }
},{
    path: '/user_profile',    
    component: resolve => require(['pages/socialhub/user_profile'], resolve),
    meta: {
        title: "Perfil",
    }
}


]

export default layout

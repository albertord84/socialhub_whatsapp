const layout = [
{
    path: '/admin',
    name: 'admin',
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
    path: '/admin/company',
    component: resolve => require(['pages/socialhub/manage_company'], resolve),
    meta: {
        title: "Empresa",
    }
},{
    path: '/user_profile',    
    component: resolve => require(['pages/socialhub/user_profile'], resolve),
    meta: {
        title: "Dashboard",
    }
}


]

export default layout

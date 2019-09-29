const layout = [
{
    path: '/admin',
    name: 'admin',
    component: resolve => require(['pages/socialhub/admin_dashboard'], resolve),
    meta: {
        title: "Dashboard",
    }
}, {
    path: '/admin/companies',
    component: resolve => require(['pages/socialhub/DataTableContacts'], resolve),
    meta: {
        title: "Empresas",
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

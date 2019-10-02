const layout = [
{
    path: '/admin',
    name: 'admin',
    component: resolve => require(['pages/socialhub/adminDashboard'], resolve),
    meta: {
        title: "Dashboard",
    }
}, {
    path: '/admin/companies',
    component: resolve => require(['pages/socialhub/managerContacts'], resolve),
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

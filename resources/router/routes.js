import routes_attendant from './routes_attendant.js'
import routes_admin from './routes_admin.js'

const routes = [
{
    path: '/admin', //para todo o que precisar de customer
    component: resolve => require(['src/layout_admin'], resolve),
    children: routes_admin
},  {
    path: '/attendant', //para todo o que precisar de customer
    component: resolve => require(['src/layout_attendant'], resolve),
    children: routes_attendant
},  {
    path: '/',
    name: 'login',
    component: resolve => require(['pages/login'], resolve),
    meta: {
        title: "Login",
    }
}, /*{
    path: '/login',
    name: 'login',
    component: resolve => require(['pages/login'], resolve),
    meta: {
        title: "Login",
    }
}, {
    path: '/register',
    name: 'register',
    component: resolve => require(['pages/register'], resolve),
    meta: {
        title: "register",
    }
}*/, {
    path: '/forgotpassword',
    name: 'forgotpassword',
    component: resolve => require(['pages/forgotpassword'], resolve),
    meta: {
        title: "Forgot Password",
    }
}, {
    path: '/reset_password/:token',
    name: 'reset_password_token',
    component: resolve => require(['pages/reset_password'], resolve),
    meta: {
        title: "Reset Password",
    }
}, {
    path: '/lockscreen',
    component: resolve => require(['pages/lockscreen'], resolve),
    meta: {
        title: "Lockscreen",
    }
}, {
    path: '/500',
    component: resolve => require(['pages/500'], resolve),
    meta: {
        title: "500",
    }
},
    {
        path: '*',
        component: resolve => require(['pages/404'], resolve),
        meta: {
            title: "404",
        }
    }
]
export default routes

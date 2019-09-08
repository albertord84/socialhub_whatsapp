const layout = [{
    path: '/',
    name: 'dashboard',
    component: resolve => require(['pages/index'], resolve),
    meta: {
        title: "Dashboard",
    }
}, {
    path: '/index2',
    component: resolve => require(['pages/index2'], resolve),
    meta: {
        title: "Dashboard2",
    }
}, {
    path: '/product_details',
    component: resolve => require(['pages/e-commerce/product_details'], resolve),
    meta: {
        title: "Product details",
    }
}, {
    path: '/product_edit',
    component: resolve => require(['pages/e-commerce/product_edit'], resolve),
    meta: {
        title: "Product Edit",
    }
}, {
    path: '/e_dashboard',
    component: resolve => require(['pages/e-commerce/e_dashboard'], resolve),
    meta: {
        title: "E dashboard",
    }
}, {
    path: '/cart_details',
    component: resolve => require(['pages/e-commerce/cart_details'], resolve),
    meta: {
        title: "Cart Details",
    }
}, {
    path: '/product_gallery',
    component: resolve => require(['pages/e-commerce/product_gallery'], resolve),
    meta: {
        title: "Product gallery",
    }
}, {
    path: 'form_elements',
    component: resolve => require(['pages/form_elements'], resolve),
    meta: {
        title: "Form Elements",
    }
}, {
    path: 'form_wizards',
    component: resolve => require(['pages/form_wizards'], resolve),
    meta: {
        title: "Form Wizards",
    }

}, {
    path: 'form_validations',
    component: resolve => require(['pages/form_validations'], resolve),
    meta: {
        title: " Form Validations",
    }
}, {
    path: 'dropdowns',
    component: resolve => require(['pages/dropdowns'], resolve),
    meta: {
        title: " Dropdowns",
    }
}, {
    path: 'cards',
    component: resolve => require(['pages/card'], resolve),
    meta: {
        title: " Cards",
    }
}, {
    path: 'buttons',
    component: resolve => require(['pages/buttons'], resolve),
    meta: {
        title: "Buttons",
    }
}, {
    path: 'radios_checkboxes',
    component: resolve => require(['pages/radios_checkboxes'], resolve),
    meta: {
        title: " Radios & Checkboxes",
    }
}, {
    path: 'vue-datepicker',
    component: resolve => require(['pages/vue-datepicker'], resolve),
    meta: {
        title: " Datepickers",
    }
}, {
    path: 'form_editors',
    component: resolve => require(['pages/form_editors'], resolve),
    meta: {
        title: " Form Editors",
    }
}, {
    path: 'notifications',
    component: resolve => require(['pages/notifications'], resolve),
    meta: {
        title: " Notifications",
    }
}, {
    path: 'modals',
    component: resolve => require(['pages/modals'], resolve),
    meta: {
        title: " Modals",
    }
}, {
    path: 'vscroll',
    component: resolve => require(['pages/vscroll'], resolve),
    meta: {
        title: " Vscroll",
    }
}, {
    path: 'vue-slider',
    component: resolve => require(['pages/vue_slider'], resolve),
    meta: {
        title: " Vue Slider",
    }
}, {
    path: 'ui_elements',
    component: resolve => require(['pages/ui_elements'], resolve),
    meta: {
        title: " UI Elements",
    }
}, {
    path: 'typography',
    component: resolve => require(['pages/typography'], resolve),
    meta: {
        title: "Typography",
    }
}, {
    path: 'api',
    component: resolve => require(['pages/api'], resolve),
    meta: {
        title: "API",
    }
}, {
    path: 'timeline',
    component: resolve => require(['pages/timeline'], resolve),
    meta: {
        title: "Timeline",
    }
}, {
    path: 'chat',
    component: resolve => require(['pages/chat'], resolve),
    meta: {
        title: "Chat",
    }
}, {
    path: 'calendar',
    component: resolve => require(['pages/calendar'], resolve),
    meta: {
        title: "Calendar",
    }
}, {
    path: 'simple_tables',
    component: resolve => require(['pages/simple_tables'], resolve),
    meta: {
        title: "Simple Tables",
    }
}, {
    path: 'advanced_tables',
    component: resolve => require(['pages/advanced_tables'], resolve),
    meta: {
        title: "Advanced Tables",
    }
}, {
    path: 'widgets',
    component: resolve => require(['pages/widgets'], resolve),
    meta: {
        title: "Widgets",
    }
}, {
    path: 'chartist',
    component: resolve => require(['pages/chartist'], resolve),
    meta: {
        title: "Chartist Charts",
    }
}, {
    path: 'frappe-charts',
    component: resolve => require(['pages/frappe_charts'], resolve),
    meta: {
        title: "Frappe Charts",
    }
}, {
    path: 'e_linecharts',
    component: resolve => require(['pages/e_linecharts'], resolve),
    meta: {
        title: "Echarts - Line",
    }
}, {
    path: 'e_barcharts',
    component: resolve => require(['pages/e_barcharts'], resolve),
    meta: {
        title: "Echarts - Bar",
    }
}, {
    path: 'e_piecharts',
    component: resolve => require(['pages/e_piecharts'], resolve),
    meta: {
        title: "Echarts - Pie",
    }
}, {
    path: 'trend_bar',
    component: resolve => require(['pages/trend_bar'], resolve),
    meta: {
        title: "Vue Trend/Bar charts",
    }
}, {
    path: 'gmaps',
    component: resolve => require(['pages/gmaps'], resolve),
    meta: {
        title: "Maps",
    }
}, {
    path: 'gallery',
    component: resolve => require(['pages/gallery'], resolve),
    meta: {
        title: "Gallery",
    }
}, {
    path: 'vue_draggable',
    component: resolve => require(['pages/vue_draggable'], resolve),
    meta: {
        title: "Vue Draggable",
    }
}, {
    path: 'image_cropper',
    component: resolve => require(['pages/image_cropper'], resolve),
    meta: {
        title: "Image Cropper",
    }
}, {
    path: 'multi_file_upload',
    component: resolve => require(['pages/multi_file_upload'], resolve),
    meta: {
        title: "Multi File Upload",
    }
}, {
    path: 'vue_dropzone',
    component: resolve => require(['pages/vue-dropzone'], resolve),
    meta: {
        title: "Vue Dropzone",
    }
}, {
    path: 'user_profile',
    component: resolve => require(['pages/user_profile'], resolve),
    meta: {
        title: "User Profile",
    }
}, {
    path: 'add_user',
    component: resolve => require(['pages/add_user'], resolve),
    meta: {
        title: "Add User",
    }
}, {
    path: 'users_list',
    component: resolve => require(['pages/users_list'], resolve),
    meta: {
        title: "Users List",
    }
}, {
    path: 'edit_profile',
    component: resolve => require(['pages/edit_user'], resolve),
    meta: {
        title: "Edit User",
    }
}, {
    path: 'edit_user/:user_id',
    component: resolve => require(['pages/edit_user'], resolve),
    meta: {
        title: "Edit User",
    }
}, {
    path: 'view_user/:user_id',
    component: resolve => require(['pages/view_user'], resolve),
    meta: {
        title: "View User",
    }
}, {
    path: 'edit_user_dashboard/:user_id',
    name: 'edit_user_dashboard',
    component: resolve => require(['pages/edit_user'], resolve),
    meta: {
        title: "Edit User",
    }
}, {
    path: 'view_user_dashboard/:user_id',
    name: 'view_user_dashboard',
    component: resolve => require(['pages/view_user'], resolve),
    meta: {
        title: "View User",
    }
}, {
    path: 'edit_user_api/:user_id',
    name: 'edit_user_api',
    component: resolve => require(['pages/edit_user'], resolve),
    meta: {
        title: "Edit User",
    }
}, {
    path: 'view_user_api/:user_id',
    name: 'view_user_api',
    component: resolve => require(['pages/view_user'], resolve),
    meta: {
        title: "View User",
    }
},
    {
    path: 'blank',
    component: resolve => require(['pages/blank'], resolve),
    meta: {
        title: "Blank",
    }
}, {
    path: 'transitions',
    component: resolve => require(['pages/transitions'], resolve),
    meta: {
        title: "Transitions",
    }
}, {
    path: 'invoice',
    component: resolve => require(['pages/invoice'], resolve),
    meta: {
        title: "Invoice",
    }
}, {
    path: 'contact_us',
    component: resolve => require(['pages/contact_us'], resolve),
    meta: {
        title: "Contact Us",
    }
}, {
    path: 'Pricing',
    component: resolve => require(['pages/pricing'], resolve),
    meta: {
        title: "Pricing",
    }
}, {
    path: 'contacts',
    component: resolve => require(['pages/contacts'], resolve),
    meta: {
        title: "Contacts",
    }
}, {
    path: 'tasks',
    component: resolve => require(['pages/tasks'], resolve),
    meta: {
        title: "Tasks",
    }
}]

export default layout

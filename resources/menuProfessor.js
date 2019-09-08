const menu_items = [

    // {
    //     name: 'Início',
    //     link: '/', //dashboardProfessor
    //     icon: 'fa fa-home'
    // },
    {
        name: 'Matérias',
        is_quiz:false,
        link: '/matters', //mattersProfessor
        icon: 'fa fa-book'
    },
    {
        name: 'Estudantes',
        is_quiz:false,
        link: '/classes',
        icon: ' fa fa-users'
    },
    // {
    //     //To ALberto
    //     name: 'Usuários',
    //     link: '/users',
    //     icon: ' fa fa-users'
    // },
    {
        name: 'Relatórios',
        is_quiz:false,
        link: '/reports',
        icon: ' fa fa-bar-chart'
    },
    {
        name: 'Presença',
        is_quiz:false,
        link: '/presence_list',
        icon: ' fa fa fa-address-card-o'
    },    
    // {
    //     name: 'Servidor',
    //     link: '/aaaa1',
    //     icon: 'fa fa-globe'
    // },
    // {
    //     name: 'Calendário', 
    //     link: '/calendar',
    //     icon: 'fa fa-calendar'
    // },
    // {
    //     name: 'Configuração',
    //     link: '/aaaa2',
    //     icon: 'fa fa-cog'
    // },
    {
        name: 'Acessar Quiz',
        is_quiz:true,
        link: '#/#',
        icon: 'fa fa-cog'
    },
    
    
];
export default menu_items;
const menu_items = [
    {
        name: 'Contatos',
        link: '/manager',
        icon: 'fa fa-address-book-o'
    },{
        name: 'Atendentes',
        link: '/manager/attendant',
        icon: ' fa fa-headphones'
    }, {
        name: 'QRCode',
        link: '/manager/qrcode',
        icon: ' fa fa-qrcode'
    }, {
        name: 'Hardware',
        link: '/manager/hardware',
        icon: 'mdi mdi-chip'
    }, {
        name: 'Bling',
        icon: 'mdi mdi-exclamation-thick mdi-rotate-45',
        child: [
            {
                name: 'Integração',
                link: '/manager/bling',
                icon: 'fa fa-angle-double-right'
            }, {
                name: 'Mensagens',
                link: '/cart_details',
                icon: 'fa fa-angle-double-right'
            }, {
                name: 'Vendas',
                link: '/cart_details',
                icon: 'fa fa-angle-double-right'
            }
        ]
},
    

    
    // {
    //     name: 'Dashboard',
    //     link: '/manager',
    //     icon: ' fa fa-home'
    // },{
    
    //  }, {
    //      name: 'Empresa',
    //      link: '/manager/company',
    //      icon: ' fa fa-building-o'
    //  },
    
];
export default menu_items;
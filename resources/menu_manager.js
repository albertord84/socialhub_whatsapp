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
        name: 'Integrações',
        icon: 'mdi mdi-settings-transfer-outline',
        child: [
            {
                name: 'Bling',
                link: '/manager/bling',
                icon: 'mdi mdi-exclamation-thick mdi-rotate-45'
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
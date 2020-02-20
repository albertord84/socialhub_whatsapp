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
        icon: 'mdi mdi-settings-transfer-outline',
        child: [
            {
                name: 'Integração',
                link: '/manager/bling',
                icon: 'mdi mdi-exclamation-thick mdi-rotate-45'
            },{
                name: 'Vendas Bling',
                link: '/manager/blingSales',
                icon: 'fa fa-users'
            }
        ]
}];
export default menu_items;
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
    }, /*{
        name: 'Hardware',
        link: '/manager/hardware',
        icon: 'mdi mdi-chip'
    },*/ {
        name: 'Bling',
        icon: 'mdi mdi-exclamation-thick mdi-rotate-45',
        child: [
            {
                name: 'Integração',
                link: '/manager/bling',
                icon: 'mdi mdi-settings-transfer-outline'
            },{
                name: 'Vendas Bling',
                link: '/manager/blingSales',
                icon: 'fa fa-users'
            }
        ]
},{
    name: 'Correios',
    icon: 'mdi mdi-mailbox-open-up-outline',
    child: [
        {
            name: 'Integração',
            link: '/manager/correios',
            icon: 'mdi mdi-settings-transfer-outline'
        },{
            name: 'Envios',
            link: '/manager/trackings',
            icon: 'mdi mdi-bus-clock'
        },{
            name: 'Estatísticas',
            link: '/manager/correiosSatistics',
            icon: 'mdi mdi-chart-line'
        }
    ]
}


];
export default menu_items;
<html>
    <head>
        <style>
            .mail-header{
                background-color: #F4F8FB;
                min-height: 100px;
                vertical-align: middle;
            }
            .mail-body{
                min-height: 300px;
            }
            .mail-footer{
                background-color: #F4F8FB;
                min-height: 100px;                
                vertical-align: middle;
            }
            .text-center{
                text-align: center;
            }
            .logo{
                font-size: 4rem;
                color: #8A40FD;
            }
            .content{
                font-size: 1rem;
                margin: 2rem;
                margin-left: 30px;
                margin-right: 30px;
                text-align: justify;
            }
            .credentials{
                margin-left: 2rem;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="mail-header text-center">
                <h1 class="logo">SocialHub</h1>                
            </div>
            <div class="mail-body">
                <br>
                <h2 class="text-center">Cadastro satisfatório</h2>                 
                <p class="content">
                    Prezado {{$User->name}}, 
                    
                    <br><br>                    
                    O cadastro da sua empresa {{$Company->name}} e da sua conta de GERENTE na ferramenta <a href="https://app.socialhub.pro"> SociaHub</a> foi criado com sucesso.
                    
                    <br><br>
                    E breve você receberá o hardware no Endereço para correspondência informado. <br>
                    Uma vez recebido, você deve entrar em contato com o nosso atendente a través do email <span style="color:black">{{$Seller->email}}</span>
                    ou do telefone <b>{{$Seller->phone}}</b> e ele irá orientar você para concluir o processo de <b>CONFIGURAÇÃO</b>.

                    <br><br>                    
                    As suas credenciais para acesso ao nosso <a href="https://app.socialhub.pro">sistema</a> são: 
                    
                    <br><br>                    
                    <b class="credentials">Usuário:</b> <span style="color:black">{{$User->email}}</span><br>
                    <b class="credentials">Senha:</b> {{$User->password}}
                
                    <br><br>
                    Muito obrigado por usar nosso serviço.<br>
                    Atte. Equipe SocialHub.
                </p>

            </div>
            <div class="mail-footer text-center">
                <br>
                <h4>SocialHub - {{date("Y")}} - Todos os direitos reservados</h4>
            </div>
        </div>
    </body>
</html>


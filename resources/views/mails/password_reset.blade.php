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
                <h2 class="text-center">Redefinição de senha</h2>                 
                <p class="content">
                    Prezado {{$data['name']}}, 
                    
                    <br><br>                    
                    Para redefinir sua senha:
                    
                    <br><br>
                    @component('mail::button', ['url' => url('/#reset_password/'.$data['token'])])
                        Clique aqui e preencha o formulário
                    @endcomponent
                    
                
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


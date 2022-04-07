<?php
require_once("conexao.php");

//CRIAR AUTOMATICAMENTE O USUARIO ADMIN
$query = $pdo->query("SELECT * FROM usuarios where nivel = 'admin'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
    $res = $pdo->query("INSERT INTO usuarios SET nome = 'Administrador', cpf = '000.000.000-00', email = '$email_adm', senha = '123', nivel = 'Admin'");
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Diário Online | SEMED Santa Rosa do Piauí</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5544089876216624" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <meta charset='UTF-8'>
    <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
    <link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
    <link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script>

    <link rel="shortcut icon" href="img/icon.ico" type="image/x-icon">
    <link rel="icon" href="img/icon.ico" type="image/x-icon">


    <style class="cp-pen-styles">
        @import url(https://fonts.googleapis.com/css?family=Open+Sans);

        .btn {
            display: inline-block;
            *display: inline;
            *zoom: 1;
            padding: 4px 10px 4px;
            margin-bottom: 0;
            font-size: 13px;
            line-height: 18px;
            color: #333333;
            text-align: center;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
            vertical-align: middle;
            background-color: #f5f5f5;
            background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
            background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: linear-gradient(top, #ffffff, #e6e6e6);
            background-repeat: repeat-x;
            filter: progid:dximagetransform.microsoft.gradient(startColorstr=#ffffff, endColorstr=#e6e6e6, GradientType=0);
            border-color: #e6e6e6 #e6e6e6 #e6e6e6;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            border: 1px solid #e6e6e6;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
            -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            *margin-left: .3em;
        }

        .btn:hover,
        .btn:active,
        .btn.active,
        .btn.disabled,
        .btn[disabled] {
            background-color: #e6e6e6;
        }

        .btn-large {
            padding: 9px 14px;
            font-size: 15px;
            line-height: normal;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .btn:hover {
            color: #333333;
            text-decoration: none;
            background-color: #e6e6e6;
            background-position: 0 -15px;
            -webkit-transition: background-position 0.1s linear;
            -moz-transition: background-position 0.1s linear;
            -ms-transition: background-position 0.1s linear;
            -o-transition: background-position 0.1s linear;
            transition: background-position 0.1s linear;
        }

        .btn-primary,
        .btn-primary:hover {
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            color: #ffffff;
        }

        .btn-primary.active {
            color: rgba(255, 255, 255, 0.75);
        }

        .btn-primary {
            background-color: #4a77d4;
            background-image: -moz-linear-gradient(top, #6eb6de, #4a77d4);
            background-image: -ms-linear-gradient(top, #6eb6de, #4a77d4);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6eb6de), to(#4a77d4));
            background-image: -webkit-linear-gradient(top, #6eb6de, #4a77d4);
            background-image: -o-linear-gradient(top, #6eb6de, #4a77d4);
            background-image: linear-gradient(top, #6eb6de, #4a77d4);
            background-repeat: repeat-x;
            filter: progid:dximagetransform.microsoft.gradient(startColorstr=#6eb6de, endColorstr=#4a77d4, GradientType=0);
            border: 1px solid #3762bc;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary.active,
        .btn-primary.disabled,
        .btn-primary[disabled] {
            filter: none;
            background-color: #4a77d4;
        }

        .btn-block {
            width: 100%;
            display: block;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;
        }

        html {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            width: 100%;
            height: 100%;
            font-family: 'Open Sans', sans-serif;
            background: #048243;
            background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -moz-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -moz-linear-gradient(-45deg, #007029 0%, #007029 100%);
            background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -webkit-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -webkit-linear-gradient(-45deg, #007029 0%, #007029 100%);
            background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -o-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -o-linear-gradient(-45deg, #007029 0%, #00541f 100%);
            background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), -ms-linear-gradient(top, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), -ms-linear-gradient(-45deg, #007029 0%, #007029 100%);
            background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104, 128, 138, .4) 10%, rgba(138, 114, 76, 0) 40%), linear-gradient(to bottom, rgba(57, 173, 219, .25) 0%, rgba(42, 60, 87, .4) 100%), linear-gradient(135deg, #007029 0%, #007029 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3E1D6D', endColorstr='#048243', GradientType=1);
        }

        .input {
            width: 100%;
            margin-bottom: 10px;
            background: rgba(0, 0, 0, 0.3);
            border: none;
            outline: none;
            padding: 10px;
            font-size: 13px;
            color: #fff;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 4px;
            box-shadow: inset 0 -5px 45px rgba(100, 100, 100, 0.2), 0 1px 1px rgba(255, 255, 255, 0.2);
            -webkit-transition: box-shadow .5s ease;
            -moz-transition: box-shadow .5s ease;
            -o-transition: box-shadow .5s ease;
            -ms-transition: box-shadow .5s ease;
            transition: box-shadow .5s ease;
        }

        .input:focus {
            box-shadow: inset 0 -5px 45px rgba(100, 100, 100, 0.4), 0 1px 1px rgba(255, 255, 255, 0.2);
        }

        .mostra {
            float: right;
            font-size: 11px;
            font-weight: bold;
            margin-top: -48px;
            text-align: right;
            cursor: pointer;
            user-select: none;
            display: inline;

        }

        .mostra:hover {
            color: #1C1C1C;
        }

        #login-container {
            padding: 0;
            box-sizing: border-box;
            font-family: Helvetica;
            color: #323232;
            border: none;
            background-color: #FFF;
            width: 400px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px 30px;
            border-radius: 10px;
            text-align: center;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);


        }

        textarea:focus,
        input:focus {
            outline: none;
        }


        a:hover {
            color: #08558B
        }

        #input-login,
        #senha {
            border: none;
            border-bottom: 2px solid #323232;
            padding: 10px;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        #input-login:focus,
        #senha:focus {
            border-bottom: 2px solid #0f7951;

        }

        #form-login {
            margin-top: 30px;
            margin-bottom: 40px;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
        }

        label,
        #input-login,
        #senha {
            display: block;
            width: 100%;
            text-align: left;
        }

        label {
            font-weight: bold;
            font-size: .8rem;
        }

        #forgot-pass {
            text-align: right;
            display: block;
            font-size: .8rem;
            margin-top: 3vh;
        }

        #entrar {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            border: none;
            margin-top: 20px;
            width: 100%;
            height: 40px;
            border-radius: 30px;
            color: #fff;
            background-color: #0f7951;
            cursor: pointer;

        }

        #entrar:hover {
            background-color: #002d10;
            transition: .5s;
        }

        p {
            font-size: 12px;
            font-weight: bold;
            color: #a2a2a2;
            display: block;
        }

        #social-container {
            margin-top: -10px;
            display: block;
        }
    </style>



</head>

<body>



    <div class="d-flex flex-column bd-highlight mb-3" id="login-container">
        <div align="center" class="mb-4">
            <img src="img/logo2.png" width="200">
        </div>
        <form id="form-login" method="post" action="autenticar.php">
            <label for="email">E-mail</label>
            <input id="input-login" type="email" name="email" placeholder="Digite seu e-mail" required="required" autocomplete="off" />
            <div>
                <label for="password">Senha</label>
                <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required="required">
                <span id="m" class="mostra" onclick="mostrarSenha()">MOSTRAR</span>
                <small><a id="forgot-pass" href="" data-toggle="modal" data-target="#modalRecuperar" title="Clique para Recuperar sua Senha">Recuperar Senha?</a></small>
                <button type="submit" id="entrar">Entrar</button>

            </div>



        </form>

        <div id=social-container>
            <p> INFORMAÇÕES E SUPORTE <br> (89) 98822-4456 <br>suporte@ediariosemed.com.br </p>


        </div>
    </div>

    <script type="text/javascript">
        function mostrarSenha() {
            var tipo = document.getElementById("senha");
            var texto = document.getElementById("m");

            if (tipo.type == "password") {
                tipo.type = "text";
                document.getElementById("m").innerHTML = "OCULTAR";
            } else {
                tipo.type = "password";
                document.getElementById("m").innerHTML = "MOSTRAR";
            }

        }
    </script>
</body>

</html>





<!-- Modal -->
<div class="modal fade" id="modalRecuperar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Recuperar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Seu Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>

                    <small>
                        <div id="mensagem">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button id="btn-fechar" type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-info">Recuperar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM OU SEM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function() {

        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "recuperar.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#mensagem').removeClass()
                if (mensagem.trim() == "Sua senha foi enviada com sucesso para o seu e-mail.") {
                    //$('#nome').val('');
                    //$('#btn-fechar').click();
                    $('#mensagem').addClass('text-success')
                } else {
                    $('#mensagem').addClass('text-danger')
                }
                $('#mensagem').text(mensagem)
            },

            cache: true,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>

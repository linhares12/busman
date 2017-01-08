<?php //var_dump($errors->isEmpty());  ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="/admin/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/admin/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/admin/plugins/iCheck/square/blue.css">

        <link rel="stylesheet" href="/css/login.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="login-background">
            <div class="filter-dark">
                <div class="row">
                    <div class="col-md-12">
                        <div class="login-right pull-right col-md-3 {{!$errors->isEmpty() ? 'collapse in' : ''}}" id="login-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="login-box">
                                        <div class="login-logo">Bus<b>Man</b></div>
                                        <div class="login-box-body">
                                            <p class="login-box-msg">Entrar no sistema</p>

                                            <form action="{{ url('/login') }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                </div>
                                                @if ($errors->has('email'))
                                                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                                @endif
                                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <input type="password" name="password" class="form-control" placeholder="Senha">
                                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                                </div>
                                                @if ($errors->has('password'))
                                                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-xs-8">
                                                        <div class="checkbox icheck">
                                                            <label>
                                                                <input type="checkbox" name="remember"> Manter-me conectado
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-xs-4">
                                                        <button type="submit" class="btn btn-block btn-flat" style="background-color: #800000; color: #fff; font-weight: bold">Entrar</button>
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                            </form>
                                            <a href="{{ url('/password/reset') }}">Esquecí minha senha</a><br>
                                        </div>
                                    </div>
                                    <div style="text-align: center" class="copyright">
                                        &copy;{{date('Y')}} Desenvolvido por <a href="https://albasolucoes.com" target="_blank">Alba Soluções Web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--div id="collapse-button"><i class="fa fa-bars" data-toggle="collapse" data-target="#login-form"></i></div-->

                        <a id="collapse-button" data-toggle="collapse" data-target="#login-form" href="#collapse1" style="text-decoration: none; color: #fff">
                            <i class="pull-right fa fa-bars"></i>
                        </a>

                        <div class="col-md-9 pull-right login-left">
                            <div class="wrapper">
                                Gerenciador de lançamentos contábeis código aberto
                            </div>
                            
                            <div class="wrapper2">
                                "O mundo pertence a quem se atreve"
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- jQuery 2.2.3 -->
        <script src="/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="/admin/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="/admin/plugins/iCheck/icheck.min.js"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
        </script>
    </body>
</html>
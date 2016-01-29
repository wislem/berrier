<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Berrier Admin Panel</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{asset('admin_assets/bootstrap/css/bootstrap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('admin_assets/dist/css/AdminLTE.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('admin_assets/plugins/iCheck/square/blue.css')}}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{url('/')}}"><b>Berr</b>ier</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                {!! BootForm::open()->action('/admin/auth/login') !!}

                @if($errors->has('general'))
                <div class="alert alert-danger">
                    {{ $errors->first('general') }}
                </div>
                @endif

                <div class="form-group has-feedback @if($errors->has('email')) has-error @endif">
                    <label class="control-label sr-only" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="form-group has-feedback @if($errors->has('password')) has-error @endif">
                    <label class="control-label sr-only" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" value="1"> Remember me
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div><!-- /.col -->
                </div>

                {!! BootForm::close() !!}

                {{--<a href="#">I forgot my password</a><br>--}}
                {{--<a href="register.html" class="text-center">Register a new membership</a>--}}

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="{{ asset('admin_assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

        <!-- Bootstrap 3.3.5 -->
        <script src="{{ asset('admin_assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- iCheck -->
        <script src="{{ asset('admin_assets/plugins/iCheck/icheck.min.js') }}"></script>
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

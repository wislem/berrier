<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="<?= csrf_token() ?>" />
        <meta name="csrf-param" content="_token" />

        <title>Berrier Admin Panel</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{asset('admin_assets/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Plugins -->
        @yield('css')
        <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin_assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('admin_assets/dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin_assets/dist/css/app.css')}}">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="{{asset('admin_assets/dist/css/skins/skin-blue.min.css')}}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>
    <body class="hold-transition skin-blue sidebar-mini"> <!--layout-boxed-->
        <div class="wrapper">

            @include('berrier::admin.partials.header');

            @include('berrier::admin.partials.left-sidebar');

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                @yield('content')

            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.3.0
                </div>
                <strong>Copyright © 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                @include('berrier::admin.partials.right-sidebar')
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.1.4 -->
        <script src="{{asset('admin_assets/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{asset('admin_assets/bootstrap/js/bootstrap.min.js')}}"></script>



        <script src="{{asset('admin_assets/plugins/fastclick/fastclick.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/bootbox/bootbox.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/select2/select2.full.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/moment/locales/el.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

        <!-- AdminLTE App -->
        <script src="{{asset('admin_assets/dist/js/app.js')}}"></script>

        @if(Session::has('msg'))
            <script>
                $.bootstrapGrowl('{{Session::get('msg')}}', {
                    type: '{{Session::get('msg_type')}}',
                    width: 'auto'
                });
            </script>
        @endif

        @yield('js')

    </body>
</html>

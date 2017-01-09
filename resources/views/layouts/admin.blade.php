
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@if(isset($title)) {{$title}}  @endif| BusMan</title>

  <link rel="icon" href="/img/icon16x16.png">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/admin/bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- bootstrap datepicker -->
<link rel="stylesheet" href="/admin/plugins/datepicker/datepicker3.css">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
  
  <!-- Select2 -->
  <link rel="stylesheet" href="/admin/plugins/select2/select2.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/admin/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/admin/dist/css/skins/_all-skins2.min.css">



 <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="/admin/plugins/iCheck/all.css">


 <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

   <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link data-require="bootstrap-css@*" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
<style>
.alert-dismissable .my-close,
.alert-dismissible .my-close {
  position: relative;
  top: -7px;
  right: -19px;
  
}
.modal-content{
  border-radius: 0px;
}
.form-control{
  border-radius: 0px;
}
.my-close {
  float: right;
  font-size: 21px;
  font-weight: bold;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  filter: alpha(opacity=20);
  opacity: .2;
}
.my-close:hover,
.my-close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
  filter: alpha(opacity=50);
  opacity: .5;
}
button.my-close {
  -webkit-appearance: none;
  
  cursor: pointer;
  background: transparent;
  border: 0;
}

.navbar{
  box-shadow: 0 5px 5px rgba(0,0,0,.1);
}

</style>

</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><i class="fa fa-home"></i> </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Bus<strong>Man</strong></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!--li>
            <a href="/mensagens" data-toggle = "tooltip" data-placement="bottom" title="Ver mensagens">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">@if(isset($msg_number)) {{$msg_number}} @else 0 @endif</span>
            </a>
          </li>
          <li>
            <a href="/tarefas" data-toggle = "tooltip" data-placement="bottom" title="Ver tarefas">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">@if(isset($tsk_number)) {{$tsk_number}} @else 0 @endif</span>
            </a>
          </li-->
          <li>
              <a>
              <i class="fa fa-user"> </i>
              <span class="hidden-xs">@if(isset(auth()->user()->email)) {{auth()->user()->email}} @endif</span>
            </a>
          </li>
          <li>
          <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle = "tooltip" data-placement="bottom"  title="Sair">Sair</a>

          <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  @include('inc.sidebar-menu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      @yield('main_content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <small class="pull-right">&copy;{{date('Y')}} Desenvolvido por <a href="https://albasolucoes.com" target="_blank">Alba Soluções Web</a></small>.
  </footer>

  

</div>
<script src="/js/functional.js"></script>
<!-- jQuery 2.2.3 -->
<script src="/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/admin/bootstrap/js/bootstrap.min.js"></script>

<!-- Form Validator -->
<!--script src="/admin/plugins/jQueryvalidation/jquery.validate.min.js"></script>
<script src="/admin/plugins/jQueryvalidation/localization/messages_pt_BR.min.js"></script-->

<!-- ChartJS 1.0.1 -->
<script src="/admin/plugins/chartjs/Chart.min.js"></script>

<!-- Select2 -->
<script src="/admin/plugins/select2/select2.full.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script-->

<!-- InputMask -->
<script src="/admin/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.numeric.extensions.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.phone.extensions.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.regex.extensions.js"></script>
<script src="/admin/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- iCheck 1.0.1 -->
<script src="/admin/plugins/iCheck/icheck.min.js"></script>

<!-- bootstrap datepicker -->
<script src="/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/admin/plugins/datepicker/locales/bootstrap-datepicker.pt.js"></script>

<!-- DataTables -->
<script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>


<!-- bootstrap color picker -->
<script src="/admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- FastClick -->
<script src="/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="/admin/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/admin/dist/js/pages/dashboard2.js"></script>


</body>
</html>

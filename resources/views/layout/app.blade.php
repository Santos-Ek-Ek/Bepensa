<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" id="token" value="{{ csrf_token() }}">
    <!-- Ruta dinámica -->
    <meta name="url_route" id="url_route" value="{{ url('/') }}">
    <title>Bepensa Inventario</title>

    <link rel="icon" href="https://www.bepensa.com/wp-content/uploads/2018/05/cropped32x32.png" sizes="32x32">

    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!-- Inicio de Vue -->

    <script src="{{ asset('vue/vue.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vue/vue.resource.js') }}" type="text/javascript"></script>

    <!-- Fin de Vue -->

    <!-- Ícono de la página -->
    <link rel="icon" href="https://www.bepensa.com/wp-content/uploads/2018/05/cropped32x32.png" sizes="32x32">

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img src="dist/img/logo.png" alt="AdminLTELogo">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ url("salir") }}" class="btn btn-primary">Cerrar sesión</a>
                </li>
                {{-- Notifications Dropdown Menu --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link" style="display: flex; justify-content: center; align-items: center;">
                <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <span class="brand-text font-weight-light"><img src="dist/img/logo.png" alt="AdminLTE Logo"
                        style="opacity: .8"></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="align-items: justify; justify-content:justify; ">
                    <div class="image"
                        style="display: flex; align-items: center; justify-content: center; margin: 0.3rem;">
                        {{-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> --}}
                        <i class="fas fa-user-circle text-white" style="font-size: 20px"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Session::get('usuario') }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item menu-open">
                      <a href="{{ url("cobro") }}" class="nav-link active">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                          Facturación
                        </p>
                      </a>
                    </li>
                    @if (Session::get('rol') === 'Administrador')
                    
                    <li class="nav-item menu-open">
                      <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                          Configuración
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ url("productos") }}" class="nav-link">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Productos</p>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ url("proveedores") }}" class="nav-link">
                            <i class="fas fa-truck nav-icon"></i>
                            <p>Proveedores</p>
                          </a>
                        </li>
                      </ul>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ url("clientes") }}" class="nav-link">
                            <i class="fas fa-address-book nav-icon"></i>
                            <p>Clientes</p>
                          </a>
                        </li>
                      </ul>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ url('cfdi') }}" class="nav-link">
                            <i class="fas fa-file-invoice nav-icon"></i>
                            <p>CFDI</p>
                          </a>
                        </li>
                      </ul>

                      <ul class="nav nav-treeview" hidden>
                        <li class="nav-item">
                          <a href="{{ url("usuarios") }}" class="nav-link">
                            <i class="fas fa-route nav-icon"></i>
                            <p>Rutas</p>
                          </a>
                        </li>
                      </ul>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ url("usuarios") }}" class="nav-link">
                            <i class="far fa-user nav-icon"></i>
                            <p>Usuarios</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    @endif
                    <!--Inventario-->
                    <li class="nav-item menu-open" hidden>
                      <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                          Inventario
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ url("inventario_retornable") }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lleno retornable</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ url("inventario_no_retornable") }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lleno no retornable</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ url("inventario_vacios") }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Vacíos, plásticos y otros</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <!--Usuarios-->
                  
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <!-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-center">
            <h1><b>BEPENSA BEBIDAS SA DE CV</b></h1>
          </div>
        </div>
      </div> -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="https://www.bepensa.com/" target="_blank">Bepensa</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer> -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @stack('scripts')
    <script defer src="script.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>

    {{-- <script>
  $(function () {
     $("#example1").DataTable({
       "responsive": true, "lengthChange": false, "autoWidth": false,
       "buttons": ["copy", "csv", "excel", "pdf", "print"]
     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
     $('#example2').DataTable({
       "paging": true,
       "lengthChange": false,
       "searching": false,
       "ordering": true,
       "info": true,
       "autoWidth": false,
       "responsive": true,
    });
 });
</script> --}}
</body>

</html>
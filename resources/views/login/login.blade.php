<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bepensa | Log in</title>
 <!-- Icono de la página -->
 <link rel="icon" href="https://www.bepensa.com/wp-content/uploads/2018/05/cropped32x32.png" sizes="32x32">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <a href="#" class="h1"><img src="dist/img/logo.png" alt=""></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg h4">Iniciar sesión</p>

      @if ($errors->has('credenciales'))
        <div class="alert alert-danger text-center">
          {{ $errors->first('credenciales') }}
        </div>
      @endif
      <form action="{{ url('login') }}" method="post">
        @csrf
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Usuario" name="usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          @error('usuario')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          @error('password')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>
        <div class="row">
          <div class="col-2">
          </div>
          <!-- /.col -->
          <div class="col-8">
            <input type="submit" value="Ingresar" class="btn btn-primary btn-block">
          </div>
          <!-- /.col -->
          <div class="col-2">
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

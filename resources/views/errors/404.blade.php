<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Happy Patient | Not Found</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

  <style>
    .error-content {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 100;
      height: 100vh;
      margin: 0;
    }
    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .code {
      border-right: 2px solid;
      font-size: 26px;
      padding: 0 15px 0 15px;
      text-align: center;
    }

    .message {
      font-size: 18px;
      text-align: center;
      padding: 7px 0 0 15px;
    }

    .btn-back-home {
      font-size: 15px;
      padding: 5px 15px 0 0;
      text-align: center;
    }
    .btn-home {
      font-size: 15px;
      padding: 5px 0 0 15px;
      text-align: center;
    }

  </style>

</head>
<body>

  <div class="d-flex justify-content-center full-height error-content">
    <div class="align-self-center">
      <div class="row">
        <div class="code">
          404
        </div>
        <div class="message">
          @if($exception->getMessage()) {{ $exception->getMessage() }} @else Not Found @endif
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="btn-back-home">
          <a href="{{ url()->previous() }}"><i class="fa fa-angle-double-left"></i> Back</a>
        </div>
        <div class="btn-home">
          <a href="{{ route('dashboard.index') }}"> Homepage</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
</body>
</html>
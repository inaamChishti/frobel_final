<!DOCTYPE html>

<html lang="en" class="default-style">

<head>
  <title>Frobel Login</title>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icon fonts -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css') }}">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="{{ asset('assets/css/appwork.css') }}" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="{{ asset('assets/css/theme-corporate.css') }}" class="theme-settings-theme-css">
  <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}" class="theme-settings-colors-css">
  <link rel="stylesheet" href="{{ asset('assets/css/uikit.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/authentication.css') }}">
  <style>
    .gradient-custom {
/* fallback for old browsers */
background: #6a11cb;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
}
img{

  width: 161px;
}
.card-body{
  background-color: #0000ff42;
}


.center-login {
  margin: 0;
  position: absolute;
  top: 30px;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
.text-uppercase{
  font-family: "Times New Roman", Times, serif;
font-weight: bold;
}
.background{
  background-image: url('{{ asset('img/background_img.png') }}');
    background-repeat: no-repeat;
    top: -100px;
    background-size: cover;
    background-attachment: fixed;
    background-position: center center;
    background-position: 0 0;
    height: 900px;

}
  </style>
</head>

<body>
  <section class="vh-100 background" >

    <div class="container py-5 h-100" style="width: 900px !important;height:400px !important">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;opacity:0.6;height:450px !important;">
            <div class="card-body p-5 " style="height:450px !important;">

              <div class="mb-md-5 mt-md-4 pb-5" style="margin-top:0 !important">

                <form method="POST" action="{{ url('custom-login') }}">
                <div class="ui-w-60" style="margin-left: 10% !important;">
                    <div class="w-80 position-relative" style="padding-bottom: 54%">
                    <img src="{{ asset('img/FrobelEducationWhite (1).png') }}" width="" alt="frobel-logo">
                    </div>
                  </div>

                <h2 class=" fw-bold mb-2 text-uppercase text-center" style="padding-bottom: 6%">Login</h2>



                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="form-group">
                      <label for="username" class="form-label">Username</label>
                          <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('email') }}" required autocomplete="email" autofocus>

                          @error('username')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>

                  <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                      </label>
                      <input type="password" id="password" class="form-control" placeholder="******" @error('password') is-invalid @enderror name="password" required >
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>

                  {{-- <div class="form-group row">
                      <div class="col-md-6 offset-md-4">
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                              <label class="form-check-label" for="remember">
                                  {{ __('Remember Me') }}
                              </label>
                          </div>
                      </div>
                  </div> --}}

                  <div class="form-group row mb-0">
                      <div class="col-md-8 offset-md-2">
                          <button type="submit" class="btn btn-primary center-login">
                              {{ __('Login') }}
                          </button>


                      </div>
                  </div>
              </form>
              </div>

              <div>

                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>




</body>

</html>

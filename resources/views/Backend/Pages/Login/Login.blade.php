<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Inventory System | Log in</title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <link rel="stylesheet" href="{{asset('Backend/plugins/fontawesome-free/css/all.min.css')}}">
      <link rel="stylesheet" href="{{asset('Backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{asset('Backend/dist/css/adminlte.min.css?v=3.2.0')}}">
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <div class="login-logo">
            <!-- <a href="#"><b>Rakib</b>Soft</a> -->
             <!-- <img src="{{asset('Backend/dist/img/avatar.png')}}" class="img-fluid" alt=""> -->
         </div>
         <div class="card">
            <div class="card-header">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              @if(Session::has('error-message'))
                    <p class="alert alert-danger">{{ Session::get('error-message') }}</p>
              @endif
            </div>
            <div class="card-body login-card-body">
               <p class="login-box-msg">Sign in to start your session</p>
               <form action="{{ route('login.functionality') }}" method="post">
                @csrf
                  <div class="input-group mb-3">
                     <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" class="form-control" placeholder="Password" name="password">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <div class="icheck-primary">
                           <input type="checkbox" id="remember">
                           <label for="remember">
                           Remember Me
                           </label>
                        </div>
                     </div>
                     <!-- <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                     </div> -->
                  </div>
               
                  <div class="social-auth-links text-center mb-3">
                    
                      <button type="submit" class="btn btn-block btn-primary">Sign in </button>
                  </div>
                </form>
               <p class="mb-1">
                  <a href="#">I forgot my password</a>
               </p>
            </div>
         </div>
      </div>
      <script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('Backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('Backend/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
   </body>
</html>
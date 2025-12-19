<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>PAK-PINDI - Forgot Password</title>

   <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
   <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
   <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
   <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
   <style>
      .auth-card {
         box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.1);
         border: none;
         border-radius: 10px;
      }
      .auth-content {
         min-height: 450px;
      }
      .password-reset-info {
         color: #6c757d;
         margin-bottom: 20px;
         font-size: 0.95rem;
         line-height: 1.6;
      }
      .back-to-login {
         color: #6c757d;
         margin-top: 20px;
         font-size: 0.9rem;
      }
      .back-to-login a {
         color: #4e73f8;
         text-decoration: none;
      }
      .back-to-login a:hover {
         text-decoration: underline;
      }
   </style>
</head>

<body class=" ">
   <!-- loader Start -->
   <div id="loading">
      <div id="loading-center">
      </div>
   </div>
   <!-- loader END -->

   <div class="wrapper">
      <section class="login-content">
         <div class="container">
            <div class="row align-items-center justify-content-center height-self-center">
               <div class="col-lg-6">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="p-3">
                              <h2 class="mb-2">Reset Password</h2>
                              <p class="password-reset-info">Forgot your password? No problem. Just enter your email address and we'll email you a password reset link.</p>
                              
                              <!-- Session Status -->
                              @if (session('status'))
                              <div class="alert alert-success mb-4" role="alert">
                                 {{ session('status') }}
                              </div>
                              @endif

                              <form method="POST" action="{{ route('password.email') }}">
                                 @csrf

                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="floating-label form-group">
                                          <input class="floating-input form-control" type="email" placeholder=" " name="email" value="{{ old('email') }}" required autofocus>
                                          <label>Email</label>
                                          @if ($errors->has('email'))
                                          <span class="text-danger">{{ $errors->first('email') }}</span>
                                          @endif
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                                 
                                 <div class="back-to-login text-center">
                                    <a href="{{ route('login') }}">Back to Login</a>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>

   <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
   <!-- Table Treeview JavaScript -->
   <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>
   <!-- Chart Custom JavaScript -->
   <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>
   <!-- Chart Custom JavaScript -->
   <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>
   <!-- app JavaScript -->
   <script src="{{ asset('backend/assets/js/app.js') }}"></script>
</body>

</html>
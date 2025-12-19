<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>PAK-PINDI</title>

      <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">

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
                                 <h2 class="mb-2">Sign In</h2>
                                 <p>Login to stay connected.</p>
                                 
                                 @if(session('2fa_required'))
                                    <div class="alert alert-info">
                                        {{ session('2fa_required') }}
                                    </div>
                                 @endif
                                 
                                 @if(session('2fa_error'))
                                    <div class="alert alert-danger">
                                        {{ session('2fa_error') }}
                                    </div>
                                 @endif
                                 
                                 @if(isset($show_otp) && $show_otp)
                                    <!-- OTP Verification Form -->
                                    <form method="POST" action="{{ route('2fa.verify') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" type="text" placeholder=" " name="otp_code" required autofocus maxlength="6" pattern="[0-9]{6}" title="Please enter a 6-digit code">
                                                    <label>Enter OTP Code</label>
                                                    @if ($errors->has('otp_code'))
                                                    <span class="text-danger">{{ $errors->first('otp_code') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Verify OTP</button>
                                        <p class="mt-3">
                                            Didn't receive the code? <a href="javascript:void(0)" onclick="resendOTP()">Resend</a>
                                        </p>
                                    </form>
                                 @else
                                    <!-- Regular Login Form -->
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" type="email" placeholder=" " value="{{ old('email') }}" name="email" required autofocus autocomplete="username">
                                                    <label>Email</label>
                                                    @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control" type="password" placeholder=" " value="{{ old('password') }}" name="password" required autofocus autocomplete="username">
                                                    <label>Password</label>
                                                    @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                                    <label class="custom-control-label control-label-1" for="remember_me">Remember Me</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                @if (Route::has('password.request'))
                                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                        <p class="mt-3">
                                            <!-- Create an Account <a href="{{ route('register') }}" class="text-primary">Sign Up</a> -->
                                        </p>
                                    </form>
                                 @endif
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
      
      <script>
        function resendOTP() {
            const userId = '{{ $user_id ?? "" }}';
            
            if (!userId) {
                alert('Session expired. Please login again.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            fetch('{{ route("2fa.resend") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'New OTP sent successfully!');
                } else {
                    alert(data.message || 'Failed to resend OTP. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
      </script>
   </body>
</html>

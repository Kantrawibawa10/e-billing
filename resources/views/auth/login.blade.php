<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../assets/images/logo/logo.png"  type="image/x-icon">
    {{-- <link rel="icon" type="image/png" href="../assets/img/logo.png"> --}}

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		     
                  <h3 class="text-left mb-4">Sistem Billing</h3>
                  <form method="POST" action="{{ route('login') }}" id="login-form">
                     @csrf
                     <div class="form-group">
                       <label for="username">{{ __('Username') }}</label>
                       <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} boxed" name="username" id="username" value="{{ old('username') }}" required autofocus>
                     </div>
                     @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('email') }}</strong>
                        </span>
                     @endif
                 
                     <div class="form-group">
                         <label for="password">{{ __('Password') }}</label>
                         <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} boxed" name="password" id="password" required>
                     </div>
                     @if ($errors->has('password'))
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                         </span>
                     @endif
                 
                     <div class="form-group" style="margin-bottom: 0px; float:left;">
                         @if (Route::has('password.request'))
                             <a href="{{ route('password.request') }}" class="forgetpwd">
                                {{ __('Forgot Your Password?') }}
                             </a>
                         @endif
                     </div>
                 
                     <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                    </div>
                  </form>
                 

               </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

	</body>
</html>


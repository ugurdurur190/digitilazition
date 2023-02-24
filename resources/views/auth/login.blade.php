<!DOCTYPE html>
<html lang="en">
<head>
	<title>SEFAMERVE</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<link href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">

	<script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>
	
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-3">

			<form method="POST" action="{{ route('login.custom') }}">
				@csrf

				<div class="form-outline mb-2 text-center">
					<h4 class="">Dijitalleşme Projeleri Yönetim Sistemi Giriş Sayfası</h4>
					
					<img src="{{asset('assets/img/header8.png')}}" alt="">
				</div>

				<div class="form-outline mb-2">
					<label class="form-label">E-posta</label>
					<input type="email" class="form-control form-control-lg" name="email" required />
				</div>

				<div class="form-outline mb-2">
					<label class="form-label">Şifre</label>
					<input type="password" class="form-control form-control-lg" name="password" required />
					@if ($errors->has('emailPassword'))
						<span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                    @endif
				</div>

				<div class="form-outline mb-2">
					<label class="form-label">ReCaptcha</label>
                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                </div> 

				<div class="form-outline mb-2 text-center">
					<button class="btn btn-dark btn-lg">Giriş</button>
				</div>

				<hr class="my-4">

				<div class="form-outline mb-2 text-center">
					<a class="btn btn-lg" href="{{ url('login/google') }}">
						<img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
					</a>
				</div>
			</form>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
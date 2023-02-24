@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#userOperations-update').on('submit', function () {
				$('#submit').attr('disabled', 'true'); 
			});
        });
    </script>

	<div class="col-lg-12">
	<h2>Hesap Bilgilerini Düzenle</h2>
	<hr/>
		<div class="card">
			<div class="card-body">
				<form action="{{ url('users/operations/update', [$users->id]) }}" method="GET" id="userOperations-update">
				
                <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $users->id }}">
				<input type="hidden" name="privilege_id" class="form-control form-control-sm" value="{{ $users->privilege_id }}">

					<div class="row">
						<div class="col-md-6 border-right">
							<div class="form-group">
								<label for="" class="control-label"><b>İsim</b></label>
								<input type="text" name="name" class="form-control form-control-sm" value="{{ $users->name }}" maxlength="50" placeholder="Maksimum 50 karakter..." required>
							</div>
                            <br/>
							
							<div class="form-group">
								<label for="" class="control-label"><b>E-posta</b></label>
								<input type="email" name="email" class="form-control form-control-sm" value="{{ $users->email }}" pattern=".+@sefamerve\.com" placeholder="kullanıcı@sefamerve.com - Maksimum 64 karakter..." maxlength="64" required>
								@if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
							</div>
							<br/>
							<div class="form-group">
								<label for="" class="control-label"><b>Şifre</b></label>
								<input type="password" name="password" class="form-control form-control
								@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" minlength="8" maxlength="256" placeholder="Minumum 8, Maksimum 256 Karakter" required>
								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							<br/>
							<div class="form-group">
								<label for="" class="control-label"><b>Şifreyi Onayla</b></label>
								<input type="password" name="password_confirmation" class="form-control form-control
								@error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password"  required>
							</div>
						</div>
					</div>
					<hr>
					<button class="btn btn-dark mr-2" id="submit">Güncelle</button>
                    <a class="btn btn-dark mr-2" href="{{ url('/') }}">Geri</a>
				</form>
			</div>
		</div>
		<br/>
	</div>
	@endsection
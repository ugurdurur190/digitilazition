@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#user-store').on('submit', function () {
				$('#submit').attr('disabled', 'true'); 
			});
        });
    </script>

	<div class="col-lg-12">
	<h2>Yeni Kullanıcı</h2>
	<hr/>
	<a class="btn btn-dark float-right mb-2" href="{{ url('users/list') }}">Kullanıcı Listesi</a>
	
		<div class="card">
			<div class="card-body">
				<form action="{{ url('users/store') }}" method="GET" id="user-store">
				@csrf
					<div class="row">
						<div class="col-md-6 border-right">
							<div class="form-group">
								<label for="" class="control-label"><b>İsim</b></label>
								<input type="text" name="name" class="form-control form-control-sm" maxlength="50" placeholder="Maksimum 50 karakter..." required>
							</div>
							<br/>
							<div class="form-group">
								<label for=""><b>Statü</b></label><br/><br/>
								<input type="radio" name="privilege_id" id="admin" onchange="disabledUnit();" required value="1"> Admin<br/><br/>
								<input type="radio" name="privilege_id" id="staff" onchange="disabledUnit();" required value="2"> Personel<br/><br/>
								<input type="radio" name="privilege_id" id="subscriber" onchange="disabledUnit();" required value="3"> Yönetici<br/><br/>
								<input type="radio" name="privilege_id" id="unitSubscriber" onchange="selectUnit();" value="4" required> Birim Yöneticisi<br/>
								
								<select name="unit_id" id="units" class="custom-select custom-select-sm" style="height:30px; width:400px;" required>
									<option value="">Birim Seç</option>
									@foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                    @endforeach
                                </select>
								<br/><br/>
								
								<input type="radio" name="privilege_id" id="developer" onchange="disabledUnit();" value="5" required> Developer<br/>
							</div>
							<br/>
							<div class="form-group">
								<label for="" class="control-label"><b>E-posta</b></label>
								<input type="email" name="email" class="form-control form-control-sm" pattern=".+@sefamerve\.com" placeholder="kullanıcı@sefamerve.com - Maksimum 64 karakter..." maxlength="64" required>
								@if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
							</div>
							<br/>
							<div class="form-group">
								<label for="" class="control-label"><b>Şifre</b></label>
								<input type="password" name="password" class="form-control form-control 
								@error('password') is-invalid @enderror" required autocomplete="current-password" minlength="8" maxlength="256" placeholder="Minumum 8, Maksimum 256 Karakter" required>
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
								@error('password') is-invalid @enderror" required autocomplete="current-password" minlength="8" maxlength="256" required>
							</div>
						</div>
					</div>
					<hr>
						<button class="btn btn-dark mr-2" id="submit">Kaydet</button>
						
						<a class="btn btn-dark mr-2" href="{{ url('users/list') }}">Geri</a>
				</form>

			
			</div>
		</div>
		<br/>
	</div>
	@endsection
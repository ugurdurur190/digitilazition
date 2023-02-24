@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#form-edit').on('submit', function () {
				$('#submit').attr('disabled', 'true');
			});
        });
    </script>
	<div class="col-lg-12">
	<h2>Form Düzenle</h2>
	<hr/>
		<div class="card">
			<div class="card-body">
				<form action="{{ url('forms/update',[$forms->id]) }}" method="GET" id="form-edit">
				
                <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $forms->id }}">
					<div class="row">
						<div class="col-md-6 border-right">
							<div class="form-group">
								<label for="" class="control-label">Başlık</label>
								<input type="text" name="title" class="form-control form-control-sm" value="{{ $forms->title }}" placeholder="Maksimum 50 karakter..." maxlength="50"  required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Açıklama</label>
								<textarea name="description" cols="30" rows="4" class="form-control" maxlength="250" placeholder="Maksimum 250 karakter..." required >{{ $forms->description }}
                                </textarea>
							</div>
						</div>
					</div>
					<hr>
					<button class="btn btn-dark mr-2" id="submit">Güncelle</button>
                    <a class="btn btn-dark mr-2" href="{{ url('forms/list') }}">Geri</a>
				</form>
			</div>
		</div>
	</div>
	@endsection
@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#voteQuestion-store').on('submit', function () {
				$('#submit').attr('disabled', 'true');
			});
        });
    </script>
	<div class="col-lg-12">
		<div class="card card-outline">
			<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
				<div class="card-tools">
				
					
					<div class="row">
						<div class="col-7">
							<h2>Proje Değerlendirme Anketi Düzenleme</h2>
						</div>
						
					</div>
					<br/>

				</div>
				@if ($message = Session::get('success'))
                    <div class="alert alert-success">   
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

              	@if ($message = Session::get('warning'))
                    <div class="alert alert-warning">   
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
			</div>

			<div class="card-body">
				<h5 style="color:#8B0000;">Proje Sahibi: </h5><p>{{$users->where('id',$projects->user_id)->value('name')}}</p>
                <br/>
				<h5 style="color:#8B0000;">Proje: </h5><p>{{ $projects->title }}</p>
                <br/>
                <h5 style="color:#8B0000;">Proje Açıklaması: </h5><p>{{ $projects->description }}</p>
            	<br/>

                @foreach($units as $unit)
                    @if($projects->unit_id == $unit->id)
                        <h5 style="color:#8B0000;">Proje Ait Olduğu Birim: </h5><p>{{ $unit->unit }}</p>
                    @endif
                @endforeach
                <br/>

				<table class="table tabe-hover table-bordered">
					<tr>
						<td><h5>Etkilenen Birim</h5></td>
						<td><h5>Onay Durumu</h5></td>
					</tr>
					@foreach($affectedUnits as $affectedUnit)
						@foreach($units as $unit)
							@if($unit->id == $affectedUnit->affected_units_id)
								<tr>
									<td>{{$unit->unit}}</td>

									@if($affectedUnit->approval == 1)
										<td style="color:#008000;"><b>Onay Verildi</b></td>
									@else
										<td style="color:#8B0000;"><b>Onaylanmadı</b></td>
									@endif
								</tr>
							@endif
						@endforeach
					@endforeach
				</table>

				<table class="table tabe-hover table-bordered">
					<colgroup>
						<col width="25%">
						<col width="10%">
						<col width="5%">
					</colgroup>
					<tr>
						<td><h5>Proje Oylama Soruları</h5></td>
						<td><h5>Puan</h5></td>
						<td class="text-center"><h5>Kaldır</h5></td>
					</tr>
					@foreach($projectVoteQuestions as $projectVoteQuestion)
						<tr>
							<td>{{$projectVoteQuestion->question}}</td>
							<td>
								<h5><pre><input type="radio" name="" value="0" disabled> 0   <input type="radio" name="" value="1" disabled> 1   <input type="radio" name="" value="2" disabled> 2   <input type="radio" name="" value="3" disabled> 3   <input type="radio" name="" value="4" disabled> 4   <input type="radio" name="" value="5" disabled> 5</pre></h5>
							</td>
							<td class="text-center">
								<form action="{{ url('projects/votes/questions/remove',[$projectVoteQuestion->id]) }}" method="GET">
									@csrf
										<input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
										<button class="btn btn-flat" type="submit" onclick="this.form.submit(); this.disabled=true;">
											<i class="fa fa-remove fa-lg" style="color: black;"></i>
										</button>
								</form>
							</td>
						</tr>
					@endforeach
				</table>

				<div class="text-center">
					<form action="{{ url('projects/votes/questions/manage/permission',[$projects->id]) }}" method="GET">
						@csrf
							<input type="hidden" name="projectTitle" class="form-control form-control-sm" value="{{ $projects->title }}">
							<button class="btn btn-dark" type="submit" onclick="this.form.submit(); this.disabled=true;">
								Projeyi Oylamaya Aç
							</button>
					</form>
				</div>

				<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModalVoteQuestion">
					Ankete Soru Ekle
				</button>
				<div class="modal fade" id="exampleModalVoteQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Değerlendirme Anketi Soru EKleme</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">

								<form action="{{ url('projects/votes/questions/store') }}" method="GET" id="voteQuestion-store">
									@csrf
										<input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
										<div class="container">
											<textarea class="bold" name="voteQuestion" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Maksimum 250 Karakter" style="height:50px; width:400px; border:none;" maxlength="250" required></textarea>
											<br/>
											<h5><pre><input type="radio" name="" value="0" disabled> 0   <input type="radio" name="" value="1" disabled> 1   <input type="radio" name="" value="2" disabled> 2   <input type="radio" name="" value="3" disabled> 3   <input type="radio" name="" value="4" disabled> 4   <input type="radio" name="" value="5" disabled> 5</pre></h5>
										</div>
										
										<div class="modal-footer">
											<input type="submit" class="btn btn-dark" value="Ekle" id="submit" />
											<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                		</div>
								</form>
							</div>
							
						</div>
					</div>
				</div>

			</div>

		</div>

		<br/>
		
		<div class="card card-outline mb-5">			
			<div class="card-header text-center" style="background-color: white;border-top:5px solid #660066;">
				<h2>Proje Değerlendirme Anketi Kaldırılan Sorular</h2>
				<p style="color:#8B0000;">*Kaldırılan Sorular Dğerlendirme Anketinden Kaldırılır Oylama da Gözükmez!</p>
			</div>
            <div class="card-body ui-sortable">
				<table class="table tabe-hover table-bordered">
					<colgroup>
						<col width="25%">
						<col width="10%">
						<col width="5%">
					</colgroup>
					<tr>
						<td><h5>Proje Oylama Soruları</h5></td>
						<td><h5>Puan</h5></td>
						<td class="text-center"><h5>Geri Yükle</h5></td>
					</tr>
					@foreach($softDelVoteQuestions as $softDelVoteQuestion)
						<tr>
							<td>{{$softDelVoteQuestion->question}}</td>
							<td>
							<h5><pre><input type="radio" name="" value="0" disabled> 0   <input type="radio" name="" value="1" disabled> 1   <input type="radio" name="" value="2" disabled> 2   <input type="radio" name="" value="3" disabled> 3   <input type="radio" name="" value="4" disabled> 4   <input type="radio" name="" value="5" disabled> 5</pre></h5>
							</td>
							<td class="text-center">
								<form action="{{ url('projects/votes/questions/restore',[$softDelVoteQuestion->id]) }}" method="GET">
									@csrf
										<input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
										<button class="btn btn-flat" type="submit" onclick="this.form.submit(); this.disabled=true;">
											<i class="fa fa-undo fa-lg" style="color: black;"></i>
										</button>
								</form>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
		
	</div>
	@endsection
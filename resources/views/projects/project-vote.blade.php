@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#vote-store').on('submit', function () {
				$('#store-submit').attr('disabled', 'true');
			});

			$('#vote-update').on('submit', function () {
				$('#update-submit').attr('disabled', 'true');
			});
        });
    </script>
	<div class="col-lg-12">
		
		<div class="card card-outline">
			<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
				<div class="card-tools">
					<h2 class="text-center">Proje Değerlendirme Anketi</h2>
					<br>
				</div>
					@if ($message = Session::get('success'))
						<div class="alert alert-success">   
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

			@if($projectDone==0)
				<form action="{{ url('projects/vote/store',[$projects->id]) }}" method="GET" id="vote-store">
					<br/>
					<table class="table tabe-hover table-bordered">
						<tr>
							<td><h5 style="color:#8B0000;">Etkilenen Birim</h5></td>
							<td><h5 style="color:#8B0000;">Onay Durumu</h5></td>
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
							<col width="40%">
							<col width="10%">
						</colgroup>
						<tr>
							<td><h5 style="color:#8B0000;">Değerlendirme Soruları</h5></td>
							<td><h5 style="color:#8B0000;">Puan</h5></td>
						</tr>
						@foreach($projectVoteQuestions as $projectVoteQuestion)
							<input type="hidden" name="questionId[]" value="{{ $projectVoteQuestion->id }}" />
							<tr>
								<td>{{$projectVoteQuestion->question}}</td>
								<td>
									<h5><pre><input type="radio" name="vote{{$loop->index}}" required value="0" > 0   <input type="radio" name="vote{{$loop->index}}" required value="1" > 1   <input type="radio" name="vote{{$loop->index}}" required value="2" > 2   <input type="radio" name="vote{{$loop->index}}" required value="3" > 3   <input type="radio" name="vote{{$loop->index}}" required value="4" > 4   <input type="radio" name="vote{{$loop->index}}" required value="5" > 5</pre></h5>
								</td>
							</tr>
						@endforeach
					</table>

					<div class="card-header-light text-center">
						<input type="submit" class="btn btn-dark" value="Gönder" id="store-submit" /> 
					</div>
					<br/>
				</form>

			@else

				<form action="{{ url('projects/vote/update',[$projects->id]) }}" method="GET" id="vote-update">
					<br/>

					<table class="table tabe-hover table-bordered">
						<tr>
							<td><h5 style="color:#8B0000;">Etkilenen Birim</h5></td>
							<td><h5 style="color:#8B0000;">Onay Durumu</h5></td>
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
							<col width="40%">
							<col width="10%">
						</colgroup>
						<tr>
							<td><h5 style="color:#8B0000;">Değerlendirme Soruları</h5></td>
							<td><h5 style="color:#8B0000;">Puan</h5></td>
						</tr>
						@foreach($projectVoteQuestions as $projectVoteQuestion)
							@foreach($votes as $vote)
								@if($vote->question_id == $projectVoteQuestion->id)
									<input type="hidden" name="questionId[]" value="{{ $projectVoteQuestion->id }}" />
									<tr>
										<td>{{$projectVoteQuestion->question}}</td>
										<td>
											<h5><pre><input type="radio" name="vote{{$loop->parent->index}}" required value="0" {{ ($vote->vote==0) ? "checked" : "" }}> 0   <input type="radio" name="vote{{$loop->parent->index}}" required value="1" {{ ($vote->vote==1) ? "checked" : "" }}> 1   <input type="radio" name="vote{{$loop->parent->index}}" required value="2" {{ ($vote->vote==2) ? "checked" : "" }}> 2   <input type="radio" name="vote{{$loop->parent->index}}" required value="3" {{ ($vote->vote==3) ? "checked" : "" }}> 3   <input type="radio" name="vote{{$loop->parent->index}}" required value="4" {{ ($vote->vote==4) ? "checked" : "" }}> 4   <input type="radio" name="vote{{$loop->parent->index}}" required value="5" {{ ($vote->vote==5) ? "checked" : "" }}> 5</pre></h5>
										</td>
									</tr>
								@endif
							@endforeach
						@endforeach


						
					</table>

					<div class="card-header-light text-center">
						<input type="submit" class="btn btn-dark" value="Gönder" id="update-submit" /> 
					</div>
					<br/>
				</form>

			@endif
			</div>
			
		</div>
		<br/>
	</div>
	@endsection
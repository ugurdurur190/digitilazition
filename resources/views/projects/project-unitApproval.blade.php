@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#unitApproval-store').on('submit', function () {
				$('#submit').attr('disabled', 'true');
			});
        });
    </script>
	<div class="col-lg-12">
		<div class="card card-outline">
			<div class="card-header" style="background-color: white;border-top:5px solid #660066;"> 
				<div class="card-tools">
					<h2 class="text-center">Proje Etkilenen Birim Onayları</h2>
				</div>
					@if ($message = Session::get('success'))
						<div class="alert alert-success">   
							<strong>{{ $message }}</strong>
						</div>
					@endif
			</div>
			
			<div class="card-body">
					<h6 style="color:#8B0000;">Proje Sahibi: <span style="color:#111111;">{{$users->where('id',$projects->user_id)->value('name')}}</span></h6>
                    <br/>
					<h6 style="color:#8B0000;">Proje: <span style="color:#111111;">{{ $projects->title }}</span></h6>
                    <br/>
                    <h6 style="color:#8B0000;">Proje Açıklaması: <span style="color:#111111;">{{ $projects->description }}</span></h6>
                    <br/>
                    @foreach($units as $unit)
                        @if($projects->unit_id == $unit->id)
                            <h6 style="color:#8B0000;">Proje Ait Olduğu Birim: <span style="color:#111111;">{{ $unit->unit }}</span></h6>
                        @endif
                    @endforeach
                    <br/>

					<div class="card-header-light text-center">
						
							
								<table class="table tabe-hover table-bordered">
									<tr>
										<td><b>Etkilenen Birim</b></td>
										<td><b>Etkilenen Birim Onayı (Hayır: 0 - Evet: 1)</b></td>
									</tr>
									@foreach($affectedUnits as $affectedUnit)
										@foreach($units as $unit)
											@if($unit->id == $affectedUnit->affected_units_id)
											<form action="{{ url('projects/units/approval/store',[$affectedUnit->id]) }}" method="GET" id="unitApproval-store">
												<input type="hidden" name="project_id" value="{{ $projects->id }}" />
												<tr>
													<td>{{$unit->unit}}</td>

													@if(Auth::user()->unit_id == $unit->id)
													
														@if($affectedUnit->approval == 0)
															<td class="rounded" style="background-color:#8B0000;">
																<h5><pre><input type="radio" name="approval{{$affectedUnit->affected_units_id}}" value="0" required {{ ($affectedUnit->approval == 0) ? "checked" : "" }}> 0   <input type="radio" name="approval{{$affectedUnit->affected_units_id}}" value="1" required {{ ($affectedUnit->approval == 1) ? "checked" : "" }}> 1</pre></h5>
															</td>
														@else
															<td class="rounded" style="background-color:#008000;">
																<h5><pre><input type="radio" name="approval{{$affectedUnit->affected_units_id}}" value="0" required {{ ($affectedUnit->approval == 0) ? "checked" : "" }}> 0   <input type="radio" name="approval{{$affectedUnit->affected_units_id}}" value="1" required {{ ($affectedUnit->approval == 1) ? "checked" : "" }}> 1</pre></h5>
															</td>
														@endif

													@else
														<td>
															<h5><pre><input type="radio" name="approval{{$affectedUnit->affected_units_id}}" value="0" onclick="return false;" {{ ($affectedUnit->approval == 0) ? "checked" : "" }}> 0   <input type="radio" name="approval{{$affectedUnit->affected_units_id}}" value="1" onclick="return false;" {{ ($affectedUnit->approval == 1) ? "checked" : "" }}> 1</pre></h5>
														</td>
													@endif
													
													@if(Auth::user()->unit_id == $unit->id)
														<td><input type="submit" class="btn btn-dark" value="Gönder" id="submit" /></td>
													@endif
												</tr>
											</form>
											@endif
										@endforeach
									@endforeach
								</table>
								
							
						
						
						
					</div>
					<br/>
				
			</div>
		</div>
	</div>
	
	

	@endsection

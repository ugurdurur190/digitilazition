@extends('layouts.menu')
@section('content')
<div class="col-lg-12">

	<div class="card card-outline card-success">

		<div class="card-header text-center dontPrint" style="background-color: white;border-top:5px solid #660066;">
			<h3 class="card-title"><b>Proje Raporu</b></h3>
			<div class="card-tools">
				<button type="button" class="btn btn-flat btn-sm bg-primary dontPrint	" data-bs-toggle="modal" data-bs-target="#exampleModal">
					<i style="color: black;">PROJE BİLGİLERİ</i>
				</button>
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">PROJE BİLGİLERİ</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>

							<div class="modal-body">
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

								<h5 style="color:#8B0000;">Etkilenen Birimler: </h5>
								@foreach($affectedUnits as $affectedUnit)
									@foreach($units as $unit)
										@if($unit->id == $affectedUnit->affected_units_id)
											<p>{{$unit->unit}}</p>
										@endif
									@endforeach
								@endforeach

								<hr color="#660066;"/>
                                <br/>

								@foreach($questions as $question)
                                        @if($question->type=="radio_opt")
                                            <div class="" >
                                                <p><b>{{ $question->question }}</b></p>
                                                @foreach($answers as $answer)
                                                    @if($answer->question_id == $question->id)
                                                        @foreach(explode(",",$answer->answer) as $k => $v)
                                                            @foreach(explode(",",$question->frm_option) as $a => $b)
                                                                @if($v==$b)
                                                                    <div class="">
                                                                        <textarea name="radio[]" style="border:none; background-color:white;" class='form-control' disabled >{{ $b }}</textarea><pre></pre>
                                                                    </div>
                                                                        
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                            <hr/>

                                           
                                            @elseif($question->type=="check_opt")
                                                <div class="" >
                                                    <p><b>{{ $question->question }}</b></p>
                                                    @foreach($answers as $answer)
                                                        @if($answer->question_id == $question->id)                                            
                                                            @foreach(explode(",",$answer->answer) as $k => $v)
                                                                @foreach(explode(",",$question->frm_option) as $a => $b)
                                                                    @if($v==$b)
                                                                        <div class="">
                                                                            <textarea name="checkBox[]" style="border:none; background-color:white;" class='form-control' disabled >{{ $b }}</textarea><pre></pre>
                                                                        </div>
                                                                    @else
                                                                        @continue
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                            <hr/>
                                            
                                            @elseif($question->type=="textfield_s")
                                                <div>
                                                    <p><b>{{ $question->question }}</b></p>
                                                    @foreach($answers as $answer)
                                                        @if($answer->question_id == $question->id)
                                                            @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                <div class="">
                                                                    <textarea name='text{{$question->id}}' style="border:none; background-color:white;" class='form-control' disabled >{{ $answer->answer}}</textarea><pre></pre>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                            <hr/>

                                            @endif

                                       
                                    @endforeach



                            
                                
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
				

		<div class="card-body ui-sortable">

			<div class="accordion" id="accordionExample">

				<div class="accordion-item">
					<h2 class="accordion-header" id="headingZero">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
							PROJE
						</button>
					</h2>
					<div id="collapseZero" class="accordion-collapse collapse show" aria-labelledby="headingZero" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<br><br>
							<h4>SIRA NO:</h4>
							<p><b>{{$projects->id}}</b></p>
							<br>
							<h4>İSİM:</h4>
							<p><b>{{$users->where('id',$projects->user_id)->value('name')}}</b></p>
							<br>
							<h4>BAŞLIK:</h4>
							<p><b>{{$projects->title}}</b></p>
							<br>
							<h4>TANIM:</h4>
							<p><b>{{$projects->description}}</b></p>
							<br>
							<h4>Birim:</h4>
							@foreach($units as $unit)
                                @if($projects->unit_id == $unit->id)
                                    <p>{{ $unit->unit }}</p>
                                @endif
                            @endforeach
							<br><br><br><br>	
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingOne">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							ETKİLENEN BİRİMLER
						</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						<div class="accordion-body">

							<table class="table tabe-hover table-bordered" style="border:none;">
								@foreach($affectedUnits as $affectedUnit)
									@foreach($units as $unit)
										@if($unit->id == $affectedUnit->affected_units_id)
											<tr style="border:none;">
												<td style="border:none;">{{$unit->unit}}</td>

												@if($affectedUnit->approval == 1)
													<td style="color:#008000; border:none;"><b>Onay Verildi</b></td>
												@else
													<td style="color:#8B0000; border:none;"><b>Onaylanmadı</b></td>
												@endif
											</tr>
										@endif
									@endforeach
								@endforeach
							</table>

						</div>
					</div>
				</div>
				

				@foreach($voteQuestions as $voteQuestion)
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingThree">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
								{{ $voteQuestion->question }}
							</button>
						</h2>
						<div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<input type="hidden" name="vote{{$loop->iteration}}" disabled value="0"> #0
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$voteRate[$loop->index][0]}}%;"></div>
								</div>{{$voteRate[$loop->index][0]}}%
								<pre></pre>

								<input type="hidden" name="vote{{$loop->iteration}}" disabled value="1"> #1
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$voteRate[$loop->index][1]}}%;"></div>
								</div>{{$voteRate[$loop->index][1]}}%
								<pre></pre>

								<input type="hidden" name="vote{{$loop->iteration}}" disabled value="2"> #2
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$voteRate[$loop->index][2]}}%;"></div>
								</div>{{$voteRate[$loop->index][2]}}%
								<pre></pre>

								<input type="hidden" name="vote{{$loop->iteration}}" disabled value="3"> #3
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$voteRate[$loop->index][3]}}%;"></div>
								</div>{{$voteRate[$loop->index][3]}}%
								<pre></pre>

								<input type="hidden" name="vote{{$loop->iteration}}" disabled value="4"> #4
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$voteRate[$loop->index][4]}}%;"></div>
								</div>{{$voteRate[$loop->index][4]}}%
								<pre></pre>

								<input type="hidden" name="vote{{$loop->iteration}}" disabled value="5"> #5
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$voteRate[$loop->index][5]}}%;"></div>
								</div>{{$voteRate[$loop->index][5]}}%
								<pre></pre>
							</div>
						</div>
					</div>
				@endforeach
				


				
			</div>
		</div>
	</div>

</div>
@endsection
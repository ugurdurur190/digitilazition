@extends('layouts.menu')
@section('content')
<div class="col-lg-12">

	<div class="row">
		<div class="col-3">
			<h3 style="color: black;">PROJE LİSTESİ</h3>
		</div>
		
	</div>
    <p style="color:#8B0000;">Bu alanda gönderilen tüm "Proje Fikirleri" bulunur. "Birim Onayı" ve "Proje Oylaması" bu alanda yapılır. </p>
	<hr style="border-color:black;">
	<div class="card card-outline mb-5">
		<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
			<br/>
			<div class="card-tools">
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
		</div>
		
		<div class="card-body">
			<table class="table tabe-hover table-bordered" style="table-layout: fixed;">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="30%">
					<col width="30%">
					<col width="15%">
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Aksiyon</th>
						@if(Auth::user()->privilege_id != '5')
							<th class="text-center">Durum</th>
						@endif
					</tr>
				</thead>
				<tbody style="border-width: 3px;">
					@foreach($projects as $project)
								<tr>
									<th class="text-center">{{$loop->iteration}}</th>
									<td class="text-center">{{$users->where('id',$project->user_id)->value('name')}}<br/></td>
									<td class="text-center">{{$project->title}}</td>
									<td class="text-center">
										<div class="btn-group" role="group" aria-label="Basic outlined example">
											<button type="button" class="btn btn-flat">
												<a href="{{ url('projects/view',[$project->id]) }}">
													<i style="color: black;" class="fa fa-eye fa-lg"></i>
												</a>
											</button>
											@if(Auth::user()->privilege_id == '1' || Auth::user()->privilege_id == '4')
											<button type="button" class="btn btn-flat">
												<a href="{{ url('projects/units/approval',[$project->id]) }}">
													<i style="color: black;" class="fa fa-edit fa-lg"></i>
												</a>
											</button>
											@endif
											@if(Auth::user()->privilege_id == '1')
											<button type="button" class="btn btn-flat">
												<a href="{{ url('projects/votes/questions/manage',[$project->id]) }}">
													<i style="color: black;" class="fa fa-cog fa-lg"></i>
												</a>
											</button>
											@endif
											@if(Auth::user()->privilege_id != '5')
											<button type="button" class="btn btn-flat">
												<a href="{{ url('projects/vote',[$project->id]) }}">
													<i style="color: black;" class="fa fa-check fa-lg"></i>
												</a>
											</button>
											@endif
											@if(Auth::user()->privilege_id == '1')
												<button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$project->id}}">
														<i style="color: black;" class="fa fa-trash fa-lg"></i>
												</button>
												<div class="modal fade" id="exampleModal{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<p style="color:#8B0000;">{{$project->title}}</P> isimli projeyi silmek istediğinize emin misiniz ?
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
																<button type="button" class="btn btn-dark" onclick="this.disabled=true;">
																	<a style="color: white; text-decoration:none;" href="{{ url('projects/delete',[$project->id]) }}">
																		Sil
																	</a>
																</button>
															</div>
														</div>
													</div>
												</div>
											@endif
										</div>
									</td>
								@if(Auth::user()->privilege_id != '5')
									@if(in_array($project->id,$voteDone))
										<td style="color:green;" class="text-center"><b> Oylandı</b></td>
									@else
										<td style="color:red;" class="text-center"><b> Oylanmadı</b></td>
									@endif
								@endif
								</tr>
					@endforeach

					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
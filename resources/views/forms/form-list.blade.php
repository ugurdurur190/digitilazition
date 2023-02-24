@extends('layouts.menu')
    @section('content')
	<div class="col-lg-12">

		<div class="row">
			<div class="col-3">
				<h3 style="color: black;">PROJE FORMLARI</h3>
			</div>
			
		</div>

	<hr style="border-color:black;">
	<p style="color:#8B0000;">Bu alanda bulunan "Proje Formları" ile proje fikirlerinizi paylaşabilirsiniz. </p>
	<div class="card card-outline  mb-5">
		<div class="card-header" style="background-color: white;border-top: 5px solid #660066">
			<div class="card-tools">
				@if(Auth::user()->privilege_id == '1')
				<a class="btn btn-block btn-sm btn-default btn-flat border-black" href="{{ url('forms/new') }}"><i style="color: black;" class="fa fa-plus"></i> YENİ FORM OLUŞTUR</a>
				@endif
				<br/><br/>
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
				<table class="table tabe-hover table-bordered" id="list">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="25%">
						<col width="25%">
					</colgroup>
					<thead style="border-width: 3px;">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Başlık</th>
							<th class="text-center">Açıklama</th>
							<th class="text-center">Aksiyon</th>
							
						</tr>
					</thead>
					<tbody style="border-width: 3px;">
						@foreach($forms as $form)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$form->title}}</td>
							<td class="text-center">{{$form->description}}</td>
							<td class="text-center">
									<div class="btn-group" role="group" aria-label="Basic outlined example">

										@if(Auth::user()->privilege_id == '1')
											<button  type="button" class="btn btn-flat">
												<a href="{{ url('forms/edit',[$form->id]) }}">
												<i style="color: black;" class="fa fa-edit fa-lg"></i>
												</a>
											</button>
										@endif

										
											<button type="button" class="btn btn-flat">
												<a href="{{ url('forms/view',[$form->id]) }}">
													<i style="color: black;" class="fa fa-eye fa-lg"></i>
												</a>
											</button>
										
											
										@if(Auth::user()->privilege_id == '1')
											<button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$form->id}}">
												<i style="color: black;" class="fa fa-trash fa-lg"></i>
											</button>

											<div class="modal fade" id="exampleModal{{$form->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
													<p style="color:#8B0000;">{{$form->title}}</P> isimli formu silmek istediğinize emin misiniz ?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
														<button type="button" class="btn btn-dark" onclick="this.disabled=true;">
															<a style="color: white; text-decoration:none;" href="{{ url('forms/delete',[$form->id]) }}">
																Sil
															</a>
														</button>
													</div>
													</div>
												</div>
											</div>
										@endif

										@if(Auth::user()->privilege_id == '1')
											<button type="button" class="btn btn-flat">
												<a href="{{ url('forms/continues-projects/view',[$form->id]) }}">
													Devam Eden Proje Gir
												</a>
											</button>
										@endif

									</div>
								</td>
							
							
							</tr>	
							@endforeach
							

					</tbody>
				</table>

			</div>
	</div>
	</div>
	@endsection
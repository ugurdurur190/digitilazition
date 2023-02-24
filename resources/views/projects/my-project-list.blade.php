@extends('layouts.menu')
@section('content')
<div class="col-lg-12">
    <h3 style="color: black;">PROJELER</h3>
    <p style="color:#8B0000;">Bu alanda "Admin" olan kullanıcılar projeleri güncelleyebilir. </p>
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
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Aksiyon</th>
					</tr>
				</thead>
				<tbody style="border-width: 3px;">
					@foreach($projects as $project)
								<tr>
									<th class="text-center">{{$loop->iteration}}</th>
									<td class="text-center">{{$users->where('id',$project->user_id)->value('name')}}<br/></td>
									<td class="text-center">{{$project->title}}</td>
									<td class="text-center">
										<button type="button" class="btn btn-flat">
											<a href="{{ url('my-projects/view',[$project->id]) }}">
												<i style="color: black;" class="fa fa-eye fa-lg"></i>
											</a>
										</button>
									</td>
								
								</tr>
					@endforeach

					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
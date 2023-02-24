@extends('layouts.menu')
@section('content')
<div class="col-lg-12">

	<div class="row">
		<div class="col-4">
			<h3 style="color: black;">TAMAMLANAN PROJELER</h3>
		</div>
		
	</div>
    <p style="color:#8B0000;">Bu alanda "Çalışma Alanındaki" tüm görevleri tamamlanan projeler bulunur. </p>
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
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="20%">
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Aksiyon</th>
						<th class="text-center">Değerlendirme Oranı</th>
						<th class="text-center">Başlangıç-Bitiş</th>
					</tr>
				</thead>
				<tbody style="border-width: 3px;">
					@foreach($completedProjects as $project)
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
											
											
                                            <button type="button" class="btn btn-flat">
												<a href="{{ url('projects/todoes/works/view',[$project->id]) }}">
													<i style="color: black;" class="fa fa-list fa-lg"></i>
												</a>
											</button>
											
											
										</div>
									</td>
								
                                    @if(empty($project->score))
										@if($votes->where('project_id',$project->id)->count() != 0)
									    	<th class="text-center"><b style="color:#ff0000;">%{{ round((($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->sum('vote')+($votes->where('project_id',$project->id)->where('privilege_id',3)->sum('vote')*10))*100) / (($voteQuestions->where('project_id',$project->id)->count()*5)*(($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->unique('user_id')->count())+($votes->where('project_id',$project->id)->where('privilege_id',3)->unique('user_id')->count()*10))),0) }}</b></th>
										@else
											<th class="text-center"><b style="color:#ff0000;">%0</b></th>
										@endif
                                    @else
                                        <th class="text-center"><b style="color:#ff0000;">%{{ $project->score }}</b></th>
                                    @endif
								
									<td class="text-center">{{ $projectActivites->where('project_id',$project->id)->min('created_at')->format('d/m/Y')  }} - {{ $projectActivites->where('project_id',$project->id)->max('created_at')->format('d/m/Y')  }}</td>
								</tr>
					@endforeach
                    

					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
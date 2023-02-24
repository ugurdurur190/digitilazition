@extends('layouts.menu')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <h2>Proje Durumları</h2>
    <hr style="border-color:black;">
    <p style="color:#8B0000;">Proje <b>"Oranı"</b>, oylamada projeye verilen puanları baz alarak hesaplanan "Proje Değerlendirme Oranıdır."</p>
    <div class="text-center" style="color:#660066 ;">
        
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
        <br/>
    </div>


    <div class="row  row-cols-1 row-cols-md-2 g-3 mb-5">
        @foreach($projects as $project)
            @if($votes->where('project_id',$project->id)->count() != 0)
            <div class="col">
                <div class="card">
                    <div class="card-header" style="background-color: white;border: 5px solid #660066">

                        <h4 class="card-title"><b>Proje Sahibi: </b>{{$users->where('id',$project->user_id)->value('name')}} (Proje-{{ $project->id}})  / 
                            <b style="color:#ff0000;">
                                Oran: %{{ round((($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->sum('vote')+($votes->where('project_id',$project->id)->where('privilege_id',3)->sum('vote')*10))*100) / (($voteQuestions->where('project_id',$project->id)->count()*5)*(($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->unique('user_id')->count())+($votes->where('project_id',$project->id)->where('privilege_id',3)->unique('user_id')->count()*10))),0) }}
                            </b>
                        </h4>
                    </div>
                    <div class="card-body" style="border-left: 5px solid #660066; border-right: 5px solid #660066">
                        <div class="container-fluid">   
                            <p><b>Başlık: </b>{{ $project->title }}</p>
                            <p class="mb-0"><b>Açıklama: </b>{{ $project->description }}</p>
                        </div>
                        <br/>
                        <canvas id="myChart{{$project->id}}" style="width:100%;max-width:600px"></canvas>

                        <script>
                            var xValues = ["0", "1", "2", "3", "4", "5"];
                            var yValues = [
                                            "{{$votes->where('project_id',$project->id)->where('vote',0)->count('vote',0)}}",
                                            "{{$votes->where('project_id',$project->id)->where('vote',1)->count('vote',1)}}",
                                            "{{$votes->where('project_id',$project->id)->where('vote',2)->count('vote',2)}}",
                                            "{{$votes->where('project_id',$project->id)->where('vote',3)->count('vote',3)}}",
                                            "{{$votes->where('project_id',$project->id)->where('vote',4)->count('vote',4)}}",
                                            "{{$votes->where('project_id',$project->id)->where('vote',5)->count('vote',5)}}",
                                          ];
                            var barColors = [
                            "#b91d47",
                            "#00aba9",
                            "#2b5797",
                            "#e8c3b9",
                            "#1e7145",
                            "#660066"
                            ];

                            new Chart("myChart{{$project->id}}", {
                            type: "pie",
                            data: {
                                labels: xValues,
                                datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                                }]
                            },
                            options: {
                                title: {
                                display: true,
                                text: "Proje Oy Oranları"
                                }
                            }
                            });
                        </script>
                    </div>
                    <div class="text-center card-footer" style="background-color: white; border: 5px solid #660066">


                        
                        <button type="button" class="btn btn-flat btn-sm" style="background-color: #660066;" data-bs-toggle="modal" data-bs-target="#exampleModal{{$project->id}}">
                            <i style="color: White;">Kullanıcı Oy Bilgisi</i>
                        </button>
                        <div class="modal fade" id="exampleModal{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Kullanıcı Oy Bilgisi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>Oy Verenler: </b></p>
                                        @foreach($votes->where('project_id',$project->id)->unique('user_email') as $v)
                                            @if($users->where('email',$v->user_email)->count() == 0)
                                                <p>{{ $v->user_email }}<b style="color:#ff0000;"> (Silinmiş Kullanıcı)</b></p>
                                            @else
                                                <p>{{ $v->user_email }}</p>
                                            @endif
                                        @endforeach
                                        <br/>
                                        <hr color="#660066;"/>
                                        <p><b>Oy Vermeyenler: </b></p>
                                            @foreach($users->where('privilege_id','<>','5') as $user)
                                                @if($votes->where('project_id',$project->id)->where('user_id',$user->id)->count() == 0)
                                                    <p>{{ $user->email }}</p>
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
            </div>
            @endif
        @endforeach
    </div>


    <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header" style="background-color: white;border: 5px solid #660066">
                         <h3 class="card-title"><b>Birim Projeleri: </b></h3>
                    </div>
                    <div class="card-body" style="border-left: 5px solid #660066; border-right: 5px solid #660066">
                        <div class="container-fluid">   
                            <p></p>
                            <p class="mb-0"></p>
                        </div>
                        <br/>

                        <canvas id="myChart" style="width:700px"></canvas>
                        
                        <script>
                            var xValues = @json($unitNames);
                            var yValues = @json($projectCounts);
                            var barColors = [
                                "#b91d47","#00aba9","#2b5797","#e8c3b9","#1e7145","#660066",
                                "#D2691E","#DAA520","#FF69B4","#4B0082","#5F9EA0","#FFD700","#00FF7F","#800000",
                                "#9932CC","#00FFFF","#000000",
                            ];

                            new Chart("myChart", {
                                type: "bar",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                    }]
                                },
                                options: {
                                    legend: {display: false},
                                    title: {
                                    display: true,
                                    text: "Birim Bazında Proje Sayısı"
                                    }
                                }
                            });
                        </script>
                    </div>

                    <div class="text-center card-footer" style="background-color: white; border: 5px solid #660066">

                    </div>
                 </div>
            </div>
    </div>
@endsection

 
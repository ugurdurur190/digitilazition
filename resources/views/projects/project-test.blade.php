@extends('layouts.menu')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
			$('#todoCommit-store').on('submit', function () {
				$('#todoCommit-submit').attr('disabled', 'true');
			});

            $('#inprogresCommit-store').on('submit', function () {
				$('#inprogresCommit-submit').attr('disabled', 'true');
			});

            $('#doneCommit-store').on('submit', function () {
				$('#doneCommit-submit').attr('disabled', 'true');
			});
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <h3>Çalışma Alanı</h3>
    <hr/>
    <div id="content">
        <div class="col">
                @foreach($teams as $team)
                    @if(Auth::user()->id == $team->user_id)
                        <a class="btn btn-block btn-sm btn-default btn-flat border-black" href="{{ url('projects/todoes/new',[$projects->id]) }}">
                            <i style="color: black;" class="fa fa-plus"></i>
                            Görev Ekle
                        </a>
                    @endif
                @endforeach
			
                @foreach($teams as $team)
                    @if(Auth::user()->id == $team->user_id)
                        <a class="btn btn-block btn-sm btn-default btn-flat border-black" href="{{ url('projects/todoes/teams/view',[$projects->id]) }}">
                            <i style="color: black;" class="fa fa-plus"></i>
                            Çalışma Takımı
                        </a>
                    @endif
                @endforeach
		</div>

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

        @if( $doneCount != 0 )
        <div class="progress" style="height: 30px; background-color:#FFFFFF; box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5);">
			<div class="progress-bar bg-info" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$completionRate}}%;"><h6>Proje Tamamlanma Oranı: %{{$completionRate}}</h6></div>
		</div>
        @endif

    <div class="card-containers">

        <div class="levels list" id="todo-list">
            <span class="leveless">YAPILACAKLAR</span>
            @foreach ($todoes as $todo)
                @if ($todo->board_id == 1)
                    <div class="todo-box rounded">

                        <section data-bs-toggle="modal" data-bs-target="#exampleModals{{ $todo->id }}">
                            
                            <p> {{ $todo->title }} </p>
                            <p>{{ $users->where('id',$todo->user_id)->value('name') }}</p>
                            <div class="modal fade" id="exampleModals{{ $todo->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Görev Ayrıntıları
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{$users->where('id',$todo->user_id)->value('name')}} bu projeyi başlattı</p>
                                             @foreach($activites as $activite)
                                                @if($todo->id == $activite->todo_id)
                                                    @if($activite->board_id == 1)
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi yapılacak kısmına aldı</p>
                                                    @elseif($activite->board_id == 2)
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi devam ettiriyor kısmına aldı</p>
                                                    @else
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi tamamladı</p>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <button class="container-fluid btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalss{{ $todo->id }}"> Yorum Alanı</button>
                        <div class="modal fade" id="exampleModalss{{ $todo->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <section>
                                            <div class="container my-5 py-5 text-dark">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-12 col-lg-10 col-xl-8">
                                                        @foreach ($commits as $commit)
                                                            @if ($commit->todo_id == $todo->id)
                                                                <div class="card mb-3"
                                                                    style="background-color: #f7f6f6;">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-start">
                                                                            <img class="rounded-circle shadow-1-strong me-3"
                                                                                src="{{ asset('assets/img/user.png') }}"
                                                                                alt="" width="40"
                                                                                height="40" />
                                                                            <div class="w-100">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <h6
                                                                                        class="text-primary fw-bold mb-0">
                                                                                        {{$users->where('id',$commit->user_id)->value('name')}}
                                                                                        <span
                                                                                            class="text-dark ms-2">{{ $commit->commit }}
                                                                                        </span>
                                                                                    </h6>
                                                                                    <p class="mb-0">
                                                                                        {{ $commit->created_at }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <form action="{{ url('projects/todoes/commits/store',[$projects->id]) }}" method="GET" id="todoCommit-store">
                                            @csrf
                                            <input type="hidden" value="{{ $todo->id }}" name="todo_id">
                                            <div class="form-group">
                                                <br>
                                                <input type="text" style="border: solid 1px" name="commit"
                                                    maxlength="250" placeholder="Maksimum 250 karakter..."
                                                    class="form-control form-control-sm container-fluid" required>
                                                <br>
                                            </div>
                                            <button class="btn btn-dark" id="todoCommit-submit"><i class="fa fa-paper-plane"></i></button>
                                            <button type="button" class="btn btn-dark text-right" data-bs-dismiss="modal">Geri</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                            @if(Auth::user()->name == $users->where('id',$todo->user_id)->value('name'))
                                <div class="form-group">
                                    <form action="{{ url('projects/todoes/update',[$projects->id]) }}" method="GET">
                                        @csrf
                                            <input type="hidden" name="id" class="form-control form-control-sm" value="{{$todo->id}}" required>
                                            <select name="board_id" style="background-color:white; color:#0d6efd; border:none;" onchange="this.form.submit()" required>
                                                <option value="">Durum</option> 
                                                <option value=1>Yapılacak</option>
                                                <option value=2>Devam Ediyor</option>
                                                <option value=3>Tamamlananlar</option>
                                            </select>
                                    </form>
                                </div>
                                <br/>
                            @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="levels list" id="inprogress-list">
            <span class="leveless">DEVAM EDENLER</span>
            @foreach ($todoes as $todo)
                @if ($todo->board_id == 2)
                    <div class="todo-box rounded">

                        <section data-bs-toggle="modal" data-bs-target="#exampleModals{{ $todo->id }}">
                            <p> {{ $todo->title }} </p>
                            <p>{{$users->where('id',$todo->user_id)->value('name')}}</p>
                            <div class="modal fade" id="exampleModals{{ $todo->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Görev Ayrıntıları
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{$users->where('id',$todo->user_id)->value('name')}} bu projeyi başlattı</p>
                                             @foreach($activites as $activite)
                                                @if($todo->id == $activite->todo_id)
                                                    @if($activite->board_id == 1)
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi yapılacak kısmına aldı</p>
                                                    @elseif($activite->board_id == 2)
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi devam ettiriyor kısmına aldı</p>
                                                    @else
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi tamamladı</p>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <button class="container-fluid btn btn-dark mb-2" data-bs-toggle="modal"
                            data-bs-target="#exampleModalss{{ $todo->id }}"> Yorum Alanı</button>
                        <div class="modal fade" id="exampleModalss{{ $todo->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <section>
                                            <div class="container my-5 py-5 text-dark">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-12 col-lg-10 col-xl-8">
                                                        @foreach ($commits as $commit)
                                                            @if ($commit->todo_id == $todo->id)
                                                                <div class="card mb-3"
                                                                    style="background-color: #f7f6f6;">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-start">
                                                                            <img class="rounded-circle shadow-1-strong me-3"
                                                                                src="{{ asset('assets/img/user.png') }}"
                                                                                alt="" width="40"
                                                                                height="40" />
                                                                            <div class="w-100">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <h6
                                                                                        class="text-primary fw-bold mb-0">
                                                                                        {{$users->where('id',$commit->user_id)->value('name')}}
                                                                                        <span
                                                                                            class="text-dark ms-2">{{ $commit->commit }}
                                                                                        </span>
                                                                                    </h6>
                                                                                    <p class="mb-0">
                                                                                        {{ $commit->created_at }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <form action="{{ url('projects/todoes/commits/store',[$projects->id]) }}" method="GET" id="inprogresCommit-store">
                                            @csrf
                                            <input type="hidden" value="{{ $todo->id }}" name="todo_id">
                                            <div class="form-group">
                                                <br>
                                                <input type="text" style="border: solid 1px" name="commit"
                                                    maxlength="250" placeholder="Maksimum 250 karakter..."
                                                    class="form-control form-control-sm container-fluid" required>
                                                <br>
                                            </div>
                                            <button class="btn btn-dark" id="inprogresCommit-submit"><i class="fa fa-paper-plane"></i></button>
                                            <button type="button" class="btn btn-dark text-right" data-bs-dismiss="modal">Geri</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                            @if(Auth::user()->name == $users->where('id',$todo->user_id)->value('name'))
                            <div class="form-group">
                                    <form action="{{ url('projects/todoes/update',[$projects->id]) }}" method="GET">
                                        @csrf
                                            <input type="hidden" name="id" class="form-control form-control-sm" value="{{$todo->id}}" required>
                                            <select name="board_id" style="background-color:white; color:#0d6efd; border:none;" onchange="this.form.submit()" required>
                                                <option value="">Durum</option> 
                                                <option value=1>Yapılacak</option>
                                                <option value=2>Devam Ediyor</option>
                                                <option value=3>Tamamlananlar</option>
                                            </select>
                                    </form>
                                </div>
                                <br/>
                            @endif

                    </div>
                @endif
            @endforeach
        </div>
        <div class="levels list" id="done-list">
            <span class="leveless">TAMAMLANANLAR</span>
            <!-- <button id="addsection" class="btn btn-dark btn-sm">Yeni Görev Ekle</button> -->
            @foreach ($todoes as $todo)
                @if ($todo->board_id == 3)
                    <div class="todo-box rounded">

                        <section data-bs-toggle="modal" data-bs-target="#exampleModals{{ $todo->id }}">
                            <p> {{ $todo->title }} </p>
                            <p>{{$users->where('id',$todo->user_id)->value('name')}}</p>
                            <div class="modal fade" id="exampleModals{{ $todo->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Görev Ayrıntıları
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{$users->where('id',$todo->user_id)->value('name')}} bu projeyi başlattı</p>
                                             @foreach($activites as $activite)
                                                @if($todo->id == $activite->todo_id)
                                                    @if($activite->board_id == 1)
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi yapılacak kısmına aldı</p>
                                                    @elseif($activite->board_id == 2)
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi devam ettiriyor kısmına aldı</p>
                                                    @else
                                                    <p>{{$users->where('id',$activite->user_id)->value('name')}} bu projeyi tamamladı</p>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                        <button class="container-fluid btn btn-dark mb-2" data-bs-toggle="modal"
                            data-bs-target="#exampleModalss{{ $todo->id }}"> Yorum Alanı</button>
                        <div class="modal fade" id="exampleModalss{{ $todo->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <section>
                                            <div class="container my-5 py-5 text-dark">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-12 col-lg-10 col-xl-8">
                                                        @foreach ($commits as $commit)
                                                            @if ($commit->todo_id == $todo->id)
                                                                <div class="card mb-3"
                                                                    style="background-color: #f7f6f6;">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-start">
                                                                            <img class="rounded-circle shadow-1-strong me-3"
                                                                                src="{{ asset('assets/img/user.png') }}"
                                                                                alt="" width="40"
                                                                                height="40" />
                                                                            <div class="w-100">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <h6
                                                                                        class="text-primary fw-bold mb-0">
                                                                                        {{$users->where('id',$commit->user_id)->value('name')}}
                                                                                        <span
                                                                                            class="text-dark ms-2">{{ $commit->commit }}
                                                                                        </span>
                                                                                    </h6>
                                                                                    <p class="mb-0">
                                                                                        {{ $commit->created_at }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <form action="{{ url('projects/todoes/commits/store',[$projects->id]) }}" method="GET" id="doneCommit-store">
                                            @csrf
                                            <input type="hidden" value="{{ $todo->id }}" name="todo_id">
                                            <div class="form-group">
                                                <br>
                                                <input type="text" style="border: solid 1px" name="commit"
                                                    maxlength="250" placeholder="Maksimum 250 karakter..."
                                                    class="form-control form-control-sm container-fluid" required>
                                                <br>
                                            </div>
                                            <button class="btn btn-dark" id="doneCommit-submit"><i class="fa fa-paper-plane"></i></button>
                                            <button type="button" class="btn btn-dark text-right" data-bs-dismiss="modal">Geri</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        
                            @if(Auth::user()->name == $users->where('id',$todo->user_id)->value('name'))
                            <div class="form-group">
                                    <form action="{{ url('projects/todoes/update',[$projects->id]) }}" method="GET">
                                        @csrf
                                            <input type="hidden" name="id" class="form-control form-control-sm" value="{{$todo->id}}" required>
                                            <select name="board_id" style="background-color:white; color:#0d6efd; border:none;" onchange="this.form.submit()" required>
                                                <option value="">Durum</option> 
                                                <option value=1>Yapılacak</option>
                                                <option value=2>Devam Ediyor</option>
                                                <option value=3>Tamamlananlar</option>
                                            </select>
                                    </form>
                                </div>
                                <br/>
                            @endif 

                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>
@endsection
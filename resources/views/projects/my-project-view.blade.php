@extends('layouts.menu')
    @section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- En az bir tane checkbox işaretli mi kontrol eder. -->
    <script type="text/javascript">
            $(document).ready(function(){
            var checkboxes = $('.checkboxes');
            checkboxes.change(function(){
                if($('.checkboxes:checked').length>0) {
                    checkboxes.removeAttr('required');
                } else {
                    checkboxes.attr('required', 'required');
                }
            });

            $('#project-edit').on('submit', function () {
				$('#submit').attr('disabled', 'true');
			});

            $('#newProjectQuestion-store').on('submit', function () {
				$('#newProjectQuestion-submit').attr('disabled', 'true');
			});

            $('#newProjectProcess-store').on('submit', function () {
				$('#newProjectProcess-submit').attr('disabled', 'true');
			});
        });
    </script>

    <br/>
    <div class="col-lg-12">

    <h3 style="color: black;">PROJE DÜZENLEME SAYFASI</h3>
	<hr style="border-color:black;">
    <br/>
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
        <div class="row">
            
            

            <div class="col-md-11">
                <div class="card card-outline card-success">

                    <div class="card-body ui-sortable">
                        <form action="{{ url('my-projects/edit',[$projects->id]) }}" method="GET" id="project-edit">
                        @csrf
                                <h5 style="color:#8B0000;">Proje Sahibi:</h5>
                                    <select name="userId" class="form-control short">
                                            <option value="{{ $projects->user_id }}">
                                                {{$users->where('id',$projects->user_id)->value('name')}}
                                            </option>
                                            @foreach($users as $user)
                                                @if($user->id != $projects->user_id)
                                                    <option value="{{ $user->id }}">
                                                        {{$user->name}}
                                                    </option>
                                                @endif
                                            @endforeach
                                    </select>
                                <br/>

                                <h5 style="color:#8B0000;">Proje İsmi:</h5>
                                    <textarea name="title" style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="500" placeholder="{{ $projects->title }}"></textarea><pre></pre>
                                <br/>

                                <h5 style="color:#8B0000;">Proje Açıklaması:</h5>
                                <textarea name="description" style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="500" placeholder="{{ $projects->description }}"></textarea><pre></pre>
                                <br/>

                                <h5 style="color:#8B0000;">Proje Ait Olduğu Birim:</h5>
                                    <select name="unit_id" class="form-control form-control-sm">
                                        @foreach($units as $unit)
                                            @if($projects->unit_id == $unit->id)
                                                <option value="{{ $projects->unit_id }}">{{ $unit->unit }}</option>
                                            @endif
                                        @endforeach

                                        @foreach($units as $unit)
                                            @if($projects->unit_id != $unit->id)
                                                <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                <br/>

                                <br/>

                                @foreach($projectQuestion as $question)
                                    <input type="hidden" name="questionCount" class="form-control form-control-sm" value="{{ $loop->count }}">
                                    <input type="hidden" name="question_id[]" class="form-control form-control-sm" value="{{ $question->id }}">
                                    <input type="hidden" name="question[]" class="form-control form-control-sm" value="{{ $question->question }}">
                                    <input type="hidden" name="type[]" class="form-control form-control-sm" value="{{ $question->type }}">
                                    <input type="hidden" name="frm_option[]" class="form-control form-control-sm" value="{{ $question->frm_option}}">
                                        @if($question->type=="radio_opt")
                                                <p><b>{{ $question->question }}</b></p>
                                                <div class="row">
                                                    <div class="col">
                                                        @if($answers->where('question_id',$question->id)->count() == 0)
                                                            @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                <input type="radio" name="radio{{$question->id}}" value="{{ $v }}" required />
                                                                <input type="text" name="radio[]" style="border: none; background-color:white;" disabled value="{{ $v }}" /><pre></pre>
                                                            @endforeach
                                                        @else
                                                            @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                <input type="radio" name="radio{{$question->id}}" value="{{ $v }}"/>
                                                                <input type="text" name="radio[]" style="border: none; background-color:white;" disabled value="{{ $v }}" /><pre></pre>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <div class="col">
                                                        <p style="color:#8B0000;">En Son Seçim:</p>
                                                        @foreach($answers->where('question_id',$question->id) as $answer)
                                                            @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                @foreach(explode(",",$answer->answer) as $a => $b)
                                                                    @if($v == $b)
                                                                    <input type="radio" value="{{ $v }}" disabled {{ ($b == $v) ? "checked" : "" }}  />
                                                                    <input type="text" style="border: none; background-color:white;" value="{{ $v }}" disabled/><pre></pre>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                        @if(Auth::user()->privilege_id == '1')
                                                            <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#projectQuestionDelete{{$question->id}}">
                                                                <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                            </button>

                                                            <div class="modal fade" id="projectQuestionDelete{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            Soruyu silmek istediğinize eminmisiniz?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                                                            <button type="button" class="btn btn-dark" onclick="this.disabled=true;">
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('my-projects/question/delete',[$question->id]) }}">
                                                                                    Sil
                                                                                </a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                        <hr/>


                                        @elseif($question->type=="check_opt")
                                                <p><b>{{ $question->question }}</b></p>
                                                <div class="row">
                                                    <div class="col">
                                                        @if($answers->where('question_id',$question->id)->count() == 0)
                                                            @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                <input class="checkboxes" type="checkBox" name="checkBox{{$question->id}}[]" value="{{ $v }}" required/>
                                                                <input type="text" name="checkBox[]" style="border: none; background-color:white;" disabled value="{{ $v }}" /><pre></pre>
                                                            @endforeach
                                                        @else
                                                            @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                <input class="checkboxes" type="checkBox" name="checkBox{{$question->id}}[]" value="{{ $v }}"/>
                                                                <input type="text" name="checkBox[]" style="border: none; background-color:white;" disabled value="{{ $v }}" /><pre></pre>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="col">
                                                        <p style="color:#8B0000;">En Son Seçim:</p>
                                                            @foreach($answers->where('question_id',$question->id) as $answer)
                                                                @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                    @foreach(explode(",",$answer->answer) as $a => $b)
                                                                        @if($v == $b)
                                                                            <input class="checkboxes" type="checkBox" value="{{ $v }}" {{ ($b == $v) ? "checked" : "" }} disabled />
                                                                            <input type="text" style="border: none; background-color:white;" value="{{ $v }}" disabled  /><pre></pre>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endforeach
                                                    </div>
                                                </div>
                                                        @if(Auth::user()->privilege_id == '1')
                                                            <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#projectQuestionDelete{{$question->id}}">
                                                                <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                            </button>

                                                            <div class="modal fade" id="projectQuestionDelete{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            Soruyu silmek istediğinize eminmisiniz?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                                                            <button type="button" class="btn btn-dark" onclick="this.disabled=true;">
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('my-projects/question/delete',[$question->id]) }}">
                                                                                    Sil
                                                                                </a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                            
                                        <hr/>
                                        
                                        @elseif($question->type=="textfield_s")
                                            <div>
                                                <p><b>{{ $question->question }}</b></p>
                                                    <div class="">
                                                        @foreach($answers->where('question_id',$question->id) as $answer)                                   
                                                            <textarea name='text{{$question->id}}' id='' style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="1000" placeholder="{{ $answer->answer }}"></textarea><pre></pre>      
                                                        @endforeach

                                                        @if($answers->where('question_id',$question->id)->count() == 0)
                                                            <textarea name='text{{$question->id}}' id='' style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="1000" placeholder="Maksimum 1000 karakter..." required></textarea><pre></pre>
                                                        @endif
                                                    </div>

                                                        @if(Auth::user()->privilege_id == '1')
                                                            <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#projectQuestionDelete{{$question->id}}">
                                                                <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                            </button>

                                                            <div class="modal fade" id="projectQuestionDelete{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            Soruyu silmek istediğinize eminmisiniz?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                                                            <button type="button" class="btn btn-dark" onclick="this.disabled=true;">
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('my-projects/question/delete',[$question->id]) }}">
                                                                                    Sil
                                                                                </a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                            </div>
                                        <hr/>

                                        @endif

                                    
                                @endforeach


                                @foreach($processes as $process)
                                    <div id="accordion">
                                        <div class='card'>
                                                <div class='card-header'>
                                                    <a class='card-link' href='#collapse{{$process->id}}'>
                                                        {{$process->process}}
                                                        @if(Auth::user()->privilege_id == '1')
                                                        <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#projectProcess{{$process->id}}">
                                                            <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                        </button>
                                                        <div class="modal fade" id="projectProcess{{$process->id}}" tabindex="-1" aria-labelledby="exampleModalLabelProcess" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabelProcess">Onayla</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            Bu süreci silmek istediğinize eminmisiniz?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                                                            <button type="button" class="btn btn-dark" onclick="this.disabled=true;">
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('my-projects/process/delete',[$process->id]) }}">
                                                                                    Sil
                                                                                </a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                    </a> 
                                                </div>
                                            <div id='collapse{{$process->id}}' data-parent = '#accordion' >
                                                <div class='card-body'>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <input type="hidden" name="process_id[]" class="form-control form-control-sm" value="{{ $process->id }}">
                                                            <input type="hidden" name="process_id{{$process->id}}[]" class="form-control form-control-sm" value="{{ $process->id }}">
                                                            <input type="hidden" name="process[]" class="form-control form-control-sm" value="{{ $process->process }}">
                                                            <input type="hidden" name="process_title[]" class="form-control form-control-sm" value="{{ $process->title }}">
                                                            <input type="hidden" name="processCount" class="form-control form-control-sm" value="{{ $loop->count }}">
                                                            <h4>{{$process->title}}</h4>
                                                            <br/>
                                                            <b><textarea class="form-control" style="height:50px; width:300px; background-color:white; border:none;" disabled>Süreç Aşamaları?</textarea></b><br/><br/>
                                                            <b><textarea class="form-control" style="height:50px; width:300px; background-color:white; border:none;" disabled>Hardcopy onayları var mı?</textarea></b><br/><br/>
                                                            <b><textarea class="form-control" style="height:50px; width:300px; background-color:white; border:none;" disabled>Manuel veri toplama süreci var mı?</textarea></b><br/><br/>
                                                            <b><textarea class="form-control" style="height:50px; width:300px; background-color:white; border:none;" disabled>Sürecin mevcut manuel aşama sayısı?</textarea></b><br/><br/>
                                                            <b><textarea class="form-control" style="height:50px; width:300px; background-color:white; border:none;" disabled>Sürecin mevcut dijital aşama sayısı?</textarea></b><br/><br/>
                                                            <b><textarea class="form-control" style="height:50px; width:300px; background-color:white; border:none;" disabled>Sürecin mevcut dijital olgunluk oranı?</textarea></b><br/><br/>
                                                            <b><textarea class="form-control" style="height:60px; width:300px; background-color:white; border:none;" disabled>Dijitalleşme olgunluk arttırma önerileri/projeleri</textarea></b><br/><br/>
                                                        </div>

                                                        <div class="col-sm">
                                                            <h4></h4>
                                                            <br/><br/>
                                                            @foreach($processAnswers as $processAnswer)
                                                                @if($processAnswer->current_process_id == $process->id)
                                                                    @foreach(explode("|",$processAnswer->answer) as $k => $v)
                                                                        <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;" maxlength="250" placeholder="{{ $v }}"></textarea><br/><br/>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach

                                                            @if($processAnswers->where('current_process_id',$process->id)->count() == 0)
                                                            
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;"  maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;"  maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;" maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;" maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;" maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;" maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                                <textarea class="bold" name="answer{{$process->id}}[]" style="height:70px; width:400px; background-color:#EDE9F2;" maxlength="250" placeholder="Maksimum 250 karakter..."></textarea><br/><br/>
                                                            @endif
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <br/></br></br>


                        <div class="card-header-light text-center">
                            <div class="card-tools">
                                    @if(Auth::user()->privilege_id == '1')
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newProjectQuestion" data-bs-whatever="@mdo">
                                        <i style="color:White;" class="fa fa-plus fa-lg"> Yeni Soru Oluştur</i>
                                    </button>

                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newProjectProcess" data-bs-whatever="@mdo">
                                        <i style="color:White;" class="fa fa-plus fa-lg"> Mevcut Süreç Oluştur</i>
                                    </button>
                                    
                                    @endif
                                    <input type="submit" class="btn btn-dark" value="Güncelle" id="submit"/>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="newProjectQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yeni Soru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('my-projects/question/store') }}" method="GET" id="newProjectQuestion-store">
                                @csrf
                                <input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">
                                            <textarea class="bold" name="question" id="question" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="500" placeholder="Maksimum 500 karakter..." style="height:50px; width:400px; border:none;" required></textarea>
                                        </div>

                                        <br/><br/>
                                        <div class="col-sm">
                                            <select name="type" id="type" class="custom-select custom-select-sm" onchange="selectAnswerType()" style="height:30px; width:400px;" required>
                                                <option value="">Soru Tipi Seç</option>
                                                <option value="radio_opt">Tek Cevap</option>
                                                <option value="check_opt">Çoklu Cevap</option>
                                                <option value="textfield_s">Metin Alanı</option>
                                            </select>
							            </div>

                                        <br/><br/><br/>
                                        
                                        <div class="">
                                            <div id="preview">
                                              
                                            </div>
                                            <br/>

                                            <div id="addOptionRadio" style="display: none;">
                                                <i style="color:black;" class="fa fa-plus fa-lx" onclick="newRadio()"></i> Yeni Seçenek                                                </div>
                                            <div id="addOptionCheck" style="display: none;">
                                                <i style="color:black;" class="fa fa-plus fa-lx" onclick="newCheck()"></i> Yeni Seçenek
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    
                                    <input type="submit" class="btn btn-dark" value="Ekle" id="newProjectQuestion-submit" />
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>


            <div class="modal fade" id="newProjectProcess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal">Yeni Süreç</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('my-projects/process/store') }}" method="GET" id="newProjectProcess-store">
                                @csrf
                                    <input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
                                    <div class="container">
                                        <div class="row">
                                            
                                                <div class="col-sm">
                                                    <textarea class="bold" name="title" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="500" placeholder="Maksimum 500 karakter..." style="height:50px; width:400px; border:none;" required></textarea>
                                                </div>

                                                <br/>
                                                <br/>
                                                <br/>


                                                <div>
                                                <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Süreç Aşamaları?' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Hardcopy onayları var mı?' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Manuel veri toplama süreci var mı?' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Sürecin mevcut manuel aşama sayısı?' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Sürecin mevcut dijital aşama sayısı?' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Sürecin mevcut dijital olgunluk oranı?' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value='Dijitalleşme olgunluk arttırma önerileri/projeleri' /><br/>
                                                    <textarea class="bold" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="height:50px; width:400px;" disabled></textarea><br/><br/>
                                                </div>
                                            

                                                
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <input type="submit" class="btn btn-dark" value="Ekle" id="newProjectProcess-submit" />
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                    </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>


            
           

        </div>
       <br/>
    </div>

@endsection
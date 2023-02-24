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

            $('#project-store').on('submit', function () {
				$('#submit').attr('disabled', 'true');
			});

            $('#question-store').on('submit', function () {
				$('#questionStore-submit').attr('disabled', 'true');
			});

            $('#process-store').on('submit', function () {
				$('#processStore-submit').attr('disabled', 'true');
			});
        });
    </script>

    <br/>
    <div class="col-lg-12">

    <div class="row">
		<div class="col-3">
			<h3 style="color: black;">Proje Tanıtım Formu</h3>
		</div>
		
	</div>
    
	<hr style="border-color:black;">
        <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $forms->id }}">
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
            
            

            <div class="col-md-8">
                <div class="card card-outline card-success">
                    <div class="card-header p-0 py-2 text-center" style="background-color: white;border-top: 5px solid #660066">
                        <h3 class="card-title">Form Soruları</h3>
                    </div>

                    

                    <div class="card-body ui-sortable">
                        <form action="{{ url('projects/store') }}" method="POST" id="project-store">
                        @csrf
                            <input type="hidden" name="formId" class="form-control form-control-sm" value="{{ $forms->id }}">

                                <p style="color:#8B0000;"><b>*Proje Sahibi:</b></p>
                                <div>
                                    <select name="userId" class="form-control short">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{$user->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br/>

                                <p style="color:#8B0000;"><b>*Proje İsmi:</b></p>
                                <div class="">
                                    <textarea name="title" style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="500" placeholder="Maksimum 500 karakter..." required></textarea><pre></pre>
                                </div>

                                <p style="color:#8B0000;"><b>*Proje Açıklaması:</b></p>
                                <div class="">
                                    <textarea name="description" style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="1000" placeholder="Maksimum 1000 karakter..." required></textarea><pre></pre>
                                </div>

                                <div class="">
                                    <p style="color:#8B0000;"><b>*Proje Ait Olduğu Birim:</b></p>
                                    <select name="unit_id" class="form-control form-control-sm" required>
                                        <option value="">Birim Seç</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br/><br/>

                                @foreach($questions as $question)
                                    @if($question->form_id==$forms->id)
                                    <input type="hidden" name="questionCount" class="form-control form-control-sm" value="{{ $loop->count }}">
                                    <input type="hidden" name="question_id[]" class="form-control form-control-sm" value="{{ $question->id }}">
                                    <input type="hidden" name="question[]" class="form-control form-control-sm" value="{{ $question->question }}">
                                    <input type="hidden" name="type[]" class="form-control form-control-sm" value="{{ $question->type }}">
                                    <input type="hidden" name="frm_option[]" class="form-control form-control-sm" value="{{ $question->frm_option}}">
                                        @if($question->type=="radio_opt")
                                            <div class="" >
                                                <p><b>{{ $question->question }}</b></p>
                                                
                                                    @foreach(explode(",",$question->frm_option) as $k => $v)
                                                            <input type="radio" name="radio{{$question->id}}" value="{{ $v }}" required/>
                                                            <input type="text" name="radio[]" style="border: none; background-color:white;" disabled value="{{ $v }}" /><pre></pre>
                                                    @endforeach
                                                        @if(Auth::user()->privilege_id == '1')
                                                            <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$question->id}}">
                                                                <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                            </button>

                                                            <div class="modal fade" id="exampleModal{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('forms/question/delete',[$question->id]) }}">
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


                                        @elseif($question->type=="check_opt")
                                            <div class="" >
                                                <p><b>{{ $question->question }}</b></p>
                                                
                                                @foreach(explode(",",$question->frm_option) as $k => $v)
                                                        <input class="checkboxes" type="checkBox" name="checkBox{{$question->id}}[]" value="{{ $v }}" required/>
                                                        <input type="text" name="checkBox[]" style="border: none; background-color:white;" disabled value="{{ $v }}" /><pre></pre>
                                                @endforeach
                                                        @if(Auth::user()->privilege_id == '1')
                                                            <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$question->id}}">
                                                                <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                            </button>

                                                            <div class="modal fade" id="exampleModal{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('forms/question/delete',[$question->id]) }}">
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
                                        
                                        @elseif($question->type=="textfield_s")
                                            <div>
                                                <p><b>{{ $question->question }}</b></p>
                                                
                                                @foreach(explode(",",$question->frm_option) as $k => $v)
                                                    <div class="">
                                                        <textarea name='text{{$question->id}}' id='' style="background-color:white;" cols='15' rows='5' class='form-control' maxlength="1000" placeholder="Maksimum 1000 karakter..." required></textarea><pre></pre>
                                                    </div>
                                                @endforeach
                                                        @if(Auth::user()->privilege_id == '1')
                                                            <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$question->id}}">
                                                                <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                            </button>

                                                            <div class="modal fade" id="exampleModal{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('forms/question/delete',[$question->id]) }}">
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

                                    @endif
                                @endforeach


                                @foreach($process as $processes)
                                    @if($processes->form_id==$forms->id)
                                    <div id="accordion">
                                        <div class='card'>
                                                <div class='card-header'>
                                                    <a class='card-link' data-toggle='collapse' href='#collapse{{$processes->id}}'>
                                                        {{$processes->process}}
                                                        @if(Auth::user()->privilege_id == '1')
                                                        <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModalProcess{{$processes->id}}">
                                                            <i style="color: black;" class="fa fa-trash fa-lg"></i>
                                                        </button>
                                                        <div class="modal fade" id="exampleModalProcess{{$processes->id}}" tabindex="-1" aria-labelledby="exampleModalLabelProcess" aria-hidden="true">
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
                                                                                <a style="color: white; text-decoration:none;" href="{{ url('forms/process/delete',[$processes->id]) }}">
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
                                            <div id='collapse{{$processes->id}}' class = 'collapse' data-parent = '#accordion' >
                                                <div class='card-body'>
                                                    <input type="hidden" name="process_id[]" class="form-control form-control-sm" value="{{ $processes->id }}">
                                                    <input type="hidden" name="process_id{{$processes->id}}[]" class="form-control form-control-sm" value="{{ $processes->id }}">
                                                    <input type="hidden" name="process[]" class="form-control form-control-sm" value="{{ $processes->process }}">
                                                    <input type="hidden" name="process_title[]" class="form-control form-control-sm" value="{{ $processes->title }}">
                                                    <input type="hidden" name="processCount" class="form-control form-control-sm" value="{{ $loop->count }}">
                                                    <h4>{{$processes->title}}</h4>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Süreç Aşamaları?" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none;" required></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Hardcopy onayları var mı?" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none;" required></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Manuel veri toplama süreci var mı?" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none;" required></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Sürecin mevcut manuel aşama sayısı?" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none;" required></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Sürecin mevcut dijital aşama sayısı?" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none;" required></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Sürecin mevcut dijital olgunluk oranı?" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none;" required></textarea><br/><br/>
                                                    <input type='text' style='border:none; width:500px; background-color:white;' disabled value="Dijitalleşme olgunluk arttırma önerileri/projeleri" /><br/><br/>
                                                    <textarea class="bold" name="answer{{$processes->id}}[]" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="250" placeholder="Maksimum 250 karakter..." style="height:50px; width:400px; border:none" required></textarea><br/><br/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                <br/></br></br>


                        <div class="">
                            <div class="container-fluid">
                                <div class="card mb-3" style="max-width: 50rem;">
                                    <div class="card-header" style="background-color: white;border-top: 5px solid #660066">
                                        <h3 class="card-title"  style="color:#8B0000;">*Etkilenen Birimler</h3>

                                    </div>
                                    <div class="card-body p-0 py-2">
                                        <div class="container-fluid">
                                            @foreach($units as $unit)
                                                @if($unit->id == 1 || $unit->id == 2 || $unit->id == 3)
                                                    <input type="checkBox" name="unit[]" value="{{ $unit->id }}" checked onclick="return false;"/>
                                                    <input type="text" style="border: none; background-color:white; color:#8B0000;" value="{{ $unit->unit }}" disabled/><pre></pre>
                                                @else
                                                    <input type="checkBox" name="unit[]" value="{{ $unit->id }}"/>
                                                    <input type="text" style="border: none; background-color:white; color:#8B0000;" value="{{ $unit->unit }}" disabled/><pre></pre>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                            
                       
                        <div class="card-header-light text-center">
                            <div class="card-tools">
                                    @if(Auth::user()->privilege_id == '1')
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newQuestion" data-bs-whatever="@mdo">
                                        <i style="color:White;" class="fa fa-plus fa-lg"> Yeni Soru Oluştur</i>
                                    </button>

                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newProcess" data-bs-whatever="@mdo">
                                        <i style="color:White;" class="fa fa-plus fa-lg"> Mevcut Süreç Oluştur</i>
                                    </button>
                                    
                                    @endif
                                    <input type="submit" class="btn btn-dark" value="Gönder" id="submit"/>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="newQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yeni Soru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('forms/question/store') }}" method="GET" id="question-store">
                                @csrf
                                <input type="hidden" name="form_id" class="form-control form-control-sm" value="{{ $forms->id }}" required>
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
                                    
                                    <input type="submit" class="btn btn-dark" value="Ekle" id="questionStore-submit" />
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Geri</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>


            <div class="modal fade" id="newProcess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal">Yeni Süreç</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('forms/process/store') }}" method="GET" id="process-store">
                                @csrf
                                <input type="hidden" name="form_id" class="form-control form-control-sm" value="{{ $forms->id }}" required>
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
                                        
                                        <input type="submit" class="btn btn-dark" value="Ekle" id="processStore-submit" />
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
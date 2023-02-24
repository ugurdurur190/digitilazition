@extends('layouts.menu')
    @section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br/>
    
        <div class="col-lg-12">

            <div class="d-flex justify-content-center">

                <div class="col-md-10">
                    <h2>Proje Detayları</h2>
                    <hr style="border-color:black;">

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

                        <div class="card card-outline mb-5">
                        
                            <div class="card-header" style="background-color: white;border-top:5px solid #660066;"></div>
                            <div class="card-body ui-sortable">
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
                                        <p>{{ $unit->unit }}</p>
                                        @endif
                                    @endforeach
                                @endforeach

                                <hr color="#660066;"/>
                                <br/>

                                        @foreach($questions as $question)
                                            
                                            <input type="hidden" name="question_id[]" class="form-control form-control-sm" value="{{ $question->id }}">
                                            
                                                @if($question->type=="radio_opt")
                                                    <div class="" >
                                                        <p id="question{{ $question->id }}"><b>{{ $question->question }}</b></p>
                                                        @foreach($answers as $answer)
                                                            @if($answer->question_id == $question->id)
                                                                @foreach(explode(",",$answer->answer) as $k => $v)
                                                                    @foreach(explode(",",$question->frm_option) as $a => $b)
                                                                        @if($v==$b)
                                                                            <div class="">
                                                                                <textarea id="answer{{ $question->id }}" name="radio[]" style="border:none; background-color:white;" class='form-control' disabled >{{ $b }}</textarea><pre></pre>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>

                                            
                                                @elseif($question->type=="check_opt")
                                                    <div class="" >
                                                        <p id="question{{ $question->id }}"><b>{{ $question->question }}</b></p>
                                                        @foreach($answers as $answer)
                                                            @if($answer->question_id == $question->id)                                            
                                                                @foreach(explode(",",$answer->answer) as $k => $v)
                                                                    @foreach(explode(",",$question->frm_option) as $a => $b)
                                                                        @if($v==$b)
                                                                            <div class="">
                                                                                <textarea id="answer{{ $question->id }}" name="checkBox[]" style="border:none; background-color:white;" class='form-control' disabled >{{ $b }}</textarea><pre></pre>
                                                                            </div>
                                                                        @else
                                                                            @continue
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                
                                                @elseif($question->type=="textfield_s")
                                                    <div>
                                                        <p id="question{{ $question->id }}"><b>{{ $question->question }}</b></p>
                                                        @foreach($answers as $answer)
                                                            @if($answer->question_id == $question->id)
                                                                @foreach(explode(",",$question->frm_option) as $k => $v)
                                                                    <div class="">
                                                                        <textarea id="answer{{ $question->id }}" name='text{{$question->id}}' style="border:none; background-color:white;" cols='15' rows='5' class='form-control' disabled >{{ $answer->answer}}</textarea><pre></pre>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                @endif
                                                
                                        @endforeach



                                        @foreach($processes as $process)
                                                <div id="accordion">
                                                <div class='card'>
                                                        <div class='card-header'>
                                                            <a class='card-link' href='#collapse{{$process->id}}'>
                                                                {{$process->process}}     
                                                            </a> 
                                                        </div>
                                                    <div id='collapse{{$process->id}}' data-parent = '#accordion' >
                                                        <div class='card-body'>
                                                            <div class="row">
                                                            
                                                                    <div class="col-sm">
                                                                        <h4>{{$process->title}}</h4>
                                                                        <br/>
                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Süreç Aşamaları?</textarea></b><br/><br/>
                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Hardcopy onayları var mı?</textarea></b><br/><br/>

                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Manuel veri toplama süreci var mı?</textarea></b><br/><br/>
                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Sürecin mevcut manuel aşama sayısı?</textarea></b><br/><br/>
                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Sürecin mevcut dijital aşama sayısı?</textarea></b><br/><br/>
                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Sürecin mevcut dijital olgunluk oranı?</textarea></b><br/><br/>
                                                                        <b><textarea class="bold" style="height:70px; width:300px; background-color:white; border:none;" disabled>Dijitalleşme olgunluk arttırma önerileri/projeleri</textarea></b><br/><br/>
                                                                    </div>

                                                                    
                                                                    <div class="col-sm">
                                                                    <br/><br/><br/>
                                                                        @foreach($processAnswers as $processAnswer)
                                                                            @if($processAnswer->current_process_id == $process->id)
                                                                                @foreach(explode("|",$processAnswer->answer) as $k => $v)
                                                                                <textarea class="bold" style="height:70px; width:400px; background-color:#EDE9F2;" disabled>{{ $v }}</textarea><br/><br/>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </div>

                                                            
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        @endforeach
                            
                            </div>
                        </div>

                    </div>
                </div>
           <br/>
        </div>
    

@endsection
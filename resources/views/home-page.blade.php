@extends('layouts.menu')
    @section('content')

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
        <br/><br/><br/>
          <h1>DİJİTALLEŞME PROJELERİ YÖNETİM SİSTEMİNE HOŞGELDİN</h1>
          <h2>{{ Auth::user()->name }}</h2>
          <img src="{{ asset('assets/img/sefamerve2.png') }}" alt="">
        </div>
 @endsection

 
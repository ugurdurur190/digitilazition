@extends('layouts.menu')
@section('content')

<div class="container rounded" style="background-color: #111111;">
    <div class="row">
        @if(Auth::user()->privilege_id == '1')
            <video controls>
                <source src="" type="video/mp4" />
            </video>
            <br/>
        @endif

        @if(Auth::user()->privilege_id == '4')
            <video controls>
                <source src="" type="video/mp4" />
            </video>
            <br/>
        @endif

        @if(Auth::user()->privilege_id == '2')
        <video controls>
            <source src="" type="video/mp4" />
        </video>
        @endif
    </div>
</div>

@endsection
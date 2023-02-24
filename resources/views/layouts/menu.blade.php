@inject('admins', \app\Models\User::class)
@inject('notification' , 'App\Http\Controllers\NotificationController')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
        <script src="{{ asset('assets/js/menu.js') }}"></script>

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            window.setTimeout(function() {
                $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
                    $(this).remove(); 
                });
            }, 1000);
            });
        </script>
        
    </head>

    <body style="background-color: #F2EFE9; min-width: 768px;">

        <header style="background-color: white;" class="header dontPrint" id="header">
            <div><img src="{{ asset('assets/img/header8.png') }}" alt=""></div>
            <div class="header__toggle">
                <div class="dropdown dontPrint">

                    @if(Auth::user()->privilege_id != 5)
                        <button type="button" class="btn btn-sm position-relative" style="background-color:#660066;" data-bs-toggle="modal" data-bs-target="#bigModal">
                            <i style="color: #FFFFFF;" class="fa fa-bell fa-lg"></i>
                            @if(($notification->getUnapprovedProjectCount() + $notification->getUnratedProjectCount()) != 0)
                            <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notification->getUnapprovedProjectCount() + $notification->getUnratedProjectCount() }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                            @else
                            
                            @endif
                        </button>
                    @endif
                
                    @if(Auth::user()->privilege_id != 5)
                        <button type="button" class="btn btn-flat">
                            <a href="{{ url('video') }}">
                                Kullanım Videosu
                            </a>
                        </button>
                    @endif
                    
                    <button class="btn btn-secondary btn-sm dropdown-toggle" style="background-color: #660066;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->email }}
                    </button>
                    <ul class="dropdown-menu">
                        <li class="text-center"><a href="{{ url('users/operations/view',[Auth::user()->id]) }}" class="dropdown-item">Hesap Bilgilerini Düzenle</a></li>
                        <li class="text-center"><a class="dropdown-item" href="mailto:{{ $admins->where('privilege_id',1)->value('email') }}">Yardım</a></li>
                        <li class="text-center"><a class="dropdown-item" href="{{ route('signout') }}">Çıkış</a></li>
                    </ul>
                    <button type="button" class="btn btn-flat">
                        <a href="{{ route('signout') }}">
                            <i style="color: #660066;" class="fa fa-sign-out fa-lg"></i>
                        </a>
                    </button>
                </div>
            </div>
        </header>

        <div class="modal fade" id="bigModal" tabindex="-1" aria-labelledby="bigModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="bigModalLabel">Bildirimler</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @if(Auth::user()->privilege_id == 4)
                        <div class="modal-body">
                            <h5 style="color:#660066">Oy Bekleyen Projeler</h5>
                            <br/>
                            @if($notification->getUnratedProjectCount() != 0)
                                @foreach($notification->getUnratedProjects() as $unratedProject)
                                    <div class="rounded text-center" style="background-color:#EDE9F2;">
                                        <div class="row">
                                            <div class="col">
                                                <p><b style="color:#660066">"{{ $unratedProject->title }}"</b> , isimli proje</p>
                                            </div>
                                            <div class="col">
                                                <a href="{{ url('projects/vote',[$unratedProject->id]) }}">
                                                    Git
                                                </a>
                                            </div>
                                        </div>
                                        <hr/>
                                    </div>
                                @endforeach
                            @else
                                <p>Bildirim Yok!</p>
                            @endif

                            <br/><br/>

                            <h5 style="color:#660066">Birim Onayınızı Bekleyen Projeler</h5>
                            <br/>
                            @if($notification->getUnapprovedProjectCount() != 0)
                                @foreach($notification->getUnapprovedProjects() as $unapprovedProject)
                                    <div class="rounded text-center" style="background-color:#EDE9F2;">
                                        <div class="row">
                                            <div class="col">
                                                <p><b style="color:#660066">"{{ $unapprovedProject->title }}"</b> , isimli proje</p>
                                            </div>
                                            <div class="col">
                                                <a href="{{ url('projects/units/approval',[$unapprovedProject->id]) }}">
                                                    Git
                                                </a>
                                            </div>
                                        </div>
                                    <hr/>
                                    </div>
                                @endforeach
                            @else
                                <p>Bildirim Yok!</p>
                            @endif
                        </div>
                    @elseif(Auth::user()->privilege_id != 4)
                        <div class="modal-body">
                            <h5 style="color:#660066">Oy Bekleyen Projeler</h5>
                            <br/>
                            @if($notification->getUnratedProjectCount() != 0)
                                @foreach($notification->getUnratedProjects() as $unratedProject)
                                    <div class="rounded text-center" style="background-color:#EDE9F2;">
                                        <div class="row">
                                            <div class="col">
                                                <p><b style="color:#660066">"{{ $unratedProject->title }}"</b> , isimli proje</p>
                                            </div>
                                            <div class="col">
                                                <a href="{{ url('projects/vote',[$unratedProject->id]) }}">
                                                    Git
                                                </a>
                                            </div>
                                        </div>
                                        <hr/>
                                    </div>
                                @endforeach
                            @else
                                <p>Bildirim Yok!</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div id="mySidebar" class="sidebar" style="background-color: #660066;" onmouseover="toggleSidebar()" onmouseout="toggleSidebar()">

                <div>

                    <a href="{{ url('/') }}"><span><i class='bx bx-layer nav__logo-icon'></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Anasayfa</span></a><br>

                    @if(Auth::user()->privilege_id != '5')
                        <a href="{{ url('dashboard') }}"><span><i class='bx bx-grid-alt nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</span></a><br>
                    @endif

                    @if(Auth::user()->privilege_id == '1')
                        <a href="{{ url('users/list') }}"><span><i class='bx bx-user nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Kullanıcılar</span></a><br>
                    @endif

                    @if(Auth::user()->privilege_id != '5')
                        <a href="{{ url('forms/list') }}"><span><i class='bx bx-message-square-detail nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Proje Formu</span></a><br>
        
                        <a href="{{ url('projects/list') }}"><span><i class='bx bx-select-multiple nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Proje Anketi</span></a><br>
                        
                        <a href="{{ url('projects/votes/reports/list')}}"><span><i class='bx bx-bar-chart-alt-2 nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Proje Anket Sonucu</span></a><br>
                    @endif

                    <a href="{{ url('projects/continues/list') }}"><span><i class='bx bx-select-multiple nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Devam Eden Projeler</span></a><br>
                
                    <a href="{{ url('projects/completed/list') }}"><span><i class='bx bx-select-multiple nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Tamamlanan Projeler</span></a><br>

                    @if(Auth::user()->privilege_id == '1')
                        <a href="{{ url('my-projects/list') }}"><span><i class='bx bx-book nav__logo-icon' ></i><span class="icon-text">&nbsp;&nbsp;&nbsp;&nbsp;Proje Düzenle</span></a><br>
                    @endif
                    
                </div>

                
        </div>

            
        <br/><br/><br/><br/>
        <div id="main" class="container">
            @yield('content')
        </div>

        <!--===== MAIN JS =====-->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/sec.js') }}"></script>


    </body>
</html>
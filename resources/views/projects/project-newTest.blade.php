@extends('layouts.menu')
    @section('content')
        <script type="text/javascript">
            $(document).ready(function () {
                $('#todo-store').on('submit', function () {
                    $('#submit').attr('disabled', 'true');
                });
            });
        </script>
        <div class="col-lg-12">
            <h2>Yeni Görev</h2>
            <p style="color:#8B0000;"></p>
            <hr />
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('projects/todoes/new/store',[$projects->id]) }}" method="GET" id="todo-store">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 border-right">

                                <div class="form-group">
                                    <label for="" class="control-label">Başlık</label>
                                    <input type="text" name="title" class="form-control form-control-sm" maxlength="50" placeholder="Maksimum 50 karakter..." required>
                                </div>

                                <div class="form-group">
                                    <td>
                                        <label for="priority">durumu</label>
                                    </td>
                                    <td>
                                        <select name="board_id" class="form-control short" id="priority">
                                            <option value="1">
                                                yapılacak
                                            </option>
                                            <option value="2">
                                                devam ediyor
                                            </option>
                                            <option value="3">
                                                tamamlandı
                                            </option>
                                        </select>
                                    </td>
                                </div>
                                <div class="form-group">
                                    <td>
                                        <label for="priority">Görevi ata</label>
                                    </td>
                                    <td>
                                        <select name="userId" class="form-control short" id="priority">
                                            @foreach($users as $user)
                                                @foreach($teams as $team)
                                                    @if($user->id == $team->user_id)
                                                        <option value="{{ $user->id }}">
                                                            {{$user->name}} ({{$user->email}})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                            
                                        </select>
                                    </td>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Açıklama</label>
                                    <textarea name="description" id="" cols="30" rows="4" class="form-control" maxlength="250" placeholder="Maksimum 250 karakter..." required></textarea>
                                </div>
                                <br>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-dark mr-2" id="submit">Kaydet</button>
                        <a class="btn btn-dark mr-2" href="{{ url('projects/todoes/works/view',[$projects->id]) }}">Geri</a>
                    </form>
                </div>
            </div>

        </div>
    @endsection
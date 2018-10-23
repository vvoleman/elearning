@extends('mains/account_main')
@section('title','Uživatelé |')
@section('content')
    <div class="container m-top">
        <h1 class="text-center">Uživatelské účty</h1><hr>
        @if(!empty($data))
            <table class="table table-striped col-10 mx-auto" style="overflow: scroll">
                <thead class="thead-dark">
                <th>ID</th>
                <th>Příjmení</th>
                <th>Jméno</th>
                <th>E-mail</th>
                <th>Role</th>
                <th>Registrace</th>
                <th>Aktivní?</th>
                <th>Další</th>
                </thead>
                <tbody>
                @foreach($data as $u)
                    <tr>
                        <td>{{$u->id}}</td>
                        <td>{{$u->surname}}</td>
                        <td>{{$u->firstname}}</td>
                        <td>{{$u->email}}</td>
                        <td>{{ ucfirst(__('roles.'.$u->name)) }}</td>
                        <td>{{$u->registered}}</td>
                        <td>
                            @if(empty($u->deact_date))

                                <i class="fas fa-check-circle"></i>
                            @else
                                <i data-toggle="tooltip" data-placement="right" title="{{$u->deact_reason}}" class="fas fa-exclamation-circle"></i>
                            @endif
                        </td>
                        <td><button class="btn-sm btn btn-primary">Upravit</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <hr>
        <a href="#"><button class="btn btn-success">Nový uživatel</button></a>
    </div>
@stop
@section('customjs')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
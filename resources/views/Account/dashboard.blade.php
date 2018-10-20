@extends('mains/account_main')
@section('title','Dashboard |')
@section('title-username',Auth::user()->getFullname())
@section('content')
    <h1>Role: {{ ucfirst(__("roles.".Auth::user()->role->name)) }}</h1>
    @if(!empty($data))
    <table class="table table-striped col-8 mx-auto" style="overflow: scroll">
        <thead class="thead-dark">
            <th>ID</th>
            <th>Příjmení</th>
            <th>Jméno</th>
            <th>E-mail</th>
            <th>Role</th>
            <th>Registrace</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@stop
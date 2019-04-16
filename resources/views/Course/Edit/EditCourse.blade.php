@extends('mains.editcourse')
@section('title','Úprava kurzu "'.$c->name.'" | ')
@section('content')
    <div>
        <div class="col-md-12 d-md-flex" style="flex-wrap: wrap">
            <div class="col-md-3">
                <div>
                    <div class="d-md-flex align-items-center">
                        <i class="fas fa-users"></i>
                        <span>Studentů v kurzu</span>
                    </div>
                    <h2>{{$students}}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <div class="d-md-flex align-items-center">
                        <i class="fas fa-folder"></i>
                        <span>Modulů v kurzu</span>
                    </div>
                    <h2>{{$c->modules->count()}}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div>
                    <div class="d-md-flex align-items-center">
                        <i class="fas fa-list"></i>
                        <span>Počet testů</span>
                    </div>
                    <h2>{{$c->quizes->count()}}</h2>
                </div>
            </div>
        </div>
    </div>
@stop

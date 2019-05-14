@extends('mains.account_main')
@section('title','Test "'.$q->name.'" | ')
@section('content')
    @csrf
    <div>
    	<div class="col-md-2 sidebar">
    		<h4 class="text-center">Otázky</h4>
    		<hr>
    		<ul>
    			@for($i=0;$i<10;$i++)
    			<li>Otázka číslo {{$i+1}}</li>
    			@endfor
    		</ul>
    	</div>
    	<div class="body col-md-10 offset-md-2" style="padding-left:0;padding-right: 0">
    		<div class="infobar col-12 d-md-flex align-items-center justify-content-between">
    			<div class="countdown d-flex align-items-center">
    				<div class="timebar">
    					<div class="time" style="width: 60%;"></div>
    				</div>
    				<div style="margin-left:15px;color:white">
    					<span>19:35</span>
    				</div>
    			</div>
    			<div class="d-flex align-items-center to_submit ">
    				<span class="q_left">1. otázka z 10</span>
    				<i class="fas fa-bookmark marked" title="Označit si otázku"></i>
    			</div>
    			<div class="d-flex align-items-center to_submit">
    				<span>Chybí 3. otázky</span>
    				<button class="btn btn-secondary">Odeslat</button>
    			</div>
    		</div>
    		<div class="question">
    			<div>
    				<h2>1. Kolik je 1+1?</h2>
    			</div>
    		</div>
    	</div>
    </div>
    <!--<showquiz datas="{{$json}}"></showquiz>!-->
@stop

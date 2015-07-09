@extends('layouts.main')
@section('title')
Teebadgun.com : เพราะเราเข้าใจคนเล่นแบดมินตัน
@stop
@section('script')
    <script>
$( document ).ready(function( ) {
@if($badge)
showBadge({{$badge->id}},'{{$badge->name}}','{{$badge->desc}}');
@endif

});

function showBadge(id,name,desc){

  var content="<div class='userbadge'>"+
  "<img src='{{route('home')}}assets/images/badge/"+id+".png' />"+
  "<h2>ขอแสดงความยินดีคุณได้รับเหรียญ '"+name+"'</h2>"+
  "<p>"+desc+"</p>"+
  "</div>";
  bootbox.alert(content, function() {
  });
}


    </script>
@stop
@section('content')
{{$breadcrumbs}}
<div class="row">
  <div class="col-md-2 left">
  @if(Session::has('message'))
    {{ Session::get('message') }}
@endif
 <h1> <i class="fa fa-comment"></i> เว็บบอร์ด</h1>
	<div class="row">
		@include('forumsmenu')
	</div>
  </div>
  <div class="col-md-10 left">
  
  
  <div class="row">
    <div class="col-md-12 left">
                <h1 class="title">กระดานสนทนาทั้งหมด</h1>
        </div>
        <div class="col-md-12 left">
            <div id="open-team">
                <ul>
                  @foreach($all_cat as $cat)
                    <li class="open-team">
                    <a href="{{route('category',array($cat->id,$cat->title))}}">
                   
                    <h3><span class="glyphicon glyphicon-comment"></span> {{$cat->title}}</h3>
                    <p>{{$cat->desc}}</p></a></li>
                  @endforeach
                </ul>
            </div>
        </div>
  </div>
  
  </div>
</div>






@stop

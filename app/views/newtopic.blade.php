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
@if (Auth::user())
<div class="row">
@if(Session::has('message'))
    {{ Session::get('message') }}
@endif
  <div class="col-md-12 profile-header">
    

    <div class='row'>
        <div class="col-md-3 left">
          <h1>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h1>
          <div class="row">
            <div class="col-md-3 left">
            @if(Auth::user()->picture)
            <img src="{{ Auth::user()->picture }}" class="profile-image-s" />
            @else
            <img src="{{ asset('assets/images/guest.jpg'); }}" class="profile-image-s" />
            @endif
            </div>
            <div class="col-md-9 left">
            <ul>
              <li><span class="glyphicon glyphicon-envelope"></span> {{ Auth::user()->email }}</li>
              <li><span class="glyphicon glyphicon-map-marker"></span> จังหวัด 
              @if(Auth::user()->province)
              {{ Auth::user()->province()->name }}
              @endif</li>
              <li>
                @if(Auth::user()->fb_id)
             <a href="{{Auth::user()->link}}" target='_blank' class='btn btn-primary btn-xs' ><i class="fa fa-facebook-square fa-lg"></i> Facebook Connected</a>
            @else
            <button onclick="connectFB();" class='btn btn-primary btn-xs' ><i class="fa fa-facebook-square fa-lg"></i> เชื่อมต่อ Facebook</button>
            @endif
              </li>
            </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3 left">
          <h2>สังกัดทีม</h2>
          @foreach(Auth::user()->teams as $team)
            <div class='team-icon'><a href='{{route('team',array($team->team->id))}}'>
            <p><img src='{{ $team->team->logo}}'/>
            <h5>{{ $team->team->name }}</h5></p>
            </a></div>
          @endforeach
        </div>
        <div class="col-md-3 left">
          <h2>ลายเซ็นต์</h2>
          {{Auth::user()->signature}}
        </div>
        <div class="col-md-3 left">
           <h2>เหรียญรางวัล</h2>
            @foreach(Auth::user()->userbadges as $userbadge)
            <div class='badge-icon'><a href='javascript:void(0);' onclick='showBadge({{$userbadge->badge->id}},"{{$userbadge->badge->name}}","{{$userbadge->badge->desc}}")'>
            <p><img src='{{ asset('assets/images/badge/'.$userbadge->badge->id.'.png') }}' alt="{{$userbadge->badge->name}}"/></p>
            </a></div>
          @endforeach
        </div>
    </div>
  
  </div>
</div>
  @endif
<div class="row">
  <div class="col-md-2 left">
	<div class="row">
		@include('forumsmenu')
	</div>
  </div>
  <div class="col-md-10 left">
  
  
  <h1 class="title">ตั้งกระทู้ใหม่ : หัวข้อ {{$catinfo->title}}</h1>
  <div class="row">
    
        <div class="col-md-12 left">
            <div id="open-team">
                         {{ Form::open(array('url' => 'forums/insert','method'=>'post','id'=>'addtopic','role'=>'form','class'=>'form-horizontal')) }}
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ชื่อเรื่อง</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control"  name='title'>
                </div>
              </div>

               <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ข้อความ</label>
                <div class="col-sm-8">
                   <textarea class="form-control" name='content' rows="3"></textarea>
                </div>
              </div>
             
             
              
              <div class="form-group">

                <div class="col-sm-offset-2 col-sm-8">
                  <button type="submit" class="btn btn-default">ตั้งกระทู้</button>
                </div>
              </div>
          {{ Form::close() }}
            </div>
        </div>
            
  </div>
  
  </div>
</div>






@stop

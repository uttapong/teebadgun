@extends('layouts.main')
@section('title')
{{ $team->name }} : ตีแบดกันดอทคอม เพราะเราเข้าใจคนเล่นแบดมินตัน
@stop
@section('script')
<script>
</script>
@stop
@section('style')
<style>
.well{
  margin:0px 20px 5px 0px  !important;
  padding:10px !important;
}
</style>
@stop
@section('content')

<div class="row">
@if(Session::has('message'))
    {{ Session::get('message') }}
@endif
  <div class="col-md-12 profile-header">
    

    <div class='row'>
        <div class="col-md-3 left">
          <h1>ชื่อทีมแบดมินตัน: {{ $team->name }}</h1>
          @if($team->logo)
          <img src="{{ asset('uploads/teams/') }}/{{$team->id}}/{{$team->logo}}" class="profile-image" />
          @else
          <img src="{{ asset('assets/images/unknow.png') }}" class="profile-image" />
          @endif
          <p>
          @if(Auth::user()&&!$team->checkJoined())
            <a href="{{ route('jointeam',array($team->id)) }}" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-plus"></span> เข้าร่วมเป็นสมาชิก</a>
           @elseif(Auth::user())
           <button  class="btn btn-info btn-lg" disabled="disabled"><span class="glyphicon glyphicon-plus"></span> เป็นสมาชิกแล้ว</button>
            @endif  
            </p>
             @if($team->checkPermission())
            <p>
            
            <a href="{{ route('editteam',array($team->id)) }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span> แก้ไขข้อมูลทีม</a>
            
            <a href="{{ route('removeteam',array($team->id)) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-ban-circle"></span> ลบทีม</a>
            
            @endif
            <a href="{{ route('reportteam',array($team->id)) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-bullhorn"></span> แจ้งซ้ำ</a>
            </p>
        </div>
        <div class="col-md-3 left">
          <h2>หัวหน้าทีม</h2>
          @foreach($team->managers->all() as $manager)
          <div class='well'>
            <div class="media">
            @if($manager->getUser())
              <a class="pull-left" href="{{route('profile',array($manager->getUser()->username))}}">
            @else
              <span class="pull-left">
            @endif
                 @if($manager->getUser())
                <img style="width:50px" class="media-object" src="{{$manager->getUser()->picture}}" alt="...">
                @else
                <img style="width:50px" src="{{ asset('assets/images/guest.jpg'); }}"  />
                @endif
              @if($manager->getUser())
              </a>
              @else
              </span>
              @endif
              <div class="media-body">
              @if($manager->getUser())
                <h2 style="margin:0px;">{{ $manager->getUser()->username }}</h2>
                <h5 class="media-heading">{{ $manager->getUser()->firstname }} {{ $manager->getUser()->lastname }}</h5>
              @else
                <h2 style="margin:0px;">{{ $manager->nonmember_name }}</h2>
                <h5 class="media-heading"></h5>

              @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="col-md-3 left">
          <h2>สถานที่ตีแบด</h2>
           @foreach($team->opendays as $day)
          <div class='well'>
            <a href="{{route('gym',array($day->gym,$day->getGymName()))}}">
            <h2><i class="fa fa-map-marker fa-lg"></i> {{$day->getGymName()}}</h2>
            <p><span style='font-size:1.2rem;' class="label label-danger">{{$day->getDay()}}</span> ตั้งแต่เวลา {{$day->start_time}} - {{$day->end_time}}</p>
            <p>วิธีเล่น {{$day->payment}}</p>
            <p></p>
            </a>
          </div>
          @endforeach
        </div>
        <div class="col-md-3 left">
          
            <h2>คำขวัญ</h2>
            <p>{{$team->motto}}</p>
           <h2>เกี่ยวกับทีม</h2>
           <p>ติดต่อ {{$team->tel}}</p>
           <p>{{$team->descript}}</p>
        </div>
    </div>
  
  </div>
</div>
<div class="row">
  <div class="col-md-12 left">
  <h1>สมาชิกในทีม</h1>
  @foreach($team->members as $member)

    <div class='profile-team-icon'><a href='{{route('home')}}/profile/{{$member->user()->username}}'>
    <p><img src='{{ $member->user()->picture}}'/></p>
    <h5>{{ $member->user()->firstname}} {{ $member->user()->lastname}}</h5>
    </a></div>
  @endforeach
  </div>
</div>
@stop

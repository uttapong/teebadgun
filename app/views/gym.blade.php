@extends('layouts.main')
@section('title')
Teebadgun.com : {{ $gym->name }}
@stop
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=th&libraries=places"></script>
<script>
var map;
function initialize() {
  var gympos=new google.maps.LatLng({{$gym->lat}}, {{$gym->long}});
  var mapOptions = {
    zoom: 12,
    center: gympos
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
  var marker = new google.maps.Marker({
      position: gympos,
      map: map,
      title: '{{$gym->name}}'
  });

}

google.maps.event.addDomListener(window, 'load', initialize);


function shareFB(link,court_name){
  FB.ui({
    method: 'feed',
    //link: 'https://developers.facebook.com/docs/dialogs/',
    link: link,
    caption: 'มาตีแบดที่ทีม '+court_name+" กัน",
  }, function(response){});
}

function confirmReport(){
  bootbox.confirm("ท่านแน่ใจหรือว่าต้องการแจ้งคอร์ทแบดมินตันซ้ำ?", function(result) {
    if(result){
      location.href='{{route('gymreport',array($gym->id))}}';
    }
  }); 

}
function confirmRemove(){
  bootbox.confirm("ท่านแน่ใจหรือว่าต้องการลบคอร์ทแบดมินตัน?", function(result) {
    if(result){
      location.href='{{route('gymremove',array($gym->id))}}';
    }
  }); 
}
    </script>
@stop
@section('style')
<style>
.well{
  margin:0px 20px 5px 0px  !important;
  padding:10px !important;
}
#map-canvas {
      width: 100%;
        min-height:400px;
        margin: 0px;
        padding: 0px
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
          <h1>ชื่อคอร์ท: {{ $gym->name }}</h1>
          <div class='court-info'>
          <p>ประเภทคอร์ท: {{$gym->courtType->name}}</p>
          <p>เปิดทำการวัน: {{$gym->open_day}}</p>
          <p>เวลา: {{$gym->open_time}} - {{$gym->close_time}}</p>
          <p>จำนวนคอร์ท:  {{$gym->court_count}}</p>
          <p>
          @if($gym->checkPermission())
            <a href="{{ route('gymedit',array($gym->id)) }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span> แก้ไขข้อมูลสนาม</a>
           <button onclick="confirmRemove()" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-ban-circle"></span> ลบสนาม</button>
            @endif
             <button onclick="confirmReport()" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-bullhorn"></span> แจ้งซ้ำ</button>
            </p>
            </div>
        </div>
        <div class="col-md-3 left">
          <h2>ทีมที่เปิดที่นี่</h2>
          @foreach($gym->opendays as $openday)
         
            <div class='team-icon'><a href='{{route('team',array($openday->team))}}'>
            <p>
            
            @if(Team::find($openday->team)->logo)
                      <img src="{{ asset('uploads/teams/') }}/{{Team::find($openday->team)->id}}/{{Team::find($openday->team)->logo}}" class='team-logo-icon'/>
                    @else
                      <img src="{{ asset('assets/images/unknow.png') }}" class='team-logo-icon'/>
                    @endif
            
            <h5>{{Team::find($openday->team)->name }}</h5> <span class='label label-danger day'>{{$openday->getDay()}}</span></p>
            </a></div>
          @endforeach
        </div>
        <div class="col-md-3 left">
          <h2>ข้อมูลติดต่อ</h2>
           <p>ที่อยู่: {{$gym->address}}</p>
          <p>ชื่อผู้ติดต่อ: {{$gym->contact_person}}</p>
          <p>โทร: {{$gym->tel}}</p>
        </div>
        <div class="col-md-3 left">
          
            <h2>เพิ่มโดย</h2>
            <div class='well'>
            <div class="media">
              <a class="pull-left" href="{{route('profile',array($gym->user->username))}}">
                 @if($gym->user->picture)
                <img style="width:50px" class="media-object" src="{{$gym->user->picture}}" alt="...">
                @else
                <img style="width:50px" src="{{ asset('assets/images/guest.jpg'); }}"  />
                @endif
              </a>
              <div class="media-body">
                <h2 style="margin:0px;">{{ $gym->user->username }}</h2>
                <h5 class="media-heading">{{ $gym->user->firstname }} {{ $gym->user->lastname }}</h5>
              </div>
            </div>
          </div>
            
        </div>
    </div>
  
  </div>
</div>
<div class="row">
  <div class="col-md-12 left">
  <h1>แผนที่</h1>
  <div id="map-canvas"></div>
  </div>
</div>



@stop

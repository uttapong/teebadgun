@extends('layouts.main')
@section('title')
Teebadgun.com : เพราะเราเข้าใจคนเล่นแบดมินตัน
@stop
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=th&libraries=places"></script>
<script>
var map;
var overlays=[];
var current_lat=0.0;
var current_lng=0.0;
var current_day='all';
var current_type='team';
var infowindow =null ;
function initialize() {
  var mapOptions = {
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {

      current_lat=position.coords.latitude;
      current_lng=position.coords.longitude;

      findBy('gym','ค้นหาคอร์ท');
 
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}
function findCurrentLocation(){
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {

      current_lat=position.coords.latitude;
      current_lng=position.coords.longitude;
      findByDay(current_day,'ค้นหาทีม');

      infowindow.setContent('<div id="content"><h4>คุณอยู่ที่นี่</h4></div>');
      infowindow.setPosition(new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude));
  }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }

}
function findByDay(day,label){
  $('#day-label').html(label);
  clearOverlay();
  current_day=day;
   if(current_type=='gym')return;
    
  searchTeam();


}
function findBy(type,label){
    $('#searchby-label').html(label);
    clearOverlay();

    if(type=='team'){ searchTeam();}
    else if(type=='gym'){ searchGym();}
}
function searchGym(){
    current_type='gym';
    $.ajax({
        type: "POST",
        url: "{{route('getgym')}}",
        dataType: 'json',
        data: { lat: current_lat, lng: current_lng,day:current_day }
      })
        .done(function( msg ) {
          //console.log(msg);
        
          var mypos = new google.maps.LatLng(current_lat,current_lng);

          //console.log(msg);
          if(msg.length==0){
            bootbox.alert("ไม่พบทีมที่เปิดในวันที่เลือก", function() {
            return;
          });
            
          }

          $.each(msg, function( index, value ) {
            //console.log(value.lat);
            var myLatlng = new google.maps.LatLng(value.lat,value.long);

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: value.name
            });
            overlays.push(marker);
            var contentString = '<div id="content">'+
      
      '<h1 id="firstHeading" class="firstHeading">'+value.gym_name+'</h1>'+
      '<div id="bodyContent">'+
      '<p><a class="btn btn-info btn-sm" href="{{route('home')}}/gym/'+value.gym_id+'/'+value.gym_name+'">ดูข้อมูล</a> '+
      '</p>'+
      '<p><b>ระยะทาง : </b>'+parseFloat(value.distance).toFixed(2)+' กม.</p>'+
      '</div>'+
      '</div>';

            var info = new google.maps.InfoWindow({
         
            content: contentString
          });

            google.maps.event.addListener(marker, 'click', function() {
              info.open(map,marker);
            });


          });
          

          map.setCenter(mypos);

        });


}

function searchTeam(){
  current_type='team';

    $.ajax({
        type: "POST",
        url: "{{route('getlocationbyday')}}",
        dataType: 'json',
        data: { lat: current_lat, lng: current_lng,day:current_day }
      })
        .done(function( msg ) {
          //console.log(msg);
        
          var mypos = new google.maps.LatLng(current_lat,current_lng);

          //console.log(msg);
          if(msg.length==0){
            bootbox.alert("ไม่พบทีมที่เปิดในวันที่เลือก", function() {
            return;
          });
            
          }

          $.each(msg, function( index, value ) {
            //console.log(value.lat);
            var myLatlng = new google.maps.LatLng(value.lat,value.long);

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: value.name
            });
            overlays.push(marker);
            var contentString = '<div id="content">'+
      
      '<h3 id="firstHeading" class="firstHeading">'+value.name+'</h3>'+
      '<p><b>คอร์ทแบดมินตัน : </b>'+value.gym_name+'</p>'+
      '<p><b>ระยะทาง : </b>'+parseFloat(value.distance).toFixed(2)+' กม.</p>'+
      '<p><a class="btn btn-info btn-sm" href="{{route('home')}}/team/'+value.id+'">ดูข้อมูล</a> '+
      '<button  class="btn btn-primary btn-sm"  onclick=\'shareFB("{{route('home')}}/team/'+value.id+'","'+value.name+'");\' ><i class="fa fa-facebook-square fa-lg"></i> ชวนเพื่อนมาตี</button></p>'+
      '</div>'+
      '</div>';

            var info = new google.maps.InfoWindow({
         
            content: contentString
          });

            google.maps.event.addListener(marker, 'click', function() {
              info.open(map,marker);
            });


          });
          

          map.setCenter(mypos);

        });


}

function clearOverlay(){
  while(overlays[0]){
   overlays.pop().setMap(null);
  }
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
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
    </script>
@stop
@section('style')
<style>
.container{
  max-width:100% !important;
  padding-top: 0px !important;
}
#search-bar{
  margin:0px !important;
}
#map-canvas{
  min-height:600px;
}
</style>
@stop
@section('content')
<div class="row">
    <div class="col-md-9 left">
        <div class="col-md-12 center">
        <div id="search-bar">
            <div class='search-block'>
            <div class="btn-group">
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span id='searchby-label'>ค้นหาคอร์ท</span> <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="findBy('gym','ค้นหาคอร์ท');" >ค้นหาคอร์ท</a></li>
                <li><a href="javascript:void(0);" onclick="findBy('team','ค้นหาทีม');" >ค้นหาทีม</a></li>
              </ul>
            </div> 
            <button type="button" class="btn btn-info" onclick="findCurrentLocation();">ใกล้เคียง</button>
            <div class="btn-group">
              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                <span id='day-label'>ค้นหาจากวัน</span> <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" onclick="findByDay('all','ทุกวัน');" >ทุกวัน</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(2,'จันทร์');" >จันทร์</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(3,'อังคาร');">อังคาร</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(4,'พุธ');">พุธ</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(5,'พฤหัสบดี');">พฤหัสบดี</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(6,'ศุกร์');">ศุกร์</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(7,'เสาร์');">เสาร์</a></li>
                <li><a href="javascript:void(0);" onclick="findByDay(1,'อาทิตย์');">อาทิตย์</a></li>
              </ul>
            </div>  
            <input type="text" id="place-input" placeholder="ค้นหาสถานที่ใกล้เคียง" style="width: 280px; height: 33px"> 
            <button type="button" class="btn btn-default" onclick="clearOverlay();">ล้างผลการค้นหา</button>
        </div>
        </div>
    </div>
         <div id="map-canvas"></div>
    </div>

    <div class="col-md-3 left">
  <div class="row">
    @include('stat')

    <div class="col-md-12 left">
        <h1 class="title">ทีมที่เปิดทำการวันนี้</h1>
        </div>
        <div class="col-md-12 left">
            <div id="open-team">
                <ul style='padding-left:20px;'>
                  @foreach($open_teams1 as $team)
                    <li class="open-team">
                    <a href="{{route('team',array($team->id))}}">
                    @if($team->logo)
                      <img src="{{ asset('uploads/teams/') }}/{{$team->id}}/{{$team->logo}}" class='team-logo-icon'/>
                    @else
                      <img src="{{ asset('assets/images/unknow.png') }}" class='team-logo-icon'/>
                    @endif
                    {{$team->name}}</a></li>
                  @endforeach
                </ul>
            </div>
        </div>
    
  </div>
  </div>
    
</div>




@stop

@extends('layouts.main')
@section('title')
Teebadgun.com : แก้ไขข้อมูลสนามแบดมินตัน
@stop
@section('script')

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=th&libraries=places"></script>
<script>
jQuery( document ).ready(function( ) {

	$("#editgym").submit(function(e)
	{
	    var postData = $(this).serializeArray();
	    var formURL = $(this).attr("action");
	    $.ajax(
	    {
	        url : formURL,
	        type: "POST",
	        data : postData,
	        success:function(data, textStatus, jqXHR) 
	        {

	        	console.log(data);
	            if(data==1)bootbox.alert("คุณได้แก้ไขข้อมูลสนามเรียบร้อยแล้ว",function() {

	            	location.href='{{ route('home'); }}';
					});
	            else {
	            	var errs='<ul>';
	            	$.each( data, function( key, value ) {
					  errs=errs+"<li>"+value+"</li>";
					});
					errs+="</ul>";
	            	bootbox.alert("ข้อมูลไม่ถูกต้องกรุณาตรวจสอบข้อมูลสนามต่อไปนี้ <div class='alert alert-danger'>"+errs+"</div>", function() {
					});
	            }
	        },
	        error: function(jqXHR, textStatus, errorThrown) 
	        {
	            //if fails      
	        }
	    });
	    e.preventDefault(); //STOP default action
	});

	$(function() {
	    $('.timepicker').datetimepicker({
	      pickDate: false
	    });
	  });
});


var court = new google.maps.InfoWindow({
      content: "<span class='label label-danger'>ตำแหน่งคอร์ท</span>"
  });

 var marker = null;

function initialize() {

  var markers = [];
  var map = new google.maps.Map(document.getElementById('map-canvas'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    zoom: 12
  });

  //Geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        maxWidth: 500,
        content: "<div style='width: 120px;overflow:hidden;'>You are here</div>"
      });
      //console.log(pos)
      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }

  // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });

  google.maps.event.addListener(map, 'click', function(e) {

    placeMarker(e.latLng, map);
  });
}



function placeMarker(position, map) {
 	if(marker==null)marker = new google.maps.Marker({
	      position: position,
	      map: map,
	      title: 'พิกัด',
	      draggable:false
	  });
 	else marker.setPosition(position);

 	console.log(position);
 	$('#lat').val(position.lat());
 	$('#long').val(position.lng());
	 //court.open(map,marker);

  map.panTo(position);
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
</script>
@stop
@section('style')
<style>
	html, body {
        height: 100%;
        margin: 0px;
        padding: 0px

      }
      #map-canvas{
		width: 100%;
      	height: 400px;
      }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        text-overflow: ellipsis;
      }

      #pac-input:focus {
        border-color: #4d90fe;
        margin-left: -1px;
        padding-left: 14px;  /* Regular padding-left + 1. */
        width: 401px;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

	 #target {
        width: 345px;
      }
</style>
@stop
@section('content')

<div class="row">
  	<div class="col-md-12 left">
                <h1 class="title">แก้ไขข้อมูลคอร์ทแบดมินตัน</h1>
	</div>
	
  <div class="col-md-5 left">
	<div class="row">
	    <div class="col-md-12 center">
	        <div id="search-bar">
	        	<div class="input-group">
	        	<span class="input-group-addon">ค้นหาตำแหน่ง</span>
	            <input type="text" class='form-control' id="pac-input" placeholder="กรอกสถานที่ใกล้เคียง" style="width: 100% !important;"> 
	            </div>
	        </div>
	        <div class='alert alert-warning'>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<span class="glyphicon glyphicon-info-sign"></span> คลิกบนแผนที่เพื่อระบุพิกัดของคอร์ทแบดมินตัน</div>
	    </div>
	    <div class="col-md-12 center">
    		<div id="map-canvas"></div>
	    </div>
	</div>
  </div>
  <div class="col-md-7 left">
	
	
	<div class="row">
		
        <div class="col-md-12 left">
            <div id="open-team">
            {{ Form::model($gym, array('route' => array('gymupdate', $gym->id),'id'=>'editgym','role'=>'form','class'=>'form-horizontal','method'=>'post')) }}
             
						  <div class="form-group">
						    <label for="name" class="col-sm-2 control-label">ชื่อคอร์ท</label>
						    <div class="col-sm-8">
						      {{ Form::text('name',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="lat" class="col-sm-2 control-label">ละติจูด</label>
						    <div class="col-sm-4">
						    {{ Form::text('lat',null,array('class'=>'form-control','id'=>'lat','onkeyup'=>'$(this).val(\'\')')) }}
						     
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">ลองติจูด</label>
						    <div class="col-sm-4">
						      {{ Form::text('long',null,array('class'=>'form-control','id'=>'long','onkeyup'=>'$(this).val(\'\')')) }}
						    </div>

						  </div>
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">ที่อยู่</label>
						    <div class="col-sm-8">
						      {{ Form::text('address',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">จำนวนคอร์ท</label>
						    <div class="col-sm-4">
						      {{ Form::text('court_count',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">ประเภทคอร์ท</label>
						    <div class="col-sm-4">
						    	<select class="form-control" name="type">
						    	@foreach ($court_type as $type)
								    <option value='{{ $type->id }}' @if($gym->type==$type->id) selected @endif>{{ $type->name }}</option>
								@endforeach
						      	</select>
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">ค่าเช่าสนาม (บาท)</label>
						    <div class="col-sm-4">
						      {{ Form::text('fee',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">วันทำการ</label>
						    <div class="col-sm-12" style='margin-left: 8px;'>
						     
						     <input type="checkbox" name='openday[]' value='จันทร์' @if(Str::contains($gym->open_day,'จันทร์'))checked @endif> จันทร์
						     <input type="checkbox" name='openday[]' value='อังคาร' @if(Str::contains($gym->open_day,'อังคาร'))checked @endif> อังคาร
						     <input type="checkbox" name='openday[]' value='พุธ' @if(Str::contains($gym->open_day,'พุธ'))checked @endif> พุธ
						     <input type="checkbox" name='openday[]' value='พฤหัส' @if(Str::contains($gym->open_day,'พฤหัส'))checked @endif> พฤหัสบดี
						     <input type="checkbox" name='openday[]' value='ศุกร์' @if(Str::contains($gym->open_day,'ศุกร์'))checked @endif> ศุกร์
						     <input type="checkbox" name='openday[]' value='เสาร์' @if(Str::contains($gym->open_day,'เสาร์'))checked @endif> เสาร์
						     <input type="checkbox" name='openday[]' value='อาทิตย์' @if(Str::contains($gym->open_day,'อาทิตย์'))checked @endif> อาทิตย์
						     
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">เวลาเปิด</label>
						    <div class="col-sm-4 input-group ">
						    	<div class="bfh-timepicker" data-time="{{ $gym->open_time }}" data-name="open_time"></div>
								
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">เวลาปิด</label>
						    <div class="col-sm-4  input-group ">
						      	<div class="bfh-timepicker" data-time="{{ $gym->close_time }}" data-name="close_time"></div>
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">ติดต่อคุณ</label>
						    <div class="col-sm-4">
						      {{ Form::text('contact_person',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">โทร</label>
						    <div class="col-sm-4">
						      {{ Form::text('tel',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">ที่จอดรถ</label>
						    <div class="col-sm-4">
						      {{ Form::text('car_park',null,array('class'=>'form-control')) }}
						    </div>
						  </div>

						 
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-warning">บันทึก</button>
						    </div>
						  </div>
					{{ Form::close() }}
            </div>
        </div>
        		
	</div>
	
  </div>
</div>




@stop
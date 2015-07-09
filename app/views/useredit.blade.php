@extends('layouts.main')
@section('title')
Teebadgun.com : แก้ไขข้อมูลสมาชิก
@stop
@section('script')
<script>
var allAmphur;
jQuery( document ).ready(function( $ ) {
	allAmphur=$('select[name="district"]').children();

	province=$('select[name="province"]').val();
	$('option.amphur[province!="'+province+'"]').detach();

	$("#adduser").submit(function(e)
	{
	  

	    var formObj = $(this);
    	var formURL = formObj.attr("action");
    	var formData = new FormData(this);
	    $.ajax(
	    {
	        url : formURL,
	        type: "POST",
	        data : formData,
	        mimeType:"multipart/form-data",
    	contentType: false,
        cache: false,
        processData:false,
	        success:function(data, textStatus, jqXHR) 
	        {

	        	console.log(data);
	            if(data==1)bootbox.alert("ข้อมูลของท่านถูกแก้ไขเรียบร้อยแล้ว",function() {

	            	location.href='{{ action('HomeController@index'); }}';
					});
	            else {
	            	var obj = jQuery.parseJSON( data );
	            	var errs='<ul>';
	            	$.each( obj, function( key, value ) {
					  errs=errs+"<li>"+value+"</li>";
					});
					errs+="</ul>";
	            	bootbox.alert("ข้อมูลไม่ถูกต้องกรุณาตรวจสอบข้อมูลของท่าน <div class='alert alert-danger'>"+errs+"</div>", function() {
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
	
});

function showAmphur(){
	province=$('select[name="province"]').val();
	$('select[name="district"]').append(allAmphur);
	//$('option.amphur[province="'+province+'"]').show();
	$('option.amphur[province!="'+province+'"]').detach();

}

</script>
@stop
@section('style')
<style>
	html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
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
  	<div class="col-md-12 align-center" >
  <h1 class="title">แก้ไขข้อมูลสมาชิก</h1>
  </div>
  <div class="col-md-1 left">
	
  </div>
  <div class="col-md-10 left">
	
	
	<div class="row">
		
        <div class="col-md-12 left">
            <div id="open-team">
            			{{ Form::model($user, array('route' => array('userupdate', $user->id),'enctype'=>'multipart/form-data','id'=>'adduser','role'=>'form','class'=>'form-horizontal','method'=>'post')) }}
              
						  <div class="form-group">
						    <label for="name" class="col-sm-2 control-label">ชื่อผู้ใช้</label>
						    <div class="col-sm-4">
						      {{ Form::text('username',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						   <div class="form-group">
						    <label for="exampleInputFile" class="col-sm-2 control-label">รูปโฟรไฟล์</label>
						    <div class="col-sm-4">
						    <input type="file" id="picture" name="picture">
						    <p class="help-block">รูปจตุรัส ขนาดไม่เกิน 200KB</p>
						    </div>
						    @if($user->picture)
						    <div class='col-sm-6'>
						    	<img width="100" height="100" src="{{ $user->picture }}" />
						    </div>
						    @endif
						  </div>
						  <div class="form-group">
						    <label for="name" class="col-sm-2 control-label">รหัสผ่าน</label>
						    <div class="col-sm-4">
						      <input type="password" class="form-control"  name='password'>
						    </div>
						    <label for="name" class="col-sm-2 control-label">ยืนยันรหัสผ่าน</label>
						    <div class="col-sm-4">
						      <input type="password" class="form-control"  name='password2'>
						    </div>
						  </div>
						 
						  <div class="form-group">
						    <label for="lat" class="col-sm-2 control-label">ชื่อ</label>
						    <div class="col-sm-4">
						      {{ Form::text('firstname',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">สกุล</label>
						    <div class="col-sm-4">
						       {{ Form::text('lastname',null,array('class'=>'form-control')) }}
						    </div>
						    <div class="col-sm-4">
						    </div>

						  </div>
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">อีเมล์</label>
						    <div class="col-sm-4">
						      {{ Form::text('email',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">โทร</label>
						    <div class="col-sm-4">
						       {{ Form::text('phone',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">มือถือ</label>
						    <div class="col-sm-4">
						       {{ Form::text('mobile',null,array('class'=>'form-control')) }}
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">วันเกิด</label>
						    <div class="col-sm-4 input-group ">
						    	<div class="bfh-datepicker"  data-format="y-m-d" data-name="birthdate" data-date="{{ $user->birthdate }}"></div>
								
						    </div>
						    
						  </div>
						  

						   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">บ้านเลขที่</label>
						    <div class="col-sm-2">
						    	{{ Form::text('addressno',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">หมู่</label>
						    <div class="col-sm-2">
						    	{{ Form::text('moo',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">ซอย</label>
						    <div class="col-sm-2">
						    	{{ Form::text('soi',null,array('class'=>'form-control')) }}
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">ถนน</label>
						    <div class="col-sm-2">
						    	{{ Form::text('road',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">ตำบล</label>
						    <div class="col-sm-2">
						    	{{ Form::text('subdistrict',null,array('class'=>'form-control')) }}
						    </div>
						    <label for="inputPassword3" class="col-sm-2 control-label">อำเภอ</label>
						    <div class="col-sm-2">
						    	<select class="form-control" name="district">
						    	@foreach ($amphurs as $amphur)
								    <option class='amphur' province='{{ $amphur->province_id }}' value='{{ $amphur->id }}' @if($user->district==$amphur->id) selected @endif >{{ $amphur->name }}</option>
								@endforeach
								</select>
						    </div>
						  </div>

						   <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">จังหวัด</label>
						    <div class="col-sm-4">
						    	<select class="form-control" name="province" onchange='showAmphur();'>
						    	@foreach ($provinces as $province)
								    <option  value='{{ $province->id }}' @if($user->province==$province->id) selected @endif >{{ $province->name }}</option>
								@endforeach
						      	</select>
						    </div>
						  </div>
						  
						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">ลายเซ็นต์</label>
						    <div class="col-sm-10">
						      {{ Form::text('signature',null,array('class'=>'form-control')) }}
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">รูปภาพแรคเก็ต</label>
						    <div class="col-sm-10">

						      @if($user->flag_racket) <input type="file"  name="gear_racket"> @else <i class="fa fa-lock fa-lg"></i> locked @endif
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">รูปภาพเอ็น</label>
						    <div class="col-sm-10">
						       @if($user->flag_string) <input type="file"  name="gear_string"> @else <i class="fa fa-lock fa-lg"></i> locked @endif
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">รูปภาพรองเท้า</label>
						    <div class="col-sm-10">
						       @if($user->flag_shoes) <input type="file"  name="gear_shoes"> @else <i class="fa fa-lock fa-lg"></i> locked @endif
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">รูปภาพกระเป๋า</label>
						    <div class="col-sm-10">
						      @if($user->flag_bag) <input type="file"  name="gear_bag"> @else <i class="fa fa-lock fa-lg"></i> locked @endif
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

  <div class="col-md-1 left">
	
  </div>
</div>




@stop
@extends('layouts.main')
@section('title')
Teebadgun.com : เพิ่มสนามแบดมินตัน
@stop
@section('script')
<script src="http://twitter.github.com/hogan.js/builds/2.0.0/hogan-2.0.0.js"></script>
<script>

jQuery( document ).ready(function( $ ) {

	autoComplete();
	autoCompleteCourt();
	$("#addteam").submit(function(e)
	{
		var formObj = $(this);
	    var formData = new FormData(this);
	    var formURL = $(this).attr("action");
	    
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
	            if(data==1)bootbox.alert("คุณได้เพิ่มข้อมูลทีมใหม่เรียบร้อยแล้ว",function() {

	            	location.href='{{ route('home'); }}';
				});
	            else {
	            	var errs='<ul>';
	            	data=jQuery.parseJSON( data );
	            	$.each( data, function( key, value ) {
					  errs=errs+"<li>"+value+"</li>";
					});
					errs+="</ul>";
	            	bootbox.alert("ข้อมูลไม่ถูกต้องกรุณาตรวจสอบข้อมูลทีมต่อไปนี้ <div class='alert alert-danger'>"+errs+"</div>", function() {
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


function autoCompleteCourt(){
	$(function() {

    $("#court").autocomplete({
        source: function( request, response ) {
        $.ajax({
          url: "{{ route('home')}}/gym/autocomplete/"+$('#court').val(),
          dataType: "json",
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                name: item.name,
                value: item.name
              }
            }));
          }
        });
      },
        minLength: 1,
        messages: {
	        noResults: '',
	        results: function() {}
	    },
	    select: function( event, ui ) {

	        $('#court').val(ui.item.name);
	        
      	},
      	close: function() {

      	},
      	change: function(event,ui){
      		
      		if(ui.item==null)$('#court').val('');
      	}
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {

        var inner_html = '<a>'+
        '<div class="list_item_text" user_id="'+item.value+'">'+
        	'<p>'+ item.label+'</p>'+
        '</div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});

}
function unBlank(str){
	return str.replace(' ','-');
}
function addCourt(){
	if($.trim($('#court').val())==""){ 
		bootbox.alert("กรุณากรอกชื่อคอร์ท");
		return;
	}

	$('#courtlist').append('<div class="alert alert-info alert-dismissable"><button onclick="remove_hidden_court(\''+unBlank($('#court').val())+'\')" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4>'+$('#court').val()+'</h4><p> วัน <span class="label label-primary">'+toThaiDay($('#day').val())+'</span></p><p> เวลา '+$('#start_time').val()+'น. ถึง '+$('#end_time').val()+'น.</p></div>');
	obj={};
	obj.court=$('#court').val();
	obj.day=$('#day').val();
	obj.start_time=$('#start_time').val();
	obj.end_time=$('#end_time').val();
	obj.payment=$('#payment').val();
	obj.remark=$('#remark').val();
	$('<input>').attr('type','hidden').attr('name','court[]').attr('id',unBlank($('#court').val())).val(JSON.stringify(obj)).appendTo('form');

	$('#court').val('');
	$('#day').val('Mon');
	$('#payment').val('');
	$('#remark').val('');

}

function autoComplete(){
	$(function() {

    $("#manager").autocomplete({
        source: function( request, response ) {
        $.ajax({
          url: "{{ route('home')}}/user/autocomplete/"+$('#manager').val(),
          dataType: "json",
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.firstname +' '+item.lastname,
                value: item.id,
                picture: item.picture,
                username: item.username
              }
            }));
          }
        });
      },
        minLength: 1,
        messages: {
	        noResults: '',
	        results: function() {}
	    },
	    select: function( event, ui ) {
	        $('#managerlist').append('<p><span class="label label-info"><button onclick="remove_hidden_manager(\''+ui.item.value+'\')" type="button" class="close-manager" data-dismiss="alert" aria-hidden="true">&times;</button>'+ui.item.label+'</span></p>');
	        $('#manager').val('');
	        $('<input>').attr('type','hidden').attr('name','manager[]').val(ui.item.value).appendTo('form');
      	},
      	close: function() {
        $('#manager').val('');
      }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {

        var inner_html = '<a>'+
        '<div class="list_item_container" user_id="'+item.value+'">'+
        	'<div class="image">'+
        		'<img style="width:100%" src="' + item.picture + '" />'+
        	'</div>'+
        	'<div class="description"><p><strong>'+ item.username+'</strong></p><p>'+ item.label+'</p></div>'+
        '</div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});

}

function manualAddManager(){

	bootbox.confirm("ผู้ใช้ที่ต้องการเพิ่มไม่มีในระบบ<br />คลิกเพื่อยืนยันการเพิ่มหัวหน้าทีม", function(result) {
	  if(result){
	  	$('#managerlist').append('<p><span class="label label-info"><button onclick="remove_hidden_manager(\''+$('#manager').val()+'\')" type="button" class="close-manager" data-dismiss="alert" aria-hidden="true">&times;</button>'+$('#manager').val()+'</span></p>');
	  	$('<input>').attr('type','hidden').attr('name','manager[]').val($('#manager').val()).appendTo('form');
	  	$('#manager').val('');
	  }
	});
	
      
}
function remove_hidden_manager(name){
	$("input[name='manager[]'][value='"+name+"']").remove();
}

function remove_hidden_court(name){
	$("input[name='court[]'][id='"+name+"']").remove();
}

function toThaiDay(day){
	switch(day)
	{
		case "2":
		return "จันทร์";
		break;

		case "3":
		return "อังคาร";
		break;

		case "4":
		return "พุธ";
		break;

		case "5":
		return "พฤหัสบดี";
		break;

		case "6":
		return "ศุกร์";
		break;

		case "7":
		return "เสาร์";
		break;

		case "1":
		return "อาทิตย์";
		break;

		default:
		return "ไม่สามารถแปลวันได้";
	}
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

      .ui-menu{
      	width: 305px !important;
      	padding: 0px;
      }
      .ui-menu-item{
      	list-style-type: none;
      	 background-color: white;
    border-bottom: 1px solid #ccc;
   		vertical-align: middle;
      }

     .list_item_container {
    height: 50px;
     padding: 5px;
   
	}
	.list_item_container p{
    line-height: 50px;
   
	}
	.list_item_text p{
   	padding: 5px;
	}

	.list_item_container:hover{
		background-color: #FFAD00;
	}
	a.ui-corner-all{
		text-decoration: none;
		font-size: .9em;
	}
	.image {
	    width: 40px;
	    height: 40px;
	    float: left;
	    margin-right: 10px;
	}
	.description {
	    font-size: 1em;
	    color: #333;
	    max-width: 200px

	}
	.description p{
	    line-height: .8em;

	}
	.autocomplete-btn{
	    position: absolute;
		top: 5px;
		right: 5px;
	    
	}
	.close-manager{
		font-size: 21px;
		font-weight: bold;
		line-height: 1;
		color: #000000;
		text-shadow: 0 1px 0 #ffffff;
		opacity: 0.4;
		filter: alpha(opacity=20);
		margin-right: 5px;
		border:none;
		background:none;
		margin-bottom: 5px;
	}
	#managerlist span.label{
		font-size: 1em;
		font-weight: normal;
		
	}
</style>
@stop
@section('content')

<div class="row">
  	
  
<!--<div class="col-md-12 left">
	<div class="alert alert-danger alert-dismissable">
	  <strong>คำเตือน!</strong> กรุณากรอกข้อมูลทีมตามความเป็นจริง ทีมที่พบว่าไม่มีอยู่จริงบนโลกใบนี้จะถูกลบโดยอัตโนมัติ
	</div>	
	</div> -->
  <div class="col-md-4 left">
  <h4 style="margin-top: 60px;">มาเพิ่มทีมแบดมินตันใหม่ให้เป็นที่รู้จัก</h4>
	<div class="">
	  
	  <div class="media">
	  <a class="pull-left" href="#">
	    <img class="media-object" src="{{ asset('assets/images/addteam_icon1.gif'); }}" alt="icon" width="80" height="80">
	  </a>
	  <div class="media-body">
	    <h4 class="media-heading">ชื่อทีม</h4>
	    การเพิ่มทีมสามารถทำได้ง่ายโดยการกรอกชื่อทีมและเลือกหัวหน้าทีมจากรายชื่อ
	  </div>
	</div>
	<div class="media">
	  <a class="pull-left" href="#">
	    <img class="media-object" src="{{ asset('assets/images/addteam_icon2.gif'); }}" alt="icon" width="80" height="80">
	  </a>
	  <div class="media-body">
	    <h4 class="media-heading">โลโก้</h4>
	    อย่าลืมเพิ่มโลโก้ทีมสวยๆ เพื่อให้แสดงบนหน้าข้อมูลทีม
	  </div>
	</div>
	<div class="media">
	  <a class="pull-left" href="#">
	    <img class="media-object" src="{{ asset('assets/images/addteam_icon3.gif'); }}" alt="icon" width="80" height="80">
	  </a>
	  <div class="media-body">
	    <h4 class="media-heading">อย่าลืมเปิดคอร์ท</h4>
	    เลือกสถานที่เล่นอย่างน้อยหนึ่งสถานที่ ระบบจะบันทึกพิกัดของทีมให้อัตโนมัติ
	  </div>
	</div>
	<div class="media">
	  <a class="pull-left" href="#">
	    <img class="media-object" src="{{ asset('assets/images/addteam_icon4.gif'); }}" alt="icon" width="80" height="80">
	  </a>
	  <div class="media-body">
	    <h4 class="media-heading">เพิ่มแกลเลอรี่ได้ด้วย</h4>
	    คุณสามารถเพิ่มรูปภาพทีมได้หลังจากได้เพิ่มข้อมูลทีมแล้ว :)
	  </div>
	</div>
	 
	</div>
  </div>

  <div class="col-md-8 left">
	
	<h1 class="title">เพิ่มข้อมูลทีม</h1>
	<div class="row">
		
        <div class="col-md-12 left">
            <div id="open-team">
                         {{ Form::open(array('url' => 'team/insert','method'=>'post','enctype'=>'multipart/form-data','id'=>'addteam','role'=>'form','class'=>'form-horizontal')) }}
						  <div class="form-group">
						    <label for="name" class="col-sm-2 control-label">ชื่อทีม</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control"  name='name'>
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="exampleInputFile" class="col-sm-2 control-label">โลโก้ทีม</label>
						    <div class="col-sm-4">
						    <input type="file" id="logo" name="logo">
						    <p class="help-block">รูปจตุรัส ขนาดไม่เกิน 200KB</p>
						    </div>
						    
						  </div>
						  
						  <div class="form-group">
						  	 <div class="col-sm-2"></div>
						  	<div class="col-sm-10" id="managerlist">
						      <p>ยังไม่ได้เลือกผู้จัดการทีม</p>
						    </div>
						    <label for="inputEmail3" class="col-sm-2 control-label">ผู้จัดการทีม</label>
						    <div class="col-sm-4">
						      <input id="manager" type="text" class="form-control" name="manager" placeholder="ค้นหาชื่อ">
						    </div>
						    <div class="col-sm-2">
						    <button type="button" class="btn btn-medium btn-info" onclick="manualAddManager()" >เพิ่มเอง</button>
						    </div>
						    <div class="col-sm-4">
						      
						    </div>
						  </div>
						  
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">วันทำการ</label>
						    <div class="col-sm-6 well">
						    	<div class="form-group">
							    	<label class="col-sm-4 control-label">วัน</label>
							    	<div class="col-sm-8">
							    	{{ Form::select('day', array('2' => 'จันทร์', '3' => 'อังคาร', '4' => 'พุธ', '5' => 'พฤหัสบดี', '6' => 'ศุกร์', '7' => 'เสาร์', '1' => 'อาทิตย์'),null, array('class' => 'form-control','id'=>'day')) }}
							    	</div>
							    </div>
							    <div class="form-group">
									<label class="col-sm-4 control-label">คอร์ท</label>
									<div class="col-sm-8">
										{{ Form::text('gym',null,array('class'=>'form-control','placeholder'=>'ค้นหาชื่อคอร์ท','id'=>'court')) }}
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label"></label>
									<div class="col-sm-8">
										ไม่มีคอร์ทในลิสต์? <a href="{{ route('gymadd')}}" target="_blank" class="btn btn-xs btn-warning" ><span class="glyphicon glyphicon-plus"></span> เพิ่มคอร์ทใหม่</a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">เวลาเริ่ม</label>
									<div class="col-sm-8">
									<div class="bfh-timepicker" data-time="18:00" data-name="start_time" id="start_time"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">ถึง</label>
									<div class="col-sm-8">
									<div class="bfh-timepicker" data-time="24:00" data-name="end_time" id="end_time"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">วิธีคิดค่าสนาม</label>
									<div class="col-sm-8">
									{{ Form::text('payment',null,array('class'=>'form-control','id'=>'payment')) }}
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">หมายเหตุ</label>
									<div class="col-sm-8">
									{{ Form::text('remark',null,array('class'=>'form-control','id'=>'remark')) }}
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label"></label>
									<div class="col-sm-8">
									 <button type="button" onclick="addCourt();" class="btn btn-medium btn-info" >เพิ่ม</button>
									</div>
								</div>
						  	</div>
						  	<div class="col-sm-4">
						  		<div id="courtlist"></div>
						  	</div>
						 </div>
						

						  
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">โทร</label>
						    <div class="col-sm-4">
						      <input type="text" class="form-control" name="tel">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">คติ/คำขวัญ</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="motto">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">รายละเอียดอื่นๆ</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="description">
						    </div>
						  </div>
						  
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-default">บันทึก</button>
						    </div>
						  </div>
					{{ Form::close() }}
            </div>
        </div>
        		
	</div>
	
  </div>
</div>




@stop
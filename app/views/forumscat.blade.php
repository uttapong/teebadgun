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
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
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
                <h1 style="margin-left: 30px;">หัวข้อ : {{$catinfo->title}} 
                  @if (Auth::user())
                <div style="float:right;"><button onclick="$('#addform').slideToggle()" class='btn btn-info' ><i class="glyphicon glyphicon-plus"></i> ตั้งกระทู้ใหม่</button></div>
                @endif


                </h1>
       <div id="addform" style="display:none;border: 1px solid #aaa;padding:10px 50px;background-color: rgba(50,50,50,0.3);">
          <h3>ตั้งกระทู้ใหม่</h3>
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
                   <textarea class="form-control" name='content' rows="8" style="width:650px;height: 100px;background-color: #fff;"></textarea>
                </div>
              </div>
             
             
              
              <div class="form-group">

                <div class="col-sm-offset-2 col-sm-8">
                  <button type="submit" class="btn btn-default">ตั้งกระทู้</button>
                </div>
              </div>
              <input type="hidden" name="cat" value="{{$catinfo->id}}" />
          {{ Form::close() }}
            </div>
        </div>
            
  </div>

       </div>


  </div>
        <div class="col-md-12 left">
            <div class="paginate-container"> {{$all_topics->links();}}</div>
            <div id="forums-topics">
                <ul >
                   
                      <li class="" style="clear:both">
                      <div class='ftitle'><p>หัวข้อ </p></div>
                      <div class='meta'>

                      <div class='read'>อ่านแล้ว</div>
                      <div class='reply'>ตอบกลับ</div>
                      <div class='updated'>ตอบกลับล่าสุด</div>
                      </div>
                    </li>
                  @foreach($all_topics as $topic)
                    <li class="" style="clear:both">
                    <div class='ftitle'><p><a href="{{route('topic',array($topic->id,$topic->subject))}}">
                            <span class="glyphicon glyphicon-comment"></span> {{$topic->subject}}</a> <span style="color: #aaa;"> โดย {{$topic->getowner->username}}</span></p></div>
                      <div class='meta'>
                      
                      <div class='read'><span class="label @if($topic->view>0)label-success @else label-default @endif">{{$topic->view}}</span></div>
                      <div class='reply'><span class="label @if(count($topic->replies))label-success @else label-default @endif">{{count($topic->replies)}}</span></div>
                      <div class='updated'><span class="label label-default">{{$topic->format_last_update()}}</span></div>
                      </div>
                    </li>
                  @endforeach
                </ul>
            </div>
        </div>
  </div>
  
  </div>
</div>

@stop

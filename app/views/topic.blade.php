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

function removeTopic(id){
  bootbox.confirm("ท่านแน่ใจหรือไม่ว่าต้องการลบกระทู้นี้?", function(result) {
    if(result){
      location.href='{{route('removetopic',array($topic->id))}}';
    }
  }); 
}

function removeReply(id){
  bootbox.confirm("ท่านแน่ใจหรือไม่ว่าต้องการลบข้อความนี้?", function(result) {
    if(result){
      location.href='{{url('forums/removereply')}}/'+id;
    }
  }); 
}

    </script>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
@stop
@section('content')
{{$breadcrumbs}}
<div class="row">
  
</div>
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
                <h3 style="margin-left: 30px;">หัวข้อ : {{$topic->subject}} 

                @if (Auth::user()&&Auth::user()->id==$topic->getowner->id||(Auth::user()&&Auth::user()->username=='admin'))
                <div style="float:right;"><button onclick="$('#addform').slideToggle()" class='btn btn-warning' ><i class="glyphicon glyphicon-pencil"></i> แก้ไขกระทู้</button>
                <button onclick="removeTopic({{$topic->id}});" class='btn btn-danger' ><i class="glyphicon glyphicon-remove"></i> ลบกระทู้</button>
                </div>
                @endif
                </h3>

                <div id="addform" style="display:none;">
          
  <div class="row">
    
        <div class="owner-block" style="border: 1px solid #aaa;background-color: rgba(50,50,50,0.3);">
              

                         {{ Form::open(array('url' => route('updatetopic',array($topic->id)),'method'=>'post','id'=>'updatetopic','role'=>'form','class'=>'form-horizontal')) }}
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                  <h3>แก้ไขกระทู้</h3>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ชื่อเรื่อง</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control"  name='title' value="{{$topic->subject}}">
                </div>
              </div>

               <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ข้อความ</label>
                <div class="col-sm-8">
                   <textarea class="form-control" name='content' rows="8" style="width:650px;height: 100px;background-color: #fff;">
                      {{$topic->content}}
                   </textarea>
                </div>
              </div>
             
             
              
              <div class="form-group">

                <div class="col-sm-offset-2 col-sm-8">
                  <button type="submit" class="btn btn-default">อัพเดท</button>
                </div>
              </div>
              <input type="hidden" name="topicid" value="{{$topic->id}}" />
          {{ Form::close() }}
           
        </div>
            
  </div>

       </div>




                <div class='owner-block'>
                @if($topic->getowner)
                <div class='writer'>
                <p>
                <a href="{{ route('profile',array($topic->getowner->id,$topic->getowner->username)) }}">
                @if($topic->getowner->picture)
            <img src="{{ $topic->getowner->picture }}" class="profile-image-s" />
            @else
            <img src="{{ asset('assets/images/guest.jpg'); }}" class="profile-image-s" />
            @endif
            <strong>{{$topic->getowner->username}}</strong>
            </a>
            </p>
            <p>@foreach($topic->getowner->userbadges as $userbadge)
            <div class='badge-icon-sm'><a href='javascript:void(0);' onclick='showBadge({{$userbadge->badge->id}},"{{$userbadge->badge->name}}","{{$userbadge->badge->desc}}")'>
            <p><img src='{{ asset('assets/images/badge/'.$userbadge->badge->id.'.png') }}' alt="{{$userbadge->badge->name}}"/></p>
            </a></div>
          @endforeach

              </p></div>
              @endif
                <p>{{$topic->content}}</p>
                <hr/>
                <p>
                @if($topic->getowner)
                {{$topic->getowner->signature}}
                @endif</p>
            </div>
          @foreach($replies as $reply)
            @if($reply->getowner)
              @if($reply->getowner->id ==$topic->getowner->id)<div class='owner-block'>
              @else<div class='reply-block'>
              @endif
                <div class='writer'>
                <p>
                <a href="{{ route('profile')}}/{{$reply->getowner->username}}">
                @if($reply->getowner->picture)
            <img src="{{ $reply->getowner->picture }}" class="profile-image-s" />
            @else
            <img src="{{ asset('assets/images/guest.jpg'); }}" class="profile-image-s" />
            @endif
            <strong>{{$reply->getowner->username}}</strong>
            </a>
            </p>
            <p>@foreach($reply->getowner->userbadges as $userbadge)
            <div class='badge-icon-sm'><a href='javascript:void(0);' onclick='showBadge({{$userbadge->badge->id}},"{{$userbadge->badge->name}}","{{$userbadge->badge->desc}}")'>
            <p><img src='{{ asset('assets/images/badge/'.$userbadge->badge->id.'.png') }}' alt="{{$userbadge->badge->name}}"/></p>
            </a></div>
            
          @endforeach

              </p></div>
                <div style="float:left;width: 60%;"><p >{{$reply->content}}</p> 
                <hr/>
                <p>{{$reply->getowner->signature}}</p>
                </div>
                @if ((Auth::user()&&Auth::user()->id==$reply->getowner->id)||(Auth::user()&&Auth::user()->username=='admin'))
                <div style="float:right"><button onclick="removeReply({{$reply->id}});" class='btn btn-danger btn-xs' ><i class="glyphicon glyphicon-remove"></i> ลบข้อความ</button></div>
                @endif
            </div>
            @endif
          @endforeach

          
     @if (Auth::user())     
  <div class="row" >
    
        <div class="owner-block" id="addreply" style="border: 1px solid #aaa;background-color: rgba(50,50,50,0.3);">
            
                         {{ Form::open(array('url' => route('insertreply'),'method'=>'post','id'=>'insertreply','role'=>'form','class'=>'form-horizontal')) }}
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                  <h3>ตอบกระทู้</h3>
                </div>
              </div>

               <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ข้อความ</label>
                <div class="col-sm-8">
                   <textarea class="form-control" name='content' rows="8" style="width:650px;height: 100px;background-color: #fff;">
                    
                   </textarea>
                </div>
              </div>
             
             
              
              <div class="form-group">

                <div class="col-sm-offset-2 col-sm-8">
                  <button type="submit" class="btn btn-default">บันทึก</button>
                </div>
              </div>
              <input type="hidden" name="topicid" value="{{$topic->id}}" />
          {{ Form::close() }}
            
        </div>
            
  </div>
  @else
    <div class="row" >
      <div class=" col-md-12 left">
        <div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>ท่านยังไม่ได้ล๊อคอิน</strong>  กรุณาล๊อคอิน 
        <a href="{{route('login')}}" class='btn btn-info btn-xs' ><i class="fa fa-unlock-alt"></i> ที่นี่</a> ก่อนเพื่อตอบกระทู้</div>
      </div>
    </div>
  @endif
      

       


  </div>
        
  </div>
  
  </div>
</div>

@stop

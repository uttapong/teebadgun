@extends('layouts.main')
@section('title')
Teebadgun.com : {{$news->title}}
@stop

@section('og')
@if($news->filename())
		
<meta property="og:image" content="{{ $news->getoriginalfile() }}" /> 
@endif

<meta property="og:url" content="{{Request::url()}}" /> 
<meta property="og:title" content="{{$news->title}}" />
<meta property="og:description" content="{{$news->shorten()}}" />

@stop


@section('script')
<script src="http://twitter.github.com/hogan.js/builds/2.0.0/hogan-2.0.0.js"></script>
<script>

</script>
@stop
@section('style')
<style>

</style>
@stop
@section('content')
<a name="head" ></a>
<div class="row">

	<div class="col-md-12 left">
		<div class="row">
        <div class="col-md-12 left">
         @if(Session::has('message'))
                        {{ Session::get('message') }}
                    
            @endif
        	<h1>{{stripslashes($news->title)}}</h1>
        	<p><a class="btn btn-info btn-large" href="{{ route('home') }}/{{$route}}"><i class="fa fa-reply fa-lg"></i> กลับสู่หน้าหลัก</a> <div class="fb-share-button" data-href="{{ route('news',array($news->slug)) }}" data-width="200" data-type="button_count"></div></p>
            @if($news->filename())
			<img  src="{{ $news->getoriginalfile() }}" style="max-width: 50%;float: right;margin: 0px 0px 15px 25px;" />
			@endif
            <p>{{ stripslashes($news->content) }}</p>
            <hr />

            <div class="well" style='clear:both;'>
            @foreach($news->comments as $comment)
            <div class='well'>
            <div class="media">
              <a class="pull-left" href="#">
                <img style="width:80px" class="media-object" src="{{User::find($comment->author)->picture}}" alt="...">
              </a>
              <div class="media-body">
                <h5 class="media-heading">{{User::find($comment->author)->username}}</h5>
                {{$comment->body}}
                <br /><br />
                <span class='post-meta label label-default'>โพสต์เมื่อ {{$comment->created_at}}</span>
              </div>
            </div>
            </div>
            @endforeach
             @if (Auth::user())
            <form method='post' action="{{route('addcomment',array($news->id))}}" id='addcomment' role='form' class='form-horizontal'>
            
            <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">เพิ่มความคิดเห็น</label>
                            <div class="col-sm-8">
                              <textarea class="form-control" rows="4" name="comment"></textarea>
                            </div>
                            <button type="submit" class='btn btn-lg btn-info'>บันทึก</button>
                          </div>
           </form>
            @else
                <div class="row" >
                  <div class=" col-md-12 left">
                    <div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>ท่านยังไม่ได้ล๊อคอิน</strong>  กรุณาล๊อคอิน 
                    <a href="{{route('login')}}" class='btn btn-info btn-xs' ><i class="fa fa-unlock-alt"></i> ที่นี่</a> ก่อนเพื่อตอบกระทู้</div>
                  </div>
                </div>
              @endif
            </div>
            <a class="btn btn-default btn-large" href="#head"><i class="fa fa-arrow-circle-up fa-lg"></i> ขึ้นบนสุด</a>

        </div>
	</div>
	</div>
</div>

@stop
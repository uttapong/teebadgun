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
            <p>
            @if($team->team->logo)
                      <img src="{{ asset('uploads/teams/') }}/{{$team->team->id}}/{{$team->team->logo}}" class='team-logo-icon'/>
                    @else
                      <img src="{{ asset('assets/images/unknow.png') }}" class='team-logo-icon'/>
                    @endif
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
  <div class="col-md-3 left">
	<div class="row">
		@include('stat')
	</div>
  </div>
  <div class="col-md-9 left">
	
	
	<div class="row">
		<div class="col-md-12 left">
                <h1 class="title">ทีมที่เปิดทำการวันนี้</h1>
        </div>
        <div class="col-md-6 left">
            <div id="open-team">
                <ul>
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
        <div class="col-md-6 left">
            <div id="open-team">
                <ul>
                  @foreach($open_teams2 as $team)
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



<div class="row">
   <div class="col-md-4 left">
    <div class="row">
        <div class="col-md-12 left">
          <h2 class="title">ประกาศการแข่งขัน</h2>
            <div class="news-list">
            @if($announcement_all->first()->filename())

        <img style="width: 80%" src="{{ $announcement_all->first()->getfile() }}" />
        @else
        <img style="width: 80%" src="{{ asset('assets/images/headline.jpg'); }}" />
        @endif
        <p class='excerpt'>{{$announcement_all->first()->shorten()}}</p>
                <ul>
                  @foreach($announcement_all as $news)
                    <li><a href="{{ route('news',array($news->slug)) }}" >{{ $news->title }}</a></li>
                    @endforeach
                </ul>
                <a href="{{route('announcement')}}" class='btn btn-info btn-xs more'>อ่านทั้งหมด</a>
            </div>
            
        </div>
        
    
  </div>
  </div>

  
  <div class="col-md-4 left">
    <div class="row">
        <div class="col-md-12 left">
          <h2 class="title">บทความแบดมินตัน</h2>
            <div class="news-list">
            @if($article_all->first()->filename())

        <img style="width: 80%" src="{{ $article_all->first()->getfile() }}" />
        @else
        <img style="width: 80%" src="{{ asset('assets/images/headline.jpg'); }}" />
        @endif
        <p class='excerpt'>{{$article_all->first()->shorten()}}</p>
                <ul>
                  @foreach($article_all as $news)
                    <li><a href="{{ route('news',array($news->slug)) }}" >{{ $news->title }}</a></li>
                    @endforeach
                    
                </ul>
                <a href="{{route('article')}}" class='btn btn-info btn-xs more'>อ่านทั้งหมด</a>
            </div>
            
        </div>
        
    
  </div>
  </div>

  <div class="col-md-4 left">
    <div class="row">
        <div class="col-md-12 left">
          <h2 class="title">ข่าวแบดมินตัน</h2>
            <div class="news-list">
            @if($news_all->first()->filename())

        <img style="width: 80%" src="{{ $news_all->first()->getfile() }}" />
        @else
        <img style="width: 80%" src="{{ asset('assets/images/headline.jpg'); }}" />
        @endif
        <p class='excerpt'>{{$news_all->first()->shorten()}}</p>

                <ul>
                  @foreach($news_all as $news)
                    <li><a href="{{ route('news',array($news->slug)) }}" >{{ $news->title }}</a></li>
                    @endforeach
                </ul>
                <a href="{{route('news')}}" class='btn btn-info btn-xs more'>อ่านทั้งหมด</a>
            </div>
            
        </div>
        
    
  </div>
  </div>

 

</div>

<div class="row hightlight">
    <div class="col-md-4 center">
      <a href="{{route('where')}}" >
      <img src="{{ asset('assets/images/question.png'); }}" />
      <h2>ตีที่ไหนดี</h2>
      <p>คุณสามารถค้นหาคอร์ทแบดมินตัน และทีมแบดมินตันได้โดยการค้นหาจากแผนที่ คุณยังสามารถประกาศหาเพื่อนที่ลงบนโซเชียลเนตเวิร์คได้อีกด้วย</p>
      </a>
    </div>
    <div class="col-md-4 center">
    <a href="{{route('forums')}}" >
      <img src="{{ asset('assets/images/chat.png'); }}" />
      <h2>พูดคุย</h2>
      <p>คุณยังสามารถพูดคุยเรื่องราว ข่าวสาร ประสบการณ์ หรือเทคนิคต่างๆ เกี่ยวกับการเล่นแบดมินตัน แสดงความคิดเห็นเกี่ยวกับข่าว หรือประกาศการแข่งขันที่กำลังจะมีขึ้น </p>
    </a>
    </div>
    <div class="col-md-4 center">
    <a href="{{route('addteam')}}" >
      <img src="{{ asset('assets/images/plus.png'); }}" />
      <h2>เพิ่มข้อมูลทีม หรือ คอร์ท</h2>
      <p>คุณสามารถสร้างทีม และคอร์ทแบดมินตันที่คุณรู้จัก และมอบหมายหัวหน้าทีมเพื่ออำนวยความสะดวกแก่การค้นหา หรือเชิญชวนผู้เล่นท่านอื่นให้มาเล่นด้วยกัน</p>
    </a>
    </div>
</div>

@stop

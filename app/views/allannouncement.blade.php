@extends('layouts.main')
@section('title')
Teebadgun.com : เพิ่มสนามแบดมินตัน
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

<div class="row">


	<div class="col-md-12 left">
		<div class="row headline">
			@foreach($news_latest as $news)
				<div class="col-md-4 left block">
				<h2>{{ $news->title }}</h2>
				@if($news->filename())

				<img style="width: 100%" src="{{ $news->getfile() }}" />
				@else
				<img style="width: 100%" src="{{ asset('assets/images/headline.jpg'); }}" />
				@endif
				<p>{{ $news->shorten() }} <a href='{{ route('announcement',array($news->slug)) }}' class="btn btn-info btn-xs">อ่านต่อ <i class="fa fa-chevron-circle-right fa-lg"></i></a></p>
				</div>
			@endforeach
			
		</div>
	</div>
	<div class="col-md-12 left">
		<div class="row">
        <div class="col-md-12 left">
        	<h2 class="title">ประกาศ/การแข่งขัน</h2>
            <div class="news-list">
                <ul>
                	@foreach($news_all as $news)
                    <li><a href="{{ route('announcement',array($news->slug)) }}" ><i class="fa fa-arrow-circle-right fa-lg"></i> {{ $news->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            {{ $news_all->links(); }}
        </div>
        
		
	</div>
	</div>
</div>

@stop
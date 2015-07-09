@extends('layouts.admin')

@section('script')
<script>
function confirmDelete(id){

	bootbox.confirm("คุณต้องการลบบทความนี้?", function(result) {
  
  if(result){
  	location.href='{{route('home')}}/manage/content/remove/'+id;
  }
}); 
}
</script>
@stop
@section('style')
<style>

</style>
@stop
@section('content')
@if(Session::has('message'))
    {{ Session::get('message') }}
@endif
<h1>บทความทั้งหมด</h1>
<p><a href="{{route('new_content')}}" class="btn btn-info">New content</a> </p>
<table class='table table-hover table-striped' style="font-size: 12px;">
<tr> 
	<th>หัวข้อ</th>
	<th>ประเภท</th>
	<th>last updated</th>
	<th>edit</th>
	<th>delete</th>
</tr>

@foreach($contents as $content)
	<tr>
    <td><a target="_blank" href="{{ route('news',array($content->slug)) }}" > {{ $content->title }}</a></td>
    <td>{{ $content->category }}</td>
    <td>{{ $content->updated_at }}</td>
    <td><a class='btn btn-sm btn-warning' href="{{ route('edit_content',array($content->id)) }}" > edit</a></td>
    <td><button class='btn btn-sm btn-danger' onclick="confirmDelete({{$content->id}});" > delete</a></td>
    </tr>
 @endforeach
 
 </table>
 {{ $contents->links(); }}
@stop

@extends('layouts.admin')

@section('script')
<script>
$( document ).ready(function() {
  nicEditors.allTextAreas();
});

</script>
@stop
@section('style')
<style>

</style>
@stop
@section('content')
<h1>แก้ไขบทความ</h1>
{{ Form::model($content, array('route' => array('edit_content', $content->id),'enctype'=>'multipart/form-data','id'=>'editcontent','role'=>'form','method'=>'post')) }}
  <div class="form-group">
    <label for="exampleInputEmail1">หัวข้อ</label>
   {{ Form::text('title',null,array('class'=>'form-control')) }}
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">ประเภท</label>
    {{ Form::select('category', array('news' => 'news', 'article' => 'article', 'announcement' => 'announcement'),'news', array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">slug</label>
    {{ Form::text('slug',null,array('class'=>'form-control')) }}
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Image</label>
    <input type="file" name="upload">
    @if($content->upload()->count()>0)
    <img style="width: 200px;" src="{{Config::get('app.public_url')}}uploads/contents/{{$content->id}}/{{$content->upload()->first()->filename}}" />
    @endif
    
    <p class="help-block">รูปภาพที่ต้องการแสดงในหัวข้อข่าว</p>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Content</label>
    <textarea style="width:98%;" rows="5" name="content">{{$content->content}}</textarea>
  </div>
  
  <button type="submit" class="btn btn-success">บันทึก</button> <a href="{{route('new_content')}}" class="btn btn-danger">ยกเลิก</a>
{{Form::close()}}
@stop

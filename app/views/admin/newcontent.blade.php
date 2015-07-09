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
<h1>เพิ่มบทความใหม่</h1>
{{ Form::open(array('url' => 'add_content','method'=>'post','enctype'=>'multipart/form-data','id'=>'newcontent','role'=>'form')) }}
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
    <p class="help-block">รูปภาพที่ต้องการแสดงในหัวข้อข่าว</p>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Content</label>
    <textarea style="width:98%;" rows="5" name="content"></textarea>
  </div>
  
  <button type="submit" class="btn btn-success">บันทึก</button> <a href="{{route('new_content')}}" class="btn btn-danger">ยกเลิก</a>
{{Form::close()}}
@stop

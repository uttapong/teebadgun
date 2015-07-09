<?php

class ContentController extends BaseController {

	protected $layout = 'layouts.main';
	
	public function newcontent()
	{
		$data=array();
		return View::make('admin/newcontent');
	}
	public function add(){
	//dd(implode(',',Input::get('openday')));
		//dd(Input::all());
		
		//$new_content = Input::except('_token','password2');
		$new_content = Input::except('_token');
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'title' => 'required',
		 'slug' => 'required|unique:contents',
		 'content' => 'required',
		 'category'=>'required'
		 );
		 // make the validator

		$v = Validator::make($new_content, $rules);
		//dd($v->fails());
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();
		 	//return json_encode(array('result'=>0,'message'=>$v->messages()));
		 
		 }
		 else{ }
		 // create the new post
		$new_content['slug']=$this::seoUrl(Input::get('slug'));
		$new_content['title']=stripslashes(Input::get('title'));
		$new_content['content']=stripslashes(Input::get('content'));
		$content = new Content($new_content);
		$result=$content->save();

		if (Input::hasFile('upload'))
		{

			$dest=public_path()."uploads/contents/".$content->id."/";
			//dd($dest);
			if( ! file_exists($dest)) {
			    mkdir($dest, 0777);
			}
			$extension = Input::file('upload')->getClientOriginalExtension();
			$filename=uniqid().".".$extension;
			
			/*if (!is_dir($dest)) {
				mkdir($dest, 0777);
				dd($dest);

			}*/
		    Input::file('upload')->move($dest,$filename);

		    $upload=new Upload(array(
		    	'uploadable_id'=>$content->id,
		    	'path'=>'content',
		    	'filename'=>$filename,
		    	'extension'=>$extension

		    	));
		   $upload->save();
		}



		if($result){
			$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> เพิ่มเนื้อหาใหม่เรียบร้อยแล้ว</div>";
			Session::flash('message', $msg);



		}
		return Redirect::route('admin');
		

	}
	public function edit($id){
		if(Input::has('title')){


		$new_content = Input::except('_token');
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'title' => 'required',
		 'slug' => 'required',
		 'content' => 'required',
		 'category'=>'required'
		 );
		 // make the validator

		$v = Validator::make($new_content, $rules);
		//dd($v->fails());
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();
		 	//return json_encode(array('result'=>0,'message'=>$v->messages()));
		 
		 }
		 else{
		 	
		 	$content = Content::find($id);
		 	$content->title=stripslashes(Input::get('title'));
		 	$content->slug=$this::seoUrl(Input::get('slug'));
		 	$content->category=Input::get('category');
		 	$content->content=stripslashes(Input::get('content'));

			$result=$content->save();
			//dd($result);
			if (Input::hasFile('upload'))
			{

				Upload::where('uploadable_id', '=', $content->id)->delete();
				
				$dest=public_path()."/uploads/contents/".$content->id."/";
				if( ! file_exists($dest)) {
				    mkdir($dest, 0777);
				}

				$extension = Input::file('upload')->getClientOriginalExtension();
				$filename=uniqid().".".$extension;
				
			    Input::file('upload')->move($dest,$filename);

			    $upload=new Upload(array(
			    	'uploadable_id'=>$content->id,
			    	'path'=>'content',
			    	'filename'=>$filename,
			    	'extension'=>$extension

			    	));
			   $upload->save();

			   
			}

			if($result){
					$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> แก้ไขบทความเรียบร้อยแล้ว</div>";
					return Redirect::route('admin')->with('message',$msg);
			}
		 }


		}
		else{
			$data['content']= Content::where('id',$id)->first();
			//dd($data['content']);
			return View::make('admin/editcontent',$data);
		}

	}
	
	function index(){
		$data['contents']=Content::orderBy('updated_at', 'DESC')->paginate(12);
		return View::make('admin/content',$data);

	}
	
	function remove($id){

		if(Content::find($id)){

		Upload::where('uploadable_id', '=', $id)->delete();	

		Content::find($id)->delete();
		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> บทความถูกลบเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);
		}
		else{

			$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-ok'></span> ไม่พบบทความที่ต้องการลบ</div>";
			Session::flash('message', $msg);
		}
		return Redirect::route('admin');
	}

	function seoUrl($text) {
    //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
	   // $text = strtolower($text);
	    //Strip any unwanted characters
	     $text = str_replace(' ', '-', $text);
		 $text = preg_replace( '/[«»"!?,.]+/', '', $text );
		 $text=str_replace('\\', '', $text);

		 // $text = strtolower(trim($text, '-'));

		  return $text;
	}
	function addcomment($contentid){
		$content=Content::find($contentid);
		//die($contentid);
		$new_comment = array(
		 'content' => $contentid,
		 'body' => nl2br(Input::get('comment')),
		 'author' => Auth::user()->id
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'body' => 'required'
		 );
		 // make the validator
		$v = Validator::make($new_comment, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		$comment = new Comment($new_comment);
		$result=$comment->save();
		
		if($result){
			$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> เพิ่มข้อคิดเห็นของท่านเรียบร้อยแล้ว</div>";
			
		}
		else{

			$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-ok'></span> ไม่สามารถเพิ่มข้อคิดเห็นได้ กรุณาลองอีกครั้ง</div>";			
		}
		Session::flash('message', $msg);
		return Redirect::route($content->category,array($content->slug));
	}
	
	
}

?>

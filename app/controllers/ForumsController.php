<?php

class ForumsController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public function home(){
		$facebook = new Facebook(array(
		  'appId'  => '612396988819496',
		  'secret' => 'e2ab814a26b255a01ee2bc59fe8f3995',
		));


				// Get User ID
		$user = $facebook->getUser();
		
		  //$data['statusUrl'] = $facebook->getLoginStatusUrl();
		  $data['loginUrl'] = $facebook->getLoginUrl();
		   //dd($loginUrl);
		$data['all_cat']=Forumscategory::orderBy('created_date')->get();

		$data['all_cat_count']=Forumstopic::all()->count();
		$data['general_cat_count']=Forumstopic::where('cat', '=',3)->count();
		$data['review_cat_count']=Forumstopic::where('cat', '=',4)->count();
		$data['support_cat_count']=Forumstopic::where('cat', '=',5)->count();
		$data['market_cat_count']=Forumstopic::where('cat', '=',6)->count();
		
		//breadcrumbs
		Breadcrumb::addBreadcrumb('Home', route('home'));
		Breadcrumb::addBreadcrumb('Webboard');
		Breadcrumb::setSeperator(''); 
		$data['breadcrumbs']=Breadcrumb::generate(0);

		$data['badge']=HomeController::getFirstBadge();

		return View::make('forumshome',$data);

	}

	public function category($catid,$slug=null){
		$facebook = new Facebook(array(
		  'appId'  => '612396988819496',
		  'secret' => 'e2ab814a26b255a01ee2bc59fe8f3995',
		));


				// Get User ID
		$user = $facebook->getUser();
		
		  //$data['statusUrl'] = $facebook->getLoginStatusUrl();
		$data['loginUrl'] = $facebook->getLoginUrl();
		   //dd($loginUrl);
		$data['catinfo']=Forumscategory::find($catid);


		$data['all_topics']=Forumstopic::where('cat', '=',$catid)->orderBy('created_date','desc')->paginate(30);
		//dd($data['all_topics']);
		$data['cat']=$catid;
		$data['badge']=HomeController::getFirstBadge();

		$data['all_cat_count']=Forumstopic::all()->count();
		$data['general_cat_count']=Forumstopic::where('cat', '=',3)->count();
		$data['review_cat_count']=Forumstopic::where('cat', '=',4)->count();
		$data['support_cat_count']=Forumstopic::where('cat', '=',5)->count();
		$data['market_cat_count']=Forumstopic::where('cat', '=',6)->count();

		//breadcrumbs
		Breadcrumb::addBreadcrumb('Home', route('home'));
		Breadcrumb::addBreadcrumb('Webboard',route('forums'));
		Breadcrumb::addBreadcrumb('เรื่องทั่วไป');
		Breadcrumb::setSeperator(''); 
		$data['breadcrumbs']=Breadcrumb::generate(0);

		return View::make('forumscat',$data);

	}

	
	public function insert(){
		$catid=Input::get('cat');
		$new_topic = array(
		 'subject' => Input::get('title'),
		 'content' => Input::get('content'),
		 'cat' => $catid,
		 'created_date'=>date("Y-m-d H:i:s"),
		 'owner' =>Auth::user()->id
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'subject' => 'required',
		 'content' => 'required'
		 );
		 // make the validator
		$v = Validator::make($new_topic, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		$topic = new Forumstopic($new_topic);

		if(strval($topic->save()))$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> กระทู้ใหม่ถูกบันทึกเรียบร้อยแล้ว</div>";
			
		else $msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> เกิดข้อผิดพลาด ไม่สามารถตั้งกระทู้ใหม่ได้ กรุณาลองใหม่อีกครั้ง</div>";
			
		Session::flash('message', $msg);

		return Redirect::route('category',array($catid));


	}
	public function update($id){
		$catid=$id;
		

		$new_topic = array(
		 'subject' => Input::get('title'),
		 'content' => Input::get('content'),
		 'last_updated'=>date("Y-m-d H:i:s")
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'subject' => 'required',
		 'content' => 'required'
		 );
		 // make the validator
		$v = Validator::make($new_topic, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		$result = Forumstopic::find($id)->update($new_topic);

		if($result)$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> อัพเดทกระทู้เรียบร้อยแล้ว</div>";
			
		else $msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> เกิดข้อผิดพลาด ไม่สามารถอัพเดทกระทู้ได้ กรุณาลองใหม่อีกครั้ง</div>";
			
		Session::flash('message', $msg);

		return Redirect::route('topic',array($id));


	}
	public function removetopic($id){
		if(Forumstopic::find($id)){

		$topic=Forumstopic::find($id);
		$catid=$topic->cat;
		Forumstopic::destroy($id);

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> กระทู้ถูกลบเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);
		
		}
		else{

			$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-ok'></span> ไม่พบกระทู้ที่ต้องการลบ</div>";
			Session::flash('message', $msg);
		}

		return Redirect::route('category',array($catid));
	}
	public function topic($id,$slug=null){

		//increase page view

		$topic = Forumstopic::find($id);

		$topic->view++;

		$topic->save();



		$data['topic']=$topic;
		//dd($id);
		$data['replies']=Forumsreply::where('topic', '=',$id)->orderBy('replydate','asc')->paginate(15);
		//dd($data['all_topics']);
		$data['badge']=HomeController::getFirstBadge();

		$data['all_cat_count']=Forumstopic::all()->count();
		$data['general_cat_count']=Forumstopic::where('cat', '=',3)->count();
		$data['review_cat_count']=Forumstopic::where('cat', '=',4)->count();
		$data['support_cat_count']=Forumstopic::where('cat', '=',5)->count();
		$data['market_cat_count']=Forumstopic::where('cat', '=',6)->count();

		//breadcrumbs
		Breadcrumb::addBreadcrumb('Home', route('home'));
		Breadcrumb::addBreadcrumb('Webboard',route('forums'));
		Breadcrumb::addBreadcrumb($topic->getcat->title,route('category',array($topic->cat)));
		Breadcrumb::addBreadcrumb($topic->subject);
		Breadcrumb::setSeperator(''); 
		$data['breadcrumbs']=Breadcrumb::generate(0);


		return View::make('topic',$data);

	}

	public function insertreply(){
		$topicid=Input::get('topicid');
		$new_reply = array(
		 'content' => Input::get('content'),
		 'topic' => $topicid,
		 'replydate'=>date("Y-m-d H:i:s"),
		 'owner' =>Auth::user()->id
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		 'content' => 'required'
		 );
		 // make the validator
		$v = Validator::make($new_reply, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		$reply = new Forumsreply($new_reply);

		if(strval($reply->save()))$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ข้อความตอบกระทู้ถูกบันทึกเรียบร้อยแล้ว</div>";
			
		else $msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> เกิดข้อผิดพลาด ไม่สามารถตอบกระทู้ได้ กรุณาลองใหม่อีกครั้ง</div>";
			
		Session::flash('message', $msg);

		return Redirect::route('topic',array($topicid));


	}
	public function removereply($id){
		if(Forumsreply::find($id)){

		$reply=Forumsreply::find($id);
		$topicid=$reply->topic;
		Forumsreply::destroy($id);

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ข้อความถูกลบเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);
		
		}
		else{

			$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-ok'></span> ไม่พบข้อความต้องการลบ</div>";
			Session::flash('message', $msg);
		}

		return Redirect::route('topic',array($topicid));


	}

}

?>
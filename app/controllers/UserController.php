<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	protected $layout = 'layouts.main';
	
	public function login()
	{
		return View::make('login');
	}
	public function profile($username=null){
		
		if(!$username&&!Auth::user())return "You can not access this page.";
		if(!$username)$data['user']=Auth::user();
		else $data['user']=User::where('username','=',$username)->first();
		//dd($data['user']);
		
		
		return View::make('profile',$data);
	}
	
	public function signup(){

		$data=array();
		$data['provinces']=Province::all();
		return View::make('signup',$data);
	}
	public function add(){
	//dd(implode(',',Input::get('openday')));
		//dd(Input::all());
		
		$new_user = Input::except('_token','password2');
		
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'username' => 'required|unique:users',
		 'password' => 'required',
		 'firstname' => 'required',
		 'lastname'=>'required',
		 'email'=>'required'
		 );
		 // make the validator
		$v = Validator::make($new_user, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();
		 	//return json_encode(array('result'=>0,'message'=>$v->messages()));
		 
		 }
		 else{
		 	$new_user['password']=Hash::make(Input::get('password'));

		 }
		 // create the new post
		$user = new User($new_user);
		$result=$user->save();
		$this->activation_email($user->id);
		if($result){
			return "<div class='alert alert-success'><strong>การลงทะเบียนเสร็จสมบูรณ์</strong> ท่านได้ทำการลงทะเบียนกับ teebadgun.com เสร็จสมบูรณ์แล้ว
				กรุณาตรวจสอบอีเมล์ของเท่านที่ใช้ในการสมัคร เพื่อยืนยันการสมัครและเปิดใช้งานบัญชี</div>";

		}
		

	}
	public function signin(){
		// get POST data
	    $userdata = array(
	        'username'      => Input::get('username'),
	        'password'      => Input::get('password')
	    );

	    

	    if ( Auth::attempt($userdata) )
	    {	
	    	if(Auth::user()->status==0){
		    	$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> <strong>ท่านยังไม่ได้ยืนยันการลงทะเบียน</strong>  กรุณาตรวจสอบการลงทะเบียนจากอีเมล์ที่ท่านได้ทำการสมัครไว้</div>";
				Session::flash('message', $msg);
				Auth::logout();
				return View::make('login');

		    }

	        return Redirect::to('/');
	    }
	    else
	    {
	        // auth failure! lets go back to the login
	        return Redirect::to('login')
	            ->with('login_errors', true);
	        // pass any error notification you want
	        // i like to do it this way :)
	    }
	}
	public function signinfb(){

		$facebook = new Facebook(array(
		  'appId'  => '612396988819496',
		  'secret' => 'e2ab814a26b255a01ee2bc59fe8f3995',
		));

				// Get User ID
		$user = $facebook->getUser();
		//dd($user);
		
		if ($user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $user_profile = $facebook->api('/me');
		    
		    
		    //check if user has registered
		    $dbuser=User::where('fb_id','=',$user_profile['id'])->first();
		    //dd($dbuser);
		    if($dbuser){
			    Auth::login($dbuser);
		    }
		    else{
			    $new_user = array(
				 'username' => $user_profile['username'],
				 'firstname' => $user_profile['first_name'],
				 'lastname' => $user_profile['last_name'],
				 'fb_id'=>$user_profile['id'],
				 'link'=>$user_profile['link'],
				 'email'=>$user_profile['email']
				);
				
				$im=file_get_contents('https://graph.facebook.com/'.$user_profile['id'].'/picture?type=large');
						
		    	  
				if($im){
					$imdata = base64_encode($im);
			    	$imdata="data:image/jpg;base64,".$imdata;
					$new_user['picture']=$imdata;
				}
				//die($imdata);
				$inserted_user = new User($new_user);
				
				
				if($inserted_user->save()){
					Auth::login($inserted_user);
					Redirect::to('/');
				}
			    
		    }
		  } catch (FacebookApiException $e) {
		    error_log($e);
		    $user = null;
		  }
		}
		
		 //dd($statusUrl);
		// Login or logout url will be needed depending on current user state.
		if ($user) {
		  $logoutUrl = $facebook->getLogoutUrl();
		  //dd($logoutUrl);
		} else {
		  $statusUrl = $facebook->getLoginStatusUrl();
		  $loginUrl = $facebook->getLoginUrl();
		   //dd($loginUrl);
		  return header('Location: '.$loginUrl);
		  //dd($loginUrl);
		}

		// This call will always work since we are fetching public data.
		$naitik = $facebook->api('/naitik');

		return Redirect::to('/');
	}
	public function fbconnect(){

		$facebook = new Facebook(array(
		  'appId'  => '612396988819496',
		  'secret' => 'e2ab814a26b255a01ee2bc59fe8f3995',
		));

				// Get User ID
		$user = $facebook->getUser();
		//dd($user);
		
		if ($user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $user_profile = $facebook->api('/me');
		   
		    $user=Auth::user();
		    $fullname=$user_profile['first_name']." ".$user_profile['last_name'];
		    
		    $ret_obj = $facebook->api('/me/feed', 'POST',
                                    array(
                                      'link' => 'www.teebadgun.com',
                                      'message' => $fullname.' ได้เข้าร่วมสังคมตีแบดออนไลน์โดยเชื่อมต่อแอคเคาทน์เฟสบุ๊คและ ตีแบดกันดอมคอม (www.teebadgun.com)'
                                 ));
		    
		    
		   
			    
				$im=file_get_contents('https://graph.facebook.com/'.$user_profile['id'].'/picture?type=square');
						
		    	  
				if($im){
					$imdata = base64_encode($im);
			    	$imdata="data:image/jpg;base64,".$imdata;
					$user->picture=$imdata;
				}
				//die($imdata);
				
				$user->fb_id=$user_profile['id'];
				$user->link=$user_profile['link'];

				if($user->save()){
					Redirect::to('/');
				}
			    
		   
		  } catch (FacebookApiException $e) {
		    dd($e);
		    $user = null;
		  }
		}
		
		 //dd($statusUrl);
		// Login or logout url will be needed depending on current user state.
		if ($user) {
		  $logoutUrl = $facebook->getLogoutUrl();
		  //dd($logoutUrl);
		} else {
		  $statusUrl = $facebook->getLoginStatusUrl();
		  $loginUrl = $facebook->getLoginUrl();
		   //dd($loginUrl);
		  return header('Location: '.$loginUrl);
		  //dd($loginUrl);
		}

		// This call will always work since we are fetching public data.
		$naitik = $facebook->api('/naitik');
		$msg= "<div class='alert alert-success'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<i class='fa fa-facebook-square fa-lg'></i> การเชื่อมต่อกับ Facebook เสร็จสมบูรณ์ &nbsp;</div>";
		Session::flash('message', $msg);
		
		
		return Redirect::to('/');
	}
	public function edit($id){
		$data=array();
		$data['provinces']=Province::all();
		$data['amphurs']=Amphur::all();
		$data['user'] = User::where('id',$id)->first();
		return View::make('useredit',$data);

	}

	public function update($id){
	//dd(implode(',',Input::get('openday')));
		//dd(Input::all());
		
		$new_user = Input::except('_token','password2');
		if(Input::file('picture'))
		$new_user['picture']=Input::file('picture');
		$user=User::find($id);
		
		 // I'm sure you can come up with better ones
		$rules = array(
		'username' => 'required',
		 'firstname' => 'required',
		 'lastname'=>'required',
		 'email'=>'required',
		 'picture'=>'mimes:jpeg,gif,png|max:200'
		 );

		 // make the validator
		$v = Validator::make($new_user, $rules);
		 if ( $v->fails() )
		 {
		 	return $v->messages();;
		 
		 }
		 else{
		 	if(Input::get('password'))$new_user['password']=Hash::make(Input::get('password'));

		 	//create base64 encoded for avatar picture
		 	if(Input::file('picture'))
		 	{
		 		$pic =Input::file('picture');
		
				$im = file_get_contents(Input::file('picture')->getRealPath());
		    	$imdata = base64_encode($im);  

		    	$ext=trim(strtolower($pic->getClientOriginalExtension()));
		    	$imdata="data:image/{$ext};base64,".$imdata;
				$new_user['picture']=$imdata;
			}

			if(Input::file('gear_racket'))
		 	{
		 		$dest=Config::get('app.public_path')."uploads/gears/racket/".$user->id;
				//dd($dest);
				if( ! file_exists($dest)) {
				    mkdir($dest, 0777);
				}
				$extension = Input::file('gear_racket')->getClientOriginalExtension();
				$filename=uniqid().".".$extension;
				
				/*if (!is_dir($dest)) {
					mkdir($dest, 0777);
					dd($dest);
	
				}*/
			    Input::file('gear_racket')->move($dest,$filename);
	
			    $user->gear_racket=$filename;
				$user->save();
			
			}

			if(Input::file('gear_string'))
		 	{
		 		$dest=Config::get('app.public_path')."uploads/gears/string/".$user->id;
				//dd($dest);
				if( ! file_exists($dest)) {
				    mkdir($dest, 0777);
				}
				$extension = Input::file('gear_string')->getClientOriginalExtension();
				$filename=uniqid().".".$extension;
				
				/*if (!is_dir($dest)) {
					mkdir($dest, 0777);
					dd($dest);
	
				}*/
			    Input::file('gear_string')->move($dest,$filename);
	
			    $user->gear_string=$filename;
				$user->save();
			}

			if(Input::file('gear_shoes'))
		 	{
		 		$dest=Config::get('app.public_path')."uploads/gears/shoes/".$user->id;
				//dd($dest);
				if( ! file_exists($dest)) {
				    mkdir($dest, 0777);
				}
				$extension = Input::file('gear_shoes')->getClientOriginalExtension();
				$filename=uniqid().".".$extension;
				
				/*if (!is_dir($dest)) {
					mkdir($dest, 0777);
					dd($dest);
	
				}*/
			    Input::file('gear_shoes')->move($dest,$filename);
	
			    $user->gear_shoes=$filename;
				$user->save();
			}

			if(Input::file('gear_bag'))
		 	{
		 		$dest=Config::get('app.public_path')."uploads/gears/bag/".$user->id;
				//dd($dest);
				if( ! file_exists($dest)) {
				    mkdir($dest, 0777);
				}
				$extension = Input::file('gear_bag')->getClientOriginalExtension();
				$filename=uniqid().".".$extension;
				
				/*if (!is_dir($dest)) {
					mkdir($dest, 0777);
					dd($dest);
	
				}*/
			    Input::file('gear_bag')->move($dest,$filename);
	
			    $user->gear_bag=$filename;
				$user->save();
			}
		 }
		 // create the new post
		return strval($user->update($new_user));


		

	}
	public function typeahead($kw){
		$users = DB::select("select * from users where concat(firstname,lastname,username) like '%{$kw}%'", array());
		//$users=User::whereRaw("concat(firstname,lastname,username) like '%?%'", array($kw))->get();
		return json_encode($users);

	}
	public function activation_email($uid){

		$user=User::find($uid);
		//print_r($user->id);die();
		$data['user']=$user;
		$key=Config::get('app.key');

		$password = Hash::make('secret');
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $user->username, MCRYPT_MODE_CBC, md5(md5($key))));
		$data['link']=route('activate', array('token'=>$encrypted));

		Mail::queue('activation_email', $data, function($message) use ($user)
		{
			//dd($user->email);
		    $message->to($user->email, $user->firstname." ".$user->lastname)->subject('teebadgun.com : กรณายืนยันการสมัครสมาชิกเว็บไซต์');
		});
	}
	public function message(){
		return View::make('message');

	}
	public function activate($cipher){
		$key=Config::get('app.key');
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cipher), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

		$user = User::where('username', '=', $decrypted)->first();

		$user->status = 1;

		$user->save();

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok-sign'></span> <strong>การยืนยันการลงทะเบียนเสร็จสมบูรณ์</strong> ท่านได้ยืนยันการลงทะเบียนเรียบร้อยแล้ว ท่านสามารถลงชื่อเข้าใช้ได้จาก username และ password ที่ได้ทำการสมัครไว้ &nbsp;<a class='btn btn-large btn-info' href='".route('login')."'><span class='glyphicon glyphicon-user'></span> เข้าสู่ระบบ</a></div>";
		Session::flash('message', $msg);
		return View::make('message');


	}
	public function getBadgeList(){
		
	}

}

?>
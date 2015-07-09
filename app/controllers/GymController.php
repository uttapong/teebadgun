<?php

class GymController extends BaseController {

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
	
	public function newgym()
	{
		$data=array();
		$data['court_type']=Court::all();
		return View::make('newgym',$data);
	}
	public function index($id,$name=null){
		
		$data['gym']=Gym::find($id);
		return View::make('gym',$data);

	}

	public function add(){
	//dd(implode(',',Input::get('openday')));
		//dd(Input::all());
		
		$new_gym = array(
		 'name' => Input::get('name'),
		 'lat' => Input::get('lat'),
		 'long' => Input::get('long'),
		 'address' => Input::get('address'),
		 'type' => Input::get('type'),
		 'fee' => Input::get('fee'),
		 'open_day' => implode(',',Input::get('openday')),
		 'open_time' => Input::get('open_time'),
		 'close_time' => Input::get('close_time'),
		 'car_park' => Input::get('car_park'),
		 'court_count' => Input::get('court_count'),
		 'tel' => Input::get('tel'),
		 'contact_person' => Input::get('contact_person'),
		 'owner' => Auth::user()->id
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'name' => 'required',
		 'lat' => 'required|numeric',
		 'long' => 'required|numeric',
		 'court_count'=>'numeric'
		 );
		 // make the validator
		$v = Validator::make($new_gym, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		$gym = new Gym($new_gym);
		return strval($gym->save());
		

	}
	public function edit($id){
		$data=array();
		$data['gym'] = Gym::find($id)->first();
		$data['court_type']=Court::all();
		return View::make('editgym',$data);
	}
	public function update($id){
		$new_gym = array(
		 'name' => Input::get('name'),
		 'lat' => Input::get('lat'),
		 'long' => Input::get('long'),
		 'address' => Input::get('address'),
		 'type' => Input::get('type'),
		 'fee' => Input::get('fee'),
		 'open_day' => implode(',',Input::get('openday')),
		 'open_time' => Input::get('open_time'),
		 'close_time' => Input::get('close_time'),
		 'car_park' => Input::get('car_park'),
		 'court_count' => Input::get('court_count'),
		 'tel' => Input::get('tel'),
		 'contact_person' => Input::get('contact_person'),
		 'owner' => Auth::user()->id
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'name' => 'required',
		 'lat' => 'required|numeric',
		 'long' => 'required|numeric',
		 'court_count'=>'numeric'
		 );
		 // make the validator
		$v = Validator::make($new_gym, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		$result = Gym::find($id)->update($new_gym);
		if($result){
			$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ข้อมูลสนามได้รับการปรับปรุงเรียบร้อยแล้ว</div>";
			Session::flash('message', $msg);
		}
		return strval($result);

	}
	public function autocomplete($kw){
		$gyms = DB::select("select * from gyms where concat(name,contact_person,address) like '%{$kw}%' limit 7", array());
		//$users=User::whereRaw("concat(firstname,lastname,username) like '%?%'", array($kw))->get();
		return json_encode($gyms);

	}
	public function report($id){
		$gym=Gym::find($id);
		$gym->reported=1;
		$gym->save();

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> คอร์ทแบดมินตันนี้ถูกแจ้งซ้ำเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);

		$data['gym']=$gym;
		return View::make('gym',$data);

	}
	public function remove($id){
		if(Team::find($id)){

		$gymname=Gym::find($id)->name;
		Gym::destroy($id);

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span>{$gymname} ถูกลบเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);
		
		}
		else{

			$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-ok'></span> ไม่พบสนามแบดมินตันที่ต้องการลบข้อมูล</div>";
			Session::flash('message', $msg);
		}

		return Redirect::to('/');
	}

}

?>
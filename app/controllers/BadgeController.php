<?php

class BadgeController extends BaseController {

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
	
	public function index()
	{
		$this->checkBadges();
		return View::make('login');
	}
	public function checkBadges(){
		$data['badge']=$this->getFirstBadge();

	}
	public function getFirstBadge(){
		$badges=Badge::all();
		foreach($badges as $badge){
			$result = DB::select($badge->sql, array());
			dd($result);
			if($result->result)return $badge;

		}
		return "";

	}
	
}

?>
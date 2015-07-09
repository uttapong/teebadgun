<?php

class HomeController extends BaseController {

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
		$facebook = new Facebook(array(
		  'appId'  => '612396988819496',
		  'secret' => 'e2ab814a26b255a01ee2bc59fe8f3995',
		));


				// Get User ID
		$user = $facebook->getUser();
		
		  //$data['statusUrl'] = $facebook->getLoginStatusUrl();
		  $data['loginUrl'] = $facebook->getLoginUrl();
		   //dd($loginUrl);

		$data['news_all']=Content::where('category', '=', 'news')->take(6)->orderBy('created_at','DESC')->get();
		$data['article_all']=Content::where('category', '=', 'article')->take(6)->orderBy('created_at','DESC')->get();
		$data['announcement_all']=Content::where('category', '=', 'announcement')->take(6)->orderBy('created_at','DESC')->get();

		//stat
		$dayofweek=date('N')+1; 
		if($dayofweek==8)$dayofweek=1;
		$sql="select teams.id,o.day from teams left join opendays o on teams.id=o.team  where o.day = {$dayofweek}";

		$sql_open1="select distinct teams.* from teams left join opendays o on teams.id=o.team  where o.day = {$dayofweek} limit 6";
		$sql_open2="select distinct teams.* from teams left join opendays o on teams.id=o.team  where o.day = {$dayofweek} limit 6,6";
		$data['stat_all_court']=Gym::count();
		$data['open_teams1']=DB::select($sql_open1, array());
		$data['open_teams2']=DB::select($sql_open2, array());
		$data['stat_open_team']=count(DB::select($sql, array()));
		$data['stat_all_announcement']=Content::where('category','=','announcement')->count();
		$data['stat_all_member']=User::count();
		$data['badge']=$this::getFirstBadge();

		return View::make('home',$data);
	}
	public  function news($slug=null){


		if (Input::has('comment'))
		{
		   $body = Input::get('comment');
			$authorable = Auth::user();
			$commentable = Content::find(Input::get('contentid'));
			//dd($commentable);

			$commentable->addComment($body, $authorable)->save();
			$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ความเห็นของท่านถูกบันทึกเรียบร้อยแล้ว</div>";
			Session::flash('message', $msg);

		}

		$data['route'] = 'news';
		if($slug){
			$data['news']=Content::where('slug', '=', $slug)->first();

			return View::make('news',$data);

		}
		$data['news_latest']=Content::where('category', '=', 'news')->take(3)->orderBy('created_at','DESC')->get();
		
		$data['news_all'] = DB::table('contents')->where('category', '=', 'news')->orderBy('created_at','DESC')->paginate(20);
		

		return View::make('allnews',$data);
	}

	public  function article($slug=null){
		$data['route'] = 'article';
		
		if($slug){
			$data['news']=Content::where('slug', '=', $slug)->first();

			return View::make('news',$data);

		}
		$data['news_latest']=Content::where('category', '=', 'article')->take(3)->orderBy('created_at','DESC')->get();
		
		$data['news_all'] = DB::table('contents')->where('category', '=', 'article')->orderBy('created_at','DESC')->paginate(20);
		
		return View::make('allarticle',$data);
	}

	public  function announcement($slug=null){
		$data['route'] = 'announcement';
		if($slug){
			$data['news']=Content::where('slug', '=', $slug)->first();

			return View::make('news',$data);

		}
		$data['news_latest']=Content::where('category', '=', 'announcement')->take(3)->orderBy('created_at','DESC')->get();
		
		$data['news_all'] = DB::table('contents')->where('category', '=', 'announcement')->orderBy('created_at','DESC')->paginate(20);
		
		//dd($data['news_all'] );
		return View::make('allannouncement',$data);
	}

	public function where(){
		$dayofweek=date('N')+1; 
		if($dayofweek==8)$dayofweek=1;
		$sql="select teams.id,o.day from teams left join opendays o on teams.id=o.team  where o.day = {$dayofweek}";

		$sql_open1="select teams.* from teams left join opendays o on teams.id=o.team  where o.day = {$dayofweek} limit 20";
		//$sql_open2="select teams.id,teams.name from teams left join opendays o on teams.id=o.team  where o.day = {$dayofweek} limit 6,6";
		$data['stat_all_court']=Gym::count();
		$data['open_teams1']=DB::select($sql_open1, array());
		//$data['open_teams2']=DB::select($sql_open2, array());
		$data['stat_open_team']=count(DB::select($sql, array()));
		$data['stat_all_announcement']=Content::where('category','=','announcement')->count();
		$data['stat_all_member']=User::count();

		return View::make('where',$data);
	}
	public function about(){
		$data['about']=Block::where('title','=','เกี่ยวกับเรา')->first();
		//dd($data['about']->content);
		return View::make('about',$data);
	}
	

	public function getlocation(){

		if(Input::has('lat')){
			$lat=Input::get('lat');
			$lng=Input::get('lng');

			$sql="select distinct gyms.name as gym_name,teams.name,(((acos(sin(({$lat}*pi()/180)) * 
            sin((gyms.lat*pi()/180))+cos(({$lat}*pi()/180)) * 
            cos((gyms.lat*pi()/180)) * cos((({$lng}- gyms.long)* 
            pi()/180))))*180/pi())*60*1.1515
	        ) as distance 
	        FROM teams
	        left join opendays on opendays.team=teams.id
			left join gyms on opendays.gym=gyms.id 
			ORDER BY distance ASC limit 20;";

			$distance = DB::select($sql, array());
			dd($distance);
			return json_encode($distance);
		}
		else return null;
	}

	function distance($lat1, $lon1, $lat2, $lon2) {

	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  return $dist;
	}
	public function create(){

	}

	public static function getFirstBadge(){
		if(!Auth::user())return null;

		$badges=Badge::all();
		foreach($badges as $badge){
			//dd($badge->sql." ".Auth::user()->id);
			$gotBadge=Userbadge::where('user_id','=',Auth::user()->id)->where('badge_id','=',$badge->id)->count();
			if($gotBadge>0)continue;

			$result = DB::select($badge->sql." ".Auth::user()->id, array());
			//dd($result[0]->result);
			if($result[0]->result){

				$userbadge=new Userbadge;
				$userbadge->badge_id=$badge->id;
				$userbadge->user_id=Auth::user()->id;
				$userbadge->save();

				return $badge;
			}	

		}
		return "";

	}

	
	



	
}
?>
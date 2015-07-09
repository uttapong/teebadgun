<?php

class TeamController extends BaseController {

	protected $layout = 'layouts.main';
	
	public function newteam()
	{
		$data=array();
		$data['court_type']=Court::all();
		return View::make('newteam',$data);
	}
	public function add(){
	//dd(implode(',',Input::get('openday')));
		//dd(Input::all());
		
		$new_team = array(
		 'name' => Input::get('name'),
		 'description' => Input::get('remark'),
		 'motto' => Input::get('motto'),
		 'tel' =>Input::get('tel'),
		 'owner' => Auth::user()->id,
		 'logo'=>Input::file('logo')
		
		 );
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'name' => 'required|unique:teams',
		'logo'=>'mimes:jpeg,gif,png|max:200'
		 );
		 // make the validator
		$v = Validator::make($new_team, $rules);
		/* if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }*/
		 // create the new post
		 /*if(Input::file('logo'))
	 	{
	 		$pic =Input::file('logo');
	
			$im = file_get_contents(Input::file('logo')->getRealPath());
	    	$imdata = base64_encode($im);  

	    	$ext=trim(strtolower($pic->getClientOriginalExtension()));
	    	$imdata="data:image/{$ext};base64,".$imdata;
			$new_team['logo']=$imdata;
		}*/
		
		$team = new Team($new_team);
		$insert_result =$team->save();
		
		if (Input::hasFile('logo'))
		{
			$dest=Config::get('app.public_path')."uploads/teams/".$team->id."/";
			//dd($dest);
			if( ! file_exists($dest)) {
			    mkdir($dest, 0777);
			}
			$extension = Input::file('logo')->getClientOriginalExtension();
			$filename=uniqid().".".$extension;
			
			/*if (!is_dir($dest)) {
				mkdir($dest, 0777);
				dd($dest);

			}*/
		    Input::file('logo')->move($dest,$filename);

		    $team->logo=$filename;
			$team->save();
		}

		
		if($insert_result){
			$managers =Input::get('manager');
			foreach($managers as $manager)
			{

				if(is_numeric($manager))
				$new_manager = array(
				 'user_id' => $manager,
				 'team_id' => $team->id,
				 );

				else $new_manager = array(
				 'nonmember_name' => $manager,
				 'team_id' => $team->id,
				 );

				//print_r($new_manager);
			//die();

				$manager=new Manager($new_manager);
				$manager->save();
			}

			$opendays=Input::get('court');
			foreach($opendays as $openday)
			{

				$openday_arr=json_decode(stripslashes($openday));
				//die(stripslashes($openday));
				$court=Gym::where('name', '=', $openday_arr->court)->first();
				$court_id=$court->id;
				//dd($court_id);
				$new_openday = array(
				'day' => $openday_arr->day,
				'start_time' => $openday_arr->start_time,
				'end_time' => $openday_arr->end_time,
				'payment' => $openday_arr->payment,
				'gym' => $court_id,
				'remark'=>$openday_arr->remark,
				'team'=>$team->id
				 );

				$openday=new Openday($new_openday);
				$openday->save();
			}


		

		}
		return "1";
	}
	public function edit($id){
		$data=array();
		$team = Team::where('id',$id)->first();
		$data['managers'] = $team->managers->all();
		$data['opendays'] = $team->opendays->all();
		$data['team']=$team;
			
		return View::make('editteam',$data);

	}
	public function update($id){
	//dd(implode(',',Input::get('openday')));
		//dd(Input::all());
		
		$team=Team::find($id);
		
		$new_team = array(
		 'name' => Input::get('name'),
		 'description' => Input::get('description'),
		 'motto' => Input::get('motto'),
		 'tel' =>Input::get('tel'),
		 'owner' => Auth::user()->id
		
		 );
		if(Input::file('logo'))
	 	{
	 		$new_team['logo']=Input::file('logo');
	 	}
		 // let's setup some rules for our new data
		 // I'm sure you can come up with better ones
		$rules = array(
		'name' => 'required',
		'logo'=>'mimes:jpeg,gif,png|max:200'
		 );
		 // make the validator
		$v = Validator::make($new_team, $rules);
		 if ( $v->fails() )
		 {
		 // redirect back to the form with
		 // errors, input and our currently
		 // logged in user
		 	return $v->messages();;
		 
		 }
		 // create the new post
		 /*if(Input::file('logo'))
	 	{
	 		$pic =Input::file('logo');
	
			$im = file_get_contents(Input::file('logo')->getRealPath());
	    	$imdata = base64_encode($im);  

	    	$ext=trim(strtolower($pic->getClientOriginalExtension()));
	    	$imdata="data:image/{$ext};base64,".$imdata;
			$new_team['logo']=$imdata;
		}*/
		
		if (Input::hasFile('logo'))
			{

				$dest=Config::get('app.public_path')."uploads/teams/".$team->id."/";
			//dd($dest);
			if( ! file_exists($dest)) {
			    mkdir($dest, 0777);
			}
			$extension = Input::file('logo')->getClientOriginalExtension();
			$filename=uniqid().".".$extension;
			
			/*if (!is_dir($dest)) {
				mkdir($dest, 0777);
				dd($dest);

			}*/
		    Input::file('logo')->move($dest,$filename);

		    $new_team['logo']=$filename;
			

			   
			}
		
		$result = $team->update($new_team);
		

		
		if($result){

			//remove old managers and courts
			Manager::where('team_id', '=', $id)->delete();
			Openday::where('team','=',$id)->delete();

			$managers =Input::get('manager');
			foreach($managers as $manager)
			{
				//print_r($manager);
				//die();

				if(is_numeric($manager))
				$new_manager = array(
				 'user_id' => $manager,
				 'team_id' => $id,
				 );

				else $new_manager = array(
				 'nonmember_name' => $manager,
				 'team_id' => $id,
				 );

				//print_r($new_manager);
			//die();

				$manager=new Manager($new_manager);
				$manager->save();
			}

			$opendays=Input::get('court');

			foreach($opendays as $openday)
			{
				//print_r(stripslashes($openday));die();
				$openday_arr=json_decode(stripslashes($openday));
				//print_r($openday_arr);
				//die();
				if(is_numeric($openday_arr->court))$court=Gym::where('id', '=', $openday_arr->court)->first();
				else $court=Gym::where('name', '=', $openday_arr->court)->first();

				$court_id=$court->id;
				//dd($court_id);
				$new_openday = array(
				'day' => $openday_arr->day,
				'start_time' => $openday_arr->start_time,
				'end_time' => $openday_arr->end_time,
				'payment' => $openday_arr->payment,
				'gym' => $court_id,
				'remark'=>$openday_arr->remark,
				'team'=>$id
				 );

				$openday=new Openday($new_openday);
				$openday->save();
			}


		

		}
		return "1";
	}
	function index($id,$name=null){
		
		$data['team']=Team::find($id);

		return View::make('team',$data);

	}
	function join($id){
		if(!Auth::user())return "false";

		$user=Auth::user();

		//check if joined
		if(Teammember::where('team_id','=',$id)->where('user_id','=',$user->id)->count()>0){
			$msg= "<div class='alert alert-warning'><span class='glyphicon glyphicon-ok'></span> คุณเป็นสมาชิกทีมนี้อยู่แล้ว</div>";
		Session::flash('message', $msg);
			
		}	
		else{
		
		$member=new Teammember;
		$member->user_id=$user->id;
		$member->team_id=$id;
		$member->save();
		
		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> คุณได้เข้าร่วมเป็นสมาชิกทีมนี้เรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);
		}
		$data['team']=Team::find($id);
		return View::make('team',$data);

	}
	function report($id){
		$team=Team::find($id);
		$team->reported=1;
		$team->save();

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ทีมนี้ถูกแจ้งซ้ำเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);

		$data['team']=$team;
		return View::make('team',$data);

	}
	function remove($id){

		if(Team::find($id)){


		$teamname=Team::find($id)->name;
		Team::destroy($id);

		$msg= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ทีม {$teamname} ถูกลบเรียบร้อยแล้ว</div>";
		Session::flash('message', $msg);
		}
		else{

			$msg= "<div class='alert alert-danger'><span class='glyphicon glyphicon-ok'></span> ไม่พบทีมที่ต้องการลบข้อมูล</div>";
			Session::flash('message', $msg);
		}
		return Redirect::to('/');
	}
	
	
}

?>

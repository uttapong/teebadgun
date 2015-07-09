<?php


class Manager extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public function add()
	{
		
	}
	public function getValue(){
		if($this->user_id)return $this->user_id;
		else return $this->nonmember_name;
	}
	public function getName(){
		if($this->nonmember_name)return $this->nonmember_name;
		else {
				//dd($this->id);
			$user= DB::table('users')->where('id', $this->user_id)->first();
			return $user->firstname." ".$user->lastname;
			//dd($user);
			//User::select(array('firstname','lastname')->find($this->id)->first();


		}
	}
	public function getUser(){

		if($this->user_id>0){
			return User::find($this->user_id);
		}
		else return null;
	}
	

	

}

?>
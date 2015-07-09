<?php


class Team extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public function add()
	{
		
	}
	public function opendays()
    {
        return $this->hasMany('Openday','team');
    }

	public function managers()
    {
        return $this->hasMany('Manager','');
    }
    public function checkPermission(){
    	$user=Auth::user();
        if(!$user)return false;
    	if($user->role==9)return true;
    	if($user->id==$this->owner)return true;
    	foreach($this->managers() as $manager){
    		if($manager->user_id==$user->id)return true;
    	}
    	return false;
    }

    function checkJoined(){
        if(!Auth::user())return false;
        
        $member=Teammember::where('user_id','=',Auth::user()->id)->where('team_id','=',$this->id)->get();
        if($member->count()>0)return true;
        return false;
    }
    function members(){
        return $this->hasMany('Teammember');
    }

}

?>
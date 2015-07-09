<?php


class Gym extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public function add()
	{
		
	}
	public function user(){
		//dd($this->belongsTo('User','owner')->first());
		return $this->belongsTo('User','owner');
	}
	public function opendays(){
		//dd($this->hasMany('Openday','gym')->getResults());
		return $this->hasMany('Openday','gym');
	}
	
	public function checkPermission(){
    	$user=Auth::user();
        if(!$user)return false;
    	if($user->role==9)return true;
    	if($user->id==$this->owner)return true;
    	
    	return false;
    }
    public function courtType(){
    	return $this->belongsTo('Court','type');
    }

	

}

?>
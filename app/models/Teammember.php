<?php


class Teammember extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public function add()
	{
		
	}
	public function team()
    {
        return $this->belongsTo('Team');
    }

	public function user()
    {
    	//dd($this->belongsTo('User')->getResults());
        return $this->belongsTo('User')->getResults();
    }

    

}

?>
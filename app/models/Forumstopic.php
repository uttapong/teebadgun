<?php


class Forumstopic extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public $timestamps=false;
	protected $table = 'forumstopics';

	public function replies()
    {
        return $this->hasMany('Forumsreply','topic');
    }
    public function getowner()
    {
        return $this->belongsTo('User','owner');
    }
    public function getcat()
    {
        return $this->belongsTo('Forumscategory','cat');
    }
    public function format_last_update(){
    	//die($this->last_updated);
    	return date("j M y H:i:s",strtotime($this->last_updated));
    }
    




}

?>
<?php


class Forumsreply extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public $timestamps=false;
	protected $table = 'forumsreplies';

	public function add()
	{
		
	}
	public function topic()
    {
        return $this->belongsTo('Forumstopic');
    }
    public function owner()
    {
        return $this->belongsTo('User');
    }
    public function getowner()
    {
        return $this->belongsTo('User','owner');
    }

}

?>
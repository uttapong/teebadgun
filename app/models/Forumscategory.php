<?php


class Forumscategory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public $timestamps=false;
	protected $table = 'forumscategories';

	public function add()
	{
		
	}
	public function topics()
    {
        return $this->hasMany('Forumstopic','cat');
    }
    public function owner()
    {
        return $this->belongsTo('User','owner');
    }

}

?>
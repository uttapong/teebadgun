<?php


class Block extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	
	public $timestamps=false;

	public function add()
	{
		
	}
	

	public function shorten(){
		return iconv_substr(strip_tags($this->content), 0,200, "UTF-8");
	}
	public function upload()
    {

        return $this->hasMany('Upload','uploadable_id');
    }
    public function filename(){
    	if(isset($this->upload()->first()->filename))
    	return '/uploads/posts/'.$this->id."/".$this->upload()->first()->filename;
    	else return null;
    }

}

?>
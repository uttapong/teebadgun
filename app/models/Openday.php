<?php


class Openday extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	static $unguarded = true;
	public $timestamps=false;
	protected $table = 'opendays';
	
	public function gym()
	{
		return $this->belongsTo('Gym','gym');
	}

	public function team(){
		return $this->belongsTo('Team', 'team');
	}
	public function getValue(){
		$obj=new stdClass();
		$obj->court=$this->gym;
		$obj->day=$this->day;
		$obj->start_time=$this->start_time;
		$obj->end_time=$this->end_time;
		$obj->payment=$this->payment;
		$obj->remark=$this->remark;
		return json_encode($obj);
	}
	public function getGymName(){
			//dd($this->id);
			$gym= DB::table('gyms')->where('id', $this->gym)->first();
			return $gym->name;
	}
	/*public function getTeam(){
		return Team::find($this->team)->first();
	}*/
	public function getDay(){
		switch($this->day)
		{
		  case "2":
		  return "จันทร์";
		  break;

		  case "3":
		  return "อังคาร";
		  break;

		  case "4":
		  return "พุธ";
		  break;

		  case "5":
		  return "พฤหัสบดี";
		  break;

		  case "6":
		  return "ศุกร์";
		  break;

		  case "7":
		  return "เสาร์";
		  break;

		  case "1":
		  return "อาทิตย์";
		  break;
		
		default:
		  return "ไม่สามารถแปลวันได้";
		}
	}

	

}

?>
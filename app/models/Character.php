<?

class Character extends Eloquent {
	protected $table = 'characters';
	public $timestamps = true;
	
	public function aspects() {
		return $this->hasMany('Aspect')->orderBy('position');
	}
	
	public function skills() {
		return $this->hasMany('CharacterSkill')->orderBy('rank', 'desc');
	}
	
	public function campaign() {
		return Campaign::find($this->campaign_id);
	}
	
	public function consequences() {
		return $this->hasMany('Consequence');
	}
}

?>
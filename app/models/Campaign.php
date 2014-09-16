<?

class Campaign extends Eloquent {
	protected $table = 'campaigns';
	public $timestamps = true;
	
	public function characters() {
		return $this->hasMany('Character')->where('active', 1);
	}

	public function skills() {
		return $this->hasMany('SkillDefinition');
	}
	
	public function mentalSkill() {
		return $this->skills()->where('isMental', true)->get()[0];
	}
	
	public function physicalSkill() {
		return $this->skills()->where('isPhysical', true)->get()[0];
	}
	
	public function requests() {
		return $this->hasMany('CampaignRequest');
	}
}

?>
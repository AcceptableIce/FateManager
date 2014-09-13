<?

class Campaign extends Eloquent {
	protected $table = 'campaigns';

	public function skills() {
		return $this->hasMany('SkillDefinition');
	}
	
	public function mentalSkill() {
		return $this->skills()->where('isMental', true)->get()[0];
	}
	
	public function physicalSkill() {
		return $this->skills()->where('isPhysical', true)->get()[0];
	}
}

?>
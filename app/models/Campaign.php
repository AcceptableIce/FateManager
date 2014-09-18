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
		return $this->skills()->where('isMental', true)->first();
	}
	
	public function physicalSkill() {
		return $this->skills()->where('isPhysical', true)->first();
	}
	
	public function requests() {
		return $this->hasMany('CampaignRequest');
	}
	
	public function founder() {
		return User::find(PlayerPermission::where('campaign_id', $this->id)->where('permission_id', 1)->first()->id);
	}
		
	public function administrators() {
		$out = [];
		foreach(PlayerPermission::where('campaign_id', $this->id)->where('permission_id', 2)->orWhere('permission_id', 1)->get() as $a) {
			$out[] = User::find($a->user_id);
		}
		return $out;
	}
}

?>
<?

class CampaignRequest extends Eloquent {
	protected $table = 'campaign_requests';
	public $timestamps = true;
	
	public function sender() {
		return User::find($this->user_id);
	}
	
	public function definition() {
		switch($this->type) {
			case 1: //Join Request
				$char = Character::find($this->value);
				return array("name" => "Character Join Request", "desc" => $this->sender()->username." has requested that their character <a href='/fatemanager/public/character/".$char->id."'>\"".$char->name."\"</a> be added to this campaign.");
			default:
				return array("name" => "Unknown", "desc" => "An unknown request was made");
		}
	}
	
	public function accept() {
		switch($this->type) {
			case 1:
				$char = Character::find($this->value);
				$char->active = 1;
				$char->save();
				$this->delete();
				return;
		}
	}
}



?>
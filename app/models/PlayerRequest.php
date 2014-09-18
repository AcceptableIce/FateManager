<?

class PlayerRequest extends Eloquent {
	protected $table = 'player_requests';
	public $timestamps = true;
	
	public function sender() {
		return User::find($this->from_id);
	}
	
	public function definition() {
		switch($this->type) {
			case 1: //Make Admin Request
				$char = Character::find($this->value);
				return array("name" => "GM Request", "desc" => $this->sender()->username." has requested that you become a GM of their campaign ".Campaign::find(intval($this->value))->name.".");
			default:
				return array("name" => "Unknown", "desc" => "An unknown request was made");
		}
	}
	
	public function accept() {
		switch($this->type) {
			case 1:
				$permission = new PlayerPermission;
				$permission->user_id = $this->user_id;
				$permission->permission_id = 2;
				$permission->campaign_id = $this->value;
				$permission->save();
				return;
		}
	}
}



?>
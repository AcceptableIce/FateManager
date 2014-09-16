<?

class PlayerPermission extends Eloquent {
	protected $table = 'player_permissions';
	public $timestamps = true;
	
    public function definition() {
        return Permission::find($this->permission_id);
    }
    
    public function campaign() {
	    return Campaign::find($this->campaign_id);
    }

}

?>
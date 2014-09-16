<?

class SkillDefinition extends Eloquent {
	protected $table = 'campaign_skills';
	protected $touches = array('campaign');
	public $timestamps = true;

    public function campaign() {
        return $this->belongsTo('Campaign');
    }
}

?>
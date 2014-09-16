<?

class CharacterSkill extends Eloquent {
	protected $table = 'character_skills';
    protected $touches = array('character');
	public $timestamps = true;

    public function character() {
        return $this->belongsTo('Character');
    }
    
	public function definition() {
		return SkillDefinition::find($this->skill_id);
	}
}

?>
<?

class CharacterSkill extends Eloquent {
	protected $table = 'character_skills';

	public function definition() {
		return SkillDefinition::find($this->skill_id);
	}
}

?>
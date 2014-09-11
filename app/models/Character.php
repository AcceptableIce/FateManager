<?

class Character extends Eloquent {
	protected $table = 'characters';

	public function aspects() {
		return $this->hasMany('Aspect')->orderBy('position');
	}
}

?>
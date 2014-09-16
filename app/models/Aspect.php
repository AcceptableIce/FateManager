<?

class Aspect extends Eloquent {
	protected $table = 'character_aspects';
    protected $touches = array('character');
	public $timestamps = true;
	
    public function character() {
        return $this->belongsTo('Character');
    }

}

?>
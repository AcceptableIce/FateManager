<?

class Consequence extends Eloquent {
	protected $table = 'character_consequences';
    protected $touches = array('character');
	public $timestamps = true;

    public function character() {
        return $this->belongsTo('Character');
    }
}

?>
<?php
class EditApiController extends BaseController {

	public static function validateOwner($character) {
		$user = Auth::user();
		return $character->user_id == $user->id ? 'true' : 'false';
	}
	
	public static function test() {
		return EditApiController::validateOwner(Character::find(1));
	}
	
	public static function updateCharacterName($id) {
		$char = Character::find($id);
		if(EditAPIController::validateOwner($char)) {
			$char->name = Input::get('value');
			$char->save();
		}
	}
	
	public static function updateCharacterDescription($id) {
		$char = Character::find($id);
		if(EditAPIController::validateOwner($char)) {
			$char->description = Input::get('value');
			$char->save();
		}
	}
	
	public static function updateCharacterAspect($id, $position) {
		$char = Character::find($id);
		$value = Input::get('value');
		if(EditAPIController::validateOwner($char)) {
			$asp = $char->aspects()->where('position', $position)->first();
			if(isset($asp)) {
				if(strlen($value) > 0) {
					$asp->delete();
				} else {
					$asp->name = $value;
					$asp->save();
				}
			} else {
				$asp = new Aspect();
				$asp->character_id = $id;
				$asp->name = $value;
				$asp->position = $position;
				$asp->save();
			}
		}
	}
}
?>

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
	
	public static function updateCharacterRefresh($id) {
		$char = Character::find($id);
		if(EditAPIController::validateOwner($char)) {
			$char->refresh = Input::get('value');
			$char->save();
		}
	}
	
	public static function updateCharacterExtras($id) {
		$char = Character::find($id);
		if(EditAPIController::validateOwner($char)) {
			$char->extras = Input::get('value');
			$char->save();
		}
	}
	
	public static function updateCharacterStunts($id) {
		$char = Character::find($id);
		if(EditAPIController::validateOwner($char)) {
			$char->stunts = Input::get('value');
			$char->save();
		}
	}	
	
	public static function updateCharacterStress($id, $type) {
		$char = Character::find($id);
		$type = strtolower($type);
		$value = Input::get('value');
		if(EditAPIController::validateOwner($char)) {
			if($type == "physical") $char->physical_stress_taken = $value;
			if($type == "mental") $char->mental_stress_taken = $value;
			$char->save();	
		} 
	}
	
	public static function updateCharacterAspect($id, $position) {
		$char = Character::find($id);
		$value = Input::get('value');
		if(EditAPIController::validateOwner($char)) {
			$asp = $char->consequences()->where('position', $position)->first();
			if(isset($asp)) {
				if(strlen($value) == 0) {
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
	
		
	public static function updateCharacterConsequence($id, $severity, $slot = 0) {
		$char = Character::find($id);
		$value = Input::get('value');
		if(EditAPIController::validateOwner($char)) {
			$asp = $char->consequences()->where('severity', $severity)->where('position', $slot)->first();
			if(isset($asp)) {
				if(strlen($value) == 0) {
					$asp->delete();
				} else {
					$asp->name = $value;
					$asp->save();
				}
			} else {
				$asp = new Consequence();
				$asp->character_id = $id;
				$asp->name = $value;
				$asp->severity = $severity;
				$asp->position = $slot;
				$asp->save();
			}
		}
	}
			
	public static function updateCharacterSkill($id, $rank, $position) {
		$char = Character::find($id);
		$value = Input::get('value');
		if(EditAPIController::validateOwner($char)) {
			$asp = $char->skills()->where('rank', $rank)->where('position', $position)->first();
			if(isset($asp)) {
				if($value == 0) {
					$asp->delete();
				} else {
					$asp->skill_id = $value;
					$asp->save();
				}
			} else if($value != 0) {
				$asp = new CharacterSkill();
				$asp->character_id = $id;
				$asp->skill_id = $value;
				$asp->rank = $rank;
				$asp->position = $position;
				$asp->save();
			}
		}
	}
}
?>

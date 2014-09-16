<?php

class CampaignAPIController extends BaseController {

	public function acceptCampaignRequest($id, $request_id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$request = CampaignRequest::find($request_id);
			if(isset($request)) {
				$request->accept();
				echo json_encode('Success');
			}
		}
	}
	
	public function rejectCampaignRequest($id, $request_id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$request = CampaignRequest::find($request_id);
			if(isset($request)) {
				$request->delete();
				echo json_encode('Success');
			}
		}
	}
	
	public function addNewSkill($id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$skill = new SkillDefinition;
			$skill->name = "New Skill";
			$skill->campaign_id = $id;
			$skill->save();
			echo json_encode(array("id" => $skill->id));
		}
	}
	
	public function updateSkillName($id, $skill_id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$skill = SkillDefinition::find($skill_id);
			if($skill->campaign_id != $id) return json_encode('Skill does not belong to campaign');
			$skill->name = Input::get('value');
			$skill->save();
			echo json_encode("Success!");
		}
	}
	
	public function setPhysicalSkill($id, $skill_id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$skill = SkillDefinition::find($skill_id);
			if($skill->campaign_id != $id) return json_encode('Skill does not belong to campaign');
			foreach(Campaign::find($id)->skills()->get() as $s) {
				$s->isPhysical = false;
				$s->save();
			}
			$skill->isPhysical = true;
			$skill->save();
			echo json_encode("Success!");
		}		
	}
	
	public function setMentalSkill($id, $skill_id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$skill = SkillDefinition::find($skill_id);
			if($skill->campaign_id != $id) return json_encode('Skill does not belong to campaign');
			foreach(Campaign::find($id)->skills()->get() as $s) {
				$s->isMental = false;
				$s->save();
			}
			$skill->isMental = true;
			$skill->save();
			echo json_encode("Success!");
		}		
	}
	
	public function deleteSkill($id) {
		$user = Auth::user();
		if($user->isCampaignAdmin($id)) {
			$skill = SkillDefinition::find(Input::get('skill'));
			$skill->delete();
			echo json_encode("Success!");
		}
	}

}

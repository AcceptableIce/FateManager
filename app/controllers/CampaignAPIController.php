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

}

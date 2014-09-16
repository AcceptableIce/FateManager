<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $connection = 'mysql_users';
	protected $table = "accounts";
	
	protected $primaryKey = 'id';
	 
	protected $hidden = array('password', 'remember_token');
	
	public function characters() {
		return $this->hasMany('Character');
	}
	
	public function campaigns() {
		$out = array();
		foreach(PlayerPermission::where('user_id', $this->id)->get() as $p) {
			$def = $p->definition();
			if($def->id == 1 || $def->id == 2) {
				$campaign = Campaign::find($p->campaign_id);
				$out[] = $campaign;
			}
		}
		return $out;
	}
	
	public function isCampaignAdmin($campaign) {
		$pLine = PlayerPermission::where('user_id', $this->id)->where('campaign_id', $campaign)->where(function($query) {
			$query->where('permission_id', 1)->orWhere('permission_id', 2);
		})->get();
		return count($pLine) > 0;
	}
	
	public function getAuthIdentifier() {
        return $this->id;
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function getReminderEmail() {
        return $this->email;
    }
	
	public function getRememberToken() {
	    return $this->remember_token;
	}
	
	public function setRememberToken($value) {
	    $this->remember_token = $value;
	}
	
	public function getRememberTokenName() {
	    return 'remember_token';
	}

}

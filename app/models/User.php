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

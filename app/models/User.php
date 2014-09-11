<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $connection = 'user_sql';
	protected $table = "accounts";
	
	protected $primaryKey = 'id';
	 
	protected $hidden = array('password', 'remember_token');

}

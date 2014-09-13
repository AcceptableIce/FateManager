<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

public function showLogin() {
		return View::make('login');
	}

	public function doLogin() {
		$rules = array(
			'username' => 'required',
			'password' => 'required|alphaNum|min:3'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			$user = User::where('username', '=', Input::get('username'));
			if($user->count() == 0) return Redirect::to('login')->withErrors(array('message' => 'Invalid username or password.'));
			$user = $user->first(); 
			if($user->password == hash('SHA256', Input::get('password'))) {
				Auth::login($user, true);
				return Redirect::to('/');
			} else {
				return Redirect::to('login')->with('login_errors', true)->withErrors(array('message' => 'Invalid username or password.'));
			}
		}	
	}

	public function createAccount() {
		$rules = array(
			'register_username' => 'required|unique:accounts,username',
			'register_password' => 'required|alphaNum|min:5|confirmed',
			'register_email' => 'required|unique:accounts,email|email'
		);

		$validator = Validator::make(Input::all(), $rules);
		$validator->getPresenceVerifier()->setConnection('user_sql');
		if($validator->fails()) {
			return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			$user = new User;
			$user->username = Input::get('register_username');
			$user->password = hash('SHA256', Input::get('register_password'));
			$user->email = Input::get('register_email');
			$user->timestamps = false;
			$user->save();
			Auth::login($user, true);
			return Redirect::to('/');
		}

	}

	public function doLogout() {
		Auth::logout();
		return Redirect::to('login');
	}

}

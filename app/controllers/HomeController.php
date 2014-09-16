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
	
	public function createNewCharacter() {
		$user = Auth::user();

		$character = new Character;
		$character->user_id = $user->id;
		$character->campaign_id = Input::get('campaign');
		$character->name = Input::get('name');
		$character->visible = !Input::get('hidden');
		$character->save();

		return Redirect::to('/character/'.$character->id);
	}
	
	public static function convertDateToHumanReadable( $time1, $time2, $precision = 2 ) {
	// If not numeric then convert timestamps
	if( !is_int( $time1 ) ) {
		$time1 = strtotime( $time1 );
	}
	if( !is_int( $time2 ) ) {
		$time2 = strtotime( $time2 );
	}
 
	// If time1 > time2 then swap the 2 values
	if( $time1 > $time2 ) {
		list( $time1, $time2 ) = array( $time2, $time1 );
	}
 
	// Set up intervals and diffs arrays
	$intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
	$diffs = array();
 
	foreach( $intervals as $interval ) {
		// Create temp time from time1 and interval
		$ttime = strtotime( '+1 ' . $interval, $time1 );
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ( $time2 >= $ttime ) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime( "+" . $add . " " . $interval, $time1 );
			$looped++;
		}
 
		$time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
		$diffs[ $interval ] = $looped;
	}
 
	$count = 0;
	$times = array();
	foreach( $diffs as $interval => $value ) {
		// Break if we have needed precission
		if( $count >= $precision ) {
			break;
		}
		// Add value and interval if value is bigger than 0
		if( $value > 0 ) {
			if( $value != 1 ){
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}
 
	// Return string with times
	return implode( ", ", $times );
}

}

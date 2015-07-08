<?php namespace App\Http\Controllers;

use App\Http\Requests;
//use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\AuthenticateUser;

class AuthController extends Controller {

	public function login(AuthenticateUser $authenticateUser, Request $request, $provider = null) {

		return $authenticateUser->execute($request->has('code'), $this, $provider);
	}

	public function userHasLoggedIn($user) {
		//when they log in, send them back to the manage index.
		return redirect('/manage');
	}

}

<?php namespace App;

use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard as Authenticator;
use App\Repositories\UserRepository;

class AuthenticateUser {

	private $users;
	private $socialite;
	private $auth;


	public function __construct(UserRepository $users, Socialite $socialite, Authenticator $auth) {
		$this->users = $users;
		$this->socialite = $socialite;
		$this->auth = $auth;
	}

	public function execute($hasCode, $listener, $provider) {

		if(!$hasCode) return $this->getAuthorisationFirst($provider);

		$user = $this->users->findByUsernameOrCreate($this->getSocialUser($provider), $provider);

		$this->auth->login($user, true);

		return $listener->userHasLoggedIn($user);
	}

	private function getAuthorisationFirst($provider) {
		return $this->socialite->driver($provider)->redirect();
	}

	private function getSocialUser($provider) {
		return $this->socialite->driver($provider)->user();
	}

}
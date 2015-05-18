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

	public function execute($hasCode, $listener) {

		if(!$hasCode) return $this->getAuthorisationFirst();

		$user = $this->users->findByUsernameOrCreate($this->getGithubUser());

		$this->auth->login($user, true);

		return $listener->userHasLoggedIn($user);
	}

	private function getAuthorisationFirst() {
		return $this->socialite->driver('github')->redirect();
	}

	private function getGithubUser() {
		return $this->socialite->driver('github')->user();
	}
}
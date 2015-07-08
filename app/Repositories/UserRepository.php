<?php namespace App\Repositories;

use App\User;

class UserRepository {


	public function findByUsernameOrCreate($userData, $provider=null) {
		$user = User::where('provider_id', '=', $userData->id)->first();
		if(!$user) {
			//some provider specific stuff before we create
			$username = $userData->nickname;
			if($provider == 'facebook' || $username == null) {
				$username = $userData->id;
				$name_first = $userData->user['first_name'];
				$name_full = $userData->name;
			}
			if($provider == 'github') {
				$name_first = $userData->nickname;
				$name_full = $userData->name;
			}

			//check username not taken (by a different provider)
			$similarUsers = User::where('username', '=', $username)->count();
			if($similarUsers > 0) {
				//have to differ the username because we need it unique (for pretty urls etc)
				$username = $username . ($similarUsers + 1);
			}

			//create the new user
			$user = User::create([
				'username' => $username,
				'email' => $userData->email,
				'provider' => $provider,
				'provider_id' => $userData->id,
				'name_first' => $name_first,
				'name_full' => $name_full,
				'avatar_url' => $userData->avatar,
			]);
		}

		$this->checkIfUserNeedsUpdating($userData, $user, $provider);
		return $user;
	}

	public function checkIfUserNeedsUpdating($userData, $user, $provider=null) {
		$socialData = [
			//'avatar' => $userData->avatar,
			'email' => $userData->email,
			//'name' => $userData->name,
			//'username' => $userData->nickname, //updating this could mess things up
		];
		$dbData = [
			//'avatar' => $user->avatar,
			'email' => $user->email,
			//'name' => $user->name,
			//'username' => $user->username, //updating this could mess things up
		];

		//some provider specific stuff
		/*
		if($provider == 'facebook' || $socialData['username'] == null) {
			$socialData['username'] = $userData->id;
		}
		*/

		if (!empty(array_diff($socialData, $dbData))) {
			//$user->avatar = $userData->avatar;
			$user->email = $userData->email;
			//$user->name = $userData->name;
			//$user->username = $userData->nickname; //updating this could mess things up
			$user->save();
		}
	}

}
<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'key' => '',
		'secret' => '',
	],

	'github' => [
		'client_id' => getenv('GITHUB_CLIENT_ID'),
		'client_secret' => getenv('GITHUB_CLIENT_SECRET'),
		'redirect' =>  getenv('GITHUB_REDIRECT')
	],

	'facebook' => [
		'client_id' => getenv('FACEBOOK_APP_ID'),
		'client_secret' => getenv('FACEBOOK_APP_SECRET'),
		'redirect' => getenv('FACEBOOK_REDIRECT')
	]

];

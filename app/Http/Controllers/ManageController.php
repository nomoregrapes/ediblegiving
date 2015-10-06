<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Organisation;
use App\User;
use App\Http\Requests\ContactNewRequest;
use Mail;

class ManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest'); //dont use this because we are working it out ourself?
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

		//work out what to do with them
		if(!$user = Auth::user())
		{
			return view('manage.index'); //need to choose a provider & login
		}

		$data = array(
			'user' => $user
			);
		//get orgs that the user is in
		$user->orgs = Organisation::getByUser($user->id);

		//work out if they were in any orgs.
		if(!$user->orgs)
		{
			return view('manage.welcome', $data); //need a role in an org
		}


		//get the permissions they hold for each org
		foreach($user->orgs as $org)
		{
			$org->permissions = $user->getOrgPermissions($org->id);
			$data['orgs'][] = $org;
		}

		return view('manage.home', $data); //all good, show some manage links
	}

	/**
	 * Send details that a new user wants to be authorised
	 **/
	public function contactNew(ContactNewRequest $request)
	{
		if(!$user = Auth::user())
		{
			//shouldn't happen, as contact only possible once theyve logged in
			return view('manage.index'); //need to choose a provider & login
		}

		$data = array(
			'user' => $user
			);

		$input = $request->all();
		//add stuff from the logged-in user data
		$input['name_actual'] = $user->name_full;
		$input['name_first'] = $user->name_first;
		$input['email_actual'] = $user->email;
		$input['user_id'] = $user->id;
		$input['provider_used'] = $user->provider;
		$input['first_login'] = $user->created_at;
		$input['time_submitted'] = date('l jS \of F Y h:i:s A');
		//$input['picture'] = $user->avatar_url;

		//send it all in an e-mail
		//TODO: should also store or log the request in a Db?
		//TODO: replace with Mail::queue
		Mail::send('emails.admin.newuser', ["input" => $input], function($message)
		{
			$message->to('newuser@ediblegiving.org', 'Edible Giving')->subject('New User request on Edible Giving');
		});


		return view('manage.newcontact', $data);

	}


}

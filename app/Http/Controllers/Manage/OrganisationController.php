<?php namespace App\Http\Controllers\Manage;

use Auth;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\OrganisationTagDefaults;
use App\User;

class OrganisationController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Organisation Controller
	|--------------------------------------------------------------------------
	|
	| This controller provides management pages for organisations.
	*/

	protected $organisation; //current org that is being managed

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest'); //dont use this because we are working it out ourself?

		//TODO: can we do this in the constructior to avoid duplicate code in each function?
		//$this->organisation = Organisation::getBySlug($orgslug);

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$org = Organisation::getBySlug($orgslug);

		//work out what to do with them
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}

		if(!$curr_user->getOrgPermissions($org->id))
		{
			die('404');	
		}

		$data = array(
			'user' => $curr_user,
			'org' => $org
			);

		return view('manage.home', $data); //all good, show some manage links
	}


	/**
	 * List users in this organisation
	 **/
	public function users($orgslug = '')
	{
		$org = Organisation::getBySlug($orgslug);

		//check login and are a manager/admin of the org
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole(array('manager', 'admin'), $org->slug, false))
		{
			die('404');	
		}

		$data = array('org' => $org);
				$query = 'SELECT U.*, R.* 
					FROM role_user AS RU
					LEFT JOIN users AS U ON RU.user_id = U.id
					LEFT JOIN roles AS R ON RU.role_id = R.id
					WHERE RU.organisation_id = ?
					GROUP BY U.id
					ORDER BY RU.role_id ASC, U.username ASC';
		$data['users'] = DB::select($query, array((int)$org->id));

		return view('manage.organisation.users', $data);
	}


	public function usersView($orgslug = '', $username = '')
	{
		$org = Organisation::getBySlug($orgslug);

		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole(array('manager', 'admin'), $org->slug, false))
		{
			die('404');	
		}

		$data = array('org' => $org);

		//get user
		$query = 'SELECT U.*
					FROM users U
					WHERE U.username = ?
					';
		$data['user'] = DB::select($query, array($username))[0];

		if(!$data['user'])
		{
			die('User not found.');
		}

		//get roles/orgs of that user
		$query = 'SELECT RU.*, R.*, O.*
					FROM role_user RU
					LEFT JOIN roles AS R ON RU.role_id = R.id
					LEFT JOIN organisations AS O ON RU.organisation_id = O.id
					WHERE RU.user_id = ?
					ORDER BY RU.role_id ASC, O.name ASC';
		$data['user_roles'] = DB::select($query, array($data['user']->id));


		//get organisations and roles (for changing User Role).
		$query = 'SELECT O.*
					FROM organisations AS O
					WHERE 1 = 1;';
		$data['organisations'] = DB::select($query);
		$query = 'SELECT R.*
					FROM roles AS R
					WHERE 1 = 1;';
		$data['roles'] = DB::select($query);


		//display
		return view('manage.organisation.usersView', $data);
	}


	/**
	 * List defaults for this organisation
	 **/
	public function defaults($orgslug = '')
	{
		$org = Organisation::getBySlug($orgslug);

		//check login and are a manager/admin of the org
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		//TODO: maybe let them see the defaults if they are an editor?
		if(!$curr_user->hasOrgRole(array('manager', 'admin'), $org->slug, false))
		{
			die('404');	
		}


		$data = array('org' => $org);
		$data['defaults'] = OrganisationTagDefaults::getWithTagDetail($org->id);

		return view('manage.organisation.defaults', $data);
	}



}

<?php namespace App\Http\Controllers\Manage;

use Auth;
use Zizaco\Entrust\EntrustPermission; /* for detecting existance */
use App\User;
use App\Models\Role;
use App\Models\Permission;
use DB;
use \Illuminate\Http\Request;
use \App\Http\Requests\CreateOrganisationRequest;
use \App\Http\Requests\CreateUserRoleRequest;
use \App\Http\Requests\RemoveUserRoleRequest;
use Illuminate\Support\Str; /* for creating slugs */

class PowerController extends \App\Http\Controllers\Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		return view('power.index');
	}


	public function users()
	{
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}


		$data = array();

		//get users
		$data['users'] = DB::select('SELECT * FROM users where 1=1');
		foreach($data['users'] as $u => $user)
		{
			$query = 'SELECT
					organisations.name,
					organisations.slug,
					roles.display_name
				FROM role_user 
				LEFT JOIN organisations ON organisation_id = organisations.id 
				LEFT JOIN roles ON role_id = roles.id
				WHERE user_id = ?';
			$data['users'][$u]->orgs = DB::select($query, [$user->id]);
		}

		return view('power.users', $data);
	}


	public function usersView($username = '')
	{
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		$data = array();

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
		return view('power.usersView', $data);
	}

	// Save a new role
	public function usersRoleSave(CreateUserRoleRequest $request, $username = '')
	{
		$input = $request->all();

		//check login and are an admin - might not need to do this
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		$data = array();


		//\App\Models\Organisation::create($input); //TODO: something like this, what model?
		DB::table('role_user')->insert(
			array(
				'user_id' => $input['user_id'],
				'role_id' => $input['role_id'],
				'organisation_id' => $input['organisation_id']
				)
		);


		return redirect('manage/power/users/' . $username);

	}

	// Remove a role from a user
	public function usersRoleRemove(RemoveUserRoleRequest $request, $username = '')
	{
		$input = $request->all();

		//check login are an admin - or admin of that org?
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		$data = array();


		$query = DB::table('role_user')
			->where('user_id', $input['user_id'])
			->where('role_id', $input['role_id'])
			->where('organisation_id', $input['organisation_id'])
			->delete();

		return redirect('manage/power/users/' . $username);
	}


	public function orgsView($slug='')
	{
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		//get org
		$query = 'SELECT * FROM organisations WHERE slug = ?';
		$orgs = DB::select($query, array($slug));
		//$data['organisation'] = $orgs->0;
		if(!$orgs) {
			die('Organisation not found');
		}
		$data['organisation'] = $orgs[0];

		$query = 'SELECT U.*, R.* 
					FROM role_user AS RU
					LEFT JOIN users AS U ON RU.user_id = U.id
					LEFT JOIN roles AS R ON RU.role_id = R.id
					WHERE RU.organisation_id = ?
					GROUP BY U.id
					ORDER BY RU.role_id ASC, U.username ASC';
		$data['users'] = DB::select($query, array($data['organisation']->id));

		return view('power.orgsView', $data);
	}


	public function orgs()
	{
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		//get orgs
		$query = 'SELECT O.*, count(*) AS user_count FROM organisations AS O
			LEFT JOIN role_user ON O.id = organisation_id
			GROUP BY O.id;';
		$data['organisations'] = DB::select($query);

		return view('power.orgs', $data);
	}


	public function orgsCreate()
	{
		$data = array();
		return view('power.orgsCreate', $data);
	}


	public function orgsStore(CreateOrganisationRequest $request)
	{
		$input = $request->all();

		//make slug (TODO: use the org model and tidy this up)
		$slug = Str::slug($input['name']);
		$count = DB::select("SELECT COUNT(slug) as count FROM organisations WHERE slug RLIKE '^{$slug}(-[0-9]+)?$'");
		$count = $count[0]->count;
		$slug = $count ? "{$slug}-{$count}" : $slug;
		$input['slug'] = $slug;

		\App\Models\Organisation::create($input);

		return redirect('manage/power/orgs');
	}

	public function orgsUpdate($id, CreateOrganisationRequest $request)
	{
		$organisation = \App\Models\Organisation::findOrFail($id);
		$organisation->update($request->all());

		return redirect('manage/power/orgs');
	}


	public function statistics()
	{
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		return view('power.statistics');
	}


	public function bootup($function='')
	{
		//check you are good to run bootup scripts
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if($curr_user['attributes']['email'] != getenv('SUPER_ADMIN_EMAIL'))
		{
			die("not available");
			//dd($curr_user);
		}

		//login good, do stuff...

		if($function == 'acl')
		{
			echo "Setting up ACL...<br>";

			$permis = new EntrustPermission();
			if(count($permis->all()->toArray()) > 0)
			{
				die("ACL already booted up");
			}

			//setup roles
			$admin = new Role();
				$admin->name         = 'admin';
				$admin->display_name = 'Organisation admin'; // optional
				$admin->description  = 'User has full management, can only be adjusted by other admins.'; // optional
				$admin->save();
			$manager = new Role();
				$manager->name         = 'manager';
				$manager->display_name = 'Organisation manager'; // optional
				$manager->description  = 'User has full control over the organisation information, users, and location data.'; // optional
				$manager->save();
			$editor = new Role();
				$editor->name         = 'editor';
				$editor->display_name = 'Location editor'; // optional
				$editor->description  = 'User can add, edit, and remove organisation locations.'; // optional
				$editor->save();
			$viewer = new Role();
				$viewer->name         = 'viewer';
				$viewer->display_name = 'Organisation viewer'; // optional
				$viewer->description  = 'User can view organisation data and reports, but not make changes.'; // optional
				$viewer->save();
			echo "Roles created <br>";

			//setup permissions
			$locations_view = new Permission();
				$locations_view->name 	= 'org-locations-view';
				$locations_view->save();
			$locations_edit = new Permission();
				$locations_edit->name 	= 'org-locations-edit';
				$locations_edit->save();
			$locations_add = new Permission();
				$locations_add->name 	= 'org-locations-add';
				$locations_add->save();
			$locations_delete = new Permission();
				$locations_delete->name 	= 'org-locations-delete';
				$locations_delete->save();
			$defaults_view = new Permission();
				$defaults_view->name 	= 'org-defaults-view';
				$defaults_view->save();
			$defaults_edit = new Permission();
				$defaults_edit->name 	= 'org-defaults-edit';
				$defaults_edit->save();
			$defaults_add = new Permission();
				$defaults_add->name 	= 'org-defaults-add';
				$defaults_add->save();
			$defaults_delete = new Permission();
				$defaults_delete->name 	= 'org-defaults-delete';
				$defaults_delete->save();
			$users_full = new Permission();
				$users_full->name 	= 'org-users-full';
				$users_full->save();
			$admins_full = new Permission();
				$admins_full->name 	= 'org-admins-full';
				$admins_full->save();
			echo "Permissions created <br>";

			//attach permissions to roles
			$admin->attachPermissions(array(
				$admins_full,
				$users_full,
				$defaults_delete,
				$defaults_add,
				$defaults_edit,
				$defaults_view,
				$locations_delete,
				$locations_add,
				$locations_edit,
				$locations_view
				));
			$manager->attachPermissions(array(
				$users_full,
				$defaults_delete,
				$defaults_add,
				$defaults_edit,
				$defaults_view,
				$locations_delete,
				$locations_add,
				$locations_edit,
				$locations_view
				));
			$editor->attachPermissions(array(
				$defaults_view,
				$locations_delete,
				$locations_add,
				$locations_edit,
				$locations_view
				));
			$viewer->attachPermissions(array(
				$defaults_view,
				$locations_view
				));
			echo "Permissions attached to roles <br>";

			//add EG organisations
			$eg_id = DB::table('organisations')->insertGetId(
				['name' => 'Edible Giving',
				'slug' => 'edible-giving',
				'description' => 'Locations added by site moderators',
				'admin_note' => 'Has special technical roles'
				]);
			echo "EG added as an org (". $eg_id .") <br>";

			//add current/super_admin user as admin of EG
			$curr_user->attachRoleWithOrg($admin, $eg_id);
			echo "Current user attached to EG as admin.";


			echo "Done.";
			die();
		}

		elseif($function == 'debug')
		{
			echo "Setting up ACL...<br>";

			$roles = new Role();

			if(count($roles->all()->toArray()) < 1)
			{
				die("ACL needs fresh bootup");
			}
			foreach($roles->all() as $p)
			{
				if($p['attributes']['name'] == 'admin')
				{
					$admin = $p;
				}
			}
			echo "Found admin role <br>";

			//add EG organisations
			$eg_id = 6;

			//add current/super_admin user as admin of EG
			$curr_user->attachRoleWithOrg($admin, $eg_id);


			echo "Done.";
			die();
		}

		//err, what do you want?
		die('404');
		//return view('home');
	}

}

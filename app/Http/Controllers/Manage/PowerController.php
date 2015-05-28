<?php namespace App\Http\Controllers\Manage;

use Auth;
use Zizaco\Entrust\EntrustPermission; /* for detecting existance */
use App\User;
use App\Models\Role;
use App\Models\Permission;
use DB;

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
		echo "power index <br>";
		//check login and are an admin
		if(!$curr_user = Auth::user())
		{
			return redirect('/manage');
		}
		if(!$curr_user->hasOrgRole('admin', 'edible-giving'))
		{
			die('404');	
		}

		echo "You're in <br>";
		dd($curr_user);
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

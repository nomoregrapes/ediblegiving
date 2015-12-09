<?php namespace App\Http\Controllers\Manage;

use Auth;
use DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Organisation;
use App\Models\OutputCsv;

/*
use App\Models\Location;
use App\Models\LocationTag;
use App\Models\OrganisationTagDefaults;
use App\Models\TagKey;
*/

class OutputController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Import Controller
	|--------------------------------------------------------------------------
	|
	| This controller provides functions to import location data
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
	public function index($orgslug = '')
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
			'org' => $org,
			);

		//figure out what the latest csv filename is
		//TODO: take this from a cache folder?
		$data['csvLatest'] = "/manage/output/$orgslug/edible-giving_". $orgslug ."_". date('Ymd_His') .".csv" ;

		return view('manage.output.index', $data); //all good, show some manage links
	}


	/**
	 * Generate and download the CSV file - straight off, no cache or anything
	 * TODO: depreciate this, because it's probably not the best thing to do.
	 *
	 */
	public function csvDirect($orgslug = '', $filename = '')
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

		return OutputCsv::generateCsv($org, $filename);
	}


}

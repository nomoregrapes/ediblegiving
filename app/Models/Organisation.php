<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Organisation extends Model {
	
	protected $fillable = [
		'name',
		'slug',
		'description',
		'admin_note'
	];


	public static function getByUser($user_id)
	{
		$orgs = DB::table('role_user')
			->leftJoin('organisations', 'organisation_id', '=', 'organisations.id')
			->where('user_id', '=', $user_id)
			->get();
		return $orgs;
	}


	public static function getBySlug($orgslug)
	{
		$orgs = DB::table('organisations')
			->where('slug', '=', $orgslug)
			->first();
		return $orgs;
	}
}
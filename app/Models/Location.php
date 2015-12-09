<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Location extends Model {

	protected $table = 'location';	
	protected $fillable = [
		'lat',
		'lon',
		'organisation_id',
		'visible'
	];

	public function tags()
	{
		return $this->hasMany('LocationTag');
	}

	//TODO: I want to know how to write tags properly so I can chain them

	//TODO: should append ->whereNull('deleted_at'); by default - then remove that from other places


	public static function inOrg($org_id)
	{
		return DB::table('location')
			->where('organisation_id', '=', $org_id);
	}


}
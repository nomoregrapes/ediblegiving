<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class LocationTag extends Model {

	protected $table = 'location_tag';
	
	protected $fillable = ['location_id', 'key', 'value', 'populated_by'];
	protected $hidden = [];


	public function getCoreTags($location_id)
	{
		$coreTags = array('name', 'website');

		$result = DB::table('location_tag')
			->where('location_id', '=', $location_id)
			->whereIn('key', $coreTags)
			->get();

		$tags = array();

		foreach($result as $row)
		{
			$tags[ $row->key ] = $row->value;
		}
		return $tags;
	}


	public function getTopTags($location_id)
	{
		$coreTags = array('name', 'website');

		$result = DB::table('location_tag')
			->where('location_id', '=', $location_id)
			->whereNotIn('key', $coreTags)
			->limit(3)
			->get();

		$tags = array();

		foreach($result as $row)
		{
			$tags[ $row->key ] = $row->value;
		}
		return $tags;
	}
	
}
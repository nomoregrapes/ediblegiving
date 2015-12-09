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

	public static function getAllTags($location_id)
	{
		$result = LocationTag::where('location_id', '=', $location_id)
			->leftJoin('tag_key', 'location_tag.key', '=', 'tag_key.key')
			->get();
		
		return $result;
		/*
		$tags = array();
		foreach($result as $row)
		{
			$tags[ $row->key ] = $row->value;
		}
		return $tags;
		*/
	}

	//TODO: can we refractor to remove the need for getAllTags and getAllLocTags?
	public static function getAllLocTags($location_id)
	{
		$result = LocationTag::where('location_id', '=', $location_id)
			->leftJoin('tag_key', 'location_tag.key', '=', 'tag_key.key')
			->get();
		
		
		$tags = array();
		foreach($result as $row)
		{
			$tags[ $row->key ] = $row->value;
		}
		return $tags;
	}

	/* 
	 * This gets any & all tags that are used by an org
	 * primary use for CSV export, so we know what columns are needed
	 */
	public static function getOrgUsedTags($org_id) {
		$result = LocationTag::where('location.organisation_id', '=', $org_id)
			->leftJoin('tag_key', 'location_tag.key', '=', 'tag_key.key')
			->leftJoin('location', 'location_tag.location_id', '=', 'location.id')
			->groupBy('location_tag.key')
			->get();
		
		return $result;
		/*
		$tags = array();
		foreach($result as $row)
		{
			$tags[ $row->key ] = $row->value;
		}
		return $tags;
		*/
	}

	/**
	 * override update function, needs to do it on two keys
	 **/
/*
	public function update(array $attributes = array()) {
		dd($attributes);

	}
*/

	public function updateTags(Location $location, $key, $data) {
		$new_data = $data;
		$new_data['location_id'] = $location->id;
		$new_data['key'] = $key;


		//TODO: tidy up the building of this query or find another way to do it?
		$query = "INSERT INTO ". $this->table 
			."(";
			foreach(array_keys($new_data) as $i=>$v) {
				$query .= "`". $v ."`";
				if($i < count($new_data)-1) {
					$query .= ",";
				}
			}
			$query .= ")" //close up the keys
			." VALUES (";
			foreach(array_values($new_data) as $i=>$v) {
				$query .= DB::connection()->getPdo()->quote($v);
				if($i < count($new_data)-1) {
					$query .= ",";
				}
			}
			$query .= ")" //close up the values
			." ON DUPLICATE KEY UPDATE ";
		$i = 0;
		foreach($data as $col => $val) {
			$query .= " ". $col ."=". DB::connection()->getPdo()->quote($val);
			if($i < count($data)-1) {
				$query .= ",";
			}
			$i++;
		}
		$query .= ";";

		//dd($query);

		DB::statement($query);
	}

	/** 
	 * override the findOrFail func, as two keys are concerned
	 */
	public static function findOrFail($location_id, $key) {
		$location_tag = LocationTag::where('location_id', '=', $location_id)
			->where('key', '=', $key)
			->first();
		return $location_tag;
	}
	
}
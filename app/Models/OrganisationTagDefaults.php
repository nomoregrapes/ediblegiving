<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrganisationTagDefaults extends Model {

	protected $table = 'organisation_tag_defaults';
	
	protected $fillable = ['key', 'value'];
	protected $hidden = [];



	public static function getWithTagDetail($org_id)
	{
		$defaults = OrganisationTagDefaults::where('organisation_id', $org_id)
			->leftJoin('tag_key', 'organisation_tag_defaults.key', '=', 'tag_key.key')
			->select(
				'organisation_tag_defaults.key', 
				'organisation_tag_defaults.value as default_value', 
				'organisation_tag_defaults.created_at', 
				'organisation_tag_defaults.updated_at', 
				'tag_key.label', 
				'tag_key.value_type', 
				'tag_key.description'
				)
			->get();
		return $defaults;
	}
	
}
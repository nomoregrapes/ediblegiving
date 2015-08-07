<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TagKey extends Model {

	protected $table = 'tag_key';
	
	protected $fillable = ['name', 'value', 'value_type', 'description', 'visible', 'exported', 'restricted'];
	protected $hidden = [];


	
}
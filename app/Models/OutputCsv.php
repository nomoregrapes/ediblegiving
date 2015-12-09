<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Response;
use App\Models\Location;
use App\Models\LocationTag;

class OutputCsv extends Model {


	public static function generateCsv($org, $filename)
	{
		$headers = [
			'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
			,   'Content-type'        => 'text/csv'
			,   'Content-Disposition' => 'attachment; filename='.$filename.'.csv'
			,   'Expires'             => '0'
			,   'Pragma'              => 'public'
		];

		//first the simple headings
		$row_headings = array(
			'id',
			'latitude',
			'longitude',
			'published',
			'created',
			'updated'
			);

		//work out what tags we will have
		$tags_used = LocationTag::getOrgUsedTags($org->id);
		//the tag headings are just the tag labels
		foreach($tags_used as $row)
		{
			$row_headings[] = $row->label;
		}

		//first, the headings go into the list (unless we array_unshift it in later)
		$list = array(
			$row_headings
			);

		//okay, now get the locations
			//TODO: add any search parameters (like restricting to published locations)
		$locations = Location::where('organisation_id', '=', $org->id)
			->whereNull('deleted_at')
			->get();

		//compile the locations into the list, as we want - TODO: probably do a more efficent method?
		foreach ($locations as $loc) {
			//compile the array
			$thisLoc = array(
				$loc->id, 
				$loc->lat,
				$loc->lon,
				($loc->visible == 1 ? 'published' : 'draft'),
				$loc->created_at->toDateTimeString(),
				$loc->updated_at->toDateTimeString()
			);
			//get the tags of this loc
			$loc_tags = LocationTag::getAllLocTags($loc->id);
			//put the tags in IN THE SAME ORDER as the headings
			foreach($tags_used as $nextTag) {
				if(!array_key_exists($nextTag->key, $loc_tags)) {
					$thisLoc[] = "n/a";
				} elseif($nextTag->value_type == 'boolean') {
					$thisLoc[] = ($loc_tags[$nextTag->key] == 1 ? 'yes' : 'no');
				} else {
					$thisLoc[] = $loc_tags[$nextTag->key];
				}
			}

			//okay, put it in the list for the csv
			$list[] = $thisLoc;
		}

		//add headers for each column in the CSV download
		//array_unshift($list, $row_headings);

		$callback = function() use ($list) 
		{
			$FH = fopen('php://output', 'w');
			foreach ($list as $row) { 
			fputcsv($FH, $row);
		}
			fclose($FH);
		};

		return Response::stream($callback, 200, $headers);
	}

}
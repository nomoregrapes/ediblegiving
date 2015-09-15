<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateLocationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; //no user checking
		//TODO: must have permissions for the org of this location
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		//dd($this->request);//->get('key'));

		// http://laravel.com/docs/5.0/validation#available-validation-rules
		$rules = array(
			'lat' => 'required|numeric|min:-90|max:90', //|not_in:0',
			'lon' => 'required|numeric|min:-180|max:180', //|not_in:0',
			//'organisation_id' => 'required|numeric', //TODO: check it exists //Don't do: it gets added later
			'visible' => 'boolean'
		);


		//check you've got some required minimum tags
		$tags = $this->request->get('tag');
		if(!array_key_exists('name', $tags)) {
			$rules['name'] = 'required';
		}
		//check there is at least one tag of certain types
		$rules['activity'] = 'required';
		foreach($tags as $k=>$v) {
			if(substr($k, 0, 9) == 'activity_') {
				$rules['activity'] = '';
			}
		}

		//rules done
		return $rules;
	}

}

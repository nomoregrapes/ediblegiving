<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateOrganisationTagDefaultRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; //no user checking
		//TODO: must have permissions
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		//dd($this->request);//->get('key'));

		$rules = array(
			//'organisation_id' => 'required|integer',
			'key' => 'required'
		);


		//check the value is the right type
		//TODO: tighten up the rules
		switch($this->request->get('value-type')) {
			case 'boolean':
				$rules['value-boolean'] = 'required|boolean';
				break;
			case 'website':
				$rules['value-website'] = 'required|string';
				break;
			case 'telephone':
				$rules['value-telephone'] = 'required';
				break;
			default:
				$rules['value-text'] = 'required|string';
				break;
		}



		return $rules;
	}

}

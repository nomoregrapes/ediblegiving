<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateOrganisationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; //no user checking
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$slug_req = '';

		if($this->method == "PATCH") {
			$slug_req = 'required'; //TODO: should not match any org but itself
		}

		return [
			'name' => 'required|min:5',
			'slug' => $slug_req,
			'description' => '',
			'admin_note' => ''
		];
	}

}

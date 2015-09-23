<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewImportRequest extends Request {

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

		return [
			'dataurl' => 'required|min:5'
		];
	}

}

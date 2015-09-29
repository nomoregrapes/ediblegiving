<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactNewRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; //no user checking
		//TODO: must be logged in, but doesnt need an org
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
			'name' => 'required',
			'email' => 'required|email'
		);

		//rules done
		return $rules;
	}

}

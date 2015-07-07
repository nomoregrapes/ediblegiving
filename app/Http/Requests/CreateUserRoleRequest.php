<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use DB;

class CreateUserRoleRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; //TODO: user checking (EG admin or admin of the org)
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		//check the user(that we're editing) exists
		$u_id = $this->request->get('user_id');
		$query = 'SELECT U.*
					FROM users U
					WHERE U.id = ?
					';
		$user = DB::select($query, array($u_id));
		if(!$user)
		{
			$user_passed = 'required|integer|min:100|max:10'; //TODO: Greg you are a fool
		}
		else {
			$user_passed = 'required|integer';
		}

		//check the user doesn't have that org/role combo already (allows different roles in same org)
		$query = 'SELECT RU.user_id
					FROM role_user RU
					WHERE user_id = ?
					AND role_id = ?
					AND organisation_id = ?
					';
		$role_user = DB::select($query, array(
			$u_id,
			$this->request->get('role_id'),
			$this->request->get('organisation_id')
			));
		if($role_user)
		{
			$role_passed = 'required|integer|min:100|max:10'; //TODO: Greg you really are a fool
		}
		else
		{
			$role_passed = 'required|integer';
		}

		//TODO: should check org id and role id exist and not already assigned to the user
		//if($this->method == "PATCH") {

		//dd($this->request->all());
		//dd($this);

		return [
			'user_id' => $user_passed,
			'organisation_id' => 'required|integer',
			'role_id' => $role_passed
		];
	}


	public function messages()
	{
		return [
			'user_id.min' => 'That user does not exist.', //TODO: If Greg stops being a fool, don't do this?
			'user_id.max' => 'That user does not exist.', //TODO: If Greg stops being a fool, don't do this?
			'role_id.min' => 'The user already has the role with that organisation.', //TODO: If Greg stops being a fool, don't do this?
			'role_id.max' => 'The user already has the role with that organisation.' //TODO: If Greg stops being a fool, don't do this?
		];
	}

}

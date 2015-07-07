<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use DB;

class RemoveUserRoleRequest extends Request {

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
		//check the user has that org/role combo already so we can remove it
		$query = 'SELECT RU.user_id
					FROM role_user RU
					WHERE user_id = ?
					AND role_id = ?
					AND organisation_id = ?
					';
		$role_user = DB::select($query, array(
			$this->request->get('user_id'),
			$this->request->get('role_id'),
			$this->request->get('organisation_id')
			));
		if(!$role_user)
		{
			$role_passed = 'required|integer|min:100|max:10'; //TODO: Greg you really are a fool
		}
		else
		{
			$role_passed = 'required|integer';
		}

		//dd($this->request->all());
		//dd($this);

		return [
			'task' => 'in:remove',
			'user_id' => 'required|integer',
			'organisation_id' => 'required|integer',
			'role_id' => $role_passed
		];
	}


	public function messages()
	{
		return [
			'task.in' => 'Unsupported action initiated.',
			'role_id.min' => 'The user does not exist or they do not have that role anymore.', //TODO: If Greg stops being a fool, don't do this?
			'role_id.max' => 'The user does not exist or they do not have that role anymore.' //TODO: If Greg stops being a fool, don't do this?
		];
	}

}

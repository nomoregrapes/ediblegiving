<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, EntrustUserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];



    /**
     * Alias to eloquent many-to-many relation's attach() method.
     * This exists so that a specific organisation forms a part of the Entrust role for the user.
     *
     * @param mixed $role
     */
    public function attachRoleWithOrg($role, $organisation)
    {
        if(is_object($role)) {
            $role = $role->getKey();
        }

        if(is_array($role)) {
            $role = $role['id'];
        }


        if(is_object($organisation)) {
            $organisation = $organisation->getKey();
        }

        if(is_array($organisation)) {
            $organisation = $organisation['id'];
        }

        $this->roles()->attach($role, ['organisation_id' => $organisation]);
    }

}

<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;

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
	protected $fillable = [
        'username', 
        'email', 
        'provider',
        'provider_id',
        'name_first',
        'name_full',
        'avatar_url'
        ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];




    /**
     * Checks if the user has a role by its name.
     *
     * @param string|array $name       Role name or array of role names.
     * @param bool         $requireAll All roles in the array are required.
     *
     * @return bool
     */
    public function hasOrgRole($name, $org = null, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasOrgRole($roleName, $org);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the roles were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the roles were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            //get roles of this user
            if($org == null)
            {
                $org_roles = DB::select('SELECT * FROM roles 
                    LEFT JOIN role_user ON roles.id=role_user.role_id 
                    WHERE role_user.user_id = ?', 
                    [$this->id]);
            }
            else if(is_integer($org))
            {
                $org_roles = DB::select('SELECT * FROM roles 
                LEFT JOIN role_user ON roles.id=role_user.role_id 
                WHERE role_user.user_id = ?
                AND role_user.organisation_id = ?', 
                [$this->id, $org]);
            }
            else
            {
                //look up $org as a slug
                $the_org = DB::select('SELECT id FROM organisations
                    WHERE slug = ? LIMIT 1;', [$org])[0];
                //rerun this func
                return $this->hasOrgRole($name, (int)$the_org->id);
            }
            //check each of the users roles
            foreach ($org_roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Gets all the permissions a user has within an organisation
     *
     */
    public function getOrgPermissions($org_id)
    {
        $parameters = array(
            $this->id,
            $org_id
            );
        $query = 'SELECT P.*
                    FROM permissions P
                    LEFT JOIN permission_role AS PR ON P.id = PR.permission_id
                    LEFT JOIN roles AS R ON PR.role_id = R.id
                    LEFT JOIN role_user AS RU ON R.id = RU.role_id
                    WHERE RU.user_id = ?
                        AND RU.organisation_id = ?
                    ORDER BY RU.role_id ASC';
        $result = DB::select($query, $parameters);

        //make them accesible by term
        $data = array();
        foreach($result as $permis)
        {
            $data[$permis->name] = $permis;
        }

        return $data;
    }


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

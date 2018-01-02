<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Permission;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RolesPermissionsController extends Controller {
	
	/**
	 * @param Role $role
	 * @param Permission $permission
	 * @param Guard $auth
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$roles = Role::with('permissions')->get();
		$permissions = Permission::all();
		return view('roles_permissions.index', compact('roles', 'permissions'));
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		$input = $request->all();

		$roles = Role::with('permissions')->get();

		foreach($roles as $role)
		{
			$permissions_sync = isset($input['roles'][$role->id]) ? $input['roles'][$role->id]['permissions'] : [];

			$role->perms()->sync($permissions_sync);
		}

		$request->session()->flash('message', 'Permissions successfully updated.');
		
		return redirect('/role_permission ');
	}

}
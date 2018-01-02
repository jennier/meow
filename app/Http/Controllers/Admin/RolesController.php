<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Permission;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RolesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$roles = Role::latest()->orderBy('display_name','asc')->with('permissions')->paginate(20);

        $no = $roles->firstItem();

        return view('roles.index', compact('roles', 'no'));
	}

	public function create()
	{
		$permissions = Permission::all();
		return view('roles.create', compact('permissions'));
	}

	public function store(Request $request)
	{

		$this->validate($request, array('name' => 'required', 'display_name' => 'required'));


		$role = Role::create($request->all());

		$role->savePermissions($request->get('perms'));
		$request->session()->flash('message', 'Role successfully created');

		return redirect()->route('roles.index');
	}

	public function edit($id)
	{
		$role = Role::findOrFail($id);
		$permissions = Permission::all();
		$rolePermissions = $role->permissions()->lists('permission_id'); 
		return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required'));

		$role = Role::findOrFail($id);
		$role->update($request->all());

		$role->savePermissions($request->get('perms'));

		$request->session()->flash('message', 'Role successfully updated');
		return redirect()->route('roles.index');
	}

	public function destroy($id)
	{
	
		Role::delete($id);

		$request->session()->flash('message', 'Role successfully deleted');
		return redirect()->route('roles.index');
	}

}
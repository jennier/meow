<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Permission;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class PermissionsController extends Controller {

	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$permissions = Permission::latest()->orderBy('name','asc')->paginate(20);

        $no = $permissions->firstItem();

		return view('permissions.index', compact('permissions','no'));
	}

	public function create()
	{
		return view('permissions.create');
	}

	public function store(Request $request)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required'));

		$permission = Permission::create($request->all());

		//$role = Role::where('name', 'admin')->get();

		//$role->permissions()->sync([$permission->id]);

		$request->session()->flash('message', 'Permission successfully created');

		return redirect()->route('permissions.index');
	}

	public function edit($id)
	{
		$permission = Permission::findOrFail($id);
		return view('permissions.edit', compact('permission'));
	}


	public function update(Request $request, $id)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required'));

		$permission = Permission::findOrFail($id);
		$permission->update($request->all());

		$request->session()->flash('message', 'Permission successfully updated');

		return redirect()->route('permissions.index');
	}

	public function destroy($id)
	{
		$permission = Permission::findOrFail($id)->delete();
		
		$permission->roles()->detach();

		$request->session()->flash('message', 'Permission successfully deleted');

		return redirect()->route('permissions.index');
	}

}
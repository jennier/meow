<?php namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Hash;
use Laracasts\Flash\Flash;
use Mail;

class UsersController extends Controller {

	protected $dateFormat = 'm dd, Y';

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$users = User::all();
		return view('users.index', compact('users'));
	}
	
	/**
	 * @return \Illuminate\View\View
	 */
	public function show($name)
	{
		$user = User::where('name',$name)->first();
		$class = $user->roles->where('name','like','classA')->first();
		return view('users.show', compact('user','class'));
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		$roles = Role::all();
		return view('users.create', compact('roles'));
	}

	/**
	 * @param CreateUserRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		$user = $request->all();
		$password = $user['password'];
		$user['password'] = bcrypt('plain-text');
		$user = User::create($user);
		$user['password_show'] = $password;
		
		if($request->get('role')) {
			$user->roles()->attach($request->get('role'));
		} 
		
		Mail::send('emails.welcome', ['user' => $user], function ($m) use ($user) {
            $m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
            $m->to($user['email'], $user['name'])->subject('Welcome to MEOW');
			$m->bcc('jennieruff@gmail.com', $name = null);
        });
		
		$request->session()->flash('message', 'User successfully created');

		return redirect()->route('members.index');
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);
		$roles = Role::all();
		$userRoles = $user->roles();
		return view('users.edit', compact('user', 'roles', 'userRoles'));
	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 */
	public function update(Request $request, $id)
	{
		$user = User::findOrFail($id);

		$user->email = $request->get('email');
		
		if($request->get('password')) :
			$user->password = Hash::make($request->get('password'));
		endif; 
		
		$user->save();

		if($request->get('role')) : 
			$user->roles()->sync($request->get('role'));
		else : 
			$user->roles()->sync([]);
		endif ;

		$request->session()->flash('message', 'Member edited successfully');

		return redirect()->route('members.index');
	}

	/**
	 * @param $id
	 */
	public function destroy(Request $request, $id)
	{
		$user = User::findOrFail($id);
		$user->delete();

		$request->session()->flash('message','User successfully deleted');

		return redirect()->route('members.index');
	}
	
	public function committees()
	{
		return view('users.committees');
	}

}
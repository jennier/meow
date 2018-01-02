<?php namespace App\Http\Controllers;

use App\Ballot;
use App\User;

class DashboardController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
		$this->middleware('auth', ['only' => 'logged']);
	}

	public function index()
	{
		$ballots = Ballot::latest()->with('owner')->where('status', '!=', '2')->paginate(20);
		
		$ended = Ballot::latest()->with('owner')->where('status', '2')->paginate(20);
		
		return view('dashboard.index', compact('ballots', 'ended'));
	}

}

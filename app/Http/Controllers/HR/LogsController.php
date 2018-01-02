<?php namespace App\Http\Controllers\HR;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HrLog;
use App\Http\Requests\Hrlogs\CreateHrlogRequest;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $hr_logs = Hrlog::latest()->with('owner')->paginate(20);

        $no = $hr_logs->firstItem();

        return view('hr.logs.index', compact('hr_logs', 'no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
		$log = $request->all();
		$log['user_id'] = $request->user()->id;

        $hrlog = Hrlog::create($log);
		
        return redirect()->route('hr.events.show', ['id' => $request->event_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $log = Hrlog::findOrFail($id);

        return view('hr.log.show', compact('log'));
    }
	
}

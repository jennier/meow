<?php namespace App\Http\Controllers\HR;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HrPoint;
use App\Http\Requests\Hrlogs\CreateHrpointRequest;

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
        $points = Hrpoints::latest()->with('owner')->paginate(20);

        $no = $points->firstItem();

        return view('hr.points.index', compact('points', 'no'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
		$points = $request->all();

        $hr_points = Hrpoint::create($points);
		
        return redirect()->route('hr.events.show', ['id' => $request->event_id]);
    }

}

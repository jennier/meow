<?php namespace App\Http\Controllers\HR;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HrReport;
use App\Http\Requests\Hrreports\CreateHrreportRequest;

class ReportsController extends Controller
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
        $hr_reports = Hrreport::latest()->with('owner')->paginate(20);

        $no = $hr_reports->firstItem();

        return view('hr.reports.index', compact('hr_reports', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
		$report = $request->all();
		$report['user_id'] = $request->user()->id;
        $report['type'] = 'Submittor';

        // Create an initial report for the person submitting the report
        $hrreport = Hrreport::create($report);
		
        // For each indivdual involved, create a new report listing linked to the event.
        foreach($request->involved as $member):
            $report['user_id'] = $member['id'];
            $report['type'] = 'Involved';
            $hrreport = Hrreport::create($report);
        endforeach;
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $report = Hrreport::findOrFail($id);

        return view('hr.reports.show', compact('report'));
    }
	
}

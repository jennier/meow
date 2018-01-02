<?php namespace App\Http\Controllers\CR;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CrReport;
use Mail;
use App\Http\Requests\Crreports\CreateCrreportRequest;
use App\Http\Requests\Crreports\UpdateCrreportRequest;

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
        $cr_reports = Crreport::latest()->with('owner')->paginate(20);

        $no = $cr_reports->firstItem();

        return view('cr.index', compact('cr_reports', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('cr.create');
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
		$report['email'] = $request->user()->email;
		$report['owner'] = $request->user()->name;
		
        $crreport = Crreport::create($report);
		
		$report['id'] = $crreport->id;
		$report['type'] = $crreport->reportType();
		
		Mail::send('emails.report', ['report' => $report], function ($m) use ($report) {
				$m->subject('New CR report submitted by '. $report['owner']);
				$m->from('admin@cutcatscourier.com','Cut Cats Courier');
				$m->to('tim@cutcatscourier.com', 'CR');
				$m->bcc('jennieruff@gmail.com', 'JRuff');
		});
		
		$request->session()->flash('message', 'Thank you for submitting your report! Someone from CR will get back to you soonish.');
		
        return redirect()->route('cr.reports.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $report = Crreport::findOrFail($id);

        return view('cr.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $crreport = Crreport::findOrFail($id);
    
        return view('cr.edit', compact('crreport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateCrreportRequest $request, $id)
    {       
        $crreport = Crreport::findOrFail($id);

        $crreport->update($request->all());

        return redirect()->route('cr.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $crreport = Crreport::findOrFail($id);
        
        $crreport->delete();
    
        return redirect()->route('cr.reports.index');
    }
	
}

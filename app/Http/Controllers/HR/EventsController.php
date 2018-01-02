<?php namespace App\Http\Controllers\HR;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HrEvent;
use App\User;
use App\Http\Requests\Hrevents\CreateHreventRequest;
use App\Http\Requests\Hrevents\UpdateHreventRequest;
use Mail;

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
        $event = Hrevent::latest()->with('owner')->paginate(20);

        $no = $event->firstItem();

        return view('hr.events.index', compact('hr_reports', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
		$event = $request->all();
        $event['status'] = 0;

        // Create the event.
        $hr_event = Hrevent::create($event);

        //Create related event report(s).
        $event->report()->create($event);

        //Send email to HR. 
        Mail::send('emails.hrevent', ['event' => $event], function ($m) use ($event) {
            $m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
            $m->to('cutcatshr@gmail.com', 'Cut Cats HR')->subject('New HR report: '. $event->title);
        });
        
        $request->session()->flash('message', 'Thank you for filing a report with HR.');

        return redirect()->route('hr.reports.show', $event->id);
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event = Hrevent::findOrFail($id);

        return view('hr.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $event = Hrevent::findOrFail($id);
    
        return view('hr.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {       
        $event = Hrevent::findOrFail($id);

        //Log information
        $log = $request->all();
        $log['user_id'] = $request->user()->id;
        
        // Things we can do:
        // Close the ticket
        // Notify the recipient(s)
        // Dispute the report
        // Add more information/log 

        if($request['action'] == 'close') :

            $event->status = 1;
            $event->save();

            //If points were assigned, assign points to any users who need them.
            $event->points()->create();

            $reports = $event->reports;

            //Send an email to anyone involved.
            foreach($reports as $report):
                $email = $report->owner()->email;
                $username = $report->owner()->name;

                $recipients += [$email => $username];

            endforeach;

            Mail::send('emails.closehrevent', ['event' => $event], function ($m) use ($event) {
                $m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
                $m->to('cutcatshr@gmail.com', 'Cut Cats HR')->subject('HR event closed');
                $m->bcc($recipients);
            });


        elseif ($request['action'] == 'notify') :

            //Send an email to involved individuals notifying them of the report.
            foreach($reports as $report):
                $email = $report->owner()->email;
                $username = $report->owner()->name;

                $recipients += [$email => $username];

            endforeach;

            Mail::send('emails.hrevent', ['event' => $event], function ($m) use ($event) {
                $m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
                $m->to('cutcatshr@gmail.com', 'Cut Cats HR')->subject('HR event');
                $m->bcc($recipients);
            });

        elseif ($request['action'] == 'dispute') :

            //File a dispute with HR by logging a dispute, this changes the status to 2 (disputed).
            $event->status = 2;
            $event->save();

            //Send an email to HR/anyone involved.
            foreach($reports as $report):
                $email = $report->owner()->email;
                $username = $report->owner()->name;

                $recipients += [$email => $username];

            endforeach;

            Mail::send('emails.custom', ['event' => $event], function ($m) use ($event) {
                $m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
                $m->to('cutcatshr@gmail.com', 'Cut Cats HR')->subject('HR event dispute');
                $m->bcc($recipients);
            });
           
        endif;

        //Log the action
        $event->log()->create($log);

       return redirect()->route('hr.events.show',[$id]);
    }
	
}

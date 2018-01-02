<?php 

namespace App\Http\Controllers\Surveys;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Survey;
use App\SurveyResponse;
use App\SurveyQUESTION;
use App\User;
use App\Http\Requests\Surveys\CreateSurveyRequest;
use App\Http\Requests\Surveys\UpdateSurveyRequest;
use Mail;
use Carbon\Carbon;

class SurveysController extends Controller
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
        $surveys = Survey::latest()->paginate(20);

        $no = $surveys->firstItem();

        return view('surveys.index', compact('surveys', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateSurveyRequest $request)
    {
        $survey = Survey::create($request->all());
		
        return redirect()->route('surveys.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $survey = Survey::findOrFail($id);
		
		//List of users who haven't voted on this ballot (right now it gets users who have never voted)
		$no_response = User::whereHas('responses', function ($query) use ($id) {
    				$query->where('survey_id', $id);
				}, '<', 1)->get();

        return view('surveys.show', compact('survey','no_response'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
    
        return view('surveys.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {       
        $survey = Survey::findOrFail($id);
		
		//If we're closing the ballot (0), or opening the ballot (1)
		if($request['status'] == 2) :
			$request['expiration'] = Carbon::now();
		elseif($request['status'] == 1) :
			$request['expiration'] = Carbon::now()->addDays(5);
		else :
			$request['expiration'] = Carbon::now()->addWeeks(1);
		endif; 

        $survey->update($request->all());

        return redirect()->route('surveys.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        
        $survey->delete();
    
        return redirect()->route('surveys.index');
    }
	
	/**
     * View all/individual responses to surveys
     *
     * @param  int  $id
     * @return Response
     */
	 
	 public function responses($id){
		 
		 $survey = Survey::where('id',$id)->with(array(
							'questions' => function ($query) {
								$query->orderBy('group_id', 'asc');
							}),'responses.user')->first();
		 return view('surveys.responses', compact('survey'));
	 }
	
	
	/**
     * Send an email to users who haven't finished their surveys
     *
     * @param  int  $id
     * @return Response
     */
	 public function notify(Request $request, $id)
	 {
		 
		 $survey = Survey::findOrFail($id);
		 $users  = User::whereHas('responses', function ($query) use ($id) {
    				$query->where('survey_id', $id);
				}, '<', 1)->get();
		
		foreach($users as $user){
			$data = array('name' => $user->name, 'email' => $user->email, 'survey' => $survey->name, 'id' => $survey->id);
			
			Mail::queue('emails.reminderSurvey', $data, function ($m) use ($data) {
				$m->subject('Hey can you plesase respond to this survey '. $data['survey'] .'?');
				$m->from('admin@cutcatscourier.com','Cut Cats Courier');
				$m->to($data['email'], $data['name']);
				$m->bcc('jennieruff@gmail.com', 'JRuff');
			});
		}
		
		$request->session()->flash('message', 'Email reminders will be sent to members who have not yet completed their surveys.');
		
		return redirect()->route('surveys.show',[$id]);
	 }

}

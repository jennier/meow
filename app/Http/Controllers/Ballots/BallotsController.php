<?php 

namespace App\Http\Controllers\Ballots;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Ballot;
use App\User;
use App\Http\Requests\Ballots\CreateBallotRequest;
use App\Http\Requests\Ballots\UpdateBallotRequest;
use Mail;

class BallotsController extends Controller
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
        $ballots = Ballot::latest()->has('owner')->paginate(25);

        $no = $ballots->firstItem();

        return view('ballots.index', compact('ballots', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ballots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
		
		$ballot = $request->all();
		$ballot['user_id'] = $request->user()->id;
		$ballot['consensus'] = 'majority';
		$ballot['class_restriction'] = 0;
		$ballot['expiration'] = date('Y-m-d', strtotime("+2 days"));
		$email = $request->email;
		if($request->type == 1) :
			$ballot['status'] = 1;
		else :
			$ballot['status'] = 0;
		endif;
		
		$ballot = Ballot::create($ballot);
		$ballot->email = $email;
		
		$content = $request->all();
		$content = $ballot->content()->create($content);
		
		$questions = array_filter($request->question);
	
		foreach($questions as $question) :
			$q = $ballot->questions()->create(array('question' => $question['name'], 'type' => $question['type']));
			if($question['type'] == 2) :
				//create the question choices here
				foreach($question['choice'] as $choice) :
					$c = $q->choices()->create(array('question_id' => $q->id, 'name' => $choice));
				endforeach;
			endif;
		endforeach;
		
		Mail::send('emails.custom', ['ballot' => $ballot], function ($m) use ($ballot) {
            $m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
            $m->to('meownow@googlegroups.com', 'Meow Now')->subject('New ballot: '. $ballot->name);
			$m->bcc('jennieruff@gmail.com', $name = null);
        });
		
		$request->session()->flash('message', 'Your ballot has been created.');
		
        return redirect()->route('ballots.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ballot = Ballot::findOrFail($id);
	
        return view('ballots.show', compact('ballot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ballot = Ballot::findOrFail($id);
    
        return view('ballots.edit', compact('ballot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {       
        $ballot = Ballot::findOrFail($id);
		
		//If we're closing the ballot (0), or opening the ballot (1)
		if($request['status'] == 2) :
			$request['expiration'] = Carbon::now();
			
			Mail::send('emails.close', ['ballot' => $ballot], function ($m) use ($ballot) {
				$m->from('admin@cutcatscourier.com', 'Cut Cats Courier');
				$m->to('meownow@googlegroups.com', 'Cut Cats News')->subject('Ballot closed:'. $ballot->name);
				$m->bcc('jennieruff@gmail.com', $name = null);
        	});
		
			$request->session()->flash('message', 'This ballot has been closed.');
		
		elseif($request['status'] == 1) :
			$request['expiration'] = Carbon::now()->addDays(5);
		else :
			$request['expiration'] = Carbon::now()->addWeeks(1);
		endif; 

       $ballot->update($request->all());

       return redirect()->route('ballots.show',[$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ballot = Ballot::findOrFail($id);
        
        $ballot->delete();
    
        return redirect()->route('ballots.index');
	}
	
	/**
     * Send an email to users who haven't voted
     *
     * @param  int  $id
     * @return Response
     */
	 public function notify(Request $request, $id)
	 {
		 
		 $ballot = Ballot::findOrFail($id);
		 $users = User::whereHas('votes', function ($query) use ($id) {
    				$query->where('ballot_id', $id);
				}, '<', 1)
				->whereHas('roles', function ($query) use ($id){
            		$query->where('role_id','!=',3)->where('role_id','!=',5); //3 and 5 for live, 7 and 10 for test
        		})->get();
				
				
	
		foreach($users as $user){
			$data = array('name' => $user->name, 'email' => $user->email, 'ballot' => $ballot->name, 'id' => $ballot->id);
			print_r($data);
			/**
			Mail::queue('emails.reminder', $data, function ($m) use ($data) {
				$m->subject('Hey can you plesase vote on ballot '. $data['ballot'] .'?');
				$m->from('admin@cutcatscourier.com','Cut Cats Courier');
				$m->to($data['email'], $data['name']);
			});
			**/
		}
		
		$request->session()->flash('message', 'Email reminders will be sent to active members who have not yet voted.');
		/**
		return redirect()->route('ballots.show',[$id]);
		**/
	 }
	 
	 /**
     * Support a ballot
     *
     * @param  int  $id
     * @return Response
     */
	 public function support(Request $request, $id)
	 {
		 $ballot = Ballot::findOrFail($id);
		 
		 //Check to see if this person has already supported this ballot
		 if($ballot->checkUserSupport($request->user()->id)){
			return redirect()->route('ballots.show', $id)->with('message', 'You have already pledged your support for this ballot.');
		 }
		 
		 $message = 'Your support for this ballot has been registered.';
		 
		 //Get the ballot info, check to see how much support it has now.
		 $supporters = $ballot->support()->count();
		  
		 //If there's enough support to make it live, update the status. 
		 if($supporters + 1 > 1){
		 	$ballot->update(['status' => 1]);
			$message = $message . " This ballot is now live!";
		 }
		
		 $supporter['ballot_id'] = $id;
		 $supporter['user_id'] = $request->user()->id;
		 $support = $ballot->support()->create($supporter);
		  
		 return redirect()->route('ballots.show', $id)->with('message', $message);
	 }

}

<?php 

namespace App\Http\Controllers\Ballots;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BallotVotes;
use App\Http\Requests\Ballotvotes\CreateBallotvoteRequest;
use App\Http\Requests\Ballotvotes\UpdateBallotvoteRequest;
use Input;
use Redirect;
use Auth;

class BallotVotesController extends Controller
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
        $ballotvotes = Ballotvotes::latest()->paginate(20);

        $no = $ballotvotes->firstItem();

        return view('ballotvotes.index', compact('ballotvotes', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ballotvotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, $id)
    {
		//$vote = $request->all();
		$vote['ballot_id'] = $id;
		$vote['user_id'] = $request->user()->id;
	
		foreach($request->question as $key => $question) :
			$vote = array_merge($vote,$question);
			$ballotvote = Ballotvotes::create($vote);
		endforeach; 
	
		return redirect()->route('ballots.show', $vote['ballot_id'])->with('message', 'Your vote has been registered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ballotvote = Ballotvote::findOrFail($id);

        return view('ballotvotes.show', compact('ballotvote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ballotvote = Ballotvote::findOrFail($id);
    
        return view('ballotvotes.edit', compact('ballotvote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateBallotvoteRequest $request, $id)
    {       
        $ballotvote = Ballotvote::findOrFail($id);

        $ballotvote->update($request->all());

        return redirect()->route('ballotvotes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ballotvote = Ballotvote::findOrFail($id);
        
        $ballotvote->delete();
    
        return redirect()->route('ballotvotes.index');
    }

}

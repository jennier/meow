<?php 

namespace App\Http\Controllers\Ballots;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ballotquestion;
use App\Http\Requests\Ballotquestions\CreateBallotquestionRequest;
use App\Http\Requests\Ballotquestions\UpdateBallotquestionRequest;

class BallotQuestionsController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $ballotquestions = Ballotquestion::latest()->paginate(20);

        $no = $ballotquestions->firstItem();

        return view('ballotquestions.index', compact('ballotquestions', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ballotquestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateBallotquestionRequest $request)
    {
        $ballotquestion = Ballotquestion::create($request->all());

        return redirect()->route('ballotquestions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ballotquestion = Ballotquestion::findOrFail($id);

        return view('ballotquestions.show', compact('ballotquestion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ballotquestion = Ballotquestion::findOrFail($id);
    
        return view('ballotquestions.edit', compact('ballotquestion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateBallotquestionRequest $request, $id)
    {       
        $ballotquestion = Ballotquestion::findOrFail($id);

        $ballotquestion->update($request->all());

        return redirect()->route('ballotquestions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ballotquestion = Ballotquestion::findOrFail($id);
        
        $ballotquestion->delete();
    
        return redirect()->route('ballotquestions.index');
    }

}

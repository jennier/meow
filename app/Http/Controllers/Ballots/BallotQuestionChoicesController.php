<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ballotquestionchoice;
use App\Http\Requests\Ballotquestionchoices\CreateBallotquestionchoiceRequest;
use App\Http\Requests\Ballotquestionchoices\UpdateBallotquestionchoiceRequest;

class BallotQuestionChoicesController extends Controller
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
        $ballotquestionchoices = Ballotquestionchoice::latest()->paginate(20);

        $no = $ballotquestionchoices->firstItem();

        return view('ballotquestionchoices.index', compact('ballotquestionchoices', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ballotquestionchoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateBallotquestionchoiceRequest $request)
    {
        $ballotquestionchoice = Ballotquestionchoice::create($request->all());

        return redirect()->route('ballotquestionchoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ballotquestionchoice = Ballotquestionchoice::findOrFail($id);

        return view('ballotquestionchoices.show', compact('ballotquestionchoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ballotquestionchoice = Ballotquestionchoice::findOrFail($id);
    
        return view('ballotquestionchoices.edit', compact('ballotquestionchoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateBallotquestionchoiceRequest $request, $id)
    {       
        $ballotquestionchoice = Ballotquestionchoice::findOrFail($id);

        $ballotquestionchoice->update($request->all());

        return redirect()->route('ballotquestionchoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ballotquestionchoice = Ballotquestionchoice::findOrFail($id);
        
        $ballotquestionchoice->delete();
    
        return redirect()->route('ballotquestionchoices.index');
    }

}

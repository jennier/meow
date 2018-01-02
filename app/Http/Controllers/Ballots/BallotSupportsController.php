<?php 

namespace App\Http\Controllers\Ballots;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ballotsupport;
use App\Http\Requests\Ballotsupports\CreateBallotsupportRequest;
use App\Http\Requests\Ballotsupports\UpdateBallotsupportRequest;

class BallotSupportsController extends Controller
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
        $ballotsupports = Ballotsupport::latest()->paginate(20);

        $no = $ballotsupports->firstItem();

        return view('ballotsupports.index', compact('ballotsupports', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ballotsupports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $ballotsupport = Ballotsupport::create($request->all());

        return redirect()->route('ballotsupports.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ballotsupport = Ballotsupport::findOrFail($id);

        return redirect()->route('ballots.show', $vote['ballot_id'])->with('message', 'Your support has been added to this ballot.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ballotsupport = Ballotsupport::findOrFail($id);
    
        return view('ballotsupports.edit', compact('ballotsupport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateBallotsupportRequest $request, $id)
    {       
        $ballotsupport = Ballotsupport::findOrFail($id);

        $ballotsupport->update($request->all());

        return redirect()->route('ballotsupports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ballotsupport = Ballotsupport::findOrFail($id);
        
        $ballotsupport->delete();
    
        return redirect()->route('ballotsupports.index');
    }

}

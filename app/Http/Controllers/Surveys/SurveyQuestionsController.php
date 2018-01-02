<?php 

namespace App\Http\Controllers\Surveys;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Surveyquestion;
use App\Http\Requests\Surveyquestions\CreateSurveyquestionRequest;
use App\Http\Requests\Surveyquestions\UpdateSurveyquestionRequest;

class SurveyQuestionsController extends Controller
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
        $surveyquestions = Surveyquestion::latest()->paginate(20);

        $no = $surveyquestions->firstItem();

        return view('surveyquestions.index', compact('surveyquestions', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('surveyquestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateSurveyquestionRequest $request)
    {
        $surveyquestion = Surveyquestion::create($request->all());

        return redirect()->route('surveyquestions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $surveyquestion = Surveyquestion::findOrFail($id);

        return view('surveyquestions.show', compact('surveyquestion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $surveyquestion = Surveyquestion::findOrFail($id);
    
        return view('surveyquestions.edit', compact('surveyquestion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateSurveyquestionRequest $request, $id)
    {       
        $surveyquestion = Surveyquestion::findOrFail($id);

        $surveyquestion->update($request->all());

        return redirect()->route('surveyquestions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $surveyquestion = Surveyquestion::findOrFail($id);
        
        $surveyquestion->delete();
    
        return redirect()->route('surveyquestions.index');
    }

}

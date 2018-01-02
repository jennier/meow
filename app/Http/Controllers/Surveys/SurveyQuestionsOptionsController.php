<?php 

namespace App\Http\Controllers\Surveys;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Surveyquestionsoption;
use App\Http\Requests\Surveyquestionsoptions\CreateSurveyquestionsoptionRequest;
use App\Http\Requests\Surveyquestionsoptions\UpdateSurveyquestionsoptionRequest;

class SurveyQuestionsOptionsController extends Controller
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
        $surveyquestionsoptions = Surveyquestionsoption::latest()->paginate(20);

        $no = $surveyquestionsoptions->firstItem();

        return view('surveyquestionsoptions.index', compact('surveyquestionsoptions', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('surveyquestionsoptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateSurveyquestionsoptionRequest $request)
    {
        $surveyquestionsoption = Surveyquestionsoption::create($request->all());

        return redirect()->route('surveyquestionsoptions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $surveyquestionsoption = Surveyquestionsoption::findOrFail($id);

        return view('surveyquestionsoptions.show', compact('surveyquestionsoption'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $surveyquestionsoption = Surveyquestionsoption::findOrFail($id);
    
        return view('surveyquestionsoptions.edit', compact('surveyquestionsoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateSurveyquestionsoptionRequest $request, $id)
    {       
        $surveyquestionsoption = Surveyquestionsoption::findOrFail($id);

        $surveyquestionsoption->update($request->all());

        return redirect()->route('surveyquestionsoptions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $surveyquestionsoption = Surveyquestionsoption::findOrFail($id);
        
        $surveyquestionsoption->delete();
    
        return redirect()->route('surveyquestionsoptions.index');
    }

}

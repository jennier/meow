<?php 

namespace App\Http\Controllers\Surveys;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SurveyResponse;
use App\Http\Requests\Surveyresponses\CreateSurveyresponseRequest;
use App\Http\Requests\Surveyresponses\UpdateSurveyresponseRequest;

class SurveyResponsesController extends Controller
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
        $surveyresponses = Surveyresponse::latest()->paginate(20);

        $no = $surveyresponses->firstItem();

        return view('surveyresponses.index', compact('surveyresponses', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('surveyresponses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request,$id)
    {

		$response['survey_id'] = $id;
		$response['user_id'] = $request->user()->id;

		//foreach question, we create a response.
		foreach($request->question as $key => $question) :
			$response = array_merge($response, $question, array('question_id' => $key));
			$surveyresponse = Surveyresponse::create($response);
		endforeach; 
		
		return redirect()->route('surveys.show',$id)->with('message', 'Your response has been registered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $surveyresponse = Surveyresponse::findOrFail($id);

        return view('surveyresponses.show', compact('surveyresponse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $surveyresponse = Surveyresponse::findOrFail($id);
    
        return view('surveyresponses.edit', compact('surveyresponse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateSurveyresponseRequest $request, $id)
    {       
        $surveyresponse = Surveyresponse::findOrFail($id);

        $surveyresponse->update($request->all());

        return redirect()->route('surveyresponses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $surveyresponse = Surveyresponse::findOrFail($id);
        
        $surveyresponse->delete();
    
        return redirect()->route('surveyresponses.index');
    }

}

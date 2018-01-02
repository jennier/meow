<?php 

namespace App\Http\Controllers\Surveys;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Surveyquestiongroup;
use App\Http\Requests\Surveyquestiongroups\CreateSurveyquestiongroupRequest;
use App\Http\Requests\Surveyquestiongroups\UpdateSurveyquestiongroupRequest;

class SurveyQuestionGroupsController extends Controller
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
        $surveyquestiongroups = Surveyquestiongroup::latest()->paginate(20);

        $no = $surveyquestiongroups->firstItem();

        return view('surveyquestiongroups.index', compact('surveyquestiongroups', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('surveyquestiongroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateSurveyquestiongroupRequest $request)
    {
        $surveyquestiongroup = Surveyquestiongroup::create($request->all());

        return redirect()->route('surveyquestiongroups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $surveyquestiongroup = Surveyquestiongroup::findOrFail($id);

        return view('surveyquestiongroups.show', compact('surveyquestiongroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $surveyquestiongroup = Surveyquestiongroup::findOrFail($id);
    
        return view('surveyquestiongroups.edit', compact('surveyquestiongroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateSurveyquestiongroupRequest $request, $id)
    {       
        $surveyquestiongroup = Surveyquestiongroup::findOrFail($id);

        $surveyquestiongroup->update($request->all());

        return redirect()->route('surveyquestiongroups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $surveyquestiongroup = Surveyquestiongroup::findOrFail($id);
        
        $surveyquestiongroup->delete();
    
        return redirect()->route('surveyquestiongroups.index');
    }

}

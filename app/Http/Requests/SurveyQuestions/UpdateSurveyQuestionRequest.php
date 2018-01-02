<?php namespace App\Http\Requests\SurveyQuestions;

use App\Http\Requests\Request;

class UpdateSurveyQuestionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'survey_id' => 'required',
			'question' => 'required',
			'type' => 'required',
			'created_at' => 'required',
			'updated_at' => 'required',
		];
    }

}

<?php namespace App\Http\Requests\SurveyResponses;

use App\Http\Requests\Request;

class UpdateSurveyResponseRequest extends Request
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
			'user_id' => 'required',
			'question_id' => 'required',
			'response' => 'required',
			'created' => 'required',
			'updated' => 'required',
		];
    }

}

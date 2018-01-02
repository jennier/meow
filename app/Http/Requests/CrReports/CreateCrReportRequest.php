<?php namespace App\Http\Requests\CrReports;

use App\Http\Requests\Request;

class CreateCrReportRequest extends Request
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
			'user_id' => 'required',
			'client' => 'required',
			'type' => 'required',
			'content' => 'required',
		];
    }

}

<?php namespace App\Http\Requests\Ballots;

use App\Http\Requests\Request;

class UpdateBallotRequest extends Request
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
			'ballot_id' => 'required',
			'name' => 'required',
			'created_by' => 'required',
			'created_on' => 'required',
			'expiration' => 'required',
			'type' => 'required',
			'1)' => 'required',
			'status' => 'required',
			'1' => 'required',
			'2)' => 'required',
		];
    }

}

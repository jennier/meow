<?php namespace App\Http\Requests\BallotVotes;

use App\Http\Requests\Request;

class UpdateBallotVoteRequest extends Request
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
			'user_id' => 'required',
			'vote' => 'required',
		];
    }

}

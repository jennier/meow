<?php namespace App\Http\Requests\BallotVotes;

use App\Http\Requests\Request;

class CreateBallotVoteRequest extends Request
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
		
        $rules = [
			'ballot_id' => 'required',
			'user_id' => 'required',
			'question' => 'required'
		];
		
		foreach($this->request->get('question') as $id => $val)
		  {
			$rules['question.'.$key.'.vote'] = 'required';
		  }
				
		return $rules;
    }

}

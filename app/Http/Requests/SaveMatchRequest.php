<?php
namespace App\Http\Requests;

class SaveMatchRequest extends Request {

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
            'team_id'     => 'required',
            'game_id'     => 'required',
            'opponent_id' => 'required'
        ];

        foreach ($this->request->get('rounds') as $key => $round) {
            $rules['rounds.' . $key . '.map_id'] = 'required';
            foreach ($round['scores'] as $k => $score) {
                $rules['rounds.' . $key . '.scores.' . $k . '.home'] = 'required|integer';
                $rules['rounds.' . $key . '.scores.' . $k . '.guest'] = 'required|integer';
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->request->get('rounds') as $roundKey => $round) {
            $messages['rounds.' . $roundKey . '.map_id'] = 'Game ' . ($roundKey + 1) . ' is missing a map.';
            foreach ($round['scores'] as $scoreKey => $score) {
                $messages['rounds.' . $roundKey . '.scores.' . $scoreKey . '.home.required'] = 'Team score from game ' . ($roundKey + 1) . ' has invalid input.';
                $messages['rounds.' . $roundKey . '.scores.' . $scoreKey . '.guest.required'] = 'Opponent score from game ' . ($roundKey + 1) . ' has invalid input.';
            }
        }

        return $messages;
    }

}

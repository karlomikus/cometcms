<?php
namespace Comet\Http\Requests;

class SaveMatchRequest extends Request
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
            'team_id'     => 'required|integer',
            'game_id'     => 'required|integer',
            'opponent_id' => 'required|integer',
            'matchlink'   => 'URL',
            'match_date'  => 'date_format:Y-m-d H:i',
            'match_time'  => 'date_format:H:i'
        ];

        foreach ($this->request->get('rounds') as $key => $round) {
            $rules['rounds.' . $key . '.map_id'] = 'required|integer';
            foreach ($round['scores'] as $k => $score) {
                $rules['rounds.' . $key . '.scores.' . $k . '.home'] = 'required|integer';
                $rules['rounds.' . $key . '.scores.' . $k . '.guest'] = 'required|integer';
            }
        }

        return $rules;
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];
        foreach ($this->request->get('rounds') as $roundKey => $round) {
            $messages['rounds.' . $roundKey . '.map_id.required'] = 'Game ' . ($roundKey + 1) . ' is missing a map.';
            foreach ($round['scores'] as $scoreKey => $score) {
                $messages['rounds.' . $roundKey . '.scores.' . $scoreKey . '.home.required'] = 'Team score from game ' . ($roundKey + 1) . ' has invalid input.';
                $messages['rounds.' . $roundKey . '.scores.' . $scoreKey . '.guest.required'] = 'Opponent score from game ' . ($roundKey + 1) . ' has invalid input.';
            }
        }

        return $messages;
    }
}

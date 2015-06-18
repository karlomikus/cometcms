<?php
namespace App\Http\Requests;

class SaveTeamRequest extends Request {

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
            'name'     => 'required|min:3',
            'game_id'     => 'required|integer',
            'image' => 'image',
            'members' => 'required|array'
        ];

        foreach ($this->request->get('members') as $key => $member) {
            $rules['members.' . $key . '.user_id'] = 'required|integer';
            $rules['members.' . $key . '.team_id'] = 'integer';
            $rules['members.' . $key . '.captain'] = 'boolean';
        }

        return $rules;
    }

}

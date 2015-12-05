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
            'gameId'     => 'required|integer',
            'image' => 'image',
            'roster' => 'required|array'
        ];

        foreach ($this->request->get('roster') as $key => $member) {
            $rules['roster.' . $key . '.userId'] = 'required|integer';
            $rules['roster.' . $key . '.captain'] = 'boolean';
        }

        return $rules;
    }

}

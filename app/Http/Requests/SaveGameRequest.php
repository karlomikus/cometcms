<?php
namespace Comet\Http\Requests;

class SaveGameRequest extends Request {

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
            'name'  => 'required|min:2',
            'code'  => 'required|min:2',
            'image' => 'image'
        ];

        if ($this->request->has('mapname')) {
            foreach ($this->request->get('mapname') as $key => $map) {
                $rules['mapname.' . $key] = 'required|min:2';
                $rules['mapimage.' . $key] = 'image';
            }
        }

        return $rules;
    }

}

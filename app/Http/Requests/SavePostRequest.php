<?php namespace Comet\Http\Requests;

class SavePostRequest extends Request
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
            'title'              => 'required|min:5',
            'image'              => 'image',
            'content'            => 'required',
            'publish_date_start' => 'date_format:Y-m-d H:i',
            'publish_date_end'   => 'date_format:Y-m-d H:i',
            'slug'               => 'unique:posts,slug'
        ];
    }
}

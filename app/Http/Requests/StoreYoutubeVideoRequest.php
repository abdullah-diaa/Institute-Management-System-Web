<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreYoutubeVideoRequest extends FormRequest
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
        return[
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
    
}

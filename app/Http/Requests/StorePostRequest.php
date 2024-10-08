<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts,title',
            // Rule::unique('users')->ignore($user->id),
            'body' => 'required',
            'category_id' => 'required',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
        ];
    }
}

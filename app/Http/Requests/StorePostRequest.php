<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'content'          => 'required',
            'category_id'      => 'required|exists:categories,id',
            'image'            => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tags'             => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
            'meta_description'   => 'nullable|string',
            'visibility'         => 'required|in:public,private',
            'notify_subscribers' => 'nullable',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required'       => 'Post title is required.',
            'title.max'            => 'Post title may not be greater than 255 characters.',
            'content.required'     => 'Post content is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists'   => 'The selected category does not exist.',
            'image.required'       => 'Featured image is required.',
            'image.image'          => 'The uploaded file must be an image.',
            'image.mimes'          => 'Image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max'            => 'Image size must not exceed 2MB.',
            'visibility.required'  => 'Please select post visibility.',
            'visibility.in'        => 'Invalid visibility selected.',
        ];
    }
}

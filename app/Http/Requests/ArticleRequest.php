<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    
        // Only require featured_image on create
        if ($this->isMethod('post')) {
            $rules['featured_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['featured_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }
    
        return $rules;
    }
}

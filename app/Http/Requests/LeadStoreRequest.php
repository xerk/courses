<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'name_ar' => ['nullable', 'max:255', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'max:255', 'string'],
            'category_approved' => ['nullable', 'max:255', 'string'],
            'course_type' => ['nullable', 'in:medical,technical'],
            'category_id' => ['required', 'exists:categories,id'],
            'lead_from' => ['nullable', 'in:website,calls,whatsapp,by_visit'],
            'status' => ['nullable', 'max:255', 'string'],
            'business_landline' => ['nullable', 'max:255', 'string'],
            'note' => ['nullable', 'max:255', 'string'],
        ];
    }
}

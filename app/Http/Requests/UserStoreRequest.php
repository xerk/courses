<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'avatar' => ['nullable', 'file'],
            'email' => ['required', 'unique:users,email', 'email'],
            'private_email' => ['nullable', 'max:255', 'string'],
            'password' => ['required'],
            'phone' => ['nullable', 'max:255', 'string'],
            'phone2' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'inside_address' => ['nullable', 'max:255', 'string'],
            'type' => ['nullable', 'in:trainer,employee,admin'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'city' => ['nullable', 'max:255', 'string'],
            'country' => ['nullable', 'max:255', 'string'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'roles' => 'array',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;


class RegisterRequest extends FormRequest
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
        $user = Auth::user();
        return [
            'company_name'          => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone'         => 'required|string',
            'email'         => 'email|string|unique:users,email',
            'password'      => 'required|string',
            // 'city'          => 'string',
            // 'state'         => 'string',
            // 'country'       => 'string',
            // 'status'       => 'required|string',
            // 'address'       => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Please enter company name.',
            'firstname.required' => 'Please enter firstname.',
            'lastname.required' => 'Please enter lastname.',
            'email.required' => 'Please enter email address.',
            'phone.required' => 'Please enter phone.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter a password.',
            // 'city.string' => 'Please enter city.',
            // 'state.string' => 'Please enter state.',
            // 'country.string' => 'Please enter country.',
            // 'status.required' => 'Please select status.',
            'address.required' => 'Please enter customer address.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'=>0,
                'error'=>$validator->errors()->toArray()
            ])
        );
    }
}

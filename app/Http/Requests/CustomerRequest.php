<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CustomerRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string',
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => 'The firstname field is required.',
            'lastname.required' => 'The firstname field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'address.required' => 'The address field is required.',
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         response()->json([
    //             'status'=>0,
    //             'error'=>$validator->errors()->toArray()
    //         ])
    //     );
    // }
}

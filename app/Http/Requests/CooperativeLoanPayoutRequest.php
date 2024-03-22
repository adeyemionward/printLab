<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CooperativeLoanPayoutRequest extends FormRequest
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
            'member_id' => 'required|integer',
            'amount_payout' => 'required',
            'date' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'member_id.required' => 'The member field is required.',
            'amount_payout.required' => 'The amount field is required.',
            'date.required' => 'The date field is required.',
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

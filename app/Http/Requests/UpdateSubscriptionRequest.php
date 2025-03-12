<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
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
            'request_status' => 'required|in:pending,successful,failed',
            'approved_by' => 'nullable|integer', // Can be set when successful
            'note' => 'nullable|string|max:255', // Note for failed requests
            'details' => 'nullable|string|max:500', // Additional details (optional)
            'phone' => 'required|string|size:11', // If you want to include phone number validation
            'location' => 'required|string', // Assuming you want to validate the location as well
            'payment_method' => 'required|string|in:office,representative,zain_cash,master_card',
        ];
    }
}

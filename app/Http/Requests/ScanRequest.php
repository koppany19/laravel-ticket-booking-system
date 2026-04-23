<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Ticket;

class ScanRequest extends FormRequest
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
            'barcode' => 'required|integer|exists:tickets',
        ];
    }

    public function messages(): array
    {
        return [
            'barcode.required' => 'Kérjük, írd be a vonalkódot',
            'barcode.integer' => 'Kérjük csak számot adj meg',
            'barcode.exists' => 'Ez a vonalkód nem létezik a rendszerben',

        ];
    }
}

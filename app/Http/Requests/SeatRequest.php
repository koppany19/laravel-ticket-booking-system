<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatRequest extends FormRequest
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
        $seat = $this->route('seat');
        $seatId = $seat ? $seat->id : '';

        return [
            'seat_number' => "required|unique:seats,seat_number,{$seatId}|regex:/^[A-Z][0-9][0-9][0-9]$/",
            'base_price' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'seat_number.required' => 'A székszám megadása kötelező!',
            'seat_number.unique' => 'Ez a székszám már létezik!',
            'seat_number.regex' => 'A formátum: 1 betű + 3 szám (pl. A005)',
            'base_price.required' => 'Az alapár megadása kötelező!',
            'base_price.integer' => 'Az alapárnak számnak kell lennie!',
        ];

    }
}

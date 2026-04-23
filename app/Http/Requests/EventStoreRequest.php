<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required|max:255',
            'event_date_at' => 'required|date',
            'sale_start_at' => 'required|date|before:event_date_at',
            'sale_end_at' => 'required|date|after:sale_start_at|before:event_date_at',
            'max_number_allowed' => 'required|integer|min:1',
            'image' => 'required|image',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Az esemény megnevezése kötelező!',
            'description.required' => 'A leírás megadása kötelező!',
            'description.max' => 'A leírás nem lehet hosszabb 1000 karakternél!',
            'event_date_at.required' => 'Az esemény időpontját meg kell adni!',
            'sale_start_at.before' => 'A jegyértékesítésnek az esemény előtt kell kezdődnie!',
            'sale_end_at.after' => 'A zárásnak a nyitás után kell lennie!',
            'max_number_allowed.min' => 'Legalább 1 jegyet engedélyezni kell!',
            'image.required' => 'A borítókép feltöltése kötelező!',
            'image.image' => 'A feltöltött fájl nem képformátumú!',
        ];
    }
}

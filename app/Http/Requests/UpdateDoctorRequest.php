<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
        return [
            'name' => 'required|min:5|max:30',
            'city' => 'required|max:30',
            'address' => 'required|max:100',
            'phone_number' => 'max:20',
            'service' => 'max:2000',
            'image' => 'max:5012',
            'curriculum' => 'mimetypes:pdf',
            'specialty' => 'required|exists:specialties,id'
        ];
    }

    /**
     * Get the validation message
     * 
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'name.min' => 'Il nome deve avere minimo 5 caratteri',
            'name.max' => 'Il nome può avere massimo 30 caratteri',
            'city.required' => 'La città deve obbligatoria',
            'city.max' => 'La città può avere massimo 30 caratteri',
            'address.required' => 'L\'indirizzo è obbligatorio',
            'address.max' => 'L\'indirizzo può avere massimo 100 caratteri',
            'phone_number.max' => 'Il numero di telefono può avere masssimo 20 caratteri',
            'service.max' => 'Il campo di testo delle prestazioni può avere massimo 2000 caratteri',
            'image.max' => 'L\'immagine deve pesare massimo 5MB',
            'curriculum.mimetypes' => 'Il curriculum deve essere in formato PDF',
            'specialty.required' => 'Seleziona almeno una specializzazione',
            'specialty.exists' => 'C\'è stato un problema, riprova'

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:nuevo_proyecto,nombre',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:6|unique:nuevo_proyecto,codigo',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del proyecto es obligatorio.',
            'name.unique'   => 'El nombre del proyecto ya existe.',
            'codigo.required' => 'El código del proyecto es obligatorio.',
            'codigo.unique'   => 'El código del proyecto ya existe.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.required' => 'La fecha de finalización es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
        ];
    }
}

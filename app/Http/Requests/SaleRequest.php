<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends ApiFormRequest
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
            'sale_date' => 'required|date',
            'email' => 'required|email',
            'concepts' => 'required|array|min:1',
            'concepts.*.quantity' => 'required|integer|min:1',
            'concepts.*.product_id' => 'required|exists:product,id'
        ];
    }

    public function messages()
    {
        return [
            'sale_date.required' => 'La fecha de la venta es obligatoria',
            'sale_date.date' => 'La fecha de la venta debe ser una fecha valida',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser una direccion de correo valida',
            'concepts.required' => 'Los conceptos son obligatorios',
            'concepts.array' => 'Los conceptos deben ser un array',
            'concepts.min' => 'Debe haber al menos un concepto',
            'concepts.*.quantity.required' => 'La cantidad es obligatoria',
            'concepts.*.quantity.integer' => 'La cantidad debe ser un numero entero',
            'concepts.*.quantity.min' => 'La cantidad debe ser al menos 1',
            'concepts.*.product_id.required' => 'El id del producto es obligatorio',
            'concepts.*.product_id.exists' => 'El id del producto no es valido',
        ];
    }
}

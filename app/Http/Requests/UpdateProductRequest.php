<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateProductRequest extends ApiFormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id'
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "El nombre del producto es obligatorio",
            "name.string" => "El nombre debe ser una cadena de texto",
            "name.max" => "El nombre no puede superar los 250 caracteres",
            "description.required" => "ELa descripcion es obligatoria",
            "description.max" => "La descripcion no puede superar los 2000 caracteres",
            "price.required" => "El precio es obligatorio",
            "price.numeric" => "El precio debe ser un numero",
            "category_id.required" => "El id de categoria es obligatorio",
            "category_id.exists" => "La categoria seleccionada no es valida"
        ];
    }

    
}

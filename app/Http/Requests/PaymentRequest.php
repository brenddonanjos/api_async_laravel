<?php

namespace App\Http\Requests;

use App\Enums\PaymentTypesEnum;
use App\Rules\CpfValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
            "amount" => "required|numeric|gte:0",
            "payment_method" => ["required", Rule::enum(PaymentTypesEnum::class)],
            "product_id" => "required|exists:products,code", //Aceita apenas produtos existentes
            "buyer_document" => ["required", "string", new CpfValidation], 
            /*  Uma outra opção seria importar uma biblioteca externa de validação de CPF como a "geekcom/validator-docs" 
                porém decidi fazer a validação na mão. */
        ];
    }

    
}

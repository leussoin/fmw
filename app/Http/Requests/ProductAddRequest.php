<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'aNomProduit' => 'required',
            'aPrixProduit' => 'required',
            'aCaloriesProduit' => 'required'
        ];
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages() {
        return [
            'aNomProduit.required' => 'Le nom du produit est requis.',
            'aPrixProduit.required' => 'Le prix du produit est requis',
            'aCaloriesProduit.required' => 'La valeur calorifique du produit est requise.'
        ];
    }
}
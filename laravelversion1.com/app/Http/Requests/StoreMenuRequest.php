<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckMenuITem;


class StoreMenuRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'menu_catalogue_id' => 'gt:0',
        ];
    }

    public function messages(): array
    {
        return [
            'menu_catalogue_id' => [
                'gt' =>'bạn chưa chọn vị trí của menu' ,
                new CheckMenuITem($id)
            ],
        
        ];
    }
}

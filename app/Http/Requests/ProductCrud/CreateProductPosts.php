<?php

namespace App\Http\Requests\ProductCrud;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductPosts extends FormRequest
{
    /**
     * @var array $_rules
     */
    protected static $_rules = [
        'name' => 'required|max:50|min:3|string',
        'product_by_user_id'  => 'nullable|numeric'
    
    ];
    
    /**
     * @var array $_messages
     */
    protected static $_messages = [
        
        
        'name.required' => 'Product name is required',
        'name.max'      => 'Product name provided exceeds maximum length:20',
        'name.min'      => 'Product name is too short, minimum length:3',
        'name.string'   => 'This entry can only contain strings',
        
        'product_by_user_id.numeric'   => 'This entry can only contain numeric values',
    
    ];
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return self::$_rules;
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages() : array
    {
        return self::$_messages;
    }
}

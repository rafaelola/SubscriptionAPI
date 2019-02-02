<?php

namespace App\Http\Requests\PhoneCrud;

use Illuminate\Foundation\Http\FormRequest;

class CreatePhonePosts extends FormRequest
{
    
    /**
     * @var array $_rules
     */
    protected static $_rules = [
        'phone_no' => 'required|max:20|min:3|string|unique:customer_phones,phone_no|regex:/^(\+44\s?7\d{3}|\(?07\d{3}\)|\(?01\d{3}\)?)\s?\d{3}\s?\d{3}$/',
        'display_name'  => 'required|max:191|min:2|string',
        'delete_reason' => 'nullable|string'
    
    ];
    
    /**
     * @var array $_messages
     */
    protected static $_messages = [
        
        
        'phone_no.required' => 'Phone number is required',
        'phone_no.unique'   => 'User with this phone number already exist',
        'phone_no.max'      => 'Phone number provided exceeds maximum length:20',
        'phone_no.min'      => 'Phone number is too short, minimum length:3',
        'phone_no.regex'    => 'Phone number provided is not valid, expected format: +447960255218',
        'phone_no.string'   => 'This entry can only contain strings',
        
        'display_name.required' => 'Display name is required',
        'display_name.max'      => 'Display name provided exceeds maximum length:191',
        'display_name.min'      => 'Display name provided is too short, minimum length:2',
        'display_name.string'   => 'This entry can only contain strings',
        
        'delete_reason.string'   => 'This entry can only contain strings',
    
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

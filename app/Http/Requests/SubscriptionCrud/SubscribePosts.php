<?php
    
    namespace App\Http\Requests\SubscriptionCrud;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class SubscribePosts extends FormRequest
    {
        /**
         * @var array $_rules
         */
        protected static $_rules = [
            'msisdn '     => 'required|integer',
            'product_id ' => 'required|integer'
        
        ];
        
        /**
         * @var array $_messages
         */
        protected static $_messages = [
            'msisdn.required' => 'Id is required',
            'msisdn.integer'  => 'This entry can only contain integer',
            'product_id.required' => 'Id is required',
            'product_id.integer'  => 'This entry can only contain integer',
            
        
        ];
        
        
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

<?php
    namespace App\Http\Requests\PhoneCrud;
    use Illuminate\Foundation\Http\FormRequest;
    
    class UpdatePhonePosts extends CreatePhonePosts
    {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules() : array
        {
            
            $keys = array_keys(parent::$_rules);
            $values = array_values(parent::$_rules);
            $values[0] = 'required|max:20|min:3|string|regex:/^(\+44\s?7\d{3}|\(?07\d{3}|unique:customer_phones,id,' . $this->route('id');
            parent::$_rules = array_combine($keys, $values);
            
            return array_merge(parent::$_rules, [
                'id' => 'required|integer'
            ]);
        }
        
        /**
         * Get custom messages for validator errors.
         *
         * @return array
         */
        /**
         * Get custom messages for validator errors.
         *
         * @return array
         */
        public function messages() :array
        {
            return array_merge(parent::$_messages, [
                'id.required' => 'Id is required',
                'id.integer'  => 'This entry can only contain integer'
            
            ]);
        }
    }
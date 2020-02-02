<?php

namespace Lawin\Seat\Esintel\Http\Validation;

use Illuminate\Foundation\Http\FormRequest;
use Lawin\Seat\Esintel\Models\Category;

class CategoryCreateRequest extends FormRequest {


    public function authorize() {

        return true;
    }



    public function rules() {

        return [
            'category_name' => "required"
        ];
    }



    public function messages() {

        return [
            'category_name.required' => "The category name field must not be empty."
        ];
    }
}

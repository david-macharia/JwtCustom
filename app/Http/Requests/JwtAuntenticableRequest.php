<?php

namespace App\Http\Requests;

use App\Http\Tools\CreateJwt;
use App\Rules\UserIdExistInEitherTable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class JwtAuntenticableRequest extends FormRequest
{
   use CreateJwt;
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
    public function rules()
    {
        return [
            "user_id"=>["required",new UserIdExistInEitherTable(($this))],
            "password"=>["required"]
        ];
    }
}

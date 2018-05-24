<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Authorize and validate a create user form request.
 *
 * @author Erik Galloway <erik@fliplearning.com>
 */
class CreateUserRequest extends FormRequest
{
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
            'name'    => 'required|string',
            'email'   => 'bail|required|email|unique:users,email',
            'gender'  => Rule::in(['male', 'female', 'other']),
        ];
    }
}

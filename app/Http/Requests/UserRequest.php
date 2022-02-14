<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\user;


class UserRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = \App\User::$rules;
            // メソッドがPATCHのとき（つまりupdate()アクションが呼ばれるとき）
        if ($request->method == 'PATCH') {
            // passwordのrequiredの条件を外し、nullableにします。
            $key = array_search('required', $rules['password']);
            unset($rules['password'][$key]);
            array_push($rules['password'], 'nullable');

            // updateのときに、元のemailと同じ値であってもバリデーションエラーにならないようにします。
            // https://readouble.com/laravel/6.x/ja/validation.html#rule-unique
            $key = array_search('unique:users', $rules['email']);
            unset($rules['email'][$key]);
            array_push($rules['email'], Rule::unique('users')->ignore(Auth::user()));
            
            // nameについても同様
            $key = array_search('unique:users', $rules['name']);
            unset($rules['name'][$key]);
            array_push($rules['name'], Rule::unique('users')->ignore(Auth::user()));
            
        }

        return $rules;
    }
    
    /**
     * バリデーションエラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        // Userモデルに記述しているエラーメッセージを返します。
        return User::$messages;
    }

}

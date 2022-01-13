<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
    
    public function authorize()
    {
        return false;
    }
    */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post.body'=>'required|string|max:200',
            'post.keyword_1'=>'nullable|string|max:20',
            'post.keyword_2'=>'nullable|string|max:20',
            'post.keyword_3'=>'nullable|string|max:20',

        ];
    }
    
    /**
    * 定義済みバリデーションルールのエラーメッセージ取得
    *
    * @return array
    */
    public function messages()
    {
        return [
            'post.body.required'  => '本文は最低1文字以上入力してください',
            'post.body.string' => '文字列で入力してください',
            'post.body.max' => '200字以内で入力してください',
            'post.keyword_1.string' => '文字列で入力してください',
            'post.keyword_1.max' => '20字以内で入力してください',
            'post.keyword_2.string' => '文字列で入力してください',
            'post.keyword_2.max' => '20字以内で入力してください',
            'post.keyword_3.string' => '文字列で入力してください',
            'post.keyword_3.max' => '20字以内で入力してください',
            
            
        ];
    }
}

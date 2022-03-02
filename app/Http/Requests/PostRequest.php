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
     * バリデーションルール
     * @return array
     */
    public function rules()
    {
        return [
            'post.body'=>'required|string|max:200',
            'file'=>'nullable|file|image|',
            'post.prefs'=>'integer',
            'post.categories'=>'integer',
            'tags' => 'nullable|starts_with:#',

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
            'file.image' => '画像ファイルではありません',
            'tags.starts_with' => '各タグの先頭には#をつけてください',
            
        ];
    }
}

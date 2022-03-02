<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     /*
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
            'reply.body'=>'required|string|max:200',
            'file'=>'nullable|file|image|',
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
            'reply.body.required'  => '本文は最低1文字以上入力してください',
            'reply.body.string' => '文字列で入力してください',
            'reply.body.max' => '200字以内で入力してください',
            'file.image' => '画像ファイルではありません'
            
            
        ];
    }
    
}

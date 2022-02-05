<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nickname', 'profile', 'icon', 'prefs', 'categories'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * バリデーションルール
    * Auth\RegisterControllerから移動しています。
    * 追加したユーザーの項目を追記しています。
    *
    * @var array
    */
    
    public static $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nickname' => ['string'],
            'profile' => ['string'],
            'icon' => ['nullable', 'image'],
            'prefs' => ['integer'],
            'categories' => ['integer'],
    ];
    
    /**
     * バリデーションエラーメッセージ
    * Auth\RegisterControllerから移動しています。
    * 追加したユーザーの項目を追記しています。
    *  
    * @var array
    */
    public static $messages = [
        'name.required' => 'お名前を入力してください。',
        'name.max' => 'お名前は50文字以内で入力してください。',
        'email.required' => 'E-mailアドレスを入力してください。',
        'email.email' => '正しいE-mailアドレスを入力してください。',
        'email.max' => 'E-mailアドレスは255文字以内で入力してください。',
        'email.unique' => 'そのメールアドレスは既に登録されています。',
        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.confirmed' => '入力されたパスワードが一致しません。',
        'nickname.string' => '文字列で入力してください。',
        'profile.string' => '文字列で入力してください。',
        'icon.image' => '画像ではありません。',
    ];
    
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
    
    public function getPrefNameAttribute() {
        return config('prefs.'.$this->prefs);
    }
    
    public function getCategoryNameAttribute() {
        return config('categories.'.$this->categories);
    }
    
        
}

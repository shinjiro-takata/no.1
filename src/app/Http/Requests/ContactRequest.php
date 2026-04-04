<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// お問い合わせフォーム専用のバリデーションをまとめる
class ContactRequest extends FormRequest
{
    // 今回は誰でも送信できるため常に許可する
    public function authorize()
    {
        return true;
    }

    // 入力項目ごとのバリデーションルール
    public function rules()
    {
        return [
            'first_name'  => ['required', 'string', 'max:8'],
            'last_name'   => ['required', 'string', 'max:8'],
            'gender'      => ['required', 'integer', Rule::in(array_keys(Contact::GENDER_LABELS))],
            'email'       => ['required', 'email'],
            'tel1'        => ['required', 'numeric', 'digits_between:1,5'],
            'tel2'        => ['required', 'numeric', 'digits_between:1,5'],
            'tel3'        => ['required', 'numeric', 'digits_between:1,5'],
            'address'     => ['required', 'string'],
            'building'    => ['nullable', 'string'],
            'category_id' => ['required'],
            'detail'      => ['required', 'string', 'max:120'],
        ];
    }

    // バリデーションエラーメッセージ
    public function messages()
    {
        return [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号を入力してください',
            'tel1.numeric' => '電話番号は半角数字で入力してください',
            'tel1.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel2.required' => '電話番号を入力してください',
            'tel2.numeric' => '電話番号は半角数字で入力してください',
            'tel2.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel3.required' => '電話番号を入力してください',
            'tel3.numeric' => '電話番号は半角数字で入力してください',
            'tel3.digits_between' => '電話番号は5桁まで数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }
}

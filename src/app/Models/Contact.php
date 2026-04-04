<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// お問い合わせデータを扱うモデル
class Contact extends Model
{
    use HasFactory;

    // 性別の値を定数で管理する
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHER = 3;
    public const PER_PAGE = 7;

    // 画面表示用の性別ラベル
    public const GENDER_LABELS = [
        self::GENDER_MALE => '男性',
        self::GENDER_FEMALE => '女性',
        self::GENDER_OTHER => 'その他',
    ];

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];

    // 保存されている性別コードを表示用ラベルに変換する
    public function getGenderLabelAttribute()
    {
        return self::GENDER_LABELS[$this->gender] ?? '';
    }

    // お問い合わせは1つのカテゴリに属する
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

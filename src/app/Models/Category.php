<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// お問い合わせカテゴリを扱うモデル
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    // 1つのカテゴリに複数のお問い合わせが紐づく
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}

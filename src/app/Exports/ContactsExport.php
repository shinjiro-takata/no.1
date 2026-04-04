<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// お問い合わせ一覧をCSV出力用の形式に変換する
class ContactsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    // 検索条件を適用したクエリを受け取る
    public function __construct($query)
    {
        $this->query = $query;
    }

    // 出力対象のデータを取得する
    public function collection()
    {
        return $this->query->get();
    }

    // CSVのヘッダー行
    public function headings(): array
    {
        return [
            'お名前',
            '性別',
            'メールアドレス',
            'お問い合わせの種類',
            'お問い合わせ内容',
            '登録日時',
        ];
    }

    // 1件分のデータをCSVの列順に並べ替える
    public function map($contact): array
    {
        return [
            $contact->last_name . ' ' . $contact->first_name,
            $contact->gender_label,
            $contact->email,
            optional($contact->category)->content,
            $contact->detail,
            $contact->created_at,
        ];
    }
}

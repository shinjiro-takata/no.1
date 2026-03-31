<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    // 管理ページ
    public function admin(Request $request)
    {
        $categories = Category::all();

        $query = Contact::with('category')->latest('id');

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('created_date')) {
            $query->whereDate('created_at', $request->input('created_date'));
        }

        $contacts = $query->paginate(7)->appends($request->query());

        return view('admin', compact('contacts', 'categories'));
    }

    // 検索
    public function search(Request $request)
    {
        return $this->admin($request);
    }

    // 検索リセット
    public function reset()
    {
        return redirect()->route('contact.admin');
    }

    // 削除
    public function delete(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contact.admin');
    }

    // エクスポート
    public function export(): StreamedResponse
    {
        $contacts = Contact::with('category')->latest('id')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ];

        $callback = function () use ($contacts) {
            $stream = fopen('php://output', 'w');
            // BOM (Excel対策)
            fwrite($stream, "\xEF\xBB\xBF");
            // ヘッダー行
            fputcsv($stream, ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', 'お問い合わせ内容', '登録日時']);

            $genderMap = [1 => '男性', 2 => '女性', 3 => 'その他'];

            foreach ($contacts as $contact) {
                fputcsv($stream, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $genderMap[$contact->gender] ?? '',
                    $contact->email,
                    optional($contact->category)->content,
                    $contact->detail,
                    $contact->created_at,
                ]);
            }

            fclose($stream);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 入力ページ
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    // 確認ページ
    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();

        // 3つの入力値をハイフンで繋いで1つの文字列にする
        $contact['tel_full'] = $request->tel1 . $request->tel2 . $request->tel3;

        // カテゴリー名を表示するために取得
        $categoryContent = Category::find($request->category_id)->content;
        return view('confirm', compact('contact', 'categoryContent'));
    }

    // 保存処理（サンクスページへ）
    public function store(Request $request)
    {
        // 「修正する」ボタンが押された場合
        if ($request->input('back')) {
            return redirect()->route('contact.index')->withInput($request->except('back'));
        }

        $data = $request->all();
        $data['tel'] = $request->tel1 . $request->tel2 . $request->tel3;

        Contact::create($data);
        return view('thanks');
    }
}

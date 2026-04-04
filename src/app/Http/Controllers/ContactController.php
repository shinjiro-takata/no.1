<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use App\Exports\ContactsExport;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    // キーワード・性別・カテゴリ・日付の検索条件をクエリに適用する
    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $fullNameKeyword = preg_replace('/[\s ]+/u', '', $keyword); // スペースを除去してフルネーム検索に対応

            $query->where(function ($q) use ($keyword, $fullNameKeyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");

                if ($fullNameKeyword !== '') {
                    $q->orWhereRaw("CONCAT(last_name, first_name) like ?", ["%{$fullNameKeyword}%"]); // 姓名を結合したフルネームでも検索
                }
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('created_date')) {
            $query->whereDate('created_at', $request->input('created_date')); // 時刻を無視して日付だけ比較
        }

        return $query;
    }

    // 管理ページ：問い合わせ一覧を表示する
    public function admin(Request $request)
    {
        $categories = Category::all();
        $modalContact = null;

        $query = Contact::with('category')->latest('id');
        $query = $this->applyFilters($request, $query);
        $contacts = $query->paginate(Contact::PER_PAGE)->appends($request->query()); // ページネーション（クエリパラメータを引き継ぐ）

        if ($request->filled('modal')) {
            $modalContact = Contact::with('category')->find($request->input('modal')); // モーダルに表示するレコードを取得
        }

        return view('admin', compact('contacts', 'categories', 'modalContact'));
    }

    // 検索：adminに処理を委譲する
    public function search(Request $request)
    {
        return $this->admin($request);
    }

    // 検索リセット：クエリパラメータなしで管理ページへ戻る
    public function reset()
    {
        return redirect()->route('contact.admin');
    }

    // 削除：レコードを削除して前のページへ戻る
    public function delete(Contact $contact)
    {
        $contact->delete();
        return redirect()->back();
    }

    // エクスポート：現在の検索条件でCSVをダウンロードする
    public function export(Request $request)
    {
        $query = Contact::with('category')->latest('id');
        $query = $this->applyFilters($request, $query);

        return Excel::download(new ContactsExport($query), 'contacts.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    // 入力ページ：問い合わせフォームを表示する
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    // 確認ページ：バリデーション後に入力内容を確認画面へ渡す
    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();
        $contact['tel_full'] = $request->tel1 . $request->tel2 . $request->tel3; // 3つの入力値を連結
        $categoryContent = Category::find($request->category_id)->content; // カテゴリ名を取得
        return view('confirm', compact('contact', 'categoryContent'));
    }

    // 保存処理：DBに保存してサンクスページを表示する
    public function store(Request $request)
    {
        if ($request->input('back')) {
            return redirect()->route('contact.index')->withInput($request->except('back')); // 「修正する」で入力ページへ戻る
        }

        $data = $request->all();
        $data['tel'] = $request->tel1 . $request->tel2 . $request->tel3; // 3つの入力値を連結

        Contact::create($data);
        return view('thanks');
    }
}

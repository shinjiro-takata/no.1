<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
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

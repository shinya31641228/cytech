<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use \App\Models\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /**
     *商品一覧画面を表示する
     *
     * @return view
     */
    public function showHome(Request $request)
    {
        //メーカー名をcompaniesテーブルから取得
        $company = new Company;
        $companies = $company->getLists();
        //ログインしているユーザー情報を渡す
        $user = \Auth::user();
        $products = Product::where('user_id', $user['id'])->where('status', 1)->get();

        //入力される値nameの中身を定義する
        $search_word = $request->input('search_word'); //商品名の値
        $company_id = $request->input('company_id'); //メーカーの値

        return view('products.list', [
            'products' => $products,
            'companies' => $companies,
            'search_word' => $search_word,
            'company_id' => $company_id,
        ]);
    }
}
